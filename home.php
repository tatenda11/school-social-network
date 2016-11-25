<?php
	require_once("./libs/autoload.php");
	Sessions:: autheticate();
	$u = $_SESSION['fi_user'];
	$myu = new fi_users();
	$myComment = new fi_comments();
	$myL = new fi_likes();
	$myP = new fi_pages();
	$myu->getUser($u);
	if(isset($_GET['page'])){
		$page =  preg_replace("/[^0-9]/","", $_GET['page']);
	}
	else{
		$page = 1;
	}
	$myPost = new fi_posts();
	$post_count = $myPost->countNewsFeed($u);
	$paginations = paginateNull($post_count,$page,20);
	if($post_count > 0){
		$posts = $myPost->getnewsFeed($myu->systemId,$paginations['limit'],20);	
	}
	else{
		$posts = array();
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
		<div id='overlaylikes'>
			<div class='show-likes'>
				<div class='likebox panel panel-default'> 
					<div class="panel-heading">People who like this</div>
					<div class='liker-holder-box'>
					</div>
				</div>
			</div>	
		</div>
		<div id="container">
			<?php require_once("./views/navigation.php");?>
			<div id='navigation-mobila'>
				<button class='btn btn-sm btn-primary'>Navigation</button>
			</div>
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
						<?php foreach( $posts as $post): ?>
						 	<div class='post'>
						 		<?php 
						 			/*check  the typ of post*/
						 			if($post->agent == "P"){
						 				
										$info = $myP->headerInfo($post->wall);
						 				$postTop = "<img id='pro-pic-sm' src='".getPageImage($post->wall,$info['coverphoto'])."'/>"; 
						 			   	$postTop .= "<a class='post-header' href='page.php?forum=".$info['pageId']."'>".$info['title']."</a>";
						 			}   
						 			else{
						 				$info = $myu->headerInfo($post->userId);
						 				$postTop = "<img id='pro-pic-sm' src='".thumbnailPhoto($info['sid'],$info['propic'],$info['gndr'])."'/>"; 
						 			   	$postTop .= "<a class='post-header' href='profiles.php?profile=".$info['sid']."'>".$info['fname']." ". $info['surName']."</a>";

						 			}
						 			/*generate info*/
						 		?>
						 		<?= $postTop ?>
								<?php if( $post->userId != $post->wall && $post->userId != 0): ?>
									<?php $poster = $myu->headerInfo($post->wall);?>
									> <a class="post-header" style="margin-left:0%;"href="profiles.php?profile=<?= $poster['sid'] ?>"><?php echo $poster['fname'] ." ".$poster['surName'] ;?></a>
								<?php endif; ?>
								<div class='posted-wraper'>
									<p>
										<?= $post->postText?>	
									</p>
									<?php if( $post->posttyp == "P"): ?>
										<img src ="<?php echo getpath($info['sid']).$post->photo; ?>"/>
									<?php elseif($post->posttyp == "V"): ?>
                                     	<iframe width="100%" height="350px" src="<?= $post->youtube?>" frameborder="0" allowfullscreen ></iframe>
									<?php endif; ?>
									<div class='show-likes' id='show-likes<?= $post->postId ?>' rel='<?= $post->userId ?>'><div class='likebox' id='likebox<?= $post->postId ?>'></div></div>
									<div class="post-stats">
										<?php
											$comments = $myComment->getByPost($post->postId);
										?>
										<span class='show-like-box' id='<?= $post->postId ?>'><?= $myL->countLikes("P",$post->postId)?> Likes</span><span><?php $commentCount = $myComment->countComments($post->postId);echo $commentCount;?> Comments</span>
										<time class="timeago pull-right" datetime="<?= $post->postDate ?>" title="July 17, 2016"></time>
									</div>
									<div class="post-action">
										<span class="show-comment" id="<?= $post->postId?>" rel="<?= $post->userId?>"><i class="fa fa-comment fa-fw "></i> comment</span>
										<?php if($myL->checkLike($u,"P",$post->postId) == true):?>
										 	<span class="like-btn blue"  onClick="sendLike(<?= $post->postId?>,<?=$u?>,'P',<?= $post->userId?>)" id="like-span<?= $post->postId?>"><i class="fa fa-thumbs-up fa-fw"></i> unlike </span>
										<?php else:?>
											<span class="like-btn" onClick="sendLike(<?= $post->postId?>,<?=$u?>,'P',<?= $post->userId?>)" id="like-span<?= $post->postId?>"><i class="fa fa-thumbs-up fa-fw"></i> like </span>						
										<?php endif; ?>
									</div>
									<div class="comments-box" id="view_comments<?= $post->postId ?>">
										<div class="form_elements">
											<form onSubmit="return false;">
												<textarea class="form-control" id="txtPostComment<?= $post->postId ?>" aria-describedby="basic-addon3" placeholder="write a comment"></textarea>
												<input type="submit" class="btn btn-primary" value="comment" onClick="sendComment(<?= $post->postId?>,<?= $post->userId?>)"/>
											</form>
										</div></br>
										<div class='comment-stats'><a href='post.php?post=<?= $post->postId ?>'>view all comments (<?= $commentCount?>)</a></div>
										<div id="ajaxresponse<?= $post->postId?>">
						 			 		
										</div>
						 			</div>
						 		</div>
						 	</div>		
						<?php endforeach; ?>
					</div><!--End newsfeed -->
					<div id="newsfeed-loader">
						<div class="pagination-holder">
							<ul class="pagination-list">
								<?php echo $paginations['display'];?>
							</ul>	
						</div> 
					</div>	
				</div>
			<div id="ads-container">
				<img src="./imgs/ad.jpg"/>
			</div>	
		</div>
		<footer>
		<div id="foot-container">
			<ul>
				<li>&copy; 2016  tatenda munenge productions</li>
			</ul>
		</div>
	</footer>	
		<script type="text/javascript" src="js/home.js"></script>	
	</body>	
</html>