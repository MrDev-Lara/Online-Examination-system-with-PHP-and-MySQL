<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../classes/admin.php');
	include_once ($filepath.'/../lib/session.php');
	session::init();
	$admin = new admin();
	session::checkadminlogin();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	
	<link rel="stylesheet" href="css/styleadmin.css" />
	
</head>


<body>
<div class="body">
	<?php
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$adminName = $_POST['adminName'];
			$adminPass = $_POST['adminPass'];
			
			$admin->setName($adminName);
			$admin->setPass($adminPass);
			
			$result = $admin->loginsuccess();
		}
	?>
	

		<div class="container login-container">
            <div class="row">
                 <div class="col-md-8 login-form-2">
                  <h3>Admin Sign In</h3>
						<?php
							if (isset($result)){
							echo $result;
								}
						?>
					<form action="" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your name *" value="" name="adminName"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Your Password *" value="" name="adminPass"/>
						</div>
                          <button class="btn btn-danger" name="login" type="submit">Login</button> 
                    </form>
                </div>
            </div>
        </div>
	</div>
</body>
</html>