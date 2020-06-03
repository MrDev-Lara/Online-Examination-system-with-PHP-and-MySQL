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
	if(isset($_GET['action']) && $_GET['action'] == 'update'){
		$id = $_GET['id'];
	}
?>
 <?php
			if(isset($_POST['update'])){
					$id = $_GET['id'];
					$name = $_POST['name'];
					$username = $_POST['username'];
					$email = $_POST['email'];
					
					$user->setName($name);
					$user->setUsername($username);
					$user->setEmail($email);
					
					$result = $user->updatedata($id);
					
					
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
				<h1 class="text-left col-sm-3 profile" style="margin-bottom: 30px;margin-top: -5px;margin-left: -20px;">Update Profile</h1>
				<a href="<?php echo "index.php"; ?>" class="text-right btn btn-primary col-sm-offset-8 col-sm-1">BACK</a>
			</div>

			<?php
				$showdata = $user->showdatabyid($id);
				if($showdata){
			?>		
			
			<form action="" method="post">
				<div class="form-group">
					<label for="username">Your Name :</label>
					<input type="text" placeholder="Your Name" name="name" class="form-control" value="<?php echo $showdata->name; ?>"/>
				</div>
				<div class="form-group">
					<label for="password">Username :</label>
					<input type="text" placeholder="Your username" name="username" class="form-control" value="<?php echo $showdata->username; ?> "/>
				</div>
				<div class="form-group">
					<label for="password">E-mail :</label>
					<input type="mail" placeholder="Your email" name="email" class="form-control" value="<?php echo $showdata->email; ?> "/>
				</div>
				<button class="btn btn-primary" name="update" type="submit">UPDATE</button>
				
			</form>
				<?php } ?>
		</div>
	</div>
 </div>
	</body>
	
</html>