<?php
/**
 * handles the users 
 * @author tatenda munenge
 * @link http://www.tate-creative-studio.tech
 * @link tatemunenge@gmail.com
  * @link +263775351170
 * @license http://opensource
 */
class fi_notifications extends db_connection{
	public $notificationId;
	public $notFrom;
	public $notTo;
	public $notification;
	public $notDate;
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

     public function setNotifivation($from,$to,$notice,$item=null,$post){
     	try{
     		$sql = "INSERT INTO fi_notifications (notFrom,notTo,notification,notTyp,itemId)
     				VALUES (?,?,?,?,?)";
     		$query = $this->handler->prepare($sql);
     		$query->execute(array($from,$to,$notice,$item,$post));
     		if($query){
     			$this->dacCrud == true;
     		}
     		return $this->dacCrud;	
     	}
     	catch(Exception $e){
     		die($e->getMessage());	
     	}
     }

     public function getNotifications($u,$Lastlog){
          try{
               $Lastlog = date("Y/m/d");
               $sql = "SELECT * FROM fi_notifications WHERE notFrom NOT IN ($u) ORDER BY notificationId DESC LIMIT 10";
               $query = $this->handler->prepare($sql);
               $query->execute();
               $query->setFetchMode(PDO::FETCH_OBJ); 
               $obj = $query->fetchAll();
               return $obj;
          }
          catch(Exception $e){
             die("Server currently down");  
          }
     }


     public function getNotificationsAll($u,$page,$per_page){
          try{
               $sql = "SELECT * FROM fi_notifications WHERE notFrom NOT IN ($u) ORDER BY notificationId DESC LIMIT $page ,$per_page";
                $query = $this->handler->prepare($sql);
               $query->execute();
               $query->setFetchMode(PDO::FETCH_OBJ); 
               $obj = $query->fetchAll();
               return $obj;
          }
          catch(Exception $e){
               die("Server currently down");
          }
     }

     public function countNotifications(){
         try{
               $sql = "SELECT notificationId FROM fi_notifications"; 
               $query = $this->handler->prepare($sql);
               $query->execute();
               return $query->rowCount();
         }
         catch(Exception $e){
              die("serverv currently down");     
         }

     } 
}

