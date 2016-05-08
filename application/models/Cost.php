<?php

/**
 * Created by IntelliJ IDEA.
 * User: ankar
 * Date: 5/6/16
 * Time: 9:48 PM
 */
class Cost extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function convertAmount($amount, $from = 'rupiah') {

        $query = $this->db->get_where('kurs', array('date(kurs_create_at)' => date('Y-m-d')));
        return $query->row_array();
    }
}