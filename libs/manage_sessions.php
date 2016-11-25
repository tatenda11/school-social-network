<?php
session_start();
class Sessions{
	public $userId;
	public static $logged;

	public static function login_user($u){
		try{
			$_SESSION['fi_user'] = $u;
		}
		catch(Exception $e){
			die("server error");
		}
	}
	public static function getSession(){
		return $_SESSION['fi_user'];
	}

	public static function autheticate(){
		if(!$_SESSION['fi_user']){
			header("location:index.php");
		}
	} 
}
