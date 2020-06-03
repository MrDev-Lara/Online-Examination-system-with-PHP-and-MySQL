<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../config/config.php');
	
	class database{
		public $PDO;
		public function __construct(){
			if(!isset($this->PDO)){
				try{
				$this->PDO = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME,DB_USER,DB_PASS);
			}catch(PDOexception $e){
				echo "Failed to connect to database.".$e->getMessage();
			}
		}
	}
}
?>