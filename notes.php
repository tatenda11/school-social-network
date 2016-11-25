<?php
	require_once("./libs/autoload.php");
	Sessions:: autheticate();
	require_once("./libs/manageNotes.php");
	$u = $_SESSION['fi_user'];
	$myu = new fi_users();
	$myN = new fi_notes();
	$myu->getUser($u);
	
	if(isset($_GET['page'])){
		$page = preg_replace("/[^0-9]/","", $_GET['page']);
	}	
	else{
		$page = 1;
	}	
	$note_count = $myN->countNotes();
	$paginations = paginateNull($note_count,$page,15);
	if($note_count > 0){
		$notes = $myN->getNotes($paginations['limit'],15);	
	}
	else{
		$notes = array();
	}
	if(isset($_POST['btnUploadNotes'])){
		$name = $_FILES['txtnotes']['name'];
     	$data = $_FILES['txtnotes']['tmp_name'];
     	$size = $_FILES['txtnotes']['size'];
		$filename = pathinfo($name, PATHINFO_FILENAME);
		$ext =  pathinfo($name, PATHINFO_EXTENSION); 
		$des = $_POST['txtdescription'];
		if(empty($name)){
			echo "<script>alert('please choose file');</script>";
		}
		elseif(validateDocument($name) == false){
			echo "<script>alert('image type not allowed');</script>";
		}
		elseif($size > 5242880){
			echo "<script>alert('file too large');</script>";	
		}
		/*upload picture*/
		else{
			$path = "./files/$name";
			$moved = move_uploaded_file($data,$path);
			if($moved){
				$myN->setNotes($name,$des,"default",$u);
				if($myN->dacCrud == true){
					echo "<script>alert('file uploaded to server');</script>";
				} 
			}
		}			
	}
	require_once("./views/header.php");
?>
<style>
	#search-holder input[type="text"]{
		width: 40%;
		float: left;
		margin-right: 10px;
		-webkit-box-shadow: 0 1px 0 rgba(255,255,255,0.1), 0 1px 1px rgba(0,0,0,0.2) inset;
	}
	.notes-holder{
		width: 100%;
		border-bottom: 1px solid #ccc;
		padding: 1%;
	}
	@media only screen and (min-width: 150px) and (max-width: 600px){
		#edit-info-container,.site-navigation{
			display: block;
			width: 100%;
		}
	}
</style>
<div id="container">
	<div class="newline"></div>
	<div id="edit-info-container">
		<div id="search-holder">
			<form method="post" enctype="multipart/form-data" onsubmit="return false">
				<div class="form_elements" >
      				<fieldset>				
    	   				<input type='text' placeholder="Search wildcard"class="form-control" aria-describedby="basic-addon3"/>
    	   				<input type="submit" value="Search Notes" id="btnsignUp" class="btn btn-info"/>
    					<button id="UpLoadPopUp"  data-toggle="modal" data-target="#uploadNotes" class="btn btn-warning">Upload Notes</button>
    				</fieldset>
     			</div>
			</form>
		</div>
		<div id="search-result-box">
			<h3>(<?php echo $note_count; ?>) Uploaded files</h3>
			<div class="liner"></div>
			<table class="table" style="width:65%;">
				<?php foreach($notes as $note): ?>
					<?php $info = $myu->headerInfo($note->userId);?>
					<tr>
						<td><?= $note->description ?></td>
						<td><time class="timeago pull-right mobile-hide" datetime="<?= $note->uploadDate ?>" title="July 17, 2016"></time></td>
						<td><a target="_blank" href="./files/<?= $note->safename ?>" class="btn btn-default">download</a></td>
					</tr>	
				<?php endforeach;?>
			</table>			
		</div>
		<div class="pagination-holder">
			<ul class="pagination-list">
				<?php echo $paginations['display'];?>
			</ul>	
		</div> 
	</div>    
	<div id="personal-info" >
		<form method="post" enctype="multipart/form-data">
      		<div class="form_elements" >
      				<fieldset>
      					<div id="request-feedack"></div>
      					<label>Upload Notes</label></br>
      					<input type='file' name="txtnotes" aria-describedby="basic-addon3" required/></br>
      					<label>Attach description</label></br>
      					<textarea style="height:100px;" name="txtdescription" class="form-control" placeholder="Enter description for the notes" aria-describedby="basic-addon3" id="txtmsg"></textarea> 					
      					</br><input type="submit" value="Upload notes" name='btnUploadNotes' class="btn btn-info"/>
      				</fieldset>
      		</div>		
      	</form>			
	</div>
</div>
<!-- ***************************Send mesage***********************************************-->	
<div id="uploadNotes" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Share Notes</h4>
      </div>
      <div><center><img id="inmate" src="./imgs/pulse.gif"/></center></div>
      <div class="modal-body" id="signup-content">
      	<form id="uploadnotes" method="post" enctype="multipart/form-data">
      		<div class="form_elements" >
      				<fieldset>
      					<div id="request-feedack"></div>
      					<label>Send Attachment</label></br>
      					<input type='file' name="file" id="txtfile" aria-describedby="basic-addon3" required/></br>
      					<textarea style="height:100px;" name="txtdescription"class="form-control" placeholder="Enter description for the notes" aria-describedby="basic-addon3" id="txtmsg"></textarea> 					
      					</br><input type="submit" value="Upload notes" id='btnUploadNotes' class="btn btn-info"/>
      				</fieldset>
      		</div>		
      	</form>	
      	 <progress id="prog" max="100" value='0' style='display:none;'></progress>
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
