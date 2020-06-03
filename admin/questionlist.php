<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../classes/admin.php');
	// include_once ($filepath.'/../classes/user.php');
	include_once ($filepath.'/../lib/session.php');
	session::init();
	$admin = new admin();
	session::checkadminlogout();
?>
<?php	
	if(isset($_GET['action']) && $_GET['action']=='logout'){
		session::destroy();
	}
	$showquestion = $admin->showquestion();
?>
<?php
	if(isset($_GET['action']) && $_GET['action']=='delete'){
		$quesNO = $_GET['quesNO'];
		$delquestion = $admin->deletequestionbyNo($quesNO);
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
				if(isset($delquestion)){
					echo $delquestion;
				}
			?>
			<div class="panel panel-default">
					<div class="panel-heading col-md-12">
						<div class="col-md-4">
							<h2 class="panel-title">Question list</h2>
						</div>
					</div>
					<div class="panel-body">
						<table class="table table-responsive table-hover ">
							<thead>
								<tr>
									<th style="width:20%">Serial</th>
									<th style="width:60%">Question</th>
									<th style="width:20%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if(isset($showquestion)){
										$i = 0;
										foreach($showquestion as $key=>$values){
											$i++;
											?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $values['ques']; ?></td>
												<td><a href="?action=delete&quesNO=<?php echo $values['quesNO']; ?>" onclick="return confirm('Are you sure you want to delete?')">DELETE</a></td>
											</tr>
											
								<?php		}
									}
								?>
							</tbody>
					</div>
			</div>
		</div>
	</div>
</body>
</html>