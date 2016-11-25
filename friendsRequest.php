<?php
	require_once("./libs/autoload.php");
	Sessions:: autheticate();
	$u = $_SESSION['fi_user'];
	$myC = new fi_comments();
	function getPrintText($notTo,$notTyp,$id){
	global $u,$myC;
	$to = " a";
	if($notTo == $u){
		$to = " your";
	}
	if($notTyp== "comment"){
		$id = $myC->getPostId($id);
	}
	return $to." "."<a href='post.php?post=$id'>$notTyp</a>";
}
	$myu = new fi_users();
	$myF = new fi_friends();
    //$nofifications = $myN->getNotifications($u,$myL->getLastLog($u));
	$myu->getUser($u);
	if(isset($_GET['page'])){
		$page =  preg_replace("/[^0-9]/","", $_GET['page']);
	}
	else{
		$page = 1;
	}
	/*$count = $myN->countNotifications();
	$paginations = paginateNull($count,$page,20);
	if($count > 0){
		$nofifications = $myN->getNotificationsAll($u,$paginations['limit'],20);	
	}
	else{
		$nofifications = array();
	}*/
	$friends = $myF->getRequests($u)
?>
<?php require_once("./views/header.php");?>
<style>
#notifications{
	width: 30%;
	height: auto;
	background-color: #fff;
	margin-top: 30px;
	float: left;
}
#ads{
	margin-top: 30px;
	width: 20%;
	float: left;
	margin-left: 2%;
}
.not-holder2{
	width: 100%;
	float: left;
	padding: 2%;
	border-bottom: 2px solid #F3F3F3;
	clear: both;
}
.notpic{
	padding: 3px;
	float: left;
}
.not-holder2 p{
	width: auto;
	width: 60%;
	padding: 1%;
	margin-left: 1%;
	top: 0px;
	float: left;
	display: inline-block;
}
@media only screen and (min-width: 150px) and (max-width: 600px){
#notifications{
	width: 95%;
}
#ads{
	clear: both;
	display: block;
	width: 95%;
}
}
</style>
<div id='container'>
	<div id="notifications" class='panel panel-default'>
		<div class='panel-heading' style='margin:auto;'>Friend Requests</div>
			<?php foreach ( $friends as $friend): ?>
		 	 	<?php $info = $myu->headerInfo($friend->friendFrom);?>
		 	 	<div class='not-holder2'>
		 	 		<img class='notpic' src="./userInfo/<?= $info['sid'] ?>/thumbnail_<?= $info['propic']?>" alt=''/>
		 	 		<a href='profiles.php?profile=<?= $info['sid'] ?>'><?php echo $info['fname']." ".$info['surName'];?></a>  send you a friend request <br>
		 	 		<div class='btn-group pull-right' role='group' aria-label='...'>
						<button type='button' onClick='deleteRequest(<?=$friend->friendshipId?>);' class='btn btn-defauli btn-sm spacer'>Delete Request</button>
						<button type='button'  onClick='acceptRequest(<?=$friend->friendshipId?>);'class='btn btn-primary btn-sm spacer'>Accept Request</button>
					</div>
		 	 	</div>
			<?php endforeach;?>	
			<div class="pagination-holder">
				<ul class="pagination-list">
					<?php //echo $paginations['display'];?>
				</ul>	
			</div> 
	</div>
	<div id="ads">
		<img src="./imgs/ad.jpg"/>	
	</div>
</div>
<footer>
	<div id="foot-container">
		<ul>
			<li>&copy; 2016  tatenda munenge productions</li>
		</ul>
	</div>
</footer>	
		<script type="text/javascript" src="js/home.js"></script>	
	</body>	
</html>