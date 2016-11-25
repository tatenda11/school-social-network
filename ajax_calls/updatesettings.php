<?php 
include_once("../libs/autoload.php");
$u = Sessions::getSession();
if(isset($_GET['setting'])){
	$setting = cleanSql(strip_tags($_GET['setting']));
	$myS = new fi_settings();
	if($myS->editAccess($u,$setting) == true){
		echo "updated";
	}else{
		echo "failed";
	}
}
