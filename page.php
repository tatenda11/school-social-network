<?php
	require_once("./libs/autoload.php");
	Sessions:: autheticate();
	if(isset($_GET['page'])){
		$page =  preg_replace("/[^0-9]/","", $_GET['page']);
	}
	else{
		$page = 1;
	}
	$u = $_SESSION['fi_user'];
	$myu = new fi_users();
	$myu->getUser($u);
	$myMsg = new fi_messages();
	$unread = $myMsg->countUnread($u);
	$myFrnd = new  fi_friends();
	$friendsRequests = $myFrnd->countFriendRequsts($u);
	if(isset($_GET['forum'])){
		$myP = new fi_pages();	
		$forum = preg_replace("/[^0-9]/","", $_GET['forum']);
		$myP->getPage($forum);
		if($myP->dacFound == false){
			header("location:home.php");
		}
		else{
			
			$myPost = new fi_posts();
			$myComment = new fi_comments();
			$myL = new fi_likes();
			$adminInfo = $myu-> headerInfo($myP->adminId);
			$post_count = $myPost->countWallPost($forum,"P");
			$paginations = paginateWall($post_count,$page,10,$myu->studentId);
			if($post_count > 0){
				$posts = $myPost->getForumPosts($forum,$paginations['limit'],10);
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
		<title><?php echo $myP->title; ?></title>
		<meta charset="utf-8"/>	
		<meta name="viewpoint" content="width=device-width, initial-scale=0.1" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" href="imgs/logo.png">
		<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
		<link href="css/magicbox.css" rel="stylesheet" type="text/css"/>
		<link href="css/main.css" rel="stylesheet" type="text/css"/>
		<link href="css/subtheme-about.css" rel="stylesheet" type="text/css"/>
		<link href="css/theme.css" rel="stylesheet" type="text/css"/>
		<link href="css/profile.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="js/jquery-1.11.0.js"></script>
		<script src="js/jquery.timeago.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/home.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/magicbox.js"></script>
		<!--[if lt IE 9]>
  		<script src="/js/html5shiv.js" type="text/javascript"></script>
 	 	<script src="/js/respond.min.js" type="text/javascript"></script>
		<![endif]-->
	<head>
	<body>
		<header>
			<nav class="navbar navbar-fixed-top navbar-inverse"  id="my-navbar">
			<div class="container">
				<div class="navbar-header" id="navbar-slide">
					<button type="button" id="slide" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div id="logo_text"><a href="home.php" class="navbar-brand " style="font-size:22px;">solusi-fi</a></div>
				</div>
				<div class="collapse navbar-collapse space-left" id="#navbar-collapse">
					<form class="navbar-form navbar-left" role="search" method="POST">
        				<div class="form-group">
          					<input type="text" name="txtid" class="form-control" placeholder="Search">
        				</div>
        				<button type="submit" name="btnLogin" class="btn btn-info theme">Search</button>
      				</form>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="profiles.php?profile=<?= $myu->studentId ?>"><i class="fa fa-user fa-fw"></i><small></small>&nbsp;<?php echo $myu->fname;?></a></li>
						<li><a href="inbox.php"><i class="fa fa-envelope-o fa-fw"></i> Inbox <?php if($unread > 0): ?><span class="badge"><?= $unread ?></span><?php endif; ?></a></li>
						<li><a class="magic-box" href="#" rel="notifications"><i class="fa fa-info-circle fa-fw"></i> Notifications </a></li>
						<li><a class="magic-box" href="#" rel="friendsRequest"><i class="fa fa-users fa-fw"></i> friend request <?php if($friendsRequests > 0): ?><span class="badge"><?= $friendsRequests?></span><?php endif; ?></a></li>
					</ul>	
				</div>		
			</div>	
		</nav>	
		</header>
		<div id="friend-box">
			<center><img src='./imgs/Loadericon.gif'/><center>
		</div>
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
			<div class="clear"></div>
			<div id="profile-holder">
				<div id="header-area">
					<div id="pro-image-holder">
						<img src="<?= getPageImageCover($forum,$myP->coverphoto) ?>"/>
					</div>	
					<span id="name-text"><h4><?php echo $myP->title;?></h4></span>
				</div>
				<div id="action-holder">
					<div class="btn-group pull-right move-up" role="group" aria-label="...">
						
						<?php if($myP->adminId == $u):?>
							<a type="button" href="#" class="btn btn-success btn-sm spacer">Edit Page</a>
						<?php else: ?>
							<?php if($myL->checkLike($u,"F",$forum)== true):?>
								<span class="like-btn btn btn-primary"  onClick="sendLikePage(<?= $forum ?>,<?=$u?>,'F',<?= $myP->adminId ?>)" id="like-span<?= $forum ?>"><i class="fa fa-thumbs-up fa-fw"></i> unlike </span>
							<?php else:?>
								<span class="like-btn btn btn-primary" onClick="sendLikePage(<?= $forum ?>,<?=$u?>,'F',<?= $myP->adminId ?>)" id="like-span<?= $forum ?>"><i class="fa fa-thumbs-up fa-fw"></i> like </span>						
							<?php endif; ?>
						<?php endif;?>
					</div>			
				</div>
				<div class="clear"></div>
				<div id="left-nav">
					<div id="intro">
						<h3>Intro</h3>
						<p>
							<?php echo $myP->title;?>
						</p>
					</div>
					<div id="intro">
					<h3>About <?php echo $myP->title;?></h3>
						<p>
							<?php echo $myP->description;?>
						</p>
					</div>
					<div id="intro">
					<h3>Page Admin</h3>
						<p>
							<a href="profiles.php?profile=<?= $adminInfo['sid'] ?>"><?php echo $adminInfo['fname']." ".$adminInfo['surName'];?></a>
						</p>
					</div>
					<div id="intro">
						<h3><?= $myL->countLikes("F",$forum); ?> people like this</h3>
					</div>
				</div><!--end left nav -->
				<div id="right-nav">
				<?php if( $myu->systemId == $myP->adminId): ?>
					<div id="post-area">
						<div id="form-container">
							<h3>Post As <?php echo $myP->title;?></h3>
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
								</br><input type="submit" id="btnpost" class="btn btn-primary" value="post" onClick="sendPostPage(<?= $forum?>);"/>
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
				<?php endif; ?>
					<div id="newsfeed style='padding-top:-40px;'">	
						<?php
							$myPost = new fi_posts();
							$info = $myP->headerInfo($forum);
						 	$postTop = "<img id='pro-pic-sm' src='".getPageImage($forum,$info['coverphoto'])."'/>"; 
						 	$postTop .= "<a class='post-header' href='page.php?forum=".$info['pageId']."'>".$info['title']."</a>";
						?>
						<?php foreach( $posts as $post): ?>
						 	<div class='post'>
						 		<?=$postTop?>
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

										<span class='show-like-box' id='<?= $post->postId ?>'><?= $myL->countLikes("P",$post->postId)?> Likes</span><span><?php $commentCount = $myComment->countComments($post->postId);echo $commentCount;?> Comments</span>
										<time class="timeago pull-right" datetime="<?= $post->postDate ?>" title="July 17, 2016"></time>
									</div>
									<div class="post-action">
										<span class="show-comment" id="<?= $post->postId?>" rel="<?= $post->userId?>"><i class="fa fa-comment fa-fw "></i> comment</span>
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
						 			 		
										</div>
						 			</div>
						 		</div>
						 	</div>		
						<?php endforeach; ?>
					</div><!--End newsfeed -->

			</div>	
		</div>

