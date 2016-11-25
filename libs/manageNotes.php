<?php
/**
 * handles the users 
 * @author tatenda munenge
 * @link http://www.tate-creative-studio.tech
 * @link tatemunenge@gmail.com
  * @link +263775351170
 * @license http://opensource
 */
class fi_notes extends db_connection{
	public $notesId;
	public $safename;
	public $description;
	public $course;
	public $uploadDate;
	public $dacCrud = false;
	public $dacFound = false;
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

     public function setNotes($safename,$des,$course,$u){
     	try{
     		$sql = "INSERT INTO fi_notes (safename,description,course,userId) VALUES (:sfn,:des,:crs,:usr)";
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':sfn', $safename, PDO::PARAM_STR);
     		$query->bindValue(':des', $des, PDO::PARAM_STR);
     		$query->bindValue(':crs', $course, PDO::PARAM_STR);
               $query->bindValue(':usr', $u, PDO::PARAM_INT);
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

     public function getNotes($page,$per_page){
     	try{
     		$sql = "SELECT * FROM fi_notes ORDER BY notesId DESC LIMIT $page ,$per_page";
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

     public function countNotes(){
     	try{
     		$query = $this->handler->query("SELECT notesId FROM fi_notes ");
     		$n_check = $query->rowCount();
     		return $n_check;
     	}
     	catch(Exception $e){
     		die("Server currently down");		
     	}
     }

      public function runSearch($key){
          try{
               $sql = "SELECT * FROM fi_notes WHERE WHERE MATCH (description) AGAINST (':key')";
               $query = $this->handler->prepare($sql);
               $query->bindValue(':key',$key,PDO::PARAM_STR);
               $query->execute();
               $query->setFetchMode(PDO::FETCH_OBJ);
               $obj = $query->fetchAll();
               return $obj;
          }
          catch(Exception $e){
               die("server currently down");
          }
      }


}