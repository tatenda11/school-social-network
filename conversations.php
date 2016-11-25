<?php
	require_once("./libs/autoload.php");
	$u = $_SESSION['fi_user'];
	$myu = new fi_users();
	$myM = new fi_messages();
	$myu->getUser($u);
	
	if(isset($_GET['with'])){
		$with = preg_replace("/[^0-9]/","", $_GET['with']);
		$chats = $myM->getConversation($u, $with);
		$info = $myu->headerInfo($with);
	}	
	else{
		header("location:inbox.php");
	}	
	
	require_once("./views/header.php");
	function getdiv($sender){
		if($sender == $u){
			$div = "to";
		}
		else{
			$div = "from";
		}
		return $div;
	}


?>
<style>
	.from{
		width: 45%;
		border-radius: 11px;
		padding: 2%;
		float: left;
		clear: both;
		margin-bottom: 15px;
		border: 1px solid #4dc247;
		background-color: #F0F8FF;
	}
	.to{
		width: 45%;
		border-radius: 11px;
		padding: 2%;
		margin-left: 7%;
		height: auto;
		clear: both;
		float: left;
		margin-bottom: 15px;
		border: 1px solid #4dc247;
	}
	.chat-heading{
		float: right;
		margin-right: 3%;
	}
	#chat-box{
		float: left;
		width: 65%;
		background-color: white;
		height: 600px;
		overflow-y: scroll;
		margin-left: 3%;
		padding: 2%;
	}
	@media only screen and (min-width: 150px) and (max-width: 600px){
		#chat-box{
			width: 100%;
			padding-top: 50px;
		}
		.to,.from{
			width: 90%;
		}	
	}
</style>
<div id="container">
	<?php require_once("./views/navigation.php");?>
	<div id="chat-box">
		<?php foreach($chats as $chat): ?>
			<?php if( $chat->userFrom == $u): ?> 
				<div class="to">
					<a href="" class='chat-heading'>You</a></br>
					<p><?= $chat->message ?></p>
					<small><time class="timeago pull-right" datetime="<?= $chat->sentDate ?>" title="July 17, 2016"></time></small></br>
					<?php if( $chat->status == "O"): ?>
						<span class='pull-right'>delivered</span>
					<?php else: ?>
						<span class='pull-right'>not read</span>
					<?php endif; ?>
				</div>	
			<?php else: ?>
				<div class="from">
					<a href="profiles.php?profile=<?php echo $info['sid'] ;?>" class='chat-heading'><?php echo $info['fname']." ".$info['surName'];?></a></br>
					<p><?= $chat->message ?></p></br>
					<small><time class="timeago pull-right" datetime="<?= $chat->sentDate ?>" title="July 17, 2016"></time></small></br>
				</div>	
			<?php endif ?>
		<?php endforeach ?>
	</div>
</div>
<script type="text/javascript" src="js/home.js"></script>
</body>
</html>
