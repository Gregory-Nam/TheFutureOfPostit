<?php

class bd {

    private static $bdh;

    private static function setBd(){
        self::$bdh = new PDO('mysql:host=;dbname=futureofpostit_bd', "", "");
    }

    public function getBdd(){
        if(self::$bdh == null)
            self::setBd();
        return self::$bdh;
    }
}
