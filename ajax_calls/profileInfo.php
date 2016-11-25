<?php
include_once("../libs/autoload.php");
$u = Sessions::getSession();
if(isset($_POST['personal'])){
	//$u = $_SESSION['fi_user'];
	$myu = new fi_users();
	$myu->getUser($u);
	$myu->fname =  cleanSql(strip_tags($_POST['fn']));
	$myu->sname =  cleanSql(strip_tags($_POST['sn']));
	$myu->hometown = cleanSql(strip_tags($_POST['htown']));
	$myu->birthday = cleanSql(strip_tags($_POST['bday']));
	//$myu->birthday = date("Y-m-d H:i:s",strtotime(str_replace('/','-',$_POST['bday'])));
	$myu->mdlname = cleanSql(strip_tags($_POST['mname']));
	$myu->bio = cleanSql(strip_tags($_POST['bio']));
	$myu->updateprofile($u);
	if($myu->dacCrud == true){
		echo "updated";
	}
	else{
		echo"failed";
	}
}
if(isset($_POST['academic'])){
	//$u = $_SESSION['fi_user'];
	$myu = new fi_users();
	$myu->getUser($u);
	$myu->level =  cleanSql(strip_tags($_POST['level']));
	$myu->hostelId =  cleanSql(strip_tags($_POST['hostel']));
	$myu->majorId =  cleanSql(strip_tags($_POST['major']));
	$myu->hghschool =  cleanSql(strip_tags($_POST['school']));
	$myu->updateprofile($u);
	if($myu->dacCrud == true){
		echo "updated";
	}
	else{
		echo"failed";
	}

}

if(isset($_GET['changePass'])){
	$myl = new fi_logins();
	$newpass = cleanSql(strip_tags($_GET['newPass']));
	$oldpass = cleanSql(strip_tags($_GET['oldpass']));
	$myl->updatePassword($oldpass,$u,$newpass);
	if($myl->dacFound == false){
		echo "your password does not match the original";
	}
	elseif($myl->dacCrud == true){
		echo "passChanged";
	}
	else{
		echo $myl->dacFound;
	}
	
}




