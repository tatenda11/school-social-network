<?php
	require_once("./libs/autoload.php");
	if(isset($_POST['fn'])){
		
		$fn = cleanSql(strip_tags($_POST['fn']));
		$sn = cleanSql(strip_tags($_POST['sn']));
		$sId = cleanSql(strip_tags($_POST['sId']));
		$mj = cleanSql(strip_tags($_POST['mj']));
		$gn = cleanSql(strip_tags($_POST['gn']));
		$pass = $_POST['pass'];
		if(empty($fn) || empty($sn) || empty($sId) || empty($pass)){
			echo"all fields are required";
		}
		else{
			$myU = new fi_users();
			$myL = new fi_logins();
			$myS  = new fi_settings();
			$myT = new fi_tokkens();
			$myL->checkExists($sId);
			if($myL->dacFound == false){
				$id = $myL->setLogin($sId,$pass);
				if($myL->dacCrud == true){
					$myU->setAccount($fn,$sn,$id,$gn,$mj,$sId);
					if($myU->dacCrud == true){
						$myU->studentId = $sId;
						$myS->setSetings($id);
						$tokken = $myT->setTokken($id);
						$myU->intiateUser($id,$tokken);

						echo "creation success";
					}
				}
				
			}
			else{
				echo"student id already taken ";
			}
		}
	
		//echo cleanSql(strip_tags($_POST['fn']));
	}