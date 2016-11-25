<?php
	require_once("./libs/autoload.php");
	$u = $_SESSION['fi_user'];
	$myu = new fi_users();
	$myComment = new fi_comments();
	$myL = new fi_likes();
	$myP = new fi_pages();
	$myu->getUser($u);
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
				<div class='comments-box' id='view_comments$post->postId'>
				 	<div class='form_elements'>
					<form onSubmit='return false;'>
						<textarea class='form-control' id='txtPostComment$post->postId' aria-describedby='basic-addon3' placeholder='write a comment'></textarea>
						<input type='submit' class='btn btn-primary' value='comment' onClick='sendComment($post->postId,$post->userId)'/>
					</form>
					</div></br>
				 <div id='ajaxresponse $post->postId'></div>		 
		       ";
		 foreach ($comments as $comment){
		 	$info = $myu->headerInfo($comment->userId);
		 	$display = $info['fname']." ".$info['surName'];
		 	$html .="<div class='comment'>";
		 	$html .= "
		 	<span class='heading' style='margin-left:2%;'><a href='profiles.php?profile='>$display</a></span>
		 	<p>$comment->comment</p>";
		 	$html .="
		 		<div class='post-stats'>
		 			<a onClick='likeComment()'></a>
		 		   
		 	";
		 }
		 $html .="</div></div>";
	}
	return $html;
}

?>
		<?php require_once("./views/header.php");?>
		<style>
			.posted-wraper{
	width: 80%;
	float: left;
	margin-top: 8px;
	margin-left: 2%;
	min-height: 100px;
}
.posted-wraper img{
	margin-bottom: 5px;
	max-width: 100%;
}
.posted-wraper p{
	width: 85%;
}
		</style>
		<div id="container">
			<?php require_once("./views/navigation.php");?>
			<div id="post-area">
				<div id="form-container">
					<p>
						<h3>Welcome to solusi-fi<small> share something on your timeline !!</small></h3>
					</p>
					<form method="post" onSubmit="return false;">
						<div class="form_elements">
						<img id="pro-pic-sm" style="width:50px;"src="<?= thumbnailPhoto($myu->studentId,$myu->propic,$myu->gender); ?>"/>
						<div id="form-components">
							<textarea class="form-control" id="txtpost" aria-describedby="basic-addon3" placeholder="Whats on your mind?"></textarea>
							<div class='link-holder'>
								<div id="youtube" class="weblink"><input type="text" id="txtyoutube" class="form-control media" aria-describedby="basic-addon3" placeholder="paste your link youtube video link here"></div>   
								<div id="photo" class="weblink"><input type="file"  id="txtphoto" class="form-control media" aria-describedby="basic-addon3" ></br></div>
							</div>
							<input type="hidden" id="txtprivacy" value="everyone"/>
							</br><input type="submit" id="btnpost" class="btn btn-primary" value="post" onClick="sendPost(<?=$u?>,<?=$u?>);"/>
							<div id="medea-btns">
								<span class="en-icons" rel="youtube"><i class="fa fa-youtube fa-fw"></i></span>
								<span class="en-icons" rel="photo"><i class="fa fa-camera fa-fw"></i></span>
							</div>
							<div class = "btn-group">   
   								<button type = "button" class = "btn btn-default dropdown-toggle" data-toggle = "dropdown">
     								 <span id="statustext">Public</span> 
      								<span class = "caret"></span>
   								</button>
   								<ul class = "dropdown-menu" id="privacy" role = "menu">
      								<li><a href = "#" rel="everyone">Everyone</a></li>
      								<li><a href = "#" rel="friends only">Friends Only</a></li>
      								<li><a href = "#" rel="me only">Me Only</a></li>
   								</ul>
							</div>
						</div>	
					</form>
				</div>
			</div>			
			<div id="newsfeed">	
						<?php
							$myPost = new fi_posts();
							$posts = $myPost->getnewsFeed($myu->systemId);
						?>
						<?php echo buildHtml($myPost->getnewsFeed(1));?>
					</div><!--End newsfeed -->
					<div id="newsfeed-loader">
						<span rel='1' id='post-loader'><h3>see more stories</h3></span>
						<div id='animatedgif' style="display:none;"><center><img src='./imgs/LoaderIcon.gif'/></center></div>
					</div>	
				</div>
			<div id="ads-container">
				<img src="./imgs/ad.jpg"/>
			</div>	
		</div>
		<footer>
		<div id="foot-container">
			<ul>
				<li>&copy; 2016  tate-studio productions</li>
			</ul>
		</div>
	</footer>	
		<script type="text/javascript" src="js/home.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				var track_click = 0;
				var total_pages = <?= $myPost->countNewsFeed()?>;
				$("#post-loader").click(function (e){
					$(this).hide(); //hide load more button on click
				    $('#animatedgif').show(); //show loading image
				    if(track_click <= total_pages){

				    }
				});

			});


		</script>	
	</body>	
</html>