<?php
/**
 * handles the users 
 * @author tatenda munenge
 * @link http://www.tate-creative-studio.tech
 * @link tatemunenge@gmail.com
  * @link +263775351170
 * @license http://opensource
 */
class fi_likes extends db_connection{
	public $likeId;
	public $itemId;
	public $likeTyp;
	public $userId;
	public $dacFound = false;
	public$dacCrud = false;
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

     public function addLike($user,$typ,$item){
     	try{
     		$sql = "INSERT INTO fi_likes (itemId,likeTyp,userId) VALUES (:item,:typ,:user)";
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':user', $user, PDO::PARAM_INT);
     		$query->bindValue(':typ', $typ, PDO::PARAM_STR);
     		$query->bindValue(':item', $item, PDO::PARAM_INT);
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

     public function unlike($user,$typ,$item){
		try{
			$sql = "DELETE FROM fi_likes WHERE itemId = :item AND likeTyp = :likeTyp AND userId = :user LIMIT 1";
			$query = $this->handler->prepare($sql);
     		$query->bindValue(':user', $user, PDO::PARAM_INT);
     		$query->bindValue(':likeTyp', $typ, PDO::PARAM_STR);
     		$query->bindValue(':item', $item, PDO::PARAM_INT);
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

	public function countLikes($typ,$item){
		try{
			$sql = "SELECT likeId FROM fi_likes WHERE itemId = :item AND likeTyp = :likeTyp ";
			$query = $this->handler->prepare($sql);
     		$query->bindValue(':likeTyp', $typ, PDO::PARAM_STR);
     		$query->bindValue(':item', $item, PDO::PARAM_INT);
     		$query->execute();
     		return $query->rowCount();
		}
		catch(Exception $e){
			die($e->getMessage());
		}
	}

     public function getLikers($item){
          try{
               $sql = "SELECT userId FROM fi_likes WHERE itemId = :item ";
               $query = $this->handler->prepare($sql);
               $query->bindValue(':item', $item, PDO::PARAM_INT);
               $query->execute();
               $query->setFetchMode(PDO::FETCH_OBJ); 
               $obj = $query->fetchAll();
               return $obj;
          }
          catch(Exception $e){
               die("server currently down");
          }
     }

      public function getLikersTypo($item,$typ){
          try{
               $sql = "SELECT userId FROM fi_likes WHERE itemId = :item AND likeTyp= :typ ";
               $query = $this->handler->prepare($sql);
               $query->bindValue(':item', $item, PDO::PARAM_INT);
               $query->bindValue(':typ', $typ, PDO::PARAM_INT);
               $query->execute();
               $query->setFetchMode(PDO::FETCH_OBJ); 
               $obj = $query->fetchAll();
               return $obj;
          }
          catch(Exception $e){
               die($e->getMessage());
          }
     }

	public function checkLike($user,$typ,$item){
		try{
			$sql = "SELECT likeId FROM fi_likes WHERE itemId = :item AND likeTyp = :likeTyp AND userId = :user LIMIT 1";
			$query = $this->handler->prepare($sql);
     		$query->bindValue(':user', $user, PDO::PARAM_INT);
     		$query->bindValue(':likeTyp', $typ, PDO::PARAM_STR);
     		$query->bindValue(':item', $item, PDO::PARAM_INT);
     		$query->execute();
     		if($query->rowCount()){
     			return true;
     		}else{
                    return false;
               }
     				
		}
		catch(Exception $e){
			die($e->getMessage());
		}
	}

}