<?php
	require_once("./libs/autoload.php");
	Sessions::autheticate();
	$u =  Sessions::getSession();
	$myu = new fi_users();
	$myu->getUser($u);
	if(isset($_GET['comment'])){
		$comment =  preg_replace("/[^0-9]/","", $_GET['comment']);
		$myC = new fi_comments();
		$myC->getComment($u,$comment);
		if($myC->dacFound == false){
			header("location:home.php");
		}
		
	}
	else {
		header("location:home.php");
	}


	if(isset($_POST['btnsUpdate'])){
		$myC = new fi_comments();
		$text = strip_tags($_POST['txtText']);
		$comment = preg_replace("/[^0-9]/","", $_POST['txtComment']);
		$myC->updateComment($u,$comment,$text);
		if($myC->dacCrud == true){
			echo "<script>alert('post updated');</script>";
			$myC->getComment($u,$comment);
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
			<form method="post" enctype="multipart/form-data" >
      			<div class="form_elements" >
      				<fieldset>
      					<div id="request-feedack"></div>
      						<input type='hidden' value='<?= $comment ?>' name='txtComment'/>
      						<textarea style="height:100px;" name='txtText' class="form-control" placeholder="Your Message" aria-describedby="basic-addon3"><?= $myC->comment ?></textarea>
      						</br><input type="submit" value="Update Post" name="btnsUpdate" class="btn btn-info"/>
      						<a href='#'class='btn btn-danger' onClick="deleteComment(<?= $myC->commentId ?>)">delete</a>
      				</fieldset>
      			</div>		
      		</form>
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