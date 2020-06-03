<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	
	include_once ($filepath.'/../helpers/format.php');
	
	class user{
		public $db;
		public $name;
		public $username;
		public $email;
		public $password;
		public $oldpass;
		public $newpass;
		public $getans;
		public $quesid;
		
		public function __construct(){
			$this->db = new database();
			$this->format = new format();
		}
		public function setans($getanswer){
			$this->getans = $this->format->validation($getanswer);
		}
		public function setquesid($getquesid){
			$this->quesid = $this->format->validation($getquesid);
		}
		
		public function setOldpass($oldpass){
			$this->oldpass = $this->format->validation($oldpass);
		}
		public function setNewpass($newpass){
			$this->newpass = $this->format->validation($newpass);
		}
		public function setName($name){
			$this->name = $this->format->validation($name);
		}
		public function setUsername($username){
			$this->username = $this->format->validation($username);
		}
		public function setEmail($email){
			$this->email = $this->format->validation($email);
		}
		public function setPassword($password){
			$this->password = $this->format->validation($password);
		}
		
		public function processexam(){
			if(!isset($_SESSION['score'])){
				$_SESSION['score'] = '0';
			}
			$question = $this->quesid;
			$next = $question+1;
			$total_ques = $this->rowcount();
			$useranswer = $this->getans;
			$rightanswer = $this->selectrightans();
			if($rightanswer == $useranswer){
				$_SESSION['score']++;
			} 
			if($question == $total_ques){
				header("location: final.php");
				exit();
			}else{
				header("location: test.php?ques=".$next);
			}
		}
		
		public function selectrightans(){
			$sql ="select * from tbl_ans where quesNO= :quesNO and rightANS= '1'";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':quesNO',$this->quesid);
			$stmt->execute();
			$ans = $stmt->fetchAll();
			$result = $ans['id'];
			return $result;
		}
		
		public function emailalreadytaken(){
			$sql ="select email from tbl_user where email= :email";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':email',$this->email);
			$stmt->execute();
			if($stmt->rowCount() >0){
				return true;
			}else{
				return false;
			}
		}
		
		private function insertdata(){
			$sql = "insert into tbl_user(name,username,email,password) values(:name, :username, :email, :password)";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':name',$this->name);
			$stmt->bindParam(':username',$this->username);
			$stmt->bindParam(':email',$this->email);
			$password = md5($this->password);
			$stmt->bindParam(':password',$password);
			$result = $stmt->execute();
			if($result){
				$nameerr = "<div class='alert alert-success'><strong>Thank You!</strong> You have been registered</div>";
				return $nameerr;
			}else{
				$nameerr = "<div class='alert alert-danger'>Sorry,you have not been registered.Please try again!</div>";
				return $nameerr;
			}
		}
		
		public function registersuccess(){
			if(empty($this->name)){
				$nameerr = "<span class='alert alert-danger'>Name is Required</span>";
				return $nameerr;
			}
			
			if (!preg_match("/^[a-zA-Z ]*$/",$this->name)) {
				$nameerr = "<span class='alert alert-danger'>Only letters and white space allowed</span>";
				return $nameerr;
			}
			
			if(empty($this->username)){
				$nameerr = "<span class='alert alert-danger'>Username is Required</span>";
				return $nameerr;
			}
			
			if (!preg_match("/^[a-zA-Z ]*$/",$this->username)) {
				$nameerr = "<span class='alert alert-danger'>Only letters and white space allowed</span>";
				return $nameerr;
			}
			
			if(empty($this->email)){
				$nameerr = "<span class='alert alert-danger'>Email is Required</span>";
				return $nameerr;
			}
			if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
				$nameerr = "<span class='alert alert-danger'>Invalid email format</span>";
				return $nameerr;
			}
		
			$emailtaken = $this->emailalreadytaken();
			if($emailtaken == true){
				$nameerr = "<span class='alert alert-danger'>Email already exist</span>";
				return $nameerr;
			}
		
			if(empty($this->password)){
				$nameerr = "<span class='alert alert-danger'>Password is Required</span>";
				return $nameerr;
			}
			if(strlen($this->password)<6){
				$nameerr = "<span class='alert alert-danger'>Password should me more than 6 word</span>";
				return $nameerr;
			}
			
			$result = $this->insertdata();
			return $result;
		}
		
		public function loginvalidate(){
			$sql = "select * from tbl_user where username = :username and password = :password";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':username',$this->username);
			$password = md5($this->password);
			$stmt->bindParam(':password',$password);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_OBJ);
			return $result;
		}
		
		public function loginsuccess(){
			if(empty($this->username)){
				$nameerr = "<span class='alert alert-danger'>Username cannot be empty</span>";
				return $nameerr;
			}
			if(empty($this->password)){
				$nameerr = "<span class='alert alert-danger'>Password cannot be empty</span>";
				return $nameerr;
			}
			$result = $this->loginvalidate();
			if($result){
				if($result->status == '1'){
					$msg = "<span class='alert alert-danger'>Your ID has been disabled.</span>";
					return $msg;
				}else{
				session::init();
				session::set("login", true);
				session::set("userid", $result->userid);
				session::set("name", $result->name);
				session::set("username", $result->username);
				session::set("email", $result->email);
				session::set("loginmsg", "<div class='alert alert-success'><strong>Success!</strong> You are logged in.</div>");
				header("Location: index.php");
				}
			}else{
				$nameerr = "<div class='alert alert-danger'>Username and password is not matched.</div>";
				return $nameerr;
			}
		}
		public function showdatabyid($id){
			$sql ="select * from tbl_user where userid= :userid";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':userid',$id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_OBJ);
			return $result;
		}
		
		public function showuserdata(){
			$sql ="select * from tbl_user";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll();
			return $result;
		}
		public function disablebyid($id){
			$sql ="update tbl_user set status='1' where userid= :userid";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':userid',$id);
			$result = $stmt->execute();
			if($result){
				$errmsg = "<div class='alert alert-danger'>Student successfully disabled</div>";
				return $errmsg;
			}
		}
		public function enablebyid($id){
			$sql ="update tbl_user set status='0' where userid= :userid";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':userid',$id);
			$result = $stmt->execute();
			if($result){
				$errmsg = "<div class='alert alert-success'>Student successfully enabled</div>";
				return $errmsg;
			}
		}
		public function removebyid($id){
			$sql ="delete from tbl_user where userid= :userid";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':userid',$id);
			$result = $stmt->execute();
			if($result){
				$errmsg = "<div class='alert alert-danger'>Student deleted successfully</div>";
				return $errmsg;
			}
		}
			public function updatedata($id){
			if(empty($this->name)){
				$nameerr = "<div class='alert alert-danger'>Name is Required</div>";
				return $nameerr;
			}
			
			if (!preg_match("/^[a-zA-Z ]*$/",$this->name)) {
				$nameerr = "<div class='alert alert-danger'>Only letters and white space allowed</div>";
				return $nameerr;
			}
			
			if(empty($this->username)){
				$nameerr = "<div class='alert alert-danger'>Username is Required</div>";
				return $nameerr;
			}
			
			if (!preg_match("/^[a-zA-Z ]*$/",$this->username)) {
				$nameerr = "<div class='alert alert-danger'>Only letters and white space allowed</div>";
				return $nameerr;
			}
			
			if(empty($this->email)){
				$nameerr = "<div class='alert alert-danger'>Email is Required</div>";
				return $nameerr;
			}
			if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
				$nameerr = "<div class='alert alert-danger'>Invalid email format</div>";
				return $nameerr;
			}
	
			$sql = "update tbl_user set name= :name, username= :username, email= :email where userid= :userid";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':userid',$id);
			$stmt->bindParam(':name',$this->name);
			$stmt->bindParam(':username',$this->username);
			$stmt->bindParam(':email',$this->email);
			$result = $stmt->execute();
			if($result){
				$nameerr = "<div class='alert alert-success'><strong>DATA UPDATED SUCCESSFULLY</div>";
				return $nameerr;
			}else{
				$nameerr = "<div class='alert alert-danger'>Sorry, data not updated.</div>";
				return $nameerr;
			}
		}
		public function validateoldpass($id){
			$sql ="select password from tbl_user where password= :password and userid= :userid";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':userid',$id);
			$oldpass = md5($this->oldpass);
			$stmt->bindParam(':password',$oldpass);
			$stmt->execute();
			if($stmt->rowCount() >0){
				return true;
			}else{
				return false;
			}
		}
		
		public function changepassword($id){
			if(empty($this->oldpass)){
				$nameerr = "<div class='alert alert-danger'>Your old password cannot be empty!</div>";
				return $nameerr;
			}
			if(empty($this->newpass)){
				$nameerr = "<div class='alert alert-danger'>Your new password cannot be empty!</div>";
				return $nameerr;
			}
			$pass = $this->validateoldpass($id);
			if($pass == false){
				$nameerr = "<div class='alert alert-danger'>Old password do not exist</div>";
				return $nameerr;
			}
			if(strlen($this->newpass)<6){
				$nameerr = "<div class='alert alert-danger'>Your new password should be more than six character!</div>";
				return $nameerr;
			}
			$sql = "update tbl_user set password= :password where userid= :userid";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':userid',$id);
			$newpass = md5($this->newpass);
			$stmt->bindParam(':password',$newpass);
			$result = $stmt->execute();
			if($result){
				$nameerr = "<div class='alert alert-success'><strong>PASSWORD UPDATED SUCCESSFULLY</div>";
				return $nameerr;
				header('location: index.php');
			}else{
				$nameerr = "<div class='alert alert-danger'>Sorry, PASSWORD not updated.</div>";
				return $nameerr;
			}
		}
		
		public function rowcount(){
			$sql ="select * from tbl_ques";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->execute();
			$result = $stmt->rowCount();
			return $result;
		}
		public function exam(){
			$sql ="select * from tbl_ques";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_OBJ);
			return $result;
		}
		public function examshow(){
			$sql ="select * from tbl_ques";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll();
			return $result;
		}
		public function selectquestion($id){
			$sql ="select * from tbl_ques where quesNO = :quesNO";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':quesNO',$id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_OBJ);
			return $result;
		}
		public function selectanswer($id){
			$sql ="select * from tbl_ans where quesNO = :quesNO";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':quesNO',$id);
			$stmt->execute();
			$result = $stmt->fetchAll();
			return $result;
		}
	}
?>