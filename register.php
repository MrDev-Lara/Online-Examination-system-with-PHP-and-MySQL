<?php
	include "classes/user.php";
	include "lib/session.php";
	session::init();
	$user = new user();
	//session::checklogin();
?>
<?php
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$name = $_POST['name'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		$user->setName($name);
		$user->setUsername($username);
		$user->setEmail($email);
		$user->setPassword($password);
		
		$result = $user->registersuccess();
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Student Registration</title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="css/register.css" />
</head>
<body>
	

<div class="container-fluid register">
                <div class="row">
                    <div class="col-md-3 register-left">
                        <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
                        <h3>Welcome</h3>
                        <p>After your registration,you can be able to login!</p>
                        <a href="login.php" class="btn btn-success btn-lmd">Login</a>
                    </div>
                    <div class="col-md-9 register-right">
                       
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <h3 class="register-heading">Student Registration</h3>
								<form action="" method="post">
									<div class="row register-form">
									<?php
										if(isset($result)){
											echo $result;
										}
									?>
										<div class="col-md-12">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Name *" name="name" />
											</div>
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Username *" name="username" />
											</div>
											<div class="form-group">
												<input type="email" class="form-control" placeholder="Your Email *" name="email" />
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password *" name="password" />
											</div>
											
											<input type="submit" class="btnRegister"  value="Register" name="register"/>
										</div>    
									</div>
								</form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	</body>
</html>