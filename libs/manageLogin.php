<?php
include_once("PHPMailer/PHPMailerAutoload.php");
/**
 * handles the users 
 * @author tatenda munenge
 * @link http://www.tate-creative-studio.tech
 * @link tatemunenge@gmail.com
  * @link +263775351170
 * @license http://opensource
 */
class fi_logins extends db_connection{
	public $userId;
	public $studentId;
	public $status;
	public $password;
	public $signDate;
	public $lastLogin;
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

     private function hash($Val){
     	try{
     		return md5($Val);
     	}
     	catch(Exception $e){
     		die("Server currently down");
     	}
     }

     public function setLogin($sId,$pass){
     	try{
     	   	$sql = "INSERT INTO fi_login (studentId,password) VALUES (:id,:pass)";
     	   	$query = $this->handler->prepare($sql);
     	   	$query->bindValue(':id', $sId, PDO::PARAM_STR);
     	   	$query->bindValue(':pass', $this->hash($pass), PDO::PARAM_STR);
     	   	if($query){
     	   		$this->dacCrud = true;
     	   	    $query->execute();
     	   		$this->userId = $this->handler->lastInsertId();
     	   	}
     	   	return $this->userId;
     	}
     	catch(Exception $e){
     		die("Server currently down");
     	}
     }


     public function loginUser($e,$p){
        try{
            $sql = "SELECT userId FROM fi_login WHERE studentId = :sid AND password = :pass LIMIT 1";
            $query = $this->handler->prepare($sql);
            $query->bindValue(':sid',$e,PDO::PARAM_STR);
            $query->bindValue(':pass',$this->hash($p),PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount()){
                $u = $query->fetchColumn();
                $this->dacFound = true;
                sessions::login_user($u);
                self::updateLastLog($u);
             }
             return $this->dacFound;
         }
         catch(Exception $e){
             die($e->getMessage());
         }
    }

    public function getLastLog($u){
        try{
              $sql = "SELECT lastLogin FROM fi_login WHERE userId = ?  LIMIT 1";
              $query = $this->handler->prepare($sql);
              $query->execute(array($u));
              return $query->fetchColumn();;
        }
        catch(Exception $e){
            die("Sever Currently down");   
        }
    }

    public function checkExists($Sid){
     	try{
     		$query = $this->handler->prepare("SELECT userId FROM fi_login WHERE studentId = ?");
     		$query->execute(array($Sid));
     		if($query->rowCount()){
                    $this->dacFound = true;
            }
            return $this->dacFound;
     	}
     	catch(Exception $e){
     		die("Server currently down");
     	}
     }
     
     private function updateLastLog($u){
        try{
         	$query = $this->handler->prepare("UPDATE fi_login SET lastLogin = NOW() WHERE userId = ?");
            $query->execute(array($u));
        }
        catch(Exception $e){
            die($e->getMessage());
        }
     }

     public function updatePassword($pass,$u,$newpass){
        try{
            $sql  = "SELECT userId FROM fi_login WHERE userId = :u AND password = :pass";
            $query = $this->handler->prepare($sql);
            $query->bindValue(':u',$u,PDO::PARAM_INT);
            $query->bindValue(':pass',$this->hash($pass),PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount()){
                $this->dacFound = true;
                $sql = "UPDATE fi_login SET password = :pass WHERE userId = :u";
                $query2 = $this->handler->prepare($sql);
                $query2->bindValue(':u',$u,PDO::PARAM_INT);
                $query2->bindValue(':pass',$this->hash($newpass),PDO::PARAM_STR);
                $query2->execute();
                if($query2){
                    $this->dacCrud = true;
                } 
            }
            else{
                 $this->dacFound = true;
            }
            return $this->dacCrud;
        }
        catch(Exception $e){
            die("server currenlty down");
        }
     } 
}
