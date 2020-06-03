<?php
	include "classes/user.php";
	include "lib/session.php";
	session::init();
	$user = new user();
	session::checklogout();
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
	<title>Student Page</title>
	<link rel="stylesheet" href="inc/bootstrap.min.css" />
	<script type="text/javascript" src="inc/jquery.min.js"></script>
	<script type="text/javascript" src="inc/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/student.css" />
</head>

<body>

	<div class="container-fluid">
		<div class="row">
			<nav class="navbar navbar-default">
				<div class="navbar-header">
					<button class="btn btn-default navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="navbar-collapse collapse">
					<h3 style="color:#626262;">Student Panel</h3>
					<ul class="nav navbar-nav navbar-right">
									<li><a href="index.php">Home</a></li>
									<li><a href="updateprofile.php?action=update&id=<?php echo session::get('userid'); ?>">Update profile</a></li>
									<li><a href="changepassword.php?action=change&id=<?php echo session::get('userid'); ?>">Change Password</a></li>
									<li><a href="exam.php">Give Exam</a></li>
									<li><a href="?action=logout">Log Out</a></li>
					</ul>
				</div>
			</nav>
			
		</div>
	</div>
	<div class="container">
		<div class="row">
			
					<div class="well">
						
							<h2 class="text-center text-info">Exam final page</b></h2>
								<div class="showmessage">
									<h3>Thanks for giving exam!</h3>
									<h3>Your score is: 
										<?php 
											if(isset($_SESSION['score'])){
												echo $_SESSION['score'];
												unset ($_SESSION['score']);
											}
										?>
									</h3>
									<a href="viewanswer.php" class="btn btn-primary">View Answer</a>
								</div>
					</div>
			
		</div>
	</div>
	</body>
	
</html>