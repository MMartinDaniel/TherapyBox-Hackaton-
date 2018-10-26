
<?php
	/**
	 * Connector class, Creates a Connection to the database
	 */
	class Connector{
		private function __construct(){
		}
		//retrieve the connection database
		public static function DBConnection(){
			$db_config = require_once('./config/database.php');
			try {
				$mdb = new PDO("mysql:host=" . $db_config['host'] . ";dbname=" . $db_config['database'], $db_config['user'], $db_config['password'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			} catch (\PDOException $e) {
				throw new \PDOException($e->getMessage(), (int)$e->getCode());
			}

			return $mdb;
		}
	}
?>