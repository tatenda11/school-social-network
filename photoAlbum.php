<?php 
	require_once("./libs/autoload.php");
	Sessions:: autheticate();
	$u = $_SESSION['fi_user'];
	$myu = new fi_users();
	$page = 1;
	if(isset($_GET['profile'])){
		$candy = preg_replace("/[^0-9]/","", $_GET['profile']);
		$myu->getUser($candy);
		$myA = new fi_albums();
		if(isset($_GET['page'])){
			$page = preg_replace("/[^0-9]/","", $_GET['profile']);
		}
		$photoCount = $myA->countPhotos($candy);
		$paginations = paginateWall($photoCount,$page,10,$myu->systemId);
		if($photoCount > 0){
			//$posts = $myPost->getWallPosts($myu->systemId,$paginations['limit'],10);
			$photos = $myA->getPhotos($candy,$paginations['limit'],10);				
		}
		else{
			$photos = array();
		}
	}
	else{
		header("locaton:home.php");
	}
	
	require_once("./views/header.php");	
?>
	<style>
		#gallary-holder{
			background-color: #fff;
			width:85%;
			clear: both;
			margin-top: 74px;
			margin: auto;
			height: auto;
			padding: 1%;
			float: left;
		}
		#gallary-holder ul li{
			float: left;
			list-style: none;
			padding: 1%;
		}
		#gallary-holder ul li img{
			width: 190px;
			height: auto;
		}
		#gallary-holder ul li img{
			cursor:pointer;
		}
		#overlay2{
			background-color:#000;
			width: 100%;
			height: 200%;
			position: absolute;
			top: 0px;
			display: block;
			opacity: 0.9;
			cursor: pointer;
			display: none;
		}
		#overlay2 #photo-frame{
			background-color: #fff;
			width: 45%;
			height: auto;
			margin: auto;
			margin-top: 100px;
			padding: 1%;
		}
		#overlay2 #photo-frame img{
			margin: auto;
			max-width: 100%;
			clear: both;
		}
		#arrow-holder{
			width: 100%;
			height: auto;
			background-color: blue;
		}		
	</style>
	<div id="overlay2">
		<div id="photo-frame">
			<center>
				<img src=""/>
			</center>
			<div id="arrow-holder">
				<div class="btn-group pull-right move-up" role="group" aria-label="...">
  					<button type="button"id="#right"  class="btn btn-danger btn-sm spacer">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div id="container">
		<div id="gallary-holder">
			<h3>Photos of <?= $myu->fname?> (<?= $photoCount?>)</h3><hr>
			<ul id="gallary-holder">
				<?php foreach($photos as $photo):?>
					<li rel ='userinfo/<?=$myu->studentId?>/<?=$photo->photoName?>'><img src="<?= profilePhoto($myu->studentId,$photo->photoName,$myu->gender)?>"/></li>
				<?php endforeach; ?>
			</ul>
			<div class="pagination-holder">
				<ul class="pagination-list">
					<?php echo $paginations['display'];?>
				</ul>	
			</div> 
		</div>
	</div>
	<script type="text/javascript">
		$(function(){
			var current_li;
			$("#gallary-holder ul li").on('click',function(){
				var src = $(this).attr('rel');
				$("#photo-frame img").attr("src",src);
				current_li = $("#gallary-holder ul li");
				$("#overlay2").fadeIn(300);
			});
			$("#overlay2").on('click',function(){
				$("#overlay2").fadeOut(300);
			});
		});
	</script>		
	<body>
</html>