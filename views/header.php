<?php 
	$myMsg = new fi_messages();
	$unread = $myMsg->countUnread($u);
	$myFrnd = new  fi_friends();
	$friendsRequests = $myFrnd->countFriendRequsts($u);
	$html = "
			<div id='container'></br>
			<h1>Please activate your account</h1>
			<p style='width:60%;'>
				You have not activated your account you can do this by clicking the link activation link
				send to your email $myu->studentId@solusi.ac.zw
				.If you did not receive the email click the resend button </br></br><a href='home.php?resend=true' class='btn btn-default'>Resend email</a>
			</p>
			</div>
	";
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
		<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"/>
		<link href="jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
		<link href="css/main.css" rel="stylesheet" type="text/css"/>
		<link href="css/magicbox.css" rel="stylesheet" type="text/css"/>
		<link href="css/theme.css" rel="stylesheet" type="text/css"/>
		<link href="css/subtheme-about.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="js/jquery-1.11.0.js"></script>
		<script type="text/javascript" src="jquery-ui/jquery-ui.min.js"></script>
		<script src="js/jquery.timeago.js" type="text/javascript"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/jquery.form.js"></script>
		<script type="text/javascript" src="js/magicbox.js"></script>
		<!--[if lt IE 9]>
  		<script src="/js/html5shiv.js" type="text/javascript"></script>
 	 	<script src="/js/respond.min.js" type="text/javascript"></script>
		<![endif]-->
	<head>
	<body>
		<header>
			<nav class="navbar navbar-fixed-top navbar-inverse"  id="my-navbar">
			<div class="container">
				<div class="navbar-header" id="navbar-slide">
					<button type="button" id="slide-navigation" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div id="logo_text"><a href="home.php" class="navbar-brand " style="font-size:22px;">solusi-fi</a></div>
				</div>
				<div class="collapse navbar-collapse space-left" id="navbar-collapse">
					<form class="navbar-form navbar-left" role="search"  method="POST" action="members.php">
        				<div class="form-group">
          					<input type="text" name="name"  size="30" onkeyup="memberLiveSearch(this.value)" class="form-control" placeholder="Search"/>
          					<input type='hidden' name='level' value='0'/>
          					<input type='hidden' name='major' value='0'/>
          					<input type='hidden' name='hostel' value='0'/>
        				</div>
        				<button type="submit" name="btnSearch" class="btn btn-info theme">Search</button>
      				</form>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="profiles.php?profile=<?= $myu->studentId ?>"><i class="fa fa-user fa-fw"></i><small></small>&nbsp;<?php echo $myu->fname;?></a></li>
						<li><a href="inbox.php"><i class="fa fa-envelope-o fa-fw"></i> Inbox <?php if($unread > 0): ?><span class="badge"><?= $unread ?></span><?php endif; ?></a></li>
						<li><a class="magic-box" href="#" rel="notifications"><i class="fa fa-info-circle fa-fw"></i> Notifications </a></li>
						<li><a class="magic-box" href="#" rel="friendsRequest"><i class="fa fa-users fa-fw"></i> friend request <?php if($friendsRequests > 0): ?><span class="badge"><?= $friendsRequests?></span><?php endif; ?></a></li>
					</ul>	
				</div>		
			</div>	
		</nav>	
		</header>
		<div id="friend-box" class='panel panel-default'>1
			<center><img src='./imgs/Loadericon.gif'/><center>
		</div>
		<div id='ajax-loading'>
			<div>
				<center>
					<img src='./imgs/pulse.gif'  style='margin-top:270px;'/>
				</center>	
			</div>
		</div>
		<div id="ajax-search-results" class='panel panel-default'>
			<div class='panel-heading' style='margin:auto;'>Search Results</div>
			<div id="content-holder" style='background-color:#fff;'>
			</div>
			<div class='panel-heading' style='margin:auto;'><a href="members.php">advanced search</a></div>
		</div>
		<?php if($myu->status != 'A' && !isset($_GET['profile']) ){die($html);}?>

