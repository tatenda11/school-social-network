<?php
include_once("../libs/autoload.php");
$u =Sessions::getSession();
function addFriend(){
	$from = preg_replace("/[^0-9]/","", $_GET['from']);
	$to = preg_replace("/[^0-9]/","", $_GET['to']);
	$myF = new fi_friends();
	$myF->sendRequst($from,$to);
	if($myF->dacCrud == true){
		echo "friend request sent";
	}
}
function removeFriend(){
	//$from = preg_replace("/[^0-9]/","", $_GET['from']);
	$id = preg_replace("/[^0-9]/","", $_GET['id']);
	$myF = new fi_friends();
	$myF->removeFriendship($id);
	if($myF->dacCrud == true){
		echo "friend removed";
	}
}

function acceptFriend(){
	$id = preg_replace("/[^0-9]/","", $_GET['id']);
	$myF = new fi_friends();
	$myF-> acceptRequest($id);
	if($myF->dacCrud == true){
		echo "friend removed";
	}
}

if(isset($_GET['action'])){
	if($_GET['action'] == "add"){
		addFriend();
	}
	elseif($_GET['action'] == "remove"){
		removeFriend();
	}
	elseif($_GET['action'] == "accept"){
		acceptFriend();
	}
}

