<?php 
require_once("../libs/autoload.php");
$u = Sessions::getSession();

if(isset($_GET['act'])){
	$e =  preg_replace("/[^0-9]/","", $_GET['act']);
	$s = cleanSql(strip_tags($_GET['status']));
	$myE = new fi_attending();
	if($myE->checkAttending($u,$e)== false){
		$myE->setAttending($e,$u,$s);
		if($myE->dacCrud==true){
			echo("attending status noted");
		}
	}
	else{
		$myE->updateAttending($u,$e,$s);
		if($myE->dacCrud==true){
			echo("attending status noted");
		}
	}	
}
if(isset($_GET['user'])){
	$user =  preg_replace("/[^0-9]/","", $_GET[ 'user']);
	$myu = new fi_users();
	$info = $myu->headerInfo($user);
	$html = "<img src='userInfo/".$info['sid']."/thumbnail_".$info['propic']."'/>";
	$html .= "<a href='profiles.php?profile=".$info['sid']."'>".$info['fname']." ".$info['surName']."</a>";
	echo $html;
}