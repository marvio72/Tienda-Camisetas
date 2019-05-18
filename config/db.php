<?php 
require_once 'database/bdconfig.php';
class Database{
    public static function connect(){
        $db = new mysqli(HOST,USER,PASS,BDATOS);
        $db->query("SET NAMES 'utf8'");
        return $db;
        
    }
}

