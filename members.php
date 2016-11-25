<?php
	require_once("./libs/autoload.php");
	Sessions:: autheticate();
	$u = $_SESSION['fi_user'];
	$myu = new fi_users();
	$myF = new fi_friends();
	$myu->getUser($u);
	$m =getInput("major");
	$n =getInput("name");
	$l =getInput("level");
	$h =getInput("hostel");
	$hostels = selectQuery("fi_hostels");
	$majors = selectQuery("fi_degrees");
	if(isset($_GET['page'])){
		$page = preg_replace("/[^0-9]/","", $_GET['page']);
	}	
	else{
		$page = 1;
	}	
	if(isset($_POST['btnSearch'])){
		$l = cleanSql($_POST['level']);
		$m = cleanSql($_POST['major']);
		$n = cleanSql($_POST['name']);
		$h = cleanSql($_POST['hostel']);
		//$n = cleanSql($_POST[$nana]);
		$record_count = $myu->countResults($n,$m,$h,$l);
		$paginations = paginate($record_count,$page,$n,$m,$h,$l);
		//$paginations['limit'];
		if($record_count > 0){
			$members = $myu->runSearch($n,$m,$h,$l,$paginations['limit'],5);
		}
		else{
			$members = array();
		}
	}
	else{
		$record_count = $myu->countAll();
		$paginations = paginate($record_count,$page,$n,$m,$h,$l);
		$members = $myu->getAll($paginations['limit'],5);

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
	.pro-pic-sm{
		width: 180px;
		height: 180px;
		display: none;
	}
</style>
<div id="container">
	<div class="newline"></div>
	<div id="personal-info">
		<div class="list-group">
  			<a class="list-group-item active" href="Add_Folder.php"><span style="font-size:19px;">Search Members</span></a>
  		</div>
    	<form method="POST" action="members.php">
      		<div class="form_elements">
      			<label>filter by name</label></br>
				<input type="text" style="width:90%;"name="name" placeholder="search..." class="form-control widen" aria-describedby="basic-addon3"></input></br>
				<label>filter by level</label></br>
      			<select  name="level" style="width:90%;" class="form-control widen" aria-describedby="basic-addon3">
      				<option value="0" class="form-control widen" style="width:90%;" aria-describedby="basic-addon3">no filter</option>
      				<option value="1.1" class="form-control widen" style="width:90%;" aria-describedby="basic-addon3">1.1</option>
      				<option value="1.2" class="form-control widen" style="width:90%;" aria-describedby="basic-addon3">1.2</option>
      				<option value="2.1" class="form-control widen" style="width:90%;" aria-describedby="basic-addon3">2.1</option>
      				<option value="2.2" class="form-control widen" style="width:90%;" aria-describedby="basic-addon3">2.2</option>
      				<option value="attachee" class="form-control widen"  style="width:90%;" aria-describedby="basic-addon3">attachee</option>
      				<option value="4.1" class="form-control widen" style="width:90%;" aria-describedby="basic-addon3">4.1</option>
      				<option value="4.2" class="form-control widen" style="width:90%;" aria-describedby="basic-addon3">4.2</option>
      				<option value="other" class="form-control widen" style="width:90%;" aria-describedby="basic-addon3">Other</option>
      			</select></br>
      			<label>filter by major</label></br>
				<select style="width:90%;" name="major" class="form-control widen" aria-describedby="basic-addon3">
      				<option value="0" class="form-control widen" style="width:90%;" aria-describedby="basic-addon3">no filter</option>
      				<?php foreach( $majors as $major): ?>
						<option value="<?= $major->majorId ?>" class="form-control widen" style="width:90%;" aria-describedby="basic-addon3"><?=  $major->description ?></option>
					<?php endforeach; ?>
      			</select></br>
      			<label>filter by hostel</label></br>
 				<select style="width:90%;" name="hostel" class="form-control widen" aria-describedby="basic-addon3">
 					<option value="0" class="form-control widen" style="width:90%;" aria-describedby="basic-addon3">no filter</option>
 					<?php foreach( $hostels as $hostel): ?>
						<option value="<?= $hostel->hostel?>" class="form-control widen" style="width:90%;"aria-describedby="basic-addon3"><?=  $hostel->hostelName ?></option>
					<?php endforeach; ?>							
      			</select></br>
			   <input type="submit" value="Search members" name="btnSearch" class="btn btn-default btn-primary" onClick="updatePersonal();"/>
      		</div>		
      	</form>
    </div>
	<div id="edit-info-container">
		<div id="search-result-box">
			<h3>Browse Members (<?php echo $record_count; ?>)</h3>
			<div class="liner"></div>
			<?php foreach( $members as $member): ?>
				<div class="search-holder">
					<img id="pro-pic-sm" src="<?= profilePhoto($member->studentId,$member->propic,$member->gender); ?>" />
					<span class='heading'><a href="profiles.php?profile=<?= $member->studentId ?>"><?php echo $member->fname." ". $member->sname;?></a></span>
					<p>
						Studies <?= fetchNameQuery("SELECT description FROM fi_degrees WHERE majorId = $member->majorId")?> 
						</br>Level <?= $member->level ?></br>
					</p> 
					<div class="btn-group" role="group" aria-label="...">
  					</br>
  					<?php if($u== $member->systemId):?> 
  						
  					<?php elseif( $myF->checkFriendship($u,$member->systemId) == false && $u != $member->systemId): ?>
  						<button type="button" onClick="addFriend(<?= $u?>,<?= $member->systemId ?>)" class="btn btn-sm click-hide">Add Friend</button>
  					<?php elseif($myF->status == "A"):?>
  						<button type="button" onClick="removeFriend(<?= $myF->friendshipId ?>,<?= $member->systemId ?>)"  class="btn btn-sm click-hide">Remove Friend </button>
  					<?php elseif($member->systemId != $u):?>
  						<button type="button" onClick="removeFriend(<?= $myF->friendshipId?>,<?= $member->systemId ?>)"  class="btn btn-sm click-hide">Cancel request</button>
  					<?php endif; ?>
  					<div class="request-feedback" id="request-feedback<?= $member->systemId?>"></div>		
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