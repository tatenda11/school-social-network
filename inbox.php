<?php
	require_once("./libs/autoload.php");
	Sessions:: autheticate();
	$u = $_SESSION['fi_user'];
	$myu = new fi_users();
	$myM = new fi_messages();
	$myu->getUser($u);
	
	if(isset($_GET['page'])){
		$page = preg_replace("/[^0-9]/","", $_GET['page']);
	}	
	else{
		$page = 1;
	}	
	$msg_count = $myM->countAll($u);
	$paginations = paginateNull($msg_count,$page,5);
	if($msg_count > 0){
		$messages = $myM->getInbox($u,$paginations['limit'],5);	
	}
	else{
		$messages = array();
	}
	
	require_once("./views/header.php");
?>
<style>
	.request-feedback{
		clear: both;
		float: left;
		margin-left: 2%;
		padding-bottom: 5px;
	}
	.msg-holder{
		width: 100%;
		height: auto;
		padding: 1%;
		float: left;
		border-bottom: 1px solid #ccc; 
	}
	.msg-holder .heading a{
		float: left;
		color: blue;
	}
	.msg-holder .msg-snip{
		float:left;
		width:70%;
		margin-left:2%;
		padding: 0.5%;
		padding-top:0%; 
	}
	.msg-holder .from-holder{
		width: 20%;
		float: left;
	}
	.msg-holder .msg-snip .time-ago{
		float:right;
	}
	.msg-holder .msg-snip:hover{
		cursor: pointer;
	}
	.msg-holder .msg-container{
		width: 100%;
		height:auto;
		border:1px solid #ccc;
		margin-top: 9px;
		padding: 5%;
	}
	.msgMark{
		background-color: #f3f3f3;
		font-weight: bolder;
	}
	.msg-holder .msg-container p{
		width: 80%;
	}
	.msg-container{
		display: none;
	}
	.P{
		background-color: #f3f3f3;
	}
	@media only screen and (min-width: 150px) and (max-width: 600px){
		.msg-holder .heading{
			clear:both;
			width: 100%;
			float:none;
		}
		.msg-holder .msg-snip{
			float:none;
			width:100%;
			clear: both
		}
		.msg-holder .from-holder{
		width: 100%;
		float: none;
		margin-left: 2%;
		}
		
	}
</style>
<div id="container">
	<?php require_once("./views/navigation.php");?>
	<div id="edit-info-container">
		<div id="search-result-box">
			<h3>Inbox (<?php echo $msg_count; ?>)</h3>
			<div class="liner"></div>
				<?php foreach($messages as $message): ?>
					<?php $info = $myu->headerInfo($message->userFrom);?>
					<div class="msg-holder <?php if($message->status == 'P'){echo 'msgMark';}?>" id='msg-holder<?= $message->messageId ?>'>
						<div class ='from-holder'><span class='heading'><a href="conversations.php?with=<?= $message->userFrom ?>"><?php echo $info['fname']." ". $info['surName']?></a></span></div>
						<div class="msg-snip ">
							<a href="#" style='color:#000;' class='msg-click' id='<?= $message->messageId?>'><?php echo substr($message->message,0,150);?></a>
							<time class="timeago pull-right mobile-hide" datetime="<?= $message->sentDate ?>" title="July 17, 2016"></time>
						</div>
						<div style="clear:both;width:100%;margin-top:5px;"></div>
						<div class='msg-container' id="showmessage<?= $message->messageId?>">
							<p>
								<?= $message->message ?>
							</p>
							<form method="post" enctype="multipart/form-data" onsubmit="return false">
								<div class="form_elements" >
      								<fieldset>
      									<div id="request-feedack<?= $message->messageId ?>"></div>
      										<textarea style="height:100px;" class="form-control" id="txtReply<?= $message->messageId ?>"placeholder="Reply <?= $info['fname'] ?>" aria-describedby="basic-addon3" id="txtmsg"></textarea>
    	   									</br><input type="submit" onClick="sendReply(<?= $message->userFrom ?>,<?= $message->messageId?>);"value="Send Message" id="btnsignUp" class="btn btn-info"/>
      								</fieldset>

     					 		</div>
							</form>
						</div>
					</div>
				<?php endforeach; ?>
		</div>
		<div class="pagination-holder">
			<ul class="pagination-list">
				<?php echo $paginations['display'];?>
			</ul>	
		</div> 
	</div>    
</div>
<script type="text/javascript" src="js/home.js"></script>
</body>
</html>
