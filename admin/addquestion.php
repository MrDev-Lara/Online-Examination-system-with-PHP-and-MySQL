<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../classes/admin.php');
	//include_once ($filepath.'/../classes/user.php');
	include_once ($filepath.'/../lib/session.php');
	session::init();
	$admin = new admin();
	session::checkadminlogout();
?>
<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$quesNO = $_POST['quesNO'];
		$ques = $_POST['ques'];
		$answer1 = $_POST['answer1'];
		$answer2 = $_POST['answer2'];
		$answer3 = $_POST['answer3'];
		$answer4 = $_POST['answer4'];
		$rightANS = $_POST['rightANS'];
		
		$admin->setquesNO($quesNO);
		$admin->setques($ques);
		$admin->setanswer1($answer1);
		$admin->setanswer2($answer2);
		$admin->setanswer3($answer3);
		$admin->setanswer4($answer4);
		$admin->setrightANS($rightANS);
		
		$que = $admin->addquestion();
	}
		$result = $admin->countquestion();
		$total = $result+1;
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
			if(isset($que)){
				echo $que;
			}
		?>
			<div class="panel panel-default">
					<div class="panel-heading col-md-12">
						<div class="col-md-4">
							<h2 class="panel-title">Add Question</h2>
						</div>
					</div>
					<div class="panel-body">
						<table class="table table-responsive table-hover ">
							<form action="" method="post">
								<thead>
									<tr>
									<td>Question No :</td>
										<td>
											<div class="form-group">
												<input type="number" placeholder="add the question number" name="quesNO" class="form-control" value="<?php echo $total;?>" required/>
											</div>
										</td>
									</tr>
									<tr>
									<td>Insert Question :</td>
										<td>
											<div class="form-group">
												<input type="text" placeholder="Insert Your Question" name="ques" class="form-control" required/>
											</div>
										</td>
									</tr>
									
									<tr>
										<td><h5 style="margin-top:20px;margin-bottom:20px;" class="text-danger">Choices</h5></td>
										<td><h5 style="margin-top:20px;margin-bottom:20px;" class="text-danger">Enter your choices of answers here</h5></td>
									</tr>
									<tr>
									<td>Choice One :</td>
										<td>
											<div class="form-group">
												<input type="text" placeholder="Insert Your choice one answer" name="answer1" class="form-control" required/>
											</div>
										</td>
									</tr>
									<tr>
									<td>Choice two :</td>
										<td>
											<div class="form-group">
												<input type="text" placeholder="Insert Your choice two answer" name="answer2" class="form-control" required/>
											</div>
										</td>
									</tr>
									<tr>
									<td>Choice three :</td>
										<td>
											<div class="form-group">
												<input type="text" placeholder="Insert Your choice three answer" name="answer3" class="form-control" required/>
											</div>
										</td>
									</tr>
									<tr>
									<td>Choice four :</td>
										<td>
											<div class="form-group">
												<input type="text" placeholder="Insert Your choice four answer" name="answer4" class="form-control" required/>
											</div>
										</td>
									</tr>
									<tr>
									<td>Right Answer NO :</td>
										<td>
											<div class="form-group">
												<input type="number" placeholder="Insert Your right answer number" name="rightANS" class="form-control" required/>
											</div>
										</td>
									</tr>
									<tr>
										<td>
										
										</td>
										<td>
											<div class="form-group">
												<button type="submit" name="submit" class="btn btn-primary btn-md"style="margin-top:20px;">ADD QUESTION</button>
											</div>
										</td>
									</tr>
								</thead>
							</form>
						</table>
					</div>
			</div>
		</div>
	</div>
</body>
</html>