<?php
/**
 * handles the users 
 * @author tatenda munenge
 * @link http://www.tate-creative-studio.tech
 * @link tatemunenge@gmail.com
  * @link +263775351170
 * @license http://opensource
 */
class fi_settings extends db_connection{
 	
 	public $settingId;
 	public $userId;
 	public $setting;
 	public $access;
 	public $dacFound = false;
 	public $dacCrud = false;
 	private $handler;

 	public function __construct(){
     	try{
     		$this->handler = parent::connect();
     		return $this->handler;
     	}
     	catch(Exception $e){
     		die("Server currently down");
     	}
     }

     public function setSetings($u){
		try{
			$sql = "INSERT INTO fi_settings (userId) VALUES (:u)";
			$query = $this->handler->prepare($sql);
			$query->bindValue(":u",$u,PDO::PARAM_INT);
			$query->execute();
			if($query){
				$this->dacCrud == true;
			}
			return $this->dacCrud;
		} 
		catch(Exception $e){
			die("Server currently down");
		}     
	}
	
	public function getAccess($u){
		try{
			$sql = "SELECT access FROM fi_settings WHERE userId = :u";
			$query = $this->handler->prepare($sql);
			$query->bindValue(":u",$u,PDO::PARAM_INT);
			$query->execute();
			$query->setFetchMode(PDO::FETCH_OBJ);
			$obj = $query->fetch();
			return $obj->access;
		}
		catch(Exception $e){
			die("Server currently down");
		}
	}

	public function checkExist($u){
		try{
			$sql = "SELECT access FROM fi_settings WHERE userId = :u";
			$query = $this->handler->prepare($sql);
			$query->bindValue(":u",$u,PDO::PARAM_INT);
			$query->execute();
			if($query->rowCount()){
				return true;
			}
			else{
				return false;
			}
		}
		catch(Exception $e){
			die("Server currently down");
		}
	}

	public function editAccess($u,$a){
		try{
			$sql = "UPDATE fi_settings SET access = :a WHERE userId = :u LIMIT 1";
			$query = $this->handler->prepare($sql);
			$query->bindValue(":a",$a,PDO::PARAM_INT);
			$query->bindValue(":u",$u,PDO::PARAM_INT);
			$query->execute();
			if($query){
				$this->dacCrud = true;
			}
			return $this->dacCrud; 

		}
		catch(Exception $e){
			die("server currently down");
		}
	}
 }	





