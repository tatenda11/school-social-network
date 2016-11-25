<?php
/**
 * handles the users 
 * @author tatenda munenge
 * @link http://www.tate-creative-studio.tech
 * @link tatemunenge@gmail.com
  * @link +263775351170
 * @license http://opensource
 */
class fi_friends extends db_connection{
	public $friendshipId;
	public $friendDate;
	public $friendFrom;
	public $friendTo;
	public $status;
     public $Count;
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

     public function sendRequst($from,$to){
     	try{
     		if($this->checkFriendship($from,$to) == false){
                    $sql = "INSERT INTO fi_friends (friendFrom,friendTo,friendDate) VALUES(?,?,NOW())";
                    $query = $this->handler->prepare($sql);
                    $query->execute(array($from,$to));
                    if($query){
                         $this->dacCrud = true;
                    }
                    return $this->dacCrud;
               }
     	}
     	catch(Exception $e){
     		die("Server currently down");	
     	}
     }

     public function checkFriendship($uone,$utwo){
     	try{
     		$sql = "SELECT status,friendshipId FROM fi_friends WHERE friendfrom = :one AND friendTo = :two 
                       UNION (SELECT status,friendshipId FROM fi_friends WHERE friendfrom = :two AND friendTo = :one )";
     		$query = $this->handler->prepare($sql);	
     		$query->bindValue(':one', $uone, PDO::PARAM_INT);
     		$query->bindValue(':two', $utwo, PDO::PARAM_INT);
     		$query->execute();
     		if($query->rowCount()){
     			$u_check = true;
                    $query->setFetchMode(PDO::FETCH_OBJ); 
                    $obj = $query->fetch();
                    $this->status = $obj->status;
                    $this->friendshipId = $obj->friendshipId;
     		}
               else{
                     $u_check = false;
               }
     		return $u_check;	
     	}
     	catch(Exception $e){
     		die($e->getMessage());	
     	}
     }

     public function countFriends($u){
     	try{
     		$sql = "SELECT friendshipId FROM fi_friends WHERE friendFrom = :user
     		   	   AND status = 'A' UNION (SELECT friendshipId FROM fi_friends WHERE friendTo = :user
                       AND status = 'A') ";
     		$query = $this->handler->prepare($sql);	
     		$query->bindValue(':user', $u, PDO::PARAM_INT);
     		$query->execute();
     		$f_check = $query->rowCount();
     		return $f_check;
     	}
     	catch(Exception $e){
     		die("Server currently down");
     	}
     }

     public function countFriendRequsts($u){
          try{
               $sql = "SELECT friendshipId FROM fi_friends WHERE friendTo = :user
                       AND status = 'P'";
               $query = $this->handler->prepare($sql); 
               $query->bindValue(':user', $u, PDO::PARAM_INT);
               $query->execute();
               $f_check = $query->rowCount();
               return $f_check;
          }
          catch(Exception $e){
               die("Server currently down");
          }
     }

      public function getRequests($u){
          try{
               $sql = "SELECT * FROM fi_friends WHERE friendTo = :user AND  status = 'P'";
               $query = $this->handler->prepare($sql); 
               $query->bindValue(':user', $u, PDO::PARAM_INT);
               $query->execute();
               $query->setFetchMode(PDO::FETCH_OBJ);
               $this->Count = $query->rowCount(); 
               $obj = $query->fetchAll();
               return $obj;
          }
          catch(Exception $e){
               die($e->getMessage());
          }
     }

     public function acceptRequest($id){
     	try{
     		$sql = "UPDATE fi_friends SET status = 'A'  WHERE friendshipId = :id LIMIT 1";		
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':id', $id, PDO::PARAM_INT);
     		$query->execute();
     		if($query){
     			$this->dacCrud = true;
     		}
     		return $this->dacFound;	 		
     	}
     	catch(Exception $e){
     		die("sever currently down");
     	}
     }
     public function getFriendsArray($u){
        try{
           $sql =  "SELECT * FROM fi_friends WHERE friendFrom = :user
                    AND status = 'A' UNION (SELECT * FROM fi_friends WHERE friendTo = :user
                    AND status = 'A') ";
          $query = $this->handler->prepare($sql); 
          $query->bindValue(':user', $u, PDO::PARAM_INT);
          $query->execute();
          $obj = $query->fetchAll();
          return $obj;
        }
        catch(Exception $e){
          die("sever currently down");
        }
     }
     public function removeFriendship($id){
     	try{
     		$sql = "DELETE FROM fi_friends WHERE friendshipId = :id LIMIT 1";
     		$query = $this->handler->prepare($sql);
               $query->bindValue(':id', $id, PDO::PARAM_INT);
     		$query->execute();
     		if($query){
     			$this->dacCrud = true;
     		}
     		return $this->dacFound;

          }
     	catch(Exception $e){

     	}
     }

}
 
