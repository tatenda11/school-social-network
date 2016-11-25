<?php
	require_once("./libs/autoload.php");
	if(isset($_POST['btnLogin'])){
		$s = cleanSql(strip_tags($_POST['txtid']));
		$p = cleanSql(strip_tags($_POST['txtpass']));
		$myu = new fi_logins();
		$myu->loginUser($s,$p);
		if($myu->dacFound == true){
			header("location:home.php");			
		}
		else{
			echo "<script>alert('invalid credentials');</script>";
		}
	}
?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Solusi-fi Social Network</title>
	<meta charset="utf-8"/>	
	<meta name="viewpoint" content="width=device-width, initial-scale=0.1" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="imgs/logo.png">
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
	<link href="css/main.css" rel="stylesheet" type="text/css"/>
	<script type="text/javascript" src="js/jquery-1.11.0.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
  <script src="/js/html5shiv.js" type="text/javascript"></script>
  <script src="/js/respond.min.js" type="text/javascript"></script>
<![endif]-->
<head>
	<script type="text/javascript">
		function signUp(){
			var btnSign = document.getElementById('btnsignUp');
			var formContent = document.getElementById('signup-content');
			var gif = document.getElementById('inmate');
			var feedback = document.getElementById("request-feedack");
			//**************************collect div elements ********************************
			btnSign.style.display = "none";
			formContent.style.display = "none";
			gif.style.display = "block";
			var fname =  $("#txtfname").val();
			var sname = $("#txtsname").val();
			var studentId = $("#txtsid").val();
			var major = $("#txtmajor").val();
			var gender = $("#txtgender").val();
			var pass = $("#txtpass").val();
			var pass2 = $("#txtpass2").val();
			var hr = new XMLHttpRequest();
			var url = "signup.php";
			var vars = "fn="+fname+"&sn="+sname+"&sId="+studentId+"&gn="+gender+"&pass="+pass+"&mj="+major;
			if(fname.length==0 || sname.length ==0 || studentId.length == 0 || pass.length == 0){
				feedback.innerHTML = "<div class='alert alert-danger' role='alert'>fill in all fiellds</div>";
				formContent.style.display = "block";
				btnSign.style.display = "block";
				gif.style.display = "none";
			}
			else if(pass != pass2){
				feedback.innerHTML = "<div class='alert alert-danger' role='alert'>your password does not match</div>";
				formContent.style.display = "block";
				btnSign.style.display = "block";
				gif.style.display = "none";
			}
			else{
				formContent.style.display = "none";
				hr.open("POST",url ,true);
				hr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
				hr.send(vars);
				hr.onreadystatechange = function(){
					if(hr.readyState == 4 && hr.status == 200){
						var data = hr.responseText;
						if(data == "creation success"){
							gif.style.display = "none";
							formContent.style.display = "block";
							$("#signup-content").html("");
							$("#signup-content").html("<a href='zimra.com' class='btn btn-primary btn-lg'>Click to activate account</a>")
							//formContentinnerHTML = "<a href='zimra.com' class='btn btn-primary btn-lg'>Click to activate account</a>";
						}
						else{
							document.getElementById('btnsignUp').style.display = "block";
							feedback.innerHTML = "<div class='alert alert-danger' role='alert'>"+ data +" <a href='spams.php'> report identity theft</a></div>";
							formContent.style.display = "block";
							btnSign.style.display = "block";
							gif.style.display = "none";
						}
					}
					else{
						formContent.style.display = "none";
					}
					
				}
			}

		}

	</script>
	<header>
		<nav class="navbar navbar-fixed-top navbar-inverse"  id="my-navbar">
			<div class="container">
				<div class="navbar-header">
					<button type="button" id="slide" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div id="logo_text"><a href="" class="navbar-brand " style="font-size:22px;">solusi-fi</a></div>
				</div>
				<div class="collapse navbar-collapse" id="navbar-collapse">
					<form class="navbar-form navbar-right" role="search" method="POST">
        				<div class="form-group">
          					<label style='color:#ccc;'>student id</label>
          					<input type="text" name="txtid" class="form-control" placeholder="Student Id">
          					<label  style='color:#ccc;'>password</label>
          					<input type="password" name="txtpass" class="form-control" placeholder="Password">
        				</div>
        				<button type="submit" name="btnLogin" class="btn btn-info theme">Login</button>
      				</form>
				</div>	
			</div>	
		</nav>	
	</header>
	<section>
		<div class="jumbotron" >
			<center>
				<div class='shade'>
					<div id="head-content-wrap">
						<br><br><br><h2>Solusi's University Social Network</h2>
						<p>
							Solusi University's first active social network making the campus smaller and connecting students 
							Register for Free
						</p>
						<div class="btn-group" role="group" aria-label="...">
  							<button type="button"  data-toggle="modal" data-target="#signUp" class="btn btn-info btn-lg">Create Account</button>
  							<button type="button" data-toggle="modal" data-target="#login" class="btn btn-warning btn-lg spacer">Member Login</button>
						</div>
					</div>
				<div>	
			</center>	
		</div>
	</section>
	<section>
		<div id="info-strip">
			<div class="row">
				<div class="col-sm-3">
					<div class="info-holder">
						<center>
							<h4>Socialise</h4>
							<img src="imgs/one.png"class="info-img"/>
							<p>
								Socialise through forums private messaging interactive newsfeed
							</p>
						</center>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="info-holder">
						<center>
							<h4>Discuss</h4>
							<img src="imgs/two.png"class="info-img"/>
							<p>
								Start online discussions with fellow students.Interactive commenting system
							</p>
						</center>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="info-holder">
						<center>
							<h4>Chat</h4>
							<img src="imgs/three.png"class="info-img"/>
							<p>
								Send private messages to any member with the inbuilt private messeging system
							</p>
						</center>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="info-holder">
						<center>
							<h4>Meet</h4>
							<img src="imgs/four.png"class="info-img"/>
							<p>
								Meet new people who you would probably would never met  
							</p>
						</center>
					</div>
				</div>
			</div>	
		</div>
	</section>
 <!-- ***************************login start***********************************************-->
  <div id="login" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Login Solusi-fi</h4>
      </div>
      <div class="modal-body">
      	<form class="navbar-form navbar-right" role="search" method="POST">
        				<div class="form-group">
          					<input type="text" name="txtid" class="form-control" placeholder="Student Id">
          					<input type="password" name="txtpass" class="form-control" placeholder="Password">
        				</div>
        				<button type="submit" name="btnLogin" class="btn btn-info theme">Login</button>
      				</form>	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ***************************login End ***********************************************-->

<!-- ***************************SignUp start***********************************************-->	
<div id="signUp" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Join Solusi-fi</h4>
      </div>
      <div><center><img id="inmate" src="./imgs/pulse.gif"/></center></div>
      <div class="modal-body" id="signup-content">
      	<form method="post" enctype="multipart/form-data" onsubmit="return false">
      		<div class="form_elements" >
      				<fieldset>
      					<div id="request-feedack"></div>
      					<lebel>First Name</label></br>
      					<input type="text" id="txtfname" class="form-control" placeholder="Your First Name" aria-describedby="basic-addon3"/>
   						</br><lebel>Surname</label></br>
      					<input type="text" id="txtsname" class="form-control" placeholder="Your Surname" aria-describedby="basic-addon3"/>
      					<div id="checkstudent"></div>
      					</br><lebel>Student Id</label></br>
      					<input type="text" id="txtsid" class="form-control" placeholder="Your Student Id number" aria-describedby="basic-addon3"/>
      					</br><lebel>What are you studying</label></br>	
      					<input type='hidden' id="txtmajor" class="form-control" value='0' aria-describedby="basic-addon3"/>
      					</br><lebel>Your Gender</label></br>	
      					<select id="txtgender" class="form-control" aria-describedby="basic-addon3">
      						<option value="M" class="form-control" aria-describedby="basic-addon3">MALE</option>
      						<option value="F" class="form-control" aria-describedby="basic-addon3">FEMALE</option>
      					</select>
      					</br><lebel>Your Password</label></br>
      					<input type="text" id="txtpass" class="form-control" placeholder="Create Password" aria-describedby="basic-addon3"/>
      					</br><lebel>Confirm Password</label></br>
      					<input type="text" id="txtpass2" class="form-control" placeholder="Create Password" aria-describedby="basic-addon3"/>		   					
      					</br><input type="submit" onClick="signUp();"value="Create Account" id="btnsignUp" class="btn btn-info"/>
      				</fieldset>
      		</div>		
      	</form>	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- ***************************SingUp End ***********************************************-->

	<footer>
		<div id="foot-container">
			<ul>
				<li>&copy; 2016  tate-studio productions</li>
			</ul>
		</div>
	</footer>	
</body>
</html>