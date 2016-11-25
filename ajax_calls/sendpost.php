<?php
include_once("../libs/autoload.php");
$u =Sessions::getSession();
function getPvtEnum($pvt){
	switch ($pvt) {
		case 'me only':
			$enum = "M";
		break;

		case 'friends only':
			$enum = "F";
		break;
		
		default:
			$enum = "E";
		break;
	}
	return $enum;
}
function buildEmbeded($url){
	$video_id = explode("?v=", $url);
	$video_id = $video_id[1];
	$returnId = "https://www.youtube.com/embed/".$video_id;
	return $returnId;
}

function buildPostHtml($postId,$owner,$text,$video,$photo,$typo){
	$myu = new fi_users();
	$u = Sessions::getSession();
	$info = $myu->headerInfo($u);
	$html = "";
	$fname = $info['fname'];
	$sId = $info['sid'];
	$propic =$info['propic'];
	$surName = $info['surName'];
	$html .= "<div class='post'>";
	$html .= "<div class= 'post-info'>";
	$html .= "<img id='pro-pic-sm' src='./userInfo/$sId/thumbnail_$propic'/>
			  <a class='post-header' href='#'>$fname $surName</a>";
	$html .= "<div class='posted-wraper'>";
	if($typo == "V"){
		$html .= "<iframe width='100%' height='350px' src='$video' frameborder='0' ></iframe>";
	}
	elseif($typo == "P"){
		$html .= "<img src ='getpath($sId ).$photo; ?>'/>";
	}
	$html .= "<p>$text</p></br>";
	$html .= "<div class='post-stats'>
				<span>0 Likes</span><span>0 Comments</span>
				<span class='time-ago'>Just Now</span>
			  </div>";
	$html .="	<class='post-action'>
				<span class='show-comment' id='$postId'><i class='fa fa-comment fa-fw '></i> comment</span>
				<span class='like-btn' onClick='sendLike($postId,$u,'P',$owner' id='like-span$postId'><i class='fa fa-thumbs-up fa-fw'></i> like </span>	
				</div>";
	$html .="
				<div class='comments-box' id='view_comments$postId'>
					<div class='form_elements'>
					<form onSubmit='return false;'>
						<textarea class='form-control' id='txtPostComment$postId' aria-describedby='basic-addon3' placeholder='write a comment'></textarea>
						<input type='submit' class='btn btn-primary' value='comment' onClick='sendComment($postId,$owner)'/>
					</form>
					</div></br>
					<div id='ajaxresponse$postId'></div>
				</div>
			";
	$html .= "</div></div></div>";
	return $html;

}
if(isset($_POST['setpost_me'])){
	$typo ="";
	$video = "";
	$text = strip_tags($_POST['text']);
	$pvt = getPvtEnum($_POST['pvt']);
	$photo = cleanSql(strip_tags($_POST['photo']));
	$user = cleanSql(strip_tags($_POST['user']));
	$wall = cleanSql(strip_tags($_POST['wall']));
	$youtube = cleanSql(strip_tags($_POST['youtube']));
	$myP = new fi_posts();
	if(!empty($youtube)){
		$typo ="V";
		$video = buildEmbeded($youtube);
	}
	elseif (!empty($photo)) {
		$typo ="P";
	}
	else{
		$typo ="T";
	}
	$myP->setPost($user,$typo,$pvt,$wall,$text,$photo,$video,"U");
	if($myP->dacCrud == true){
		echo  buildPostHtml($myP->postId,$user,$text,$video,$photo,$typo);
	}

}

if(isset($_POST['setpost_page'])){
	$typo ="";
	$video = "";
	$text = strip_tags($_POST['text']);
	$pvt = getPvtEnum($_POST['pvt']);
	$photo = cleanSql(strip_tags($_POST['photo']));
	$user = cleanSql(strip_tags($_POST['user']));
	$wall = cleanSql(strip_tags($_POST['wall']));
	$youtube = cleanSql(strip_tags($_POST['youtube']));
	$myP = new fi_posts();
	if(!empty($youtube)){
		$typo ="V";
		$video = buildEmbeded($youtube);
	}
	elseif (!empty($photo)) {
		$typo ="P";
	}
	else{
		$typo ="T";
	}
	$myP->setPost($user,$typo,$pvt,$wall,$text,$photo,$video,"P");
	if($myP->dacCrud == true){
		echo  buildPostHtml($myP->postId,$user,$text,$video,$photo,$typo);
	}
}

if(isset($_GET['like'])){
	$user = $u;
	$post = cleanSql(strip_tags($_GET['post']));
	$typ = cleanSql(strip_tags($_GET['type']));
	$owner = cleanSql(strip_tags($_GET['owner']));
	$myL = new fi_likes();
	if($myL->checkLike($user,$typ,$post)==false){
		$myL->addLike($user,$typ,$post);
		if($myL->dacCrud == true){
			echo "<i class='fa fa-thumbs-up fa-fw'></i> unlike";
			$myN = new fi_notifications();
			$myN->setNotifivation($u,$owner,"liked","post",$post);
		}	
	}
	else{
		$myL->unlike($user,$typ,$post);
		if($myL->dacCrud == true){
			echo"<i class='fa fa-thumbs-up fa-fw'></i> like";
		}	
	}
	
}

if(isset($_GET['comment'])){
	$comment = cleanSql(strip_tags($_GET['comment']));
	$post = cleanSql(strip_tags($_GET['post']));
	$owner = cleanSql(strip_tags($_GET['owner']));
	$myC = new fi_comments();
	$myC->setComment($comment,$u,$post);
	if($myC->dacCrud == true){
		$myN = new fi_notifications();
		$myN->setNotifivation($u,$owner,"liked","post",$post);
		$myu = new fi_users();
		$info = $myu->headerInfo($u);
		$fname = $info['fname'];
		$sId = $info['sid'];
		$propic =$info['propic'];
		$surName = $info['surName'];
		echo"
			<div class='comment'>
				<span class='heading'>$fname $surName</span>
				<p style='margin-left:2%;'>
					$comment
				</p>
				<div class='post-stats'>
					<span> 0  people like this</span>
					<span class='time-ago'>Just Now</span>
				</div>
			</div>
		";
	}
}

if(isset($_POST['msg'])){
	$myM = new fi_messages();
	$to = cleanSql(strip_tags($_POST['id']));
	$msg = strip_tags($_POST['msg']);
	$myM->sendMessage($to,$u,$msg,"");
	if($myM->dacCrud == true){
		echo "done";
	}

}

if(isset($_POST['likeComment'])){
	$myL = new fi_likes();
	$comment = preg_replace("/[^0-9]/","", $_POST['comment']);
	$user  = preg_replace("/[^0-9]/","", $_POST['user']);
	$typ = strip_tags($_POST['type']);
	if($myL->checkLike($u,$typ,$comment) == false){
		$myL->addLike($u,$typ,$item);
		if($myL->dacCrud == true){
			$myN = new fi_notifications();
		    $myN->setNotifivation($u,$user,"liked","comment");
		    echo"unlike";	
		}
		else{
			$myL->unlike($u,$typ,$item);
			echo "like";

		}
	}
}

if(isset($_GET['open_msg'])){
	$myM = new fi_messages();
	$id = preg_replace("/[^0-9]/","", $_GET['id']);
	$myM->openMessage($id);
	if($myM->dacCrud == true){
		echo "done";
	}
}

if(isset($_GET['deletepost'])){
	$post = preg_replace("/[^0-9]/","", $_GET['itemactive']);
	$myP = new fi_posts();
	$myP->deletePost($u,$post);
	if($myP->dacCrud == true){
		echo"post was deleted succesifully";
	}	
	else{
		echo"could not delete post";
	}
}
if(isset($_GET['deleteComment'])){
	$myC = new fi_comments();
	$comment =  preg_replace("/[^0-9]/","",$_GET['commentactive']); 
	$myC->deleteComment($u,$comment);
	if($myC->dacCrud == true){
		echo"post was deleted succesifully";
	}	
	else{
		echo"could not delete post";
	}

}
