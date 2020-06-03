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
 <?php
			if(isset($_POST['update'])){
					$id = $_GET['id'];
					$oldpass = $_POST['oldpass'];
					$newpass = $_POST['newpass'];
					
					$user->setOldpass($oldpass);
					$user->setNewpass($newpass);
					
					
					$user->validateoldpass($id);
					
					$result = $user->changepassword($id);
					
					
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
		<?php
			if(isset($result)){
				echo $result;
			}
		?>
		<div class="well well-lg">
			<div class="col-sm-12">
				<h1 class="text-left col-sm-4 profile">Change Password</h1>
				<a href="<?php echo "index.php"; ?>" class="text-right btn btn-primary col-sm-offset-7 col-sm-1">BACK</a>
			</div>	
				
			
			<form action="" method="post">
				<div class="form-group">
					<label for="oldpassword">Old Password :</label>
					<input type="password" placeholder="Your old password" name="oldpass" class="form-control"/>
				</div>
				<div class="form-group">
					<label for="newpassword">New Password</label>
					<input type="password" placeholder="Your new password" name="newpass" class="form-control"/>
				</div>
				<button class="btn btn-primary" name="update" type="submit">Change password</button>
				
			</form>
			
		</div>
	</div>
 </div>