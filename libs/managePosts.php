<?php
/**
 * handles the users 
 * @author tatenda munenge
 * @link http://www.tate-creative-studio.tech
 * @link tatemunenge@gmail.com
  * @link +263775351170
 * @license http://opensource
 */
class fi_posts extends db_connection{
	public $postId;
	public $userId;
	public $posttyp;
	public $sharing;
	public $wall;
	public $postDate;
	public $postText;
	public  $media;
	private $handler;
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

     public function setPost($u,$typ,$sharing,$wall,$txt,$photo,$youtube,$agent){
     	try{
     		$sql = "INSERT INTO fi_posts (userId,posttyp,sharing,wall,postDate,photo,youtube,postText,agent)
     				VALUES(:user,:typ,:share,:wall,NOW(),:photo,:youtube,:txt,:agent)
     			";
     		$query = $this->handler->prepare($sql);	
     		$query->bindValue(':user', $u, PDO::PARAM_INT);
     		$query->bindValue(':typ', $typ, PDO::PARAM_STR);
     		$query->bindValue(':share', $sharing, PDO::PARAM_STR);
     		$query->bindValue(':wall', $wall, PDO::PARAM_STR);
               $query->bindValue(':agent', $agent, PDO::PARAM_STR);
     		//$query->bindValue('pdate',,$date, PDO::PARAM_STR);
               $query->bindValue(':photo', $photo, PDO::PARAM_STR);
               $query->bindValue(':youtube', $youtube, PDO::PARAM_STR);
     		$query->bindValue(':txt', $txt, PDO::PARAM_STR);
     		$query->execute();
     		if($query){
     			$this->dacCrud = true;
                    $this->postId = $this->handler->lastInsertId();
     		}
     		return $this->dacCrud;
     	}
     	catch(Exception $e){
     		die($e->getMessage());	
     	}
     }
     public function getPost($post,$u){
          try{
               $sql = "SELECT * FROM fi_posts WHERE postId = :p AND wall = :u LIMIT 1";
               $query = $this->handler->prepare($sql); 
               $query->bindValue(':p', $post, PDO::PARAM_INT);
               $query->bindValue(':u', $u, PDO::PARAM_INT);
               $query->execute();
               $query->setFetchMode(PDO::FETCH_OBJ);
               $obj = $query->fetch();
               if($query->rowCount()){
                    $this->dacFound = true;
                    $this->postId = $obj->postId;
                    $this->userId = $obj->userId;
                    $this->wall = $obj->wall;
                    $this->postText = $obj->postText;
                    $this->sharing = $obj->sharing;
               }

          }
          catch(Exception $e){
               die("server currently down");
          }
     } 

     public function updatePost($post,$u,$text){
          try{
               $sql = "UPDATE fi_posts SET postText = :txt WHERE wall = :u AND postId = :post LIMIT 1";
               $query = $this->handler->prepare($sql);
               $query->bindValue(':post', $post, PDO::PARAM_INT);
               $query->bindValue(':u', $u, PDO::PARAM_INT);
               $query->bindValue(':txt', $text, PDO::PARAM_STR);
               $query->execute();
               if($query){
                    $this->dacCrud =true;
               }
               return $this->dacCrud;
          }
          catch(Exception $e){
             die($e->getMessage());  
          }
     }
     public function getWallPosts($u,$page,$per_page){
          try{
               $sql = "SELECT * FROM fi_posts WHERE wall = ? AND agent = ? ORDER BY postId DESC LIMIT $page ,$per_page";
               $query = $this->handler->prepare($sql);
               $query->execute(array($u,"U"));
               $query->setFetchMode(PDO::FETCH_OBJ); 
               $obj = $query->fetchAll();
               return $obj; 
          }
          catch(Exception $e){
               die("server currently down");
          }
     }

      public function getById($post){
          try{
               $sql = "SELECT * FROM fi_posts WHERE postId = :post";
               $query = $this->handler->prepare($sql);
               $query->bindValue(':post', $post, PDO::PARAM_INT);
               $query->execute();
               $query->setFetchMode(PDO::FETCH_OBJ); 
               $rs = $query->fetchAll();
               return $rs; 
          }
          catch(Exception $e){
               die("server currently down");
          }
     }

     public function countWallPost($u,$agent){
          try{

               $sql = "SELECT * FROM fi_posts WHERE wall = ? AND agent = ?";
               $query = $this->handler->prepare($sql);
               $query->execute(array($u,$agent));
               $c_check = $query->rowCount();
               return $c_check;
          }
          catch(Exception $e){
               die($e->getMessage());
          }
     }

     public function deletePost($u,$p){
     	try{
     		$sql = "DELETE FROM fi_posts WHERE postId = :p AND wall= :u LIMIT 1";
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':p', $p, PDO::PARAM_INT);
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


     public function getnewsFeed($u,$page,$per_page){
          try{
             $sql = "SELECT * FROM fi_posts  ORDER BY postId DESC LIMIT $page ,$per_page";
               $query = $this->handler->query($sql);
               $query->setFetchMode(PDO::FETCH_OBJ); 
               $obj = $query->fetchAll();
               return $obj; 
             
          }
          catch(Exception $e){
               die("Server currently down");
          }
     }
      
      public function countNewsFeed($u){
          try{
               $sql = "SELECT * FROM fi_posts  ORDER BY postId DESC";
               $query = $this->handler->query($sql);
               $query->execute();
               $c_check = $query->rowCount();
               return $c_check;
          } 
          catch(Exception $e){
               die("server currently down");
          }  
      }

      public function getForumPosts($forum,$page,$per_page){
          try{
               $sql = "SELECT * FROM fi_posts WHERE wall = ? AND agent = ? ORDER BY postId DESC LIMIT $page ,$per_page";
               $query = $this->handler->prepare($sql);
               $query->execute(array($forum,"P"));
               $query->setFetchMode(PDO::FETCH_OBJ); 
               $obj = $query->fetchAll();
               return $obj;
          }
          catch(Exception $e){
               die("server currently down");
          }
      }



}	








