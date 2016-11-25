<?php
/**
 * handles the users 
 * @author tatenda munenge
 * @link http://www.tate-creative-studio.tech
 * @link tatemunenge@gmail.com
  * @link +263775351170
 * @license http://opensource
 */
class fi_messages extends db_connection{
	public $messageId;
	public $userTo;
	public $userFrom;
	public $attachment;
	public $message;
	public $sentDate;
	public $status;
	private $handler;
     public $rowCount;
	public $dacCrud =false;
	public $dacFound =false;

	public function __construct(){
     	try{
     		$this->handler = parent::connect();
     		return $this->handler;
     	}
     	catch(Exception $e){
     		die("Server currently down");
     	}
     }

     public function sendMessage($to,$from,$msg,$attach = null){
     	try{
     		$sql ="INSERT INTO fi_messages (userTo,userFrom,message,attachment)  
     				VALUES (:uto,:ufrom,:msg,:atach) ";
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':uto', $to, PDO::PARAM_INT);
     		$query->bindValue(':ufrom', $from, PDO::PARAM_INT);
     		$query->bindValue(':msg', $msg, PDO::PARAM_STR);
     		$query->bindValue(':atach',$attach , PDO::PARAM_STR);	
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

     public function getInbox($u,$page,$per_page){
     	try{
     		$sql="SELECT * FROM fi_messages WHERE userTo = ? ORDER BY messageId DESC LIMIT $page ,$per_page";
               $query = $this->handler->prepare($sql);
     		$query->execute(array($u));
     		$query->setFetchMode(PDO::FETCH_OBJ); 
     		$rs = $query->fetchAll();
     		return $rs;
     	}
     	catch(Exception $e){
     		die($e->getMessage());
     	}
     }

     public function getConversation($to, $from){
          try{
               $sql = "SELECT * FROM fi_messages WHERE userTo = :uto AND userFrom = :ufrom 
               UNION (SELECT * from fi_messages WHERE userFrom = :uto AND userTo =:ufrom  ) ORDER BY messageId ASC";
               $query = $this->handler->prepare($sql);
               $query->bindValue(':uto', $to, PDO::PARAM_INT);
               $query->bindValue(':ufrom', $from, PDO::PARAM_INT);
               $query->execute();    
               $query->setFetchMode(PDO::FETCH_OBJ); 
               $rs = $query->fetchAll();
               if($query->rowCount()){
                    $this->dacFound = true;
               }
               return $rs;
          }
          catch(Exception $e){
               die($e->getMessage());
          }
     } 

     public function getSentBox($u){
     	try{
     		$sql="SELECT * FROM fi_messages WHERE userFrom = ? ORDER BY messageId ";
     		$query = $this->handler->prepare($sql);
     		$query->execute(array($u));
     		$query->setFetchMode(PDO::FETCH_OBJ); 
     		$rs = $query->fetchAll();
     		return $rs;
     	}
     	catch(Exception $e){
     		die("server currently down");	
     	}
     }

     public function countUnread($u){
     	try{
     		$sql = "SELECT * FROM fi_messages WHERE userTo = ? AND status = 'P' ";
     		$query = $this->handler->prepare($sql);
     		$query->execute(array($u));
     		$c_check = $query->rowCount();
               return $c_check;
     	}
     	catch(Exception $e){
     		die("server currently down");
     	}
     }

      public function countAll($u){
          try{
               $sql = "SELECT * FROM fi_messages WHERE userTo = ? ";
               $query = $this->handler->prepare($sql);
               $query->execute(array($u));
               $c_check = $query->rowCount();
               return $c_check;
          }
          catch(Exception $e){
               die("server currently down");
          }
     }

     public function openMessage($msg){
          try{
               $sql = "UPDATE fi_messages SET status ='O' WHERE messageId= ?";
               $query = $this->handler->prepare($sql);
               $query->execute(array($msg));
               if($query){
                    $this->dacCrud = true;
               }
               return $this->dacCrud;

          }
          catch(Exception $e){
               die("sever currenly dowm");
          }
     }

}







