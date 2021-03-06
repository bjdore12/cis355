<?php

require '../../password.php';

class Database {

    private static $dbName = 'bjdore355wi20';
    private static $dbHost = '10.8.30.49';
    private static $dbUsername = 'bjdore355wi20';
     
    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
    }
     
    public static function connect() {
       // One connection through whole application
       global $password;

       if ( null == self::$cont ) {     
        try {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, $password); 
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
