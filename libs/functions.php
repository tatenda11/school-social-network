<?php
$error = false;
$success = false;
$error_msg = "";
$success_message = ""; 

function redirect($url){
	header("location:$url");
}
function validateFile($safename){
	try{
		$passed = false;
		$allowed = array('jpg','png','gif','GIF','PNG','JPG');
		$ext = pathinfo($safename, PATHINFO_EXTENSION);
		if( in_array( $ext, $allowed )) {
			$passed = true;
		}
		return $passed;
	}
	catch(Exception $e){
		die($e->getMessage);
	}
}
function validateDocument($safename){
	try{
		$passed = false;
		$allowed = array('jpg','html','png','gif','pdf','csv','docx','doc','pptx','txt','xlsx','DOT','DOTX','ppt');
		$ext = pathinfo($safename, PATHINFO_EXTENSION);
		if( in_array( $ext, $allowed )) {
			$passed = true;
		}
		return $passed;
	}
	catch(Exception $e){
		die($e->getMessage);
	}
}
function createError($err){
	try{
		global $error,$error_msg;
		$error = true;
		$error_msg = $err;
	}
	catch(Exception $e){
		die($e->getMessage);
	}
}
function getPageImage($page,$photo){
	if($photo == "default.jpg"){
		$returnStr = "./pages/thumbnail_default.jpg";
	}
	else{
		$returnStr = "pages/page$page/thumbnail_".$photo;
	}
	return $returnStr;
}
function getPageImageCover($page,$photo){
	if($photo == "default.jpg"){
		$returnStr = "./pages/cover_default.jpg";
	}
	else{
		$returnStr = "pages/page$page/cover_".$photo;
	}
	return $returnStr;
}

function cleanXss($val){
	return strip_tags($val);
}

function getSex($gn){
	if($gn == "M"){
		$say = "his";
	}
	else{
		$say = "her";
	}
	return $say;
}
function processImage($target,$newcopy,$w,$h,$typ){
	$img = "";
	list($w_orig,$h_orig) = getimagesize($target);
	$aspect_ratio = $w_orig / $h_orig;
	if(($w/$h) > $aspect_ratio){
		$w = $h * $aspect_ratio;
	}
	else{
		$h = $w / $aspect_ratio;
	}
	switch ($typ){
    	case "jpg" or "JPG":
        	$img = imagecreatefromjpeg($target);
        break;
    	case "png" or "PNG":
        	$img = imagecreatefrompng($target);
        break;
    	case "gif" or "GIF":
        	$img = imagecreatefromgif($target);
        break;
	}
	$tci = imagecreatetruecolor($w, $h);
	imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig,$h_orig);
	imagejpeg($tci,$newcopy,100);	
}

function thumbnailPhoto($sId,$pic,$gn){
   if($pic == "default.jpg"){
   		if($gn == "M"){
   			$display = "files/thumbnail_male.png";
   		}
   		else{
   			$display = "files/thumbnail_female.png";
   		}
   }
   else{
   		$display = "./userInfo/".$sId."./thumbnail_".$pic;
   }
	return $display;
}

function profilePhoto($sId,$pic,$gn){
	 if($pic == "default.jpg"){
   		if($gn == "M"){
   			$display = "files/profiles_male.png";
   		}
   		elseif($gn == "F"){
   			$display = "files/profiles_female.jpg";
   		}
   }
   else{
   		$display = "./userInfo/".$sId."./profiles_".$pic;
   }
	return $display;
}

function getpath($sid){
	$path = "./userInfo/".$sid."/";
	return $path;
}
function deleteDirectory($dirPath) {
    if (is_dir($dirPath)) {
        $objects = scandir($dirPath);
        foreach ($objects as $object) {
            if ($object != "." && $object !="..") {
                if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
                    deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
                } else {
                    unlink($dirPath . DIRECTORY_SEPARATOR . $object);
                }
            }
        }
    reset($objects);
    rmdir($dirPath);
    }
}
function cleanSql($var){
	if( function_exists( "mysql_real_escape_string" ) ){
		$var = addslashes($var);
	}
	return $var;
}

function extractSession($val){
	$val = preg_replace("/[^0-9]/","", $val);
	return $val;
}




function selectQuery($table){
	try{
		$handler =db_connection::connect();
		$sql = "SELECT * FROM $table";
		$query = $handler->query($sql);
		$query->setFetchMode(PDO::FETCH_OBJ); 
        $rs = $query->fetchAll();
        return $rs;
	}
	catch(Exception $e){
		die("server down");
	}
}

function fetchNameQuery($sql){
	try{
		$handler =db_connection::connect();
		$query = $handler->query($sql);
		$name = $query->fetchColumn();
		return $name;
	}
	catch(Exception $e){
		die($e->getMessage());
	}
}


function getInput($var){
	if(isset($_GET[$var])){
		$val =  strip_tags(cleanSql($_GET[$var]));
	}
	else{
		$val = "0";
	}
	return $val;
}

function getPost($var){
	return strip_tags(cleanSql($_POST[$var]));
}

function gettokken($len){
   /* $result = "";
    $chars = "abcdefghijklmnopqrstuvwxyz$_?!-0123456789";
    $charArray = str_split($chars);
    for($i = 0; $i < $len; $i++){
	    $randItem = array_rand($charArray);
	    $result .= "".$charArray[$randItem];
    }*/
    return "ilufh9h2p4fhc2ouhf498";
}
function paginate($record_count,$page,$n,$m,$h,$l){
	$per_page = 5;
	$last_page = ceil($record_count/$per_page);
	if($page<1){
		$page =1;
	}	
	elseif($page>$last_page){
		$page = $last_page;
	}
	else{
		$page=$page;
	}	
	
	$centerpages ="";
	$sub1 = $page-1;
	$sub2 = $page-2;
	$add1 = $page+1;
	$add2 = $page+2;
	
	if($page==1){
		//$centerpages .= "<li><a href='#' class='pg_active'><li class='pg_active' class='pg_active'><span>$page</span></a></li>";
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'&name='.$n.'&hostel='.$h.'&major='.$m.'&level='.$l.'">'.$add1.'</a></li>';
	}
	elseif ($page==$last_page) {
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'&name='.$n.'&hostel='.$h.'&major='.$m.'&level='.$l.'">'.$sub1.'</a></li>';
		$centerpages .= "<li class='pg_active'><a href='#' class='pg_active'><span>$page</span></a></li>";	
	}
	elseif ($page>2 && $page <($last_page-2)){
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$sub2.'&name='.$n.'&hostel='.$h.'&major='.$m.'&level='.$l.'">'.$sub2.'</a></li>';
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'&name='.$n.'&hostel='.$h.'&major='.$m.'&level='.$l.'">'.$sub1.'</a></li>';
		$centerpages .= "<li class='pg_active'><a href='#' class='pg_active'><span>$page</span></a></li>";
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'&name='.$n.'&hostel='.$h.'&major='.$m.'&level='.$l.'">'.$add1.'</a></li>';
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$add2.'&name='.$n.'&hostel='.$h.'&major='.$m.'&level='.$l.'">'.$add2.'</a></li>';
	}
	elseif ($page>1 && $page<$last_page){
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'&name='.$n.'&hostel='.$h.'&major='.$m.'&level='.$l.'">'.$sub1.'</a></li>';
		$centerpages .= "<li class='pg_active'><a href='#' class='pg_active'><span >$page</span></a></li>";
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'&name='.$n.'&hostel='.$h.'&major='.$m.'&level='.$l.'">'.$add1.'</a></li>';
	}
	else{
		$centerpages = "";
	}	
		
	$display="";
	if($last_page!="1"){
		//$display.='<li>Page '.$page.' of '.$last_page.  ' </li>';
	}
	if($page!=1){
		$previous = $page -1;
		$display.='<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$previous.'&name='.$n.'&hostel='.$h.'&major='.$m.'&level='.$l.'">Prev </a></li>';
	}	
			
	$display.='<span class="number_grid">'.$centerpages.'</span>';

	if($page!=$last_page){
		$next = $page +1;
		$display.='<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$next.'&name='.$n.'&hostel='.$h.'&major='.$m.'&level='.$l.'">Next </a></li>';
	}
	$x['limit'] = ($page-1) * $per_page;
	$x['display'] = $display;
	if($record_count <= 0){
		$x['display'] ="";
	}
	return($x);
}

function paginateNull($record_count,$page,$per_page){
	$last_page = ceil($record_count/$per_page);
	if($page<1){
		$page =1;
	}	
	elseif($page>$last_page){
		$page = $last_page;
	}
	else{
		$page=$page;
	}	
	
	$centerpages ="";
	$sub1 = $page-1;
	$sub2 = $page-2;
	$add1 = $page+1;
	$add2 = $page+2;
	
	if($page==1){
		//$centerpages .= "<li><a href='#' class='pg_active'><li class='pg_active' class='pg_active'><span>$page</span></a></li>";
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">'.$add1.'</a></li>';
	}
	elseif ($page==$last_page) {
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'">'.$sub1.'</a></li>';
		$centerpages .= "<li class='pg_active'><a href='#' class='pg_active'><span>$page</span></a></li>";	
	}
	elseif ($page>2 && $page <($last_page-2)){
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$sub2.'">'.$sub2.'</a></li>';
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'</a></li>';
		$centerpages .= "<li class='pg_active'><a href='#' class='pg_active'><span>$page</span></a></li>";
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'</a></li>';
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$add2.'">'.$add2.'</a></li>';
	}
	elseif ($page>1 && $page<$last_page){
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'</a></li>';
		$centerpages .= "<li class='pg_active'><a href='#' class='pg_active'><span >$page</span></a></li>";
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">'.$add1.'</a></li>';
	}
	else{
		$centerpages = "";
	}	
		
	$display="";
	if($last_page!="1"){
		//$display.='<li>Page '.$page.' of '.$last_page.  ' </li>';
	}
	if($page!=1){
		$previous = $page -1;
		$display.='<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$previous.'">Prev </a></li>';
	}	
			
	$display.='<span class="number_grid">'.$centerpages.'</span>';

	if($page!=$last_page){
		$next = $page +1;
		$display.='<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$next.'">Next </a></li>';
	}
	$x['limit'] = ($page-1) * $per_page;
	$x['display'] = $display;
	if($record_count <= 0){
		$x['display'] ="";
	}
	return($x);
}

function paginateWall($record_count,$page,$per_page,$sid){
	$last_page = ceil($record_count/$per_page);
	if($page<1){
		$page =1;
	}	
	elseif($page>$last_page){
		$page = $last_page;
	}
	else{
		$page=$page;
	}	
	
	$centerpages ="";
	$sub1 = $page-1;
	$sub2 = $page-2;
	$add1 = $page+1;
	$add2 = $page+2;
	
	if($page==1){
		//$centerpages .= "<li><a href='#' class='pg_active'><li class='pg_active' class='pg_active'><span>$page</span></a></li>";
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'&profile='.$sid.'">'.$add1.'</a></li>';
	}
	elseif ($page==$last_page) {
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'&profile='.$sid.'">'.$sub1.'</a></li>';
		$centerpages .= "<li class='pg_active'><a href='#' class='pg_active'><span>$page</span></a></li>";	
	}
	elseif ($page>2 && $page <($last_page-2)){
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$sub2.'&profile='.$sid.'">'.$sub2.'</a></li>';
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'&profile='.$sid.'</a></li>';
		$centerpages .= "<li class='pg_active'><a href='#' class='pg_active'><span>$page</span></a></li>";
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'&profile='.$sid.'</a></li>';
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$add2.'">'.$add2.'&profile='.$sid.'</a></li>';
	}
	elseif ($page>1 && $page<$last_page){
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'&profile='.$sid.'</a></li>';
		$centerpages .= "<li class='pg_active'><a href='#' class='pg_active'><span >$page</span></a></li>";
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">'.$add1.'&profile='.$sid.'</a></li>';
	}
	else{
		$centerpages = "";
	}	
		
	$display="";
	if($last_page!="1"){
		//$display.='<li>Page '.$page.' of '.$last_page.  ' </li>';
	}
	if($page!=1){
		$previous = $page -1;
		$display.='<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$previous.'&profile='.$sid.'">Prev </a></li>';
	}	
			
	$display.='<span class="number_grid">'.$centerpages.'</span>';

	if($page!=$last_page){
		$next = $page +1;
		$display.='<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$next.'&profile='.$sid.'">Next </a></li>';
	}
	$x['limit'] = ($page-1) * $per_page;
	$x['display'] = $display;
	if($record_count <= 0){
		$x['display'] ="";
	}
	return($x);
}

function paginateForum($record_count,$page,$per_page,$sid){
	$last_page = ceil($record_count/$per_page);
	if($page<1){
		$page =1;
	}	
	elseif($page>$last_page){
		$page = $last_page;
	}
	else{
		$page=$page;
	}	
	
	$centerpages ="";
	$sub1 = $page-1;
	$sub2 = $page-2;
	$add1 = $page+1;
	$add2 = $page+2;
	
	if($page==1){
		//$centerpages .= "<li><a href='#' class='pg_active'><li class='pg_active' class='pg_active'><span>$page</span></a></li>";
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'&forum='.$sid.'">'.$add1.'</a></li>';
	}
	elseif ($page==$last_page) {
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'&forum='.$sid.'">'.$sub1.'</a></li>';
		$centerpages .= "<li class='pg_active'><a href='#' class='pg_active'><span>$page</span></a></li>";	
	}
	elseif ($page>2 && $page <($last_page-2)){
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$sub2.'&forum='.$sid.'">'.$sub2.'</a></li>';
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'&forum='.$sid.'</a></li>';
		$centerpages .= "<li class='pg_active'><a href='#' class='pg_active'><span>$page</span></a></li>";
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'&forum='.$sid.'</a></li>';
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$add2.'">'.$add2.'&profile='.$sid.'</a></li>';
	}
	elseif ($page>1 && $page<$last_page){
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'&forum='.$sid.'</a></li>';
		$centerpages .= "<li class='pg_active'><a href='#' class='pg_active'><span >$page</span></a></li>";
		$centerpages .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">'.$add1.'&profile='.$sid.'</a></li>';
	}
	else{
		$centerpages = "";
	}	
		
	$display="";
	if($last_page!="1"){
		//$display.='<li>Page '.$page.' of '.$last_page.  ' </li>';
	}
	if($page!=1){
		$previous = $page -1;
		$display.='<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$previous.'&forum='.$sid.'">Prev </a></li>';
	}	
			
	$display.='<span class="number_grid">'.$centerpages.'</span>';

	if($page!=$last_page){
		$next = $page +1;
		$display.='<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$next.'&forum='.$sid.'">Next </a></li>';
	}
	$x['limit'] = ($page-1) * $per_page;
	$x['display'] = $display;
	if($record_count <= 0){
		$x['display'] ="";
	}
	return($x);
}


 function format_date($str) {
        $month = array(" ", "Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec");
        $y = explode(' ', $str);
        $x = explode('-', $y[0]);
        $date = "";    
        $m = (int)$x[1];
        $m = $month[$m];
        $st = array(1, 21, 31);
        $nd = array(2, 22);
        $rd = array(3, 23);
        if(in_array( $x[2], $st)) {
                $date = $x[2].'st';
        }
        else if(in_array( $x[2], $nd)) {
                $date .= $x[2].'nd';
        }
        else if(in_array( $x[2], $rd)) {
                $date .= $x[2].'rd';
        }
        else {
                $date .= $x[2].'th';
        }
        $date .= ' ' . $m . ', ' . $x[0];

        return $date;
}