<?php
/**
 * handles the users 
 * @author tatenda munenge
 * @link http://www.tate-creative-studio.tech
 * @link tatemunenge@gmail.com
  * @link +263775351170
 * @license http://opensource
 */
class fi_albums extends db_connection{

	public $photoId;
	public $userId;
	public $photoName;
	public $caption;
	public $uploadDate;
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

     public function setPhoto($usr,$pic,$cap){
     	try{
     		$sql = "INSERT INTO fi_albums (userId,photoName,caption) 
     				VALUES (:usr,:pic,:cap) ";
     	    $query = $this->handler->prepare($sql);
     	    $query->bindValue(':cap', $cap, PDO::PARAM_STR);
     	    $query->bindValue(':pic', $pic, PDO::PARAM_STR);
     		$query->bindValue(':usr', $usr, PDO::PARAM_INT);
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
     public function getPhotos($usr,$page,$per_page){
          try{
               $sql = "SELECT * FROM fi_albums WHERE userId = ? LIMIT $page ,$per_page";
               $query= $this->handler->prepare($sql);
               $query->execute(array($usr));
               $query->setFetchMode(PDO::FETCH_OBJ); 
               $obj = $query->fetchAll();
               return $obj;
          }
          catch(Exception $e){
              die("server currently down");
          }
     }
      public function getPhotosDisplay($usr){
          try{
               $sql = "SELECT * FROM fi_albums WHERE userId = ?";
               $query= $this->handler->prepare($sql);
               $query->execute(array($usr));
               $query->setFetchMode(PDO::FETCH_OBJ); 
               $obj = $query->fetchAll();
               return $obj;
          }
          catch(Exception $e){
              die("server currently down");
          }
     }

     public function countPhotos($u){
          try{
               $sql = "SELECT * FROM fi_albums WHERE userId = ?";
               $query= $this->handler->prepare($sql);
               $query->execute(array($u));
               $f_check = $query->rowCount();
               return $f_check;
          }
          catch(Exception $e){
               die("server currently down");
          }
     }
}