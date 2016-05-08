<?php

/**
 * Created by IntelliJ IDEA.
 * User: ankar
 * Date: 5/6/16
 * Time: 9:14 PM
 */
class Kurs extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->model('util');
    }

    public function convertAmount($amount, $from = 'rupiah')
    {

        $amount = (float)$amount;
        /*
         * get kurs hari ini
         */
        $query = $this->db->select('kurs_value')
            ->get_where('kurs', array('date(kurs_create_at)' => date('Y-m-d')));

        if (empty($kurs)) {
            $query = $this->db->select('kurs_value')
                ->where(array('date(kurs_create_at) <= ' => date('Y-m-d')))
                ->order_by('kurs_create_at', 'DESC')
                ->limit(1)
                ->get('kurs');
            $kurs = (float)$query->row()->kurs_value;
        } else {
            $kurs = (float)$query->row()->kurs_value;
        }

        if ($from = "won") {
            $cost = $this->_getCost($amount, $kind = 1);
            $final_amount = ($amount - $cost) * $kurs;
        } else {
            $cost = $this->_getCost($amount, $kind = 2);
            $final_amount = $amount / $kurs * $kurs;
        }

        $data =
            [
                "amount" => Util::indonesianCurrency($amount),
                "kurs" => $kurs,
                "cost" => Util::indonesianCurrency($cost),
                "final_amount" => Util::indonesianCurrency($final_amount)
            ];

        return $data;
    }

    private function _getCost($amount,$kind = 1){
        $query = $this->db->select('cost_cost')
            ->where("$amount between cost_min and cost_max AND kind = $kind ")
            ->get('cost');
        return (float)$query->row()->cost_cost;
    }
}