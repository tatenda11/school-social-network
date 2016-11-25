<?php
 Class db_connection{
 	public static $db_conn;
 	public static function connect(){
 		try{
    		self::$db_conn = new PDO('mysql:host=Localhost;dbname=social','root','');
        	self::$db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        	return self::$db_conn;
		}
    	catch(PDOException $e){
             echo $e->getMessage();
    	}    
     }
    public static function sanatize($val,$filter){
    	try{
    		return $val;
    	}
    	catch(Exception $e){
    		die("server currently down");
    	}
    }
 }
#disable.android.first.run=true
//$link = db_connection::connect();
//print_r(PDO::getAvailableDrivers());
