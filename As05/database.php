<?php

require 'password.php';

class Database {

    private static $dbName = 'id12227249_cis355';
    private static $dbHost = 'localhost';
    private static $dbUsername = 'id12227249_bjdore12';
     
    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
    }
     
    public static function connect() {
       // One connection through whole application
       global $sql_login;

       if ( null == self::$cont ) {     
        try {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, $sql_login);
        }
        catch(PDOException $e) {
          die($e->getMessage()); 
        }
       }
       return self::$cont;
    }
     
    public static function disconnect() {
        self::$cont = null;
    }
}
?>
