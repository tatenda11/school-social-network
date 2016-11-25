<?php
/**
 * handles the users 
 * @author tatenda munenge
 * @link http://www.tate-creative-studio.tech
 * @link tatemunenge@gmail.com
  * @link +263775351170
 * @license http://opensource
 */
class fi_pages extends db_connection{
	public $pageId;
	public $description;
	public $adminId;
	public $coverphoto;
	public $title;
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

     public function createPage($admin,$des,$title,$pic){
     	try{
     		$sql = "INSERT INTO fi_pages (adminId,description,title,coverphoto) VALUES (:admin,:des,:title,:pic)";
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':admin', $admin, PDO::PARAM_INT);
     		$query->bindValue(':des', $des, PDO::PARAM_STR);
     		$query->bindValue(':title', $title, PDO::PARAM_STR);
               $query->bindValue(':pic', $pic, PDO::PARAM_STR);
     		$query->execute();
     		if($query){
     			$this->dacCrud = true;
                    $this->pageId = $this->handler->lastInsertId();
     		}
     		return $this->dacCrud;

     	}
     	catch(Exception $e){
     		die("sever currently down");
     	}

     }

     public function getPage($page){
     	try{
     		$sql = "SELECT * FROM fi_pages WHERE pageId = :page LIMIT 1";
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':page', $page, PDO::PARAM_INT);
     		$query->execute();
     		$query->setFetchMode(PDO::FETCH_OBJ); 
     		$obj = $query->fetch();
     		if($query->rowCount()){
                    $this->dacFound = true;
                    $this->title = $obj->title;
                    $this->description = $obj->description;
                    $this->coverphoto = $obj->coverphoto;
                    $this->pageId = $obj->pageId;
                    $this->adminId = $obj->adminId;
               }
     	}
     	catch(Exception $e){
     		die("sever currently down");	
     	}
     }

     public function editPage($page){
     	try{
     		$sql = "UPDATE fi_pages SET description = :des, title = :title, coverphoto = :photo WHERE pageId = :page ";
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':page', $page, PDO::PARAM_INT);
     		$query->bindValue(':title', $this->title, PDO::PARAM_STR);
     		$query->bindValue(':des', $$this->description, PDO::PARAM_STR);
     		$query->bindValue(':coverphoto', $this->coverphoto, PDO::PARAM_STR);
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
     public function headerInfo($page){
     	try{
               $sql = "SELECT title,pageId,description,coverphoto FROM fi_pages WHERE pageId = :page";
               $query = $this->handler->prepare($sql);
               $query->bindValue(':page', $page, PDO::PARAM_INT);
               $query->execute();
               $query->setFetchMode(PDO::FETCH_OBJ); 
               $obj = $query->fetch();
               $info = array("title"=>$obj->title, "coverphoto"=>$obj->coverphoto, "pageId"=>$obj->pageId);
               return $info;
     	}
     	catch(Exception $e){
     		die('server currently down');
     	}
     }

}

