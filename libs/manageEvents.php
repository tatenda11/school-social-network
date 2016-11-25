<?php
/**
 * handles the users 
 * @author tatenda munenge
 * @link http://www.tate-creative-studio.tech
 * @link tatemunenge@gmail.com
  * @link +263775351170
 * @license http://opensource
 */
class fi_events extends db_connection{

	public $eventId;
	public $eventName;
	public $eventDescription;
	public $startDate;
	public $startTime;
	public $endTime;
	public $venue;
	public $cost;
	public $userId;
     public $pic;
	public $otherInfo;
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

     public function setEvent($name,$des,$date,$stime,$etime,$venue,$cost,$user,$info,$pic){
     	try{
     		$sql = "INSERT INTO fi_events (eventName,eventDescription,startDate,startTime,
     										endTime,venue,cost,userId,otherInfo,pic)
				    VALUES(:name,:des,:day,:stime,:etime,:venue,:cost,:user,:info,:pic)";
     		$query = $this->handler->prepare($sql);
     		$query->bindValue(':user', $user, PDO::PARAM_INT);
     		$query->bindValue(':des', $des, PDO::PARAM_STR);
     		$query->bindValue(':day', $date);
     		$query->bindValue(':name', $name, PDO::PARAM_STR);
        $query->bindValue(':pic', $pic, PDO::PARAM_STR);
     		$query->bindValue(':stime', $stime, PDO::PARAM_STR);
     		$query->bindValue(':etime', $etime, PDO::PARAM_STR);
     		$query->bindValue(':venue', $venue, PDO::PARAM_STR);
     		$query->bindValue(':cost', $cost, PDO::PARAM_STR);
     		$query->bindValue(':info', $info, PDO::PARAM_STR);
     		$query->execute();
     		if($query){
     			$this->dacCrud = true;
     			$this->eventId = $this->handler->lastInsertId();
     		}

     	}
     	catch(Exceprtion $e){
     		die($e->getMessage());	
     	}
     }

     public function getEvent($id){
          try{
               $sql = "SELECT * FROM fi_events WHERE eventId = :id";
               $query = $this->handler->prepare($sql);
               $query->bindValue(':id', $id, PDO::PARAM_INT);
               $query->execute();
               $query->setFetchMode(PDO::FETCH_OBJ); 
               $obj = $query->fetch();
               $this->eventId = $obj->eventId;
               $this->eventName = $obj->eventName;
               $this->eventDescription = $obj->eventDescription;
               $this->startTime = $obj->startTime;
               $this->startDate = $obj->startDate;
               $this->endTime = $obj->endTime;
               $this->cost = $obj->cost;
               $this->otherInfo = $obj->otherInfo;
               $this->pic = $obj->pic;
               $this->venue = $obj->venue;
               $this->userId = $obj->userId;

          }
          catch(Exception $e){
               die("server currently down");
          }
     } 

     public function editEvent($eventId){
          try{
               $sql = "UPDATE fi_events SET eventName = :name, eventDescription =:des,
                                            startTime = :stym, startDate = :sdate, 
                                            endTime = :etime, cost= :cost, otherInfo = :info,
                                            pic = :pic, venue = :venue 
                       WHERE eventId = :id  LIMIT 1                                 
                    ";
               echo $sql;
                $query = $this->handler->prepare($sql);
                $query->bindValue(':id', $this->eventId, PDO::PARAM_INT);
                $query->bindValue(':des', $this->eventDescription, PDO::PARAM_STR);
                $query->bindValue(':stym', $this->startTime,PDO::PARAM_STR);
                $query->bindValue(':name', $this->eventName, PDO::PARAM_STR);
                $query->bindValue(':sdate', $this->startDate, PDO::PARAM_STR);
                $query->bindValue(':etime', $this->endTime, PDO::PARAM_STR);
                $query->bindValue(':venue', $this->venue, PDO::PARAM_STR);
                $query->bindValue(':cost', $this->cost, PDO::PARAM_STR);
                $query->bindValue(':info', $this->otherInfo, PDO::PARAM_STR);
                $query->bindValue(':pic', $this->pic, PDO::PARAM_STR);
                $query->execute();
                if($query){
                    $this->dacCrud = true;
                }
               return $this->dacCrud;

          }
          catch(Exceprtion $e){
               die("server currently down");
          }
     }

     public function deleteEvent($event){
          try{
               $sql = "DELETE FROM fi_events WHERE eventId = :id";
               $query = $this->handler->prepare($sql);
               $query->bindValue(':id', $event, PDO::PARAM_INT);
               $query->execute();
               if($query){
                    $this->dacCrud = true;
               }
               return $this->dacCrud;
          }
          catch(Exceprtion $e){
               die("server currently down");
          }
     }

     public function getEventsAll(){
        try{
            $sql = "SELECT * FROM fi_events ORDER BY eventId DESC";
            $query = $this->handler->prepare($sql);
            $query->setFetchMode(PDO::FETCH_OBJ); 
             $query->execute();
            $obj = $query->fetchAll();
            return $obj;
        }
        catch(Exceprtion $e){
            die("server currently down");
        }
     }



}	

