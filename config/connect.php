<?php
//database configuration file

/**
* Database connection script
* An abstract class
* @param none
* @return Object
* Description: initialize database connection then return connection Object.
*/

abstract class DBAdapter {
	//initialize DB connection settings
	private static  $host 	  = 'localhost';//$config['host']; 	 // Host name 
	private static  $username = 'webusers';//$config['username']; // Mysql username 
	private static  $password = 'edecobode';//$config['password']; // Mysql password 
	private static  $db_name  = 'besthealth';//$config['dbname'];	 // Database name
	private static  $connect  = null; 		 //set connection variable to null
	//returns on successful connection
	private static function initConnection() {
		try {
			self::$connect = new PDO("mysql:host=".self::$host.";dbname=".self::$db_name, self::$username, self::$password); //initialize database connection
		}
		catch(PDOException $e) {
			echo "MYSQL_DB_ERROR: ".$e->getMessage(); //throw any error message
		}
		return self::$connect;
	}
	//return connection Object
	public static function connect() {
		return self::$connect = self::initConnection(); //return connection
	}
}


?>