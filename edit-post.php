<?php
	require_once("./libs/autoload.php");
	Sessions::autheticate();
	$u =  Sessions::getSession();
	$myu = new fi_users();
	$myu->getUser($u);
	if(isset($_GET['post'])){
		$post =  preg_replace("/[^0-9]/","", $_GET['post']);
		$myP = new fi_posts();
		$myP->getPost($post,$u);
		$auth = false;
		if($myP->userId == $u){
			$auth = true;
		}
		elseif($myP->wall == $u){
			$auth = true;
		}
		else{
			header("location:home.php");
		}
	}
	else {
		header("location:home.php");
	}


	if(isset($_POST['btnsignUp'])){
		$myP = new fi_posts();
		$text = $_POST['txtText'];
		$post = preg_replace("/[^0-9]/","", $_POST['txtPost']);
		$myP->updatePost($post,$u,$text);
		if($myP->dacCrud == true){
			echo "<script>alert('post updated');</script>";
			$myP->getPost($post,$u);
		}
	}
?>
<?php require_once("./views/header.php");?>
<style>
#notifications{
	width: 50%;
	height: auto;
	background-color: #fff;
	margin-top: 30px;
	float: left;
}
#ads{
	margin-top: 30px;
	width: 20%;
	float: left;
	margin-left: 2%;
}
.not-holder2{
	width: 100%;
	float: left;
	padding: 2%;
	border-bottom: 2px solid #F3F3F3;
	clear: both;
}
.notpic{
	padding: 3px;
	float: left;
}
.not-holder2 p{
	width: auto;
	width: 60%;
	padding: 1%;
	margin-left: 1%;
	top: 0px;
	float: left;
	display: inline-block;
}
@media only screen and (min-width: 150px) and (max-width: 600px){
#notifications{
	width: 95%;
}
#ads{
	clear: both;
	display: block;
	width: 95%;
}
}
</style>
<div id='container'>
	<div id="notifications" class='panel panel-default' style='padding:1%;'>
		<div class='panel-heading' style='margin:auto;'>Edit Post</div>
		<?php if($u == $myP->userId):?>
			<form method="post" enctype="multipart/form-data" >
      			<div class="form_elements" >
      				<fieldset>
      					<div id="request-feedack"></div>
      						<input type='hidden' value='<?= $post ?>' name='txtPost'/>
      						<textarea style="height:100px;" name='txtText' class="form-control" placeholder="Your Message" aria-describedby="basic-addon3"><?= $myP->postText ?></textarea>
      						</br><input type="submit" value="Update Post" name="btnsignUp" class="btn btn-info"/>
      						<a href='#'class='btn btn-danger' onClick="deletePost(<?= $myP->postId ?>)">delete</a>
      				</fieldset>
      			</div>		
      		</form>
      	<?php else:?>		 
			<h5>You cannot update this but since it was posted by another user </h5>
			<button class='btn btn-danger' onClick="deletePost(<?= $myP->postId ?>)">delete from my wall</button>
      	<?php endif;?>
	</div>
	<div id="ads">
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