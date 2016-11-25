<?php
	require_once("./libs/autoload.php");
	require_once("./libs/manageNotes.php");
	$u = $_SESSION['fi_user'];
	$myu = new fi_users();
	$myN = new fi_notes();
if(isset($_POST['btnUpload'])){
	$name = $_FILES['file']['name'];
    $data = $_FILES['file']['tmp_name'];
    $des = $_POST['txtdescription'];
    $fullpath = "files".$data;
    $moved = $moved = move_uploaded_file($data,$fullpath);
    if($moved){
    	$myN->setNotes($name,$des,$des);
    	if($myN->dacCrud == true){
    		echo "upload sucesss";
    	}
    }
}