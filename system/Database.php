<?php

class Db
{
 
  private static $instance = NULL;

    private function __construct() {}

    private function __clone() {}

    public static function getInstance() {
      if (!isset(self::$instance)) {
		try {
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$host = DB_HOST;
			$name = DB_NAME;
		self::$instance = new PDO("mysql:host={$host};dbname={$name}", DB_USER, DB_PASSWORD, $pdo_options);
	 
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
      }
      return self::$instance;
    }
 
 

 
}
  
?>