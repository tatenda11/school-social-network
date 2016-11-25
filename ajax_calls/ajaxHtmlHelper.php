<?php
require_once("../libs/autoload.php");
	$myu = new fi_users();
	$myComment = new fi_comments();
	$myL = new fi_likes();
	$myP = new fi_pages();
	$myPost = new fi_posts();

function buildHtml($postArray){
	$u = $_SESSION['fi_user'];
	$myu = new fi_users();
	$myComment = new fi_comments();
	$myL = new fi_likes();
	$myP = new fi_pages();
	$myPost = new fi_posts();
	$html = "";
	foreach($postArray as $post){
		if($post->agent == "P"){
			$info = $myP->headerInfo($post->userId);
			$postTop = "<img id='pro-pic-sm' src='".getPageImage($post->wall,$info['coverphoto'])."'/>"; 
			$postTop .= "<a class='post-header' href='page.php?page=".$info['pageId']."'>".$info['title']."</a>";
		}
		else{
			$info = $myu->headerInfo($post->userId);
			$sid = $info['sid'];
			$postTop = "<img id='pro-pic-sm' src='".thumbnailPhoto($info['sid'],$info['propic'],$info['gndr'])."'/>"; 
			$postTop .= "<a class='post-header' href='profiles.php?profile=".$info['sid']."'>".$info['fname']." ". $info['surName']."</a>";
		}
		$html .= "<div class='post'>";
		$html.= $postTop;
		if( $post->userId != $post->wall){
			$poster = $myu->headerInfo($post->wall);
			$posterName = $poster['fname'] ." ".$poster['surName'];
			$postedUrl =  "profiles.php?profile=".$poster['sid'];
			$html .= "<a class='post-header' style='margin-left:0%;' href='$postedUrl'>$posterName</a>";
		}
		$html .="<div class='posted-wraper'>";
		$html .="<p>$post->postText</p>";
		if($post->posttyp == "P"){
			$path = getpath($sid).$post->photo;
			$html .=  "<img src= '$path'/>";
		}
		elseif($post->posttyp == "V"){
			$html.= "<iframe width='100%' src='$post->youtube' frameborder='0'></iframe>";
		}
		$comments = $myComment->getByPost($post->postId);
		$commentCount = $myComment->countComments($post->postId);
		$likes = $myL->countLikes('p',$post->postId);
		$html .="<div class='post-stats'>
					<span>$likes Likes </span><span>$commentCount Comments</span>
				 	<time class='timeago pull-right' datetime='<?= $post->postDate ?>' title='July 17, 2016'></time>
				 </div>	
				";
		$html .="
				<div class='post-action'>
				<span class='show-comment' id='$post->postId'><i class='fa fa-comment fa-fw'></i> comment</span>";
		if($myL->checkLike($u,"P",$post->postId)== true){
			$html .="<span class='like-btn blue'  onClick='sendLike($post->postId,$u,'P',$post->userId)' id='like-span$post->postId'><i class='fa fa-thumbs-up fa-fw'></i> unlike </span>";
		}
		else{
			$html .="<span class='like-btn' onClick='sendLike($post->postId,$u,'P',$post->userId)' id='like-span$post->postId'><i class='fa fa-thumbs-up fa-fw'></i> like </span></div>";
		}
		$html .="
				<div class='comments-box' id='view_comments$post->postId ?'>
				 <div id='ajaxresponse $post->postId'></div>		 
		       ";
		 foreach ($comments as $comment){
		 	$info = $myu->headerInfo($comment->userId);
		 	$html .="<div class='comment'>";
		 	$html .= "<p>$comment->comment</p>";
		 	$html .="
		 		<div class='post-stats'>
		 			<a onClick='likeComment()'></a>
		 		   
		 	";
		 }
		 $html .="</div></div>";
	}
	return $html;
}

 echo buildHtml($myPost->getnewsFeed(1));
?>
	
