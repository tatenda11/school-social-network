<?php
	require_once("./libs/autoload.php");
	Sessions:: autheticate();
	$u = $_SESSION['fi_user'];
	if(isset($_GET['profile'])){
		$myu = new fi_users();
		$myu->getUserById(preg_replace("/[^a-zA-Z0-9]+/", "", $_GET['profile']));
		$mys = new fi_settings();
		if($myu->dacFound == false){
			header("location:home.php");
		}
		else{
			$myF = new fi_friends();
			if(isset($_GET['page'])){
				$page =  preg_replace("/[^0-9]/","", $_GET['page']);
			}
			else{
				$page = 1;
			}
			$myPost = new fi_posts();
			$myComment = new fi_comments();
			$myL = new fi_likes();
			$post_count = $myPost->countWallPost($u,"U");
			$paginations = paginateWall($post_count,$page,10,$myu->studentId);
			if($post_count > 0){
				$posts = $myPost->getWallPosts($myu->systemId,$paginations['limit'],10);	
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
<?php require_once("./views/header.php");?>
<link href="css/profile.css" rel="stylesheet" type="text/css"/>
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
						<img src="<?=  profilePhoto($myu->studentId,$myu->propic,$myu->gender); ?>"/>
					</div>	
					<span id="name-text"><?php echo $myu->fname." ".$myu->sname;?></span>
				</div>
				<div id="action-holder">
					<?php if( $myu->systemId != $u): ?>
						<?php if( $myF->checkFriendship($u,$myu->systemId) == false): ?>
							<div class="btn-group pull-right move-up" role="group" aria-label="...">
  								<button type="button"  onClick="addFriend(<?= $u?>,<?= $myu->systemId ?>)" class="btn btn-primary btn-sm click-hide">Add friend</button>
  								<button type="button" data-toggle="modal" data-target="#message"  class="btn btn-primary btn-sm spacer">Sent Message</button>
							</div>
						<?php elseif($myF->status == "A"):?>
							<div class="btn-group pull-right move-up" role="group" aria-label="...">
								<button type="button" data-toggle="modal" data-target="#message" class="btn btn-primary btn-sm spacer">Sent Message</button>
							</div>
						<?php else:?>
							<div class="btn-group pull-right move-up" role="group" aria-label="...">
								<button type="button" onClick="addFriend(<?= $u?>,<?= $myu->systemId ?>)" class="btn btn-danger btn-sm spacer click-hide">Delete Request</button>
								<button type="button" data-toggle="modal" data-target="#message" class="btn btn-primary btn-sm spacer">Sent Message</button>
							</div>		
						<?php endif;?>
						<?php else:?>
							<div class="btn-group pull-right move-up" role="group" aria-label="...">
								<a type="button" href="updateProfile.php" class="btn btn-success btn-sm spacer">Edit Profile</a>
							</div>	
					<?php endif;?>	
				</div>
				<div class="clear"></div>
				<div id="left-nav">
					<div id="intro">
						<h3>Intro</h3>
						<p>
							<?php echo $myu->bio;?>
						</p>
					</div>
					<div id="intro">
					<h3>About <?php echo $myu->fname." ".$myu->sname;?></h3>
						<ul>
							<li>Studies <?php echo fetchNameQuery("SELECT description FROM fi_degrees WHERE majorId = $myu->majorId")." ".$myu->level; ?></li>
							<li>Stays in <?=fetchNameQuery("SELECT hostelName FROM fi_hostels WHERE hostel = $myu->hostelId");?> </li>
							<li>Went to <?=$myu->hghschool;?> </li>
							<li>From <?=$myu->hometown;?></li>
							<li>Birthday <?=$myu->birthday;?></li>
						</ul>
					</div>
					<div id="intro">
						<h3><a href="photoAlbum.php?profile=<?= $myu->systemId?>">Photos</a></h3>
						<p>
							<?php 
								$myA = new fi_albums();
								$photos = $myA->getPhotosDisplay($myu->systemId);
							?>
							<?php foreach( $photos as $photo): ?>
								<img class="thumb-display" src="<?php echo getpath($myu->studentId)."thumbnail_".$photo->photoName;?>"/>
							<?php endforeach; ?>
						</p>
					</div>
					<div id="intro">
						<h3><?= $myF->countFriends($myu->systemId)?> Friends</h3>
					</div>	
				</div>
				<div id="right-nav">
					<?php if($mys->getAccess($myu->systemId) != "C" ||  $myF->checkFriendship($u,$myu->systemId) == true || $myu->systemId == $u): ?>
					<div id="post-area">
						<div id="form-container">
							<h3>Post on <?php echo $myu->fname;?>'s wall</h3>
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
						 	<div class='post'>
						 		<?php $info = $myu->headerInfo($post->userId);?>
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
									<?php elseif($post->posttyp == "V"): ?>
                                     	<iframe width="100%" height="350px" src="<?= $post->youtube?>" frameborder="0" ></iframe>	
									<?php endif; ?>

									<div class="post-stats">
										<?php
											$comments = $myComment->getByPost($post->postId);
										?>

										<span class='show-like-box' id='<?= $post->postId ?>'><?= $myL->countLikes("P",$post->postId)?> Likes</span><span><?php $commentCount = $myComment->countComments($post->postId);echo $commentCount;?> Comments</span>
										<time class="timeago pull-right" datetime="<?= $post->postDate ?>" title="July 17, 2016"></time>
									</div>
									<div class="post-action">
										<span class="show-comment" id="<?= $post->postId?>" rel='<?= $post->userId?>' ><i class="fa fa-comment fa-fw "></i> comment</span>
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
					<div class="pagination-holder">
						<ul class="pagination-list">
							<?php echo $paginations['display'];?>
						</ul>	
					</div> 
				<?php else: ?>
					<h3>Only friends can view what <?= $myu->fname ?> posts</h3>		
				<?php endif; ?>
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

