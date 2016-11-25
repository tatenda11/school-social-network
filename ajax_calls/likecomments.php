<?php
require_once("../libs/autoload.php");
$u = Sessions::getSession();
if(isset($_GET['likeComment'])){
	$comment = preg_replace("/[^0-9]/","", $_GET['commentId']);
	$owner = preg_replace("/[^0-9]/","", $_GET['user']);
	$typ = "C";
	$u = Sessions::getSession();
	$myL = new fi_likes();
	if($myL->checkLike($u,$typ,$comment)==false){
		$myL->addLike($u,$typ,$comment);
		if($myL->dacCrud == true){
			echo "liked";
			$myN = new fi_notifications();
			$myN->setNotifivation($u,$owner,"liked","comment",$comment);
		}	
	}
	else{
		$myL->unlike($u,$typ,$comment);
		if($myL->dacCrud == true){
			echo"unliked";
		}	
	}
}
