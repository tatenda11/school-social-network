<?php
	require_once("./libs/autoload.php");
	Sessions:: autheticate();
	$u = $_SESSION['fi_user'];
	$myu = new fi_users();
	$myL = new fi_likes();
	$myu->getUser($u);
	if(isset($_GET['page'])){
		$page =  preg_replace("/[^0-9]/","", $_GET['page']);
	}
	else{
		$page = 1;
	}
	
	$myE = new fi_events();
	$events = $myE->getEventsAll();
?>
<?php require_once("./views/header.php");?>
<style>
#event-holder{
	width: 46%;
	background-color: #fff;
	height: auto;
	margin-top: 40px;
	float: left;
}
#event-action{
	float:left;
	width: 25%;
	margin-left: 2%;
	height: auto;
	margin-top: 40px;
}
.event{
	width: 100%;
	height: auto;
	border-bottom: 19px solid #f3f3f3;
	padding:2%;
	float: left;
	border-radius: 15px;
}
.event h5{
	font-size: 19px;
	font-weight: lighter;
}
.event img{
	float: left;
	padding: 2px;
}
.details-box{
	margin-left: 2%;
	width: 70%;
	background-color: #f3f3f3;
	padding: 3%;
	float: left;
}
#co-odinator-info a{
	margin-left: 3px;
} 
#overlayattending{
	width: 100%;
	height: 100%;
	background: #000;
	opacity: 0.7;
	position: fixed;
	top: 0px;
	z-index: 1000;
}
</style>
		<div id='overlayattending'>
			<div class='likebox panel panel-default'> 
					<div class="panel-heading">People who like this</div>
					<div class='liker-holder-box'>
					</div>
				</div>
			</div>	
		</div>
		<div id="container">
			<div id="event-holder">
				<?php foreach ($events as $event): ?>
					<div class='event'>
						<h5><?= $event->eventName ?></h5>
						<div class='time-strip'>
							<time class='pull-right'><?= $event->startDate ?></time>
							<time class='pull-left'><?= $event->startTime ?> to <?= $event->endTime ?></time>
						</div>
						<div class='liner'></div>
						<strong>Venue : <?= $event->venue ?></strong></br>
						<strong>Addmision : <?= $event->cost ?></strong></br>
						<?php if( $event->pic == "thumbnail_default.jpg") :?>
							<img src='./events/thumbnail_default.jpg'/>
						<?php else:?>
							<img src='./events/thumbnail_default.jpg'/>
						<?php endif;?>	
						<div class='details-box'>
							<h3>Event Datails</h3>
							<p>
								<?= $event->eventDescription ?>
							</p>
							<div class='liner'></div>
							<h5><small>Additional Informtion</small></h5>
							<p><?= $event->otherInfo ?></p>
						</div>	
						<div class='liner'></div>
						<div class="btn-group " role="group" aria-label="...">
							<button onClick = "setVal('setEvent',<?=$event->eventId?>)" class='btn btn-default' data-toggle="modal" data-target="#status">Confirm Attendence</buttom>
							<button onClick = "getCord(<?=$event->userId?>)" class='btn btn-default' data-toggle="modal" data-target="#co-odinators">Co-odinators</buttom>
							<button class='btn btn-default' data-toggle="modal" data-target="#attent-sheet"> 5 Attending</buttom>	
						</div>	
					</div>
				<?php endforeach;?>
			</div>
			<div id="event-action">
				<div class='panel panel-primary'  style='padding:1%;border:none;float:right;'> 
					<div class="panel-heading ">Events!! wats up on Campus</div>
					<h5>Why post your event on solusi-fi</h5>
					<ul>
						<li>People will get to know about your event</li>
						<li>People can see who is also going</li>
						<li>Allows you to plan ahead</li>
						<li>Get people talking</li>
					</ul>
					<a class='btn btn-primary btn-sm pull-right' href='createEvent.php'>Create Event Now</a>
				</div>
			</div>

		</div>	
<!-- *************************** status sender ***********************************************-->	
<div id="status" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div><center><img id="inmate" src="./imgs/pulse.gif"/></center></div>
      <div class="modal-body" id="signup-content">
      		<center>
      			<div class="btn-group " role="group" aria-label="...">
					<input type='hidden' id='setEvent' value='M'/>
					<button class='btn btn-primary btn-lg' onClick="sendAttend('M')">Maybe</buttom>
					<button class='btn btn-primary btn-lg' onClick="sendAttend('I')">Interested</buttom>
					<button class='btn btn-primary btn-lg' onClick="sendAttend('C')">Certainly</buttom>	
				</div>
			</center>		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  <!-- *************************** End attend sheet ***************************************************-->
 <!-- *************************** status sender ***********************************************-->	
<div id="co-odinators" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div><center><img id="inmate" src="./imgs/pulse.gif"/></center></div>
      <div class="modal-body">
      		<div id="co-odinator-info">

      		</div>		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  <!-- *************************** End co-odinators sheet ***************************************************-->
<footer>
		<script type="text/javascript" src="js/home.js"></script>
		<div id="foot-container">
			<ul>
				<li>&copy; 2016  tatenda munenge productions</li>
			</ul>
		</div>
	</footer>
</body>
</html>

