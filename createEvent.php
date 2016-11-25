<?php
	require_once("./libs/autoload.php");
	Sessions:: autheticate();
	$u = $_SESSION['fi_user'];
	$myE = new fi_events();
	$myu = new fi_users();
	$myu->getUser($u);
	$error = false;
	$success =false;
	function uploadImage($name,$data,$size){
		$rtrn = true;
		$ext = $ext =  pathinfo($name, PATHINFO_EXTENSION); 
		$thumbnail = "./events/-o1thumbnail_".pathinfo($name, PATHINFO_FILENAME).".jpg";
		/* validate size*/
		if($size > 5242880){
			echo"<script>alert('alert image to large');</script>";
			$rtrn = false;
		}
		/* validate type*/
		elseif(validateFile($name) == false){
			echo"<script>alert('alert image type not supported');</script>";
			$rtrn = false;
		}
		/*move file*/
		else{
			$moved = move_uploaded_file($data,"./events/$name");
			if($moved){
				processImage("./events/$name",$thumbnail,150,150,$ext);
			}
			else{
				echo"<script>alert('failed to upload image');</script>";
				$rtrn = false;
			}
		}
		return $rtrn;
	}

	if(isset($_POST['btnCreartEvent'])){
		$title = strip_tags($_POST['txtname']);
		$des = strip_tags($_POST['txtEventDes']);
		$venue = strip_tags($_POST['txtVenue']);
		$info = strip_tags($_POST['txtInfo']);
		$cost = strip_tags($_POST['txtCost']);
		$stime = strip_tags($_POST['txtStime']);
		$etime =strip_tags($_POST['txtEtime']);
		$date = strip_tags($_POST['txtEventDate']);
		$pic = $_FILES['txtPhoto']['name'];
		$data = $_FILES['txtPhoto']['tmp_name'];
		$size = $_FILES['txtPhoto']['size']; 
		/*validate form*/
		if(empty($title)||empty($des)||empty($venue)||empty($date)){
			$error = true;
			$msg = "Please provide the name,brief description,venue and data for your event to proceed";
		}
		else{
			if(!empty($pic)){
				if(uploadImage($pic,$data,$size)== true){
					$created = $myE->setEvent($title,$des,$date,$stime,$etime,$venue,$cost,$u,$info,$pic);
					if($created){
						$success = true;
					}
				}
				else{
					$error = true;
					$msg = "Either your image iss greater than 5MB ";
				}
			}
			else{
				$created = $myE->setEvent($title,$des,$date,$stime,$etime,$venue,$cost,$u,$info,$pic);
				if($created){
					$success = true;
				}
			}
		}
	}
?>
<?php require_once("./views/header.php");?>
<style>
#form-holder{
	width: 60%;
	float: left;
	padding: 3%;
	background-color: #fff;
}
#right-bar{
	width: 35%;
	float: left;
	margin-left: 4%;
}
</style>
		<div id='overlaylikes'>
			<div class='show-likes'>
				<div class='likebox panel panel-default'> 
					<div class="panel-heading">People who like this</div>
					<div class='liker-holder-box'>
					</div>
				</div>
			</div>	
		</div>
`		<div id="container">
			<div id="form-holder">
				<?php if($success== false):?>	
				<h3><label>Create Event<label></h3>
					<form method="post" enctype="multipart/form-data">
      				<div class="form_elements" >
      				<fieldset>
      					<div id="request-feedack">
      					<?php if($error){echo"<div class='alert alert-danger' role='alert'>$msg</div>";};?>
      					</div>
      					<label>Event Title</label></br>
      					<input type='text' name='txtname'placeholder="Event name" aria-describedby="basic-addon3" class="form-control" />
      					</br><label>Attach a Photo</label></br>
      					<input type='file' name="txtPhoto" placeholder="send notes" aria-describedby="basic-addon3"/>
      					</br><label>About your event</label></br>
      					<textarea style="height:100px;" name='txtEventDes'class="form-control" placeholder="Basic Information about your event ie who is invited etc" aria-describedby="basic-addon3" id="txtdes"></textarea>	
      					</br><label>Planned Date</label></br>
      					<input type="text" class="form-control" name="txtEventDate"placeholder="Planned date" aria-describedby="basic-addon3" id="datepicker"/>
      					</br><label>Venue</label></br>
      					<input type="text" class="form-control" name="txtVenue" placeholder="Venue" aria-describedby="basic-addon3" id="txtvenue"/>
      				    </br><label>Start time eg 9am</label></br>
      					<input type="text" class="form-control" name='txtStime'placeholder="Start time" aria-describedby="basic-addon3" id="txtstime"/>
      				    </br><label>End time eg 8pm</label></br>
      					<input type="text" class="form-control" name='txtEtime' placeholder="End time" aria-describedby="basic-addon3" />
      					</br><label>Admision Cost</label></br>
      					<input type="text" class="form-control" name='txtCost' value="$0.00" aria-describedby="basic-addon3" id="txtcost"/>
      					</br><label>About your event</label></br>
      					<textarea style="height:100px;" name='txtInfo'class="form-control" placeholder="addtional information eg dress code etc" aria-describedby="basic-addon3" id="txtinfo"></textarea>	
      					</br><input type="submit" value='create Event' class='btn btn-primary' name='btnCreartEvent'/>
      				</fieldset>
      		</div>		
      	</form>	
      	<?php else:?>
      		<j1>tatenda's code</h1>
      	<?php endif;?>
		</div>
		<div id'right-bar'>
			<div id="ads-container">
				<img src="./imgs/ad.jpg"/>
			</div>	
		</div>
		</div>
		

<script>
	$('document').ready(function(){
		$("#datepicker").datepicker();	
	});
</script>
</body>
</html>