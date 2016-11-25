<?php
require_once("../libs/autoload.php");
$u = Sessions::getSession();
function buildFriendsHtml($friends){
	$myu = new fi_users();
	if (!empty($friends)) {
		echo "<div class='panel-heading' style='margin:auto;'>Friends Requests</div>";
		foreach ($friends as $friend) {
			$info = $myu->headerInfo($friend->friendFrom);
			$name = $info['fname']." ".$info['surName'];
			$sid = $info['sid'];
			$pic = $info['propic'];
			$header = "<img id='pro-pic-sm' src='./userInfo/$sid/thumbnail_$pic' alt=''/>";
			$header .= "<a href='profiles.php?profile=$sid'>$name</a>";
			$html ="<div class='request-wrap panel panel-default' id='$friend->friendshipId'>";
			$html .= "
		    	    $header send you a friend request <br>
					<div class='btn-group pull-right' role='group' aria-label='...'>
						<button type='button' onClick='deleteRequest($friend->friendshipId);' class='btn btn-defauli btn-sm spacer'>Delete Request</button>
						<button type='button'  onClick='acceptRequest($friend->friendshipId);'class='btn btn-primary btn-sm spacer'>Accept Request</button>
					</div>
					";
			$html .="</div>";
			echo $html;
		}
		echo "<div class='panel-heading' style='margin:auto;'><a href='friendsRequest.php'>see all request</a></div>";
	}
	else{
		echo "<div class='request-wrap'><p style='margin-left:5px;'><strong>no one wants to be your friend</strong></p></div>";
	}
}


function getPrintText($notTo,$notTyp,$notification,$id){
	global $u;
	$to = " a";
	if($notTo == $u){
		$to = " your";
	}
	return $notification.$to." "."<a href='post.php?post=$id'>$notTyp</a>";
}

function buildNotificationHtml($Notifications){
	$myu = new fi_users();
	if (!empty($Notifications)){
		echo "<div class='panel-heading' style='margin:auto;'>Notifications</div>";
		foreach ($Notifications as $Notification) {
			$info = $myu->headerInfo($Notification->notFrom);
			$name = $info['fname']." ".$info['surName'];
			$sid = $info['sid'];
			$pic = $info['propic'];
			$header = "<img id='pro-pic-sm' src='./userInfo/$sid/thumbnail_$pic' alt=''/>";
			$html = "<div class='not-holder'>";
			$html .="  $header <a ref='profiles.php?profile=$sid'>$name</a>";
			$html .= "<p>".getPrintText($Notification->notTo,$Notification->notTyp,$Notification->notification,$Notification->itemId)."</p>";
			$html .= "</div>";
			echo $html;
		}
		echo "<div class='panel-heading' style='margin:auto;'><a href='notifications.php'>see all notifications</a></div>";
	}
	else{
		echo "<div class='request-wrap'><p style='margin-left:5px;'><strong>no notifications for you</strong></p></div>";	
	}
}

function buildCommentHtml($comments,$user){
	global $u;
	$myu = new fi_users();
	$myL = new fi_likes();
	if(!empty($comments)){
		foreach ($comments as $comment){
			$info = $myu->headerInfo($comment->userId);
			$name = $info['fname']." ".$info['surName'];
			$sid = $info['sid'];
			$likes = $myL->countLikes('C',$comment->commentId);
			$tymDisplay = format_date($comment->commentDate);
			$html = "<div class='comment'>";
			$html .= "<span class='heading' style='margin-left:0%;'><a href='profiles.php?profile=$sid'>$name</a></span>";
			if($u == $comment->userId){
				$html .= "<a href='edit-comment.php?comment=$comment->commentId' class='pull-right'>Edit</a>";
			}
			$html .= "<p>$comment->comment</p>";
			$html .= "<div class='post-stats'>";
			if($myL->checkLike($u,"C",$comment->commentId)== true){
				$html .="<div class='commentinfo-strip pointer'><span onClick='likeComment($comment->commentId,$u,$user)' id='like-span-comment$comment->commentId'>unlike</span> ";
			}
			else{
				$html .="<div class='commentinfo-strip pointer'><span onClick='likeComment($comment->commentId,$u,$user)' id='like-span-comment$comment->commentId'>like</span> ";
			}
			$html .="<a onClick='getLikersComment($comment->commentId)' rel='$likes' id='comment-num$comment->commentId'><i class='fa fa-thumbs-up fa-fw'></i>$likes</a>"; 
			$html .="<time class='timeago pull-right' datetime='$comment->commentDate' title='July 17, 2016'>$tymDisplay</time></div>";
			$html.="</div>";
			$html .="</div>";
			echo $html;
		}
	}
}
if(isset($_GET['content'])){
	if( $_GET['content'] == "friends"){
		$myF = new fi_friends();
		$html = buildFriendsHtml($myF->getRequests($u));
	 }
	elseif($_GET['content'] == "notifications") {
		$myN = new fi_notifications();
		$myL = new fi_logins();
		 buildNotificationHtml($myN->getNotifications($u,$myL->getLastLog($u)));
	}
	elseif (($_GET['content'] == "search")){
		$key = CleanSql($_GET['key']);
		$myu = new fi_users();
		$users = $myu->searchByName($key);
		foreach ($users as $user) {
			$info = $myu->headerInfo($user->systemId);
			$name = $info['fname']." ".$info['surName'];
			$sid = $info['sid'];
			$pic = $info['propic'];
			$header = "<img id='pro-pic-sm' src='./userInfo/$sid/thumbnail_$pic' alt=''/><a class='post-header' style='margin-left:0%;'href='profiles.php?profile=$sid'>$name</a>";	
			$html = "<div class='profile-strip'>";
			$html .= "$header";
			$html .= "</div>";
			echo $html;
		}
	}	

}

if(isset($_GET['getprofiles'])){
	$myu = new fi_users();
	$myL = new fi_likes();
	$item =  preg_replace("/[^0-9]/","", $_GET['itemId']);
	$likers = $myL->getLikers($item);
	if(!empty($likers)){
		foreach ($likers as $liker){
			$info = $myu->headerInfo($liker->userId);
			$name = $info['fname']." ".$info['surName'];
			$sid = $info['sid'];
			$pic = $info['propic'];
			$header = "<img id='pro-pic-sm' src='./userInfo/$sid/thumbnail_$pic' alt=''/><a class='post-header' style='margin-left:0%;'href='profiles.php?profile=$sid'>$name</a>";	
			$html = "<div class='liker-holder'>";
			$html .= "$header";
			$html .= "<div class='btn-group pull-right' role='group' aria-label='...'>"; 
			$html .= "<a href='profiles.php?profile=$sid' class='btn btn-sm btn-primary click-hide'>View Profile</a>";
			$html .="</div>";
			echo $html;
		}

	}
}

if(isset($_GET['getprofilesC'])){
	$myu = new fi_users();
	$myL = new fi_likes();
	$item =  preg_replace("/[^0-9]/","", $_GET['itemId']);
	$likers = $myL->getLikersTypo($item,"C");
	if(!empty($likers)){
		foreach ($likers as $liker){
			$info = $myu->headerInfo($liker->userId);
			$name = $info['fname']." ".$info['surName'];
			$sid = $info['sid'];
			$pic = $info['propic'];
			$header = "<img id='pro-pic-sm' src='./userInfo/$sid/thumbnail_$pic' alt=''/><a class='post-header' style='margin-left:0%;'href='profiles.php?profile=$sid'>$name</a>";	
			$html = "<div class='liker-holder'>";
			$html .= "$header";
			$html .= "<div class='btn-group pull-right' role='group' aria-label='...'>"; 
			$html .= "<a href='profiles.php?profile=$sid' class='btn btn-sm btn-primary click-hide'>View Profile</a>";
			$html .="</div>";
			echo $html;
		}
	}
}

if(isset($_GET['comment'])){
	$postId = preg_replace("/[^0-9]/","", $_GET['post']);
	$user = preg_replace("/[^0-9]/","", $_GET['user']);
	$myc = new fi_comments();
	$comments = $myc->getByPost($postId);
	buildCommentHtml($comments,$user);

}

if(isset($_GET['likecomment'])){
	$comment = preg_replace("/[^0-9]/","", $_GET['comment']);
	$owner = preg_replace("/[^0-9]/","", $_GET['user']);
	$typ = "C";
	$u = Sessions::getSession();
	$myL = new fi_likes();
	if($myL->checkLike($user,$typ,$comment)==false){
		$myL->addLike($user,$typ,$comment);
		if($myL->dacCrud == true){
			echo "liked";
			$myN = new fi_notifications();
			$myN->setNotifivation($u,$owner,"liked","comment",$comment);
		}	
	}
	else{
		$myL->unlike($user,$typ,$post);
		if($myL->dacCrud == true){
			echo"unliked";
		}	
	}
}