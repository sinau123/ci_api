<?php

/**
 * Created by IntelliJ IDEA.
 * User: ankar
 * Date: 5/7/16
 * Time: 7:45 AM
 */
class Util {
    const WON = "won";
    public static function indonesianCurrency($amount) {
        return number_format($amount,'0',',','.');
    }
}
