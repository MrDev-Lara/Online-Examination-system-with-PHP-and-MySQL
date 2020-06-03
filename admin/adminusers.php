<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../classes/admin.php');
	include_once ($filepath.'/../classes/user.php');
	include_once ($filepath.'/../lib/session.php');
	session::init();
	$admin = new admin();
	$user = new user();
	session::checkadminlogout();
?>
<?php	
	if(isset($_GET['action']) && $_GET['action']=='logout'){
		session::destroy();
	}
	$result = $user->showuserdata();
?>
<?php
	if(isset($_GET['action']) && $_GET['action']=='disable'){
		$id = $_GET['id'];
		$disableuser = $user->disablebyid($id);
	}
	
	if(isset($_GET['action']) && $_GET['action']=='enable'){
		$id = $_GET['id'];
		$enableuser = $user->enablebyid($id);
	}
	
	if(isset($_GET['action']) && $_GET['action']=='remove'){
		$id = $_GET['id'];
		$removeuser = $user->removebyid($id);
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Login-Register system with php by Moni Uddin</title>
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
		<?php
	if(isset($disableuser)){
		echo $disableuser;
	}
	if(isset($enableuser)){
		echo $enableuser;
	}
	if(isset($removeuser)){
		echo $removeuser;
	}
?>
			<div class="panel panel-default">
					<div class="panel-heading col-md-12">
						<div class="col-md-4">
							<h2 class="panel-title">User list</h2>
						</div>
					</div>
					<div class="panel-body">
						<table class="table table-responsive table-hover ">
							<thead>
								<tr>
									<th>Serial</th>
									<th>Name</th>
									<th>Username</th>
									<th>Email Address</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								if(isset($result)){
									$i=0;
									foreach($result as $key=>$values){
										$i++;
							?>
								<tr>
								<?php
									if($values['status'] == '1'){
								?>
									<td style="background-color:red;color:white;"><?php echo $i; ?></td>
									<td style="background-color:red;color:white;"><?php echo $values['name']; ?></td>
									<td style="background-color:red;color:white;"><?php echo $values['username']; ?></td>
									<td style="background-color:red;color:white;"><?php echo $values['email']; ?></td>
									
								<?php }else{ ?>
									<td><?php echo $i; ?></td>
									<td><?php echo $values['name']; ?></td>
									<td><?php echo $values['username']; ?></td>
									<td><?php echo $values['email']; ?></td>
									
								<?php } ?>
								<td>
										<?php
											if($values['status'] == '0'){ ?>
												<a onClick="return confirm('Are you sure you want to disable?')" href="?action=disable&id=<?php echo $values['userid']; ?>">DISABLE</a>
										<?php }else{ ?>
											<a onClick="return confirm('Are you sure you want to enable?')" href="?action=enable&id=<?php echo $values['userid']; ?>">ENABLE</a>
										<?php } ?>
											|| <a onClick="return confirm('Are you sure you want to remove?')" href="?action=remove&id=<?php echo $values['userid']; ?>">REMOVE</a></td>
								</td>
								</tr>
							<?php	}
								}
							?>
							</tbody>
					</div>
			</div>
		</div>
	</div>
</body>
</html>