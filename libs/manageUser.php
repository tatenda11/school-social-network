<?php
include_once("db_connect.php");
include_once("manage_sessions.php");
include_once("PHPMailer/PHPMailerAutoload.php");
/**
 * handles the users 
 * @author tatenda munenge
 * @link http://www.tate-creative-studio.tech
 * @link tatemunenge@gmail.com
  * @link +263775351170
 * @license http://opensource
 */
class fi_users extends db_connection{
 	public $userId;
 	public $studentId;
 	public $email;
 	public $signDate;
 	public $lastLog;
 	public $firstName;
 	public $surName;
 	public $mdlName;
 	public $major;
 	public $hostel;
 	public $hometown;
 	public $hghSchool;
 	public $gender;
    public $propic;
 	public $bio;
    public $birthday;    
 	public $level; 
 	public $accTyp;
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

     private function comEmail($e){
     	return trim($e."@solusi.ac.zw");
     }

     private function hash($Val){
     	try{
     		return md5($Val);
     	}
     	catch(Exception $e){
     		die("Server currently down");
     	}
     }

     public function setUser($fn,$Sn,$Sid,$mj,$gender,$pass){
     	try{
     		
     		$sql = "INSERT INTO fi_users (firstName,surName,studentId,major,gender,email,password,candy,signDate)";
     		$sql .= "VALUE (?,?,?,?,?,?,?,?,NOW())";
     		$query = $this->handler->prepare($sql);
     		$query->execute(array($fn,$Sn,$Sid,$mj,$gender,$this->comEmail($Sid),md5($pass),md5($Sid)));
     		if($query){
     			$this->dacCrud = true;
     			$this->userId = $this->handler->lastInsertId();
     			$this->studentId = $Sid;
     		}
     		return $this->dacCrud;
     	}
     	catch(Exception $e){
     		die($e->getMessage());
     	}
     }
     public function loginUser($e,$p){
        try{
            $sql = "SELECT userId FROM fi_users WHERE studentId = ? AND password = ? LIMIT 1";
            $query = $this->handler->prepare($sql);
            $query->execute(array(parent::sanatize($e,"email"),$this->hash($p)));
            if($query->rowCount()){
                $u = $query->fetchColumn();
                $this->dacFound = true;
                sessions::login_user($u);
                self::updateLastLog($u);
             }
             return $this->dacFound;

         }
         catch(Exception $e){
             die("Sever Currently down");
         }
    }
    public function getUser($u){
    	try{
    		$sql="SELECT * FROM fi_users WHERE userId = :user LIMIT 1";
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':user', $u, PDO::PARAM_INT);
            $query->execute();
     		$query->setFetchMode(PDO::FETCH_OBJ); 
     		$obj = $query->fetch();
             $this->status = $obj->status;
     		$this->userId = $obj->userId;
			$this->studentId = $obj->studentId;
			$this->email = $obj->email;
			$this->firstName = $obj->firstName;
			$this->surName = $obj->surName;
			$this->mdlName = $obj->mdlName;
			$this->major = $obj->major;
			$this->hostel = $obj->hostel;
			$this->propic = $obj->propic;
            $this->hometown = $obj->hometown;
			$this->hghSchool = $obj->hghSchool;
			$this->gender = $obj->gender;
            $this->birthday  = $obj->birthday;   
			$this->bio = $obj->bio;
			$this->level = $obj->level;
    	}
    	catch(Exception $e){
    		die($e->getMessage());
    	}
    } 
	public function getStatus($u){
        try{
            $sql = "SELECT status fi_users WHERE userId = :user LIMIT 1";
            $query = $this->handler->prepare($sql);
            $query->bindValue(':user', $u, PDO::PARAM_INT);
            $query->execute();
            $query->setFetchMode(PDO::FETCH_OBJ); 
            $obj = $query->fetch();
            return $obj->status'
        }
        catch(Exception $e){
            die("server currently down");
        }
    }
    public function checkExists($Sid){
     	try{
     		$query = $this->handler->prepare("SELECT userId FROM fi_users WHERE studentId = ?");
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
         	$query = $this->handler->prepare("UPDATE fi_users SET lastLog = NOW() WHERE userId = ?");
            $query->execute(array($u));
        }
        catch(Exception $e){
                die("Sever Currently down");
        }
     } 
     private function makedir(){
         try{
         	mkdir("userInfo/$this->studentId",0755);
         }
         catch(Exception $e){
            die("registration complete you can now login using your credentials");
         }
     }
      public function intiateUser(){
        try{
             //Sessions::login_user($u);
             self::sendemail($this->comEmail($this->studentId));
             self::makedir();
         }
         catch(Exception $e){
             die("failed to completed registation");   
          }
     }

     public function updateprofile($u){
        try{
            $sql = "UPDATE fi_users SET firstName = :fn,surName = :sn, mdlName = :mld,
                    major = :mjr, hostel = :hos, hometown = :hmt, hghSchool = :hgh,
                    gender = :gndr, bio = :bio,level = :level, propic = :propic , birthday = :bday  
                    WHERE userId = :user LIMIT 1";
            $query= $this->handler->prepare($sql);
            $query->bindValue(':fn', $this->firstName, PDO::PARAM_STR);
            $query->bindValue(':sn', $this->surName, PDO::PARAM_STR);
            $query->bindValue(':mld', $this->mdlName, PDO::PARAM_STR);
            $query->bindValue(':mjr', $this->major, PDO::PARAM_INT);
            $query->bindValue(':hos', $this->hostel, PDO::PARAM_INT);
            $query->bindValue(':hmt', $this->hometown, PDO::PARAM_STR);
            $query->bindValue(':hgh', $this->hghSchool, PDO::PARAM_STR);
            $query->bindValue(':bday', $this->birthday);
            $query->bindValue(':gndr', $this->gender, PDO::PARAM_INT);
            $query->bindValue(':bio', $this->bio, PDO::PARAM_STR);
            $query->bindValue(':level', $this->level, PDO::PARAM_STR);
            $query->bindValue(':propic', $this->propic, PDO::PARAM_STR);
            $query->bindValue(':user', $u, PDO::PARAM_INT);
            $query->execute();
            if($query){
                $this->dacCrud = true;
            }
            return $this->dacCrud;
        }
        catch(Exception $e){
            die("sever currently down");
        }
     }
     public function updatePic($u,$pic){
        try{
            $sql = "UPDATE fi_users SET propic = :pic WHERE userId = :user LIMIT 1";
            $query= $this->handler->prepare($sql);
            $query->bindValue(':pic', $pic, PDO::PARAM_STR);
            $query->bindValue(':user', $u, PDO::PARAM_INT);
            $query->execute();
            if($query){
                $this->dacCrud = true;
            }
            return $this->dacCrud;
        }
        catch(Exception $e){
             die("sever currently down"); 
        }
     }
     public function headerInfo($u){
        try{
            $sql="SELECT firstName,surName,propic,studentId FROM fi_users WHERE userId = :user LIMIT 1";
            $query = $this->handler->prepare($sql);
            $query->bindValue(':user', $u, PDO::PARAM_INT);
            $query->execute();
            $query->setFetchMode(PDO::FETCH_OBJ); 
            $obj = $query->fetch();
            $info = array("fname"=>$obj->firstName, "surName"=>$obj->surName, "propic"=>$obj->propic,"sid"=>$obj->studentId);
            return $info;
        }
        catch(Exception $e){
             die("sever currently down");
        }
     } 
     private function sendemail($u){
        try{
            $sent = false;
            $mail = new PHPMailer;
            //From email address and name
            $mail->From = "tatemunenge@gmail.com";
            $mail->FromName = "chris.hanyane@elearninginstitute.biz";
            $mail->addAddress("user@email.com", "elearning user");
            //Address to which recipient will reply
            $mail->addReplyTo("chris.hanyane@elearninginstitute.biz", "Reply");
            //html mode
            $mail->isHTML(true);
            $mail->Subject = "Account Activation";
            $mail->Body="click this link to activate localhost/solusi-fi/act.php?acc=$this->studentId&tokken=md5($this->studentId)";
            //$mail->AltBody = "hello user you have successifully created an elearning account with the elearning institute your login creditials are email:$this->Email and password:$pass.thank you very much http://www.elearninginstitute.biz";
            if(!$mail->send()) {
               $sent = true;
             }
              return $sent;
         }
         catch(Exception $e){
         	die("could not sent email");
         }
     }   
}	
