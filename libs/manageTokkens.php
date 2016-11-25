<?php
/**
 * handles the users 
 * @author tatenda munenge
 * @link http://www.tate-creative-studio.tech
 * @link tatemunenge@gmail.com
  * @link +263775351170
 * @license http://opensource
 */
class fi_tokkens extends db_connection{
 	
 	public $tokkenId;
 	public $tokken;
 	public $issueDate;
 	public $userId;
 	private $handler;
 	public $dacFound = false;
 	public $dacCrud = false;

 	public function __construct(){
     	try{
     		$this->handler = parent::connect();
     		return $this->handler;
     	}
     	catch(Exception $e){
     		die("Server currently down");
     	}
     }

     public function setTokken($u){
     	try{
     		$tokken = gettokken(16);
     		$sql = "INSERT INTO fi_tokken (userId,tokken) VALUES (:u,:tokken)";
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':u',$u,PDO::PARAM_INT);
     		$query->bindValue(':tokken',$tokken,PDO::PARAM_STR);
     		$query->execute();
     		if($query){
     			$this->dacCrud = true;
     		}
     		return $tokken;
     	}
     	catch(Exception $e){
     		die($e->getMessage());
     	}
     }

     public function getTokken($u,$tokken){
     	try{
     		$sql = "SELECT tokkenId FROM fi_tokken WHERE userId = :u AND tokken = :tokken LIMIT 1";
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':u',$u,PDO::PARAM_INT);
     		$query->bindValue(':tokken',$u,PDO::PARAM_STR);
     		$query->execute();
     		$query->setFetchMode(PDO::FETCH_OBJ);
     		$obj = $query->fetch();
     		return $obj->tokkenId;
     	}
     	catch(Exception $e){
     		die("server curremly dow");
     	}
     }

     public function deleteTokken($tokken){
     	try{
     		$sql = "DELETE FROM fi_tokken WHERE tokkenId = :tokken";
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':tokkens',$tokken,PDO::PARAM_INT);
     		$query->execute();
     		if($query){
     			$this->dacCrud = true;
     		}
     		return $this->dacCrud;
     	}
     	catch(Exception $e){
     		die("server curremly dow");
     	}
     }

}





















