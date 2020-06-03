<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../classes/admin.php');
	include_once ($filepath.'/../lib/session.php');
	session::init();
	$admin = new admin();
	
	$loginmsg = session::get('loginmsg');
	if($loginmsg){
		echo $loginmsg;
	}
	
	session::set('loginmsg',NULL);
	session::checkadminlogout();
?>
<?php
	if(isset($_GET['action']) && $_GET['action']=='logout'){
		session::destroy();
	}
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Admin page</title>
	<link rel="stylesheet" href="inc/bootstrap.min.css" />
	<script type="text/javascript" src="inc/jquery.min.js"></script>
	<script type="text/javascript" src="inc/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/styledash.css" />
</head>

<body>

	<div class="container-fluid">
		<div class="row">
			<nav class="navbar navbar-inverse">
				<div class="navbar-header">
					<button class="btn btn-default navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="navbar-collapse collapse">
					<img src="https://logos.textgiraffe.com/logos/logo-name/Admin-designstyle-colors-m.png" style="width:200px;height:70px;"alt="" />
					<ul class="nav navbar-nav navbar-right">
									<li><a href="index.php">HOME</a></li>
									<li><a href="adminusers.php">MANAGE STUDENT</a></li>
									<li><a href="addquestion.php">ADD QUESTION</a></li>
									<li><a href="questionlist.php">QUESTION LIST</a></li>
									<li><a href="?action=logout">LOG OUT</a></li>
					</ul>
				</div>
			</nav>
			
		</div>
	</div>
	<div class="container">
		<div class="row">
			
					<div class="well">
						
							<h2 class="admin"><b>ADMIN PANEL</b></h2>
								<div class="showmessage">
								<h3><strong>WELCOME</strong> to admin control panel.</h3>
								<h4>Manage students and control exam on online from here.</h4>
							</div>
					</div>
			
		</div>
	</div>
	</body>
	
</html>