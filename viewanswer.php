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
	$result = $user->rowcount();
	
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
						
							<h2 class="text-center text-success">All Questions and answers of <?php echo $result; ?></b></h2>
							<div class="showexam">
							
								<table>
								<?php
									$question = $user->examshow();
									if($question){
									foreach($question as $key=>$ques){
								?>
									<tr>
										<td>
											<h3><b>Question No <?php echo $ques['quesNO'];?> : </b><?php echo $ques['ques'];?></h3>
										</td>
									</tr>
									<?php 
									$id = $ques['quesNO'];
									$answer = $user->selectanswer($id);
									if($answer){
										foreach($answer as $key=>$val){
									?>
										<tr>
											<td>
												<input type="radio"/>
												<?php
													if($val['rightANS']=='1'){
														echo "<span style='color:blue;'>".$val['ans']."</span>";
													}else{
														echo $val['ans'];
													}
												?>
											</td>
										</tr>
									<?php } }?>
								<?php } }?>
								</table>	
							
								
							</div>
					</div>
			
		</div>
	</div>
	</body>
	
</html>