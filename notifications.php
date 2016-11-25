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
	$myN = new fi_notifications();
	$myL = new fi_logins();
    //$nofifications = $myN->getNotifications($u,$myL->getLastLog($u));
	$myu->getUser($u);
	if(isset($_GET['page'])){
		$page =  preg_replace("/[^0-9]/","", $_GET['page']);
	}
	else{
		$page = 1;
	}
	$count = $myN->countNotifications();
	$paginations = paginateNull($count,$page,20);
	if($count > 0){
		$nofifications = $myN->getNotificationsAll($u,$paginations['limit'],20);	
	}
	else{
		$nofifications = array();
	}
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
		<div class='panel-heading' style='margin:auto;'>Notifications</div>
			<?php foreach ( $nofifications as $Notification): ?>
		 	 	<?php $info = $myu->headerInfo($Notification->notFrom);?>
		 	 	<div class='not-holder2'>
				<img class='notpic' src="./userInfo/<?= $info['sid']?>/thumbnail_<?= $info['propic']?>" alt=''/>
					<p>
					<a href='profiles.php?profile=<?= $info['sid']?>'><?php echo $info['fname']." ".$info['surName']?></a><span style='color:#fff;'>t</span>
					<?php 
						echo $Notification->notification.getPrintText($Notification->notTo,$Notification->notTyp,$Notification->itemId);
					?>
					<time class="timeago" datetime="<?= $Notification->notDate ?>" title="July 17, 2016"></time>
				</p>
				</div>	
			<?php endforeach;?>	
			<div class="pagination-holder">
							<ul class="pagination-list">
								<?php echo $paginations['display'];?>
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