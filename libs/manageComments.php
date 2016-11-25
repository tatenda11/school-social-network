<?php
/**
 * handles the users 
 * @author tatenda munenge
 * @link http://www.tate-creative-studio.tech
 * @link tatemunenge@gmail.com
  * @link +263775351170
 * @license http://opensource
 */
class fi_comments extends db_connection{
	
	public $commentId;
	public $userId;
	public $comment;
	public $commentDate;
	public $postId;
	private $handler;
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

     public function setComment($com,$usr,$post){
     	try{
     		$sql = "INSERT INTO fi_comments (userId, comment, postId,commentDate)
     				VALUES(:user,:comment,:post, NOW())
     				";
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':user', $usr, PDO::PARAM_INT);
     		$query->bindValue(':comment', $com, PDO::PARAM_STR);	
     		$query->bindValue(':post', $post, PDO::PARAM_INT);		
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
     public function getByPost($post){
     	try{
     		$sql = "SELECT * FROM fi_comments WHERE postId = :post ORDER BY commentId ASC";
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':post', $post, PDO::PARAM_INT);
     		$query->execute();
     		$query->setFetchMode(PDO::FETCH_OBJ); 
     		$rs = $query->fetchAll();
     		return $rs;
     	}
     	catch(Expetion $e){
     		die("Server currently down");	
     	}
     }
     public function countComments($post){
     	try{
     		$sql = "SELECT * FROM fi_comments WHERE postId = :post";
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':post', $post, PDO::PARAM_INT);
     		$query->execute();
     		$c_check = $query->rowCount();
               return $c_check;
     	}
     	catch(Excpetion $e){
     		die("Server currently down");	
     	}
     } 

     public function getPostId($commentId){
          try{
               $sql = "SELECT postId FROM fi_comments WHERE commentId = :comment";
               $query = $this->handler->prepare($sql);
               $query->bindValue(':comment', $commentId, PDO::PARAM_INT);
               $query->execute();
               $c_check = $query->fetchColumn();
               return $c_check;

          }
          catch(Excpetion $e){
               die("server currently down");
          }
     }
     public function deleteComment($u,$comment){
     	try{
     		$sql = "DELETE FROM fi_comments WHERE userId = :user AND  commentId = :comment";
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':user', $u, PDO::PARAM_INT);
     		$query->bindValue(':comment', $comment, PDO::PARAM_INT);
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
     public function getComment($u,$commentId){
          try{
               $sql = "SELECT * FROM fi_comments WHERE commentId = :comment AND userId = :user LIMIT 1";
               $query = $this->handler->prepare($sql);
               $query->bindValue(':user', $u, PDO::PARAM_INT);
               $query->bindValue(':comment', $commentId, PDO::PARAM_INT);
               $query->execute();
               if($query->rowCount()){
                    $this->dacFound = true;
                    $query->setFetchMode(PDO::FETCH_OBJ);
                    $obj = $query->fetch();
                    $this->commentId = $obj->commentId;
                    $this->userId = $obj->userId;
                    $this->comment = $obj->comment;
               }
               return $this->dacFound;
          }
          catch(Exception $e){
               die($e->getMessage());
          }
     }

     public function updateComment($u,$id,$text){
          try{
               $sql = "UPDATE fi_comments SET comment = :txt WHERE userId = :u AND commentId = :comment LIMIT 1";
               $query = $this->handler->prepare($sql);
               $query->bindValue(':u', $u, PDO::PARAM_INT);
               $query->bindValue(':comment', $id, PDO::PARAM_INT);
               $query->bindValue(':txt', $text, PDO::PARAM_STR);
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
}

