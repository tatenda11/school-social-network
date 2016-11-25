<?php
	require_once("./libs/autoload.php");
	//require_once("./libs/manageImage.php");
	Sessions:: autheticate();
	$u = $_SESSION['fi_user'];
	$myu = new fi_users();
	$myu->getUser($u);
	$hostels = selectQuery("fi_hostels");
	$majors = selectQuery("fi_degrees");
	$res = fetchNameQuery("SELECT hostelName FROM fi_hostels WHERE hostel = $myu->hostelId");
	$mj = fetchNameQuery("SELECT description FROM fi_degrees WHERE majorId = $myu->majorId");
	if(isset($_POST['btnUpdate'])){
		$name = $_FILES['txtpropic']['name'];
     	$data = $_FILES['txtpropic']['tmp_name'];
     	$size = $_FILES['txtpropic']['size'];
		$filename = pathinfo($name, PATHINFO_FILENAME);
		$ext =  pathinfo($name, PATHINFO_EXTENSION); 
		/*validate*/
		if(empty($name)){
			echo "<script>alert('please choose file');</script>";
		}
		elseif(validateFile($name) == false){
			echo "<script>alert('image type not allowed');</script>";
		}
		elseif($size > 5242880){
			echo "<script>alert('image too large');</script>";	
		}
		/*upload picture*/
		else{
			
			//$img = new SimpleImage();
			$path = "./userInfo/".$myu->studentId;
			$thumbnail = $path."/thumbnail_".$filename.".jpg";
			$profile = $path."/profiles_".$filename.".jpg";
			$fullpath = $path."/".$name;
			$moved = move_uploaded_file($data,$fullpath);
			if($moved){
				$pic = $filename.".jpg";
				$myu->updatePic($u,$pic);
			
				processImage($fullpath,$profile,280,280,$ext);
				processImage($fullpath,$thumbnail,60,60,$ext);
				
				/*
				$img->load($fullpath)->resize(320, 239)->save($profile);
    			$img->load($fullpath)->thumbnail(100, 75)->save($thumbnail);
    			*/
				if($myu->dacCrud==true){
					$myu->propic = $pic;
					$myP = new fi_posts();
					$say = getSex($myu->gender);
					$myP->setPost($u,"P","E",$u,"$myu->fname changed $say profile picture ",$pic,"","U");
					$myN = new fi_notifications();
					$myN->setNotifivation($u,$u,"changed","profile picture",$myP->postId);
					$myA = new fi_albums();
					$myA->setPhoto($u,$pic,"profile photos"); 
					echo "<script>alert('image uploaded');</script>";	
				}
			}
			else{
				echo "<script>alert('failed to upload image ')</script>";
			}
		}
	}
	require_once("./views/header.php");
?>
		 <link href="css/bootstrap-switch.css" rel="stylesheet">
		<style>
			.group-box{
				border: 1px solid #ccc;
				padding: 1%;
			}
			#overlay{
				position: fixed;
			}
			@media only screen and (min-width: 150px) and (max-width: 600px){
				#edit-info-header{
					margin-top: 23px;
				}
				.nav-pills{
					width: 100%;
				}
				.nav ul li{
					float: none;
					clear: both;
				}
				.info-elements{
					width: 100%;
				}
				#processing{
					width: 70;
				}
			}
		</style>
		<div id="overlay">
			<div id="processing">
				<center>
					<img src="./imgs/pulse.gif"/>	
				</center>
			</div>
		</div>
		<div id="container">
			<?php require_once("views/navigation.php");?>		
			<div id="edit-info-container">
				<div id="edit-info-header">
					<h4>Introduction Yourself</h4>
					<ul class="nav  nav-pills">
  						<li role="presentation" class="active" rel="personal"><a href="#">Personal Information</a></li>
  						<li role="presentation" rel="academic"><a href="#">Academic Infomation</a></li>
  						<li role="presentation" rel="propic"><a href="#">Profile picture</a></li>
  						<li role="presentation" rel="settings"><a href="#">Settings</a></li>
					</ul>
				</div>
				<div style="width:100%;height:20px;background-color:#f3f3f3;"></div>
				<div id="edit-info-box">
					<div class="info-elements display" id="personal">
						<div class="list-group" style="text-align:left;">
  							<a href="#" class="list-group-item active">
   		 					<h4 class="list-group-item-heading">Update personal information</h4>
    						<p class="list-group-item-text">update your profile and meet new people and let others know you better</p></a>
						</div>
						<form method="post" enctype="multipart/form-data" onsubmit="return false">
      						<div class="form_elements ">
      							<div id='ajax-feedback'></div>
      							<label>your first name</label></br>
								<input type="text" name="txtfname" id="txtFname" value="<?= $myu->fname ?>" class="form-control widen" aria-describedby="basic-addon3"></input></br>
								<label>your middle name</label></br>
								<input type="text" name="txtSname" id="txtMname"  value="<?= $myu->mdlname ?>" class="form-control widen" aria-describedby="basic-addon3"></input><br/>
								<label>your last name</label></br>
								<input type="text" name="txtSname" id="txtLname"  value="<?= $myu->sname ?>" class="form-control widen" aria-describedby="basic-addon3"></input><br/>
								<label>your home town</label></br>
								<input type="text" name="txtSname" id="txtTown" value="<?= $myu->hometown ?>"class="form-control widen" aria-describedby="basic-addon3"></input><br/>
								<label>birthday</label></br>
								<input type="text" name="txtSname" id="datepicker" value="<?= $myu->birthday ?>" class="form-control widen" aria-describedby="basic-addon3"></input><br/>
      							<label>About me</label></br>
      							<textarea class="form-control" id="txtbio"aria-describedby="basic-addon3"><?= $myu->bio ?></textarea></br>
      							<input type="submit" value="Update Account" id="btnUpdate" class="btn btn-default btn-primary" onClick="updatePersonal();"/>
      						</div>		
      					</form>
					</div>
					<div class="info-elements" id="academic">
						<div class="list-group" style="text-align:left;">
  								<a href="#" class="list-group-item active">
   		 						<h4 class="list-group-item-heading">Update personal information</h4>
    							<p class="list-group-item-text">update your profile and meet new people and let others know you better</p></a>
							</div>
						<form method="post" enctype="multipart/form-data" onsubmit="return false">
      						<div class="form_elements info-element">
      							<div id='ajax-feedback'></div>
      							<label>What level are you</label></br>
      							<select  id="txtlevel" class="form-control widen" aria-describedby="basic-addon3">
      								<option value="<?= $myu->level ?>" class="form-control widen" aria-describedby="basic-addon3"><?= $myu->level ?></option>
      								<option value="1.1" class="form-control widen" aria-describedby="basic-addon3">1.1</option>
      								<option value="1.2" class="form-control widen" aria-describedby="basic-addon3">1.2</option>
      								<option value="2.1" class="form-control widen" aria-describedby="basic-addon3">2.1</option>
      								<option value="2.2" class="form-control widen" aria-describedby="basic-addon3">2.2</option>
      								<option value="attachee" class="form-control widen" aria-describedby="basic-addon3">attachee</option>
      								<option value="4.1" class="form-control widen" aria-describedby="basic-addon3">4.1</option>
      								<option value="4.2" class="form-control widen" aria-describedby="basic-addon3">4.2</option>
      								<option value="other" class="form-control widen" aria-describedby="basic-addon3">Other</option>
      							</select></br>
								<label>Which hostel do you stay in</label></br>
								<select  id="txthostel" class="form-control widen" aria-describedby="basic-addon3">
      								<option value="<?= $myu->hostelId?>" ><?= $res ?></option>
      								<?php foreach( $hostels as $hostel): ?>
										<option value="<?= $hostel->hostel?>" class="form-control widen" aria-describedby="basic-addon3"><?=  $hostel->hostelName ?></option>
									<?php endforeach; ?>							
      							</select></br>
								<label>Your major</label></br>
								<select id="txtmajor" class="form-control widen" aria-describedby="basic-addon3">
      								<option value="<?= $myu->majorId?>" ><?= $mj ?></option>
      								<?php foreach( $majors as $major): ?>
										<option value="<?= $major->majorId ?>" class="form-control widen" aria-describedby="basic-addon3"><?=  $major->description ?></option>
									<?php endforeach; ?>
      							</select></br>
								<label>where did you do your high school</label></br>
								<input type="text" value="<?= $myu->hghschool ?>"id="txtschool" class="form-control widen" aria-describedby="basic-addon3" placeholder="example Fletcher High School"></input><br/>
      							<input type="submit" value="Update Account" class="btn btn-default btn-primary " onClick="updateAcademic();"/>
      						</div>		
      					</form>
					</div>
					<div class="info-elements" id="propic">
						<div class="list-group" style="text-align:left;">
  							<a href="#" class="list-group-item active">
   		 					<h4 class="list-group-item-heading">Choose a profile picture</h4>
    						<p class="list-group-item-text">adding a profile picture will enable other users to recognise you</p></a>
						</div>
						<form method="post" enctype="multipart/form-data">
      						<div class="form_elements ">
      							<input type="file" id="txtpropic" name="txtpropic" class="form-control widen" aria-describedby="basic-addon3"/></br>
      							<input type="submit" value="Update Account" name="btnUpdate" class="btn btn-default btn-primary" onClick="updatePicture();"/>
      						</div>		
      					</form>
					</div>
					<div class="info-elements" id="settings">
						<div class="list-group" style="text-align:left;">
  							<a href="#" class="list-group-item active">
   		 					<h4 class="list-group-item-heading">Choose a profile picture</h4>
    						<p class="list-group-item-text">adding a profile picture will enable other users to recognise you</p></a>
						</div>
						<div class='group-box' id="password">
							<h3>password settings</h3>
							<form method="post" onSubmit="return false">
      							<div class="form_elements ">
      								<label>Current Password</label>
      								<input type="password" id="txtpassold" placeholder="current password"  class="form-control widen" aria-describedby="basic-addon3"/></br>
      								<label>New Password</label>
      								<input type="password" id="txtpassnew1" placeholder="new password"  class="form-control widen" aria-describedby="basic-addon3"/></br>
      								<label>Confirm New password</label>
      								<input type="password" id="txtpassnew2" placeholder="confirm new password"  class="form-control widen" aria-describedby="basic-addon3"/></br>
      								<input type="submit" value="Update Password" name="btnUpdatePassword" id="updatePass" class="btn btn-default btn-primary" />
      							</div>		
      						</form>
						</div></br>
						<div class='group-box'>
							<h3>Privacy Settings</h3>
							<form method="post" onSubmit="return false">
 								<div class="form_elements">
 									<label>timeline lock (who should see my timeline)</label></br>
 									everyone<br>
 									<select id="txtAccess" placeholder="new password"  class="form-control widen" aria-describedby="basic-addon3">
 										<option value='F'>Friends Only</option>
 										<option value='E'>Everyone</option>	
 									</select></br>
              						<input type="submit" value="Update Settings" id="updateSettings" name="btnUpdatePassword" class="btn btn-primary" />
 								</div>	
							</form>
						</div>
					</div>
				</div>
			</div>		
		</div>
		<script type="text/javascript" src="js/updateprofile.js"></script>
		<script>
			$('document').ready(function(){
				$("#datepicker").datepicker({ dateFormat: 'yy-mm-dd' });	
			});
		</script>	
	</body>	
</html>
