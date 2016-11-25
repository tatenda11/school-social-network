<?php
	require_once("./libs/autoload.php");
	$u = $_SESSION['fi_user'];
	if(isset($_GET['forum'])){
		$myf = new fi_pages;
		$myf->getPage(preg_replace("/[^a-zA-Z0-9]+/", "", $_GET['forum']));
		if($myf->dacFound == false){
			header("location:home.php");
		}
		else{
			if(isset($_GET['page'])){
				$page =  preg_replace("/[^0-9]/","", $_GET['page']);
			}
			else{
				$page = 1;
			}
			$myPost = new fi_posts();
			$myComment = new fi_comments();
			$myL = new fi_likes();
			$post_count = $myPost->countWallPost(preg_replace("/[^a-zA-Z0-9]+/", "", $_GET['forum']),"P");
			$paginations = paginateWall($post_count,$page,10,"");
			if($post_count > 0){
				$posts = $myPost->getForumPosts($myf->pageId,$paginations['limit'],10);	
			}
			else{
				$posts = array();
			}
		}
	}
	else{
		header("location:home.php");
	}
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $myu->fname." ".$myu->sname;?></title>
		<meta charset="utf-8"/>	
		<meta name="viewpoint" content="width=device-width, initial-scale=0.1" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" href="imgs/logo.png">
		<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
		<link href="css/main.css" rel="stylesheet" type="text/css"/>
		<link href="css/subtheme-about.css" rel="stylesheet" type="text/css"/>
		<link href="css/theme.css" rel="stylesheet" type="text/css"/>
		<link href="css/profile.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="js/jquery-1.11.0.js"></script>
		<script src="js/jquery.timeago.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/main.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
		<!--[if lt IE 9]>
  		<script src="/js/html5shiv.js" type="text/javascript"></script>
 	 	<script src="/js/respond.min.js" type="text/javascript"></script>
		<![endif]-->
	<head>
	<body>
		<header>
			<nav class="navbar navbar-fixed-top navbar-inverse"  id="my-navbar">
			<div class="container">
				<div class="navbar-header">
					<button type="button" id="slide" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div id="logo_text"><a href="" class="navbar-brand " style="font-size:22px;">solusi-fi</a></div>
				</div>
				<div class="collapse navbar-collapse space-left" id="#navbar-collapse">
					<form class="navbar-form navbar-left" role="search" method="POST">
        				<div class="form-group">
          					<input type="text" name="txtid" class="form-control" placeholder="Search">
        				</div>
        				<button type="submit" name="btnLogin" class="btn btn-info theme">Search</button>
      				</form>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#"><i class="fa fa-envelope-o fa-fw"></i> Inbox <span class="badge">4</span></a></li>
						<li><a href="#"><i class="fa fa-info-circle fa-fw"></i> Notifications <span class="badge">4</span></a></li>
						<li><a href="#"><i class="fa fa-users fa-fw"></i> friend request <span class="badge">4</span></a></li>
					</ul>	
				</div>		
			</div>	
		</nav>	
		</header>
		<div id="container">
			<div class="clear"></div>
			<div id="profile-holder">
				<div id="header-area">
					<div id="pro-image-holder">
						<img src="<?=  profilePhoto($myu->studentId,$myu->propic,$myu->gender); ?>"/>
					</div>	
					<span id="name-text"><?= $myf->title ?></span>
				</div>
				<div id="action-holder">
					
				</div>
				<div class="clear"></div>
				<div id="left-nav">
					<div id="intro">
						<h3>Intro</h3>
						<p>
							<?php echo $myf->description;?>
						</p>
					</div>
					<div id="intro">
					<h3>About <?= $myf->title ?></h3>
					</div>
					<div id="intro" class="mobile-hide">
						<h3><a href="photoAlbum.php?profile=<?= $myu->systemId?>">Photos</a></h3>
						<p>
							
						</p>
					</div>
					<div id="intro">
		
					</div>	
				</div>
				<div id="right-nav">
					<div id="post-area">
						<div id="form-container">
							
							<form method="post" onSubmit="return false;">
							<div class="form_elements">
								<div id="form-components">
								<textarea class="form-control" id="txtpost" aria-describedby="basic-addon3" placeholder="Whats on your mind?"></textarea>
								<input type="hidden" id="txtWall" value="<?= $myu->systemId ?>"/>
								<input type="hidden" id="txtUser" value="<?= $u ?>"/>
								<div class='link-holder'>
									<div id="youtube" class="weblink"><input type="text" id="txtyoutube" class="form-control media" aria-describedby="basic-addon3" placeholder="paste your link youtube video link here"></div>	   
									<div id="photo" class="weblink"><input type="file"  id="txtphoto" class="form-control media" aria-describedby="basic-addon3" ></br></div>
								</div>
								<input type="hidden" id="txtprivacy" value="everyone"/>
								</br><input type="submit" id="btnpost" class="btn btn-primary" value="post" onClick="sendPost(<?= $u?>,<?= $myu->systemId ?>);"/>
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
					</div><!--post-area -->
					<div id="newsfeed">	
						<?php
							$myPost = new fi_posts();
							//$posts = $myPost->getWallPosts($myu->systemId);
						?>
						<?php foreach( $posts as $post): ?>
						 	<?php 
						 			/*check  the typ of post*/
						 			if($post->agent == "P"){
						 				
										$info = $myP->headerInfo($post->userId);
						 				$postTop = "<img id='pro-pic-sm' src='".getPageImage($post->wall,$info['coverphoto'])."'/>"; 
						 			   	$postTop .= "<a class='post-header' href='page.php?page=".$info['pageId']."'>".$info['title']."</a>";
						 			}   
						 			else{
						 				$info = $myu->headerInfo($post->userId);
						 				$postTop = "<img id='pro-pic-sm' src='".thumbnailPhoto($info['sid'],$info['propic'],$info['gndr'])."'/>"; 
						 			   	$postTop .= "<a class='post-header' href='profiles.php?profile=".$info['sid']."'>".$info['fname']." ". $info['surName']."</a>";

						 			}
						 			/*generate info*/
						 		?>
						 	<div class='post'>
						 		<img id="pro-pic-sm" src="<?= profilePhoto($info['sid'],$info['propic'],$info['gndr']); ?>" />
								<a class="post-header" href="profiles.php?profile=<?= $info['sid']?>"><?php echo $info['fname']." ".$info['surName'];?></a>
								<?php if( $post->userId != $myu->systemId): ?>
									> <a class="post-header" style="margin-left:0%;"href="profiles.php?profile=<?= $myu->studentId ?>"><?php echo $myu->fname ." ".$myu->sname ;?></a>
								<?php endif; ?>
								<div class='posted-wraper'>
									<?php if( $u == $myu->systemId): ?>
										<small><a href="edit-post.php?post=<?= $post->postId?>"class='pull-right'>More</a></small>
									<?php endif;?>	
									<p>
										<?= $post->postText?>	
									</p>
									<?php if( $post->posttyp == "P"): ?>
										<img src ="<?php echo getpath($myu->studentId).$post->photo; ?>"/>
									<?php endif; ?>
									<div class="post-stats">
										<?php
											$comments = $myComment->getByPost($post->postId);
										?>
										<span><?= $myL->countLikes("P",$post->postId)?> Likes</span><span><?php $commentCount = $myComment->countComments($post->postId);echo $commentCount;?> Comments</span>
										<time class="timeago pull-right" datetime="<?= $post->postDate ?>" title="July 17, 2016"></time>
									</div>
									<div class="post-action">
										<span class="show-comment" id="<?= $post->postId?>"><i class="fa fa-comment fa-fw "></i> comment</span>
										<?php if($myL->checkLike($u,"P",$post->postId)== true):?>
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
										<div class='comment-stats'>view all comments (<?= $commentCount?>)</div>
										<div id="ajaxresponse<?= $post->postId?>">
						 			 		<?php foreach( $comments as $comment): ?>
						 			 			<?php $info = $myu->headerInfo($comment->userId);?>
						 			 			<div class='comment'>
													<span class='heading' style='margin-left:2%;'><a href="profiles.php?profile=<?= $info['sid']?>"><?php echo $info['fname']." ".$info['surName'];?></a></span>
													<p>
														<?= $comment->comment?> 
													</p>
													<div class="post-stats">
														<span onClick="sendLike(<?= $post->postId?>,<?=$u?>,'C',<?= $post->userId?>)" id="like-span<?= $post->postId?>"><i class="fa fa-thumbs-up fa-fw"></i> like </span>
														<time class="timeago pull-right" datetime="<?= $comment->commentDate ?>" title="July 17, 2016"></time>
													</div>
												</div>
											 <?php endforeach; ?>
										</div>
						 			</div>
						 		</div>
						 	</div>		
						<?php endforeach; ?>
					</div><!--End newsfeed -->
					<div class="pagination-holder">
						<ul class="pagination-list">
							<?php echo $paginations['display'];?>
						</ul>	
					</div> 	
				</div><!--right nav -->
			</div><!--profile-holder -->	
		</div><!--End Container -->

<!-- ***************************Send mesage***********************************************-->	
<div id="message" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Message</h4>
      </div>
      <div><center><img id="inmate" src="./imgs/pulse.gif"/></center></div>
      <div class="modal-body" id="signup-content">
      	<form method="post" enctype="multipart/form-data" onsubmit="return false">
      		<div class="form_elements" >
      				<fieldset>
      					<div id="request-feedack"></div>
      					<label>Send Attachment</label></br>
      					<input type='file' placeholder="send notes" aria-describedby="basic-addon3"/></br>
      					<textarea style="height:100px;" class="form-control" placeholder="Your Message" aria-describedby="basic-addon3" id="txtmsg"></textarea>
    	   					
      					</br><input type="submit" onClick="sendMessage(<?= $myu->systemId ?>);"value="Send Message" id="btnsignUp" class="btn btn-info"/>
      				</fieldset>
      		</div>		
      	</form>	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- ***************************SingUp End ***********************************************-->

	<script type="text/javascript" src="js/home.js"></script>

	</body>	
</html>

