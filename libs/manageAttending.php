<?php
/**
 * handles the attending sheet 
 * @author tatenda munenge
 * @link http://www.tate-creative-studio.tech
 * @link tatemunenge@gmail.com
  * @link +263775351170
 * @license http://opensource
 */
class fi_attending extends db_connection {
	public $attendId;
	public $eventId;
	public $userId;
	public $status;
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

	public function setAttending($e,$u,$s){
		try{
			$sql = "INSERT INTO fi_attending (eventId,userId,status) VALUES (:e, :u, :s)";
			$query = $this->handler->prepare($sql);
		    $query->bindValue(':e', $e, PDO::PARAM_INT);
		    $query->bindValue(':u', $u, PDO::PARAM_INT);
		    $query->bindValue(':s', $s, PDO::PARAM_INT);
		    $query->execute();
		    if($query){
		    	$this->dacCrud = true;
		    }
		    return $this->dacCrud;
		}
		catch(Exception $e){
			die("Server currently down");
		}
	}
                                                
	public function deleteAttending($u,$e){
		try{
			$sql = "DELETE FROM fi_attending WHERE eventId = :e AND userId = :u LIMIT 1";
			$query = $this->handler->prepare($sql);
			$query->bindValue(':e', $e, PDO::PARAM_INT);
			$query->bindValue(':u', $u, PDO::PARAM_INT); 
			$query->execute();
		    if($query){
		    	$this->dacCrud = true;
		    }
		    return $this->dacCrud;
		}
		catch(Exception $e){
			die("Server currently down");
		}
	}

	public function checkAttending($u,$e){
		try{
			$sql = "SELECT status FROM fi_attending WHERE userId= :u AND eventId = :e";
			$query = $this->handler->prepare($sql);
			$query->bindValue(':e', $e, PDO::PARAM_INT);
			$query->bindValue(':u', $u, PDO::PARAM_INT); 
			$query->execute();
			if($query->rowCount()){
				$this->dacFound = true;
			}
			return $this->dacFound;
		}
		catch(Exception $e){
			die("server currently down");
		}
	}

	public function updateAttending($u,$e,$s){
		try{
			$sql = "UPDATE fi_attending SET status = ? WHERE eventId = ? AND userId = ?";
			echo $sql;
			$query = $this->handler->prepare($sql);
		    $query->execute(array($s,$e,$u));
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