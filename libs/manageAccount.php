<?php
include_once("PHPMailer/PHPMailerAutoload.php");
include_once("db_connect.php");

/**
 * handles the users 
 *  @author tatenda munenge
 * v@link http://www.tate-creative-studio.tech
 *  @link tatemunenge@gmail.com
  * @link +263775351170
 *  @license http://opensource
 */
class fi_users extends db_connection{
 	public $systemId;
 	public $safeId;
 	public $fname;
 	public $sname;
    public $studentId;
 	public $mdlname;
 	public $majorId;
 	public $hostelId;
 	public $hometown;
 	public $hghschool;
 	public $gender;
 	public $level;
    public $birthday;
 	public $bio;
    public $status;
 	public $propic;
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

     public function setAccount($fname,$sname,$system,$gndr,$majorId,$sid){
     	try{
     		$sql = "INSERT INTO fi_users (fname,sname,systemId,gender,majorId,studentId) 
   					VALUES(:fn,:sn,:sy,:gn,:mj,:sid)
     		       ";
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':sy', $system, PDO::PARAM_INT);
     		$query->bindValue(':fn', $fname, PDO::PARAM_STR);
     		$query->bindValue(':sn', $sname, PDO::PARAM_STR);
     		$query->bindValue(':gn', $gndr, PDO::PARAM_STR);
            $query->bindValue(':sid', $sid, PDO::PARAM_STR);
     		$query->bindValue(':mj', $majorId, PDO::PARAM_INT);
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

     public function getUser($u){
     	try{
     		$sql = "SELECT * FROM fi_users WHERE systemId = :sy LIMIT 1";
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':sy', $u, PDO::PARAM_INT);
     		$query->execute();
     		$query->setFetchMode(PDO::FETCH_OBJ); 
     		$obj = $query->fetch();
     		$this->systemId = $obj->systemId;
			$this->fname = $obj->fname;
			$this->sname = $obj->sname;
			$this->mdlname = $obj->mdlname;
			$this->majorId = $obj->majorId;
            $this->studentId = $obj->studentId;
			$this->hostelId = $obj->hostelId;
			$this->propic = $obj->propic;
            $this->hometown = $obj->hometown;
			$this->hghschool = $obj->hghschool;
			$this->gender = $obj->gender;
            $this->birthday  = $obj->birthday;   
			$this->bio = $obj->bio;
			$this->level = $obj->level;
            $this->status = $obj->status;
     	}
     	catch(Exception $e){
     		die("server currently down");
     	}
     }

     public function getUserById($sid){
        try{
            $sql = "SELECT * FROM fi_users WHERE studentId = :sid LIMIT 1";
            $query = $this->handler->prepare($sql);
            $query->bindValue(':sid', $sid, PDO::PARAM_INT);
            $query->execute();
            $query->setFetchMode(PDO::FETCH_OBJ); 
            $obj = $query->fetch();
            if($query->rowCount()){
                $this->dacFound = true;
                $this->systemId = $obj->systemId;
                $this->fname = $obj->fname;
                $this->sname = $obj->sname;
                $this->mdlname = $obj->mdlname;
                $this->majorId = $obj->majorId;
                $this->studentId = $obj->studentId;
                $this->hostelId = $obj->hostelId;
                $this->propic = $obj->propic;
                $this->hometown = $obj->hometown;
                $this->hghschool = $obj->hghschool;
                $this->gender = $obj->gender;
                $this->status = $obj->status;
                $this->birthday  = $obj->birthday;   
                $this->bio = $obj->bio;
                $this->level = $obj->level;
            }
        }
        catch(Exception $e){
            die("server currently down");
        }
     }

     public function updateprofile($u){
     	try{
     		$sql = " UPDATE fi_users SET fname = :fn,sname = :sn, mdlname = :mld,
                     majorId = :mjr, hostelId = :hos, hometown = :hmt, hghSchool = :hgh,
                     gender = :gndr, bio = :bio,level = :level, propic = :propic , birthday = :bday  
                     WHERE systemId = :sy LIMIT 1
                   ";
            $query= $this->handler->prepare($sql);
            $query->bindValue(':fn', $this->fname, PDO::PARAM_STR);
            $query->bindValue(':sn', $this->sname, PDO::PARAM_STR);
            $query->bindValue(':mld', $this->mdlname, PDO::PARAM_STR);
            $query->bindValue(':mjr', $this->majorId, PDO::PARAM_INT);
            $query->bindValue(':hos', $this->hostelId, PDO::PARAM_INT);
            $query->bindValue(':hmt', $this->hometown, PDO::PARAM_STR);
            $query->bindValue(':hgh', $this->hghschool, PDO::PARAM_STR);
            $query->bindValue(':bday', $this->birthday, PDO::PARAM_STR);
            $query->bindValue(':gndr', $this->gender, PDO::PARAM_INT);
            $query->bindValue(':bio', $this->bio, PDO::PARAM_STR);
            $query->bindValue(':level', $this->level, PDO::PARAM_STR);
            $query->bindValue(':propic', $this->propic, PDO::PARAM_STR);
            $query->bindValue(':sy', $u, PDO::PARAM_INT);
            $query->execute();
            if($query){
                $this->dacCrud = true;
            }
            return $this->dacCrud;
     	}
     	catch(Exception $e){
     		die($e->getMessage());
     	}
     }

      public function updatePic($u,$pic){
        try{
            $sql = "UPDATE fi_users SET propic = :pic WHERE systemId = :user LIMIT 1";
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

     public function intiateUser($tokken,$u){
        try{
             //Sessions::login_user($u);
             self::sendemail($this->comEmail($this->studentId),$tokken,$u);
             self::makedir();
         }
         catch(Exception $e){
             die("failed to completed registation");   
          }
     }

     private function comEmail($e){
        return trim($e."@solusi.ac.zw");
     }
     
     public function headerInfo($u){
        try{
            $sql="SELECT fname,sname,propic,studentId,gender FROM fi_users WHERE systemId = :user LIMIT 1";
            $query = $this->handler->prepare($sql);
            $query->bindValue(':user', $u, PDO::PARAM_INT);
            $query->execute();
            $query->setFetchMode(PDO::FETCH_OBJ); 
            $obj = $query->fetch();
            $info = array("fname"=>$obj->fname, "surName"=>$obj->sname, "propic"=>$obj->propic,"sid"=>$obj->studentId,"gndr"=>$obj->gender);
            return $info;
        }
        catch(Exception $e){
             die("sever currently down");
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
     /***************Search Engine************************/
     
     public function searchByName($key){
        try{
            $sql = "SELECT systemId FROM fi_users WHERE fname LIKE '%$key%' UNION (SELECT systemId FROM fi_users WHERE sname LIKE '%$key%')";
            
            $query = $this->handler->prepare($sql);
            $query->execute();
            $query->setFetchMode(PDO::FETCH_OBJ); 
            $obj = $query->fetchAll();
            return $obj;
        }
        catch(Excepition $e){
            die("server currently down");
        }
     }


     public function runSearch($n,$m,$h,$l,$page,$per_page){
        try{
            
            $sql = "SELECT * FROM fi_users WHERE fname LIKE '%$n%' "." ".$this->buildQuery($n,$m,$h,$l)." UNION (SELECT * FROM fi_users WHERE sname LIKE '%$n%' "." ".$this->buildQuery($n,$m,$h,$l).")"." LIMIT $page ,$per_page";
            $query= $this->handler->prepare($sql);
            $query->execute();
            $query->setFetchMode(PDO::FETCH_OBJ); 
            $obj = $query->fetchAll();
            return $obj;
        }
        catch(Exception $e){
            die($e->getMessage());
        }
     }
     public function countResults($n,$m,$h,$l){
        try{
             $sql = "SELECT * FROM fi_users WHERE fname LIKE '%$n%' "." ".$this->buildQuery($n,$m,$h,$l)." UNION (SELECT * FROM fi_users WHERE sname LIKE '%$n%' "." ".$this->buildQuery($n,$m,$h,$l).")";
             $query= $this->handler->prepare($sql);
             $query->execute();
             return $query->rowCount();
        }
        catch(Exception $e){
            die("sever down");
        }
     }


     private function buildQuery($n,$m,$h,$l){
        try{
            if($m == "0" && $h=="0" && $l=="0"){
                $sql = "";
            }
            /*major*/
            elseif($m != "0" && $h=="0" && $l=="0"){
                $sql = "AND majorId = $m";
            }
            /*major and hostel*/
            elseif($m != "0" && $h !="0" && $l =="0"){
                $sql ="AND majorId= $m AND hostelId = $h";
            }
            /*major and hostel and level*/
            elseif ($m != "0" && $h !="0" && $l !="0") {
                $sql ="AND majorId= $m AND hostelId = $h AND level =$l";
            }
            /*hostel*/
            elseif($m == "0" && $h!="0" && $l=="0"){
                $sql = "AND hostelId = $h";
            }
            /*level*/
            elseif($m == "0" && $h=="0" && $l!="0"){
                $sql = "AND level = $l";   
            }
            elseif($m == "0" && $h !="0" && $l !="0") {
                $sql =  "AND hostelId = $h AND level = $l";
            }
            else{
                $sql = "";
            }
            return $sql;
        }
        catch(Exception $e){
            die("server dowm"); 
        }
     }

     public function getAll($page,$per_page){
        try{
            $sql = "SELECT * FROM fi_users ORDER BY safeId DESC LIMIT $page ,$per_page ";
            //$sql = "SELECT * FROM fi_users";
            $query= $this->handler->prepare($sql);
            $query->execute();
            $query->setFetchMode(PDO::FETCH_OBJ); 
            $obj = $query->fetchAll();
            return $obj;
        }
        catch(Exception $e){
            die("server down");
        }
     }

     public function countAll(){
        try{
             $sql = "SELECT * FROM fi_users";
             $query= $this->handler->prepare($sql);
             $query->execute();
             return $query->rowCount();
        }
        catch(Exception $e){
            die("sever down");
        }
     }
     /***************End Search Engine************************/
     private function sendemail($email,$tokken,$id){
        try{
            $sent = false;
            $mail = new PHPMailer;
            //From email address and name
            $mail->From = "tatemunenge@gmail.com";
            $mail->FromName = "Creative Studios";
            $mail->addAddress($email, "solusi-fi user");
            //Address to which recipient will reply
            $mail->addReplyTo("tatemunenge@munenge", "Reply");
            //html mode
            $mail->isHTML(true);
            $mail->Subject = "Account Activation";
            $mail->Body="click this link to activate <a href='https://www.solusi-fi.com/activate.php?tokken=$tokken&candy=$id'>click here</a>";


            
            $mail->AltBody = "hello user you have successifully created an elearning account with the elearning institute your login creditials are email:thank you very much http://www.elearninginstitute.biz";
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



