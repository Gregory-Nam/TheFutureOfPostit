<?php

class bd {

    private static $bdh;

    private static function setBd(){
        self::$bdh = new PDO('mysql:host=mysql-futureofpostit.alwaysdata.net;dbname=futureofpostit_bd', "178438", "789456123");
    }

    public function getBdd(){
        if(self::$bdh == null)
            self::setBd();
        return self::$bdh;
    }
}
