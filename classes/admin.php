<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../lib/session.php');
	include_once ($filepath.'/../helpers/format.php');
	
	class admin{
		public $db;
		public $format;
		public $adminName;
		public $adminPass;
		public $quesNO;
		public $ques;
		public $answer1;
		public $answer2;
		public $answer3;
		public $answer4;
		public $rightANS;
		
		public function __construct(){
			$this->db = new database();
			$this->format = new format();
		}
		
		public function setName($adminName){
			$this->adminName = $this->format->validation($adminName);
		}
		public function setPass($adminPass){
			$this->adminPass = $this->format->validation($adminPass);
		}
		
		public function setquesNO($quesNO){
			$this->quesNO = $quesNO;
		}
		public function setques($ques){
			$this->ques = $ques;
		}
		
		public function setanswer1($answer1){
			$this->answer1 = $answer1;
		}
		public function setanswer2($answer2){
			$this->answer2 = $answer2;
		}
		public function setanswer3($answer3){
			$this->answer3 = $answer3;
		}
		public function setanswer4($answer4){
			$this->answer4 = $answer4;
		}
		public function setrightANS($rightANS){
			$this->rightANS = $rightANS;
		}
		
		public function loginvalidate(){
			$sql = "select * from tbl_admin where adminUSER = :adminUSER and adminPASS = :adminPASS";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':adminUSER',$this->adminName);
			$adminPass = md5($this->adminPass);
			$stmt->bindParam(':adminPASS',$adminPass);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_OBJ);
			return $result;
		}
		
		public function loginsuccess(){
			if(empty($this->adminName)){
				$errmsg = "<div class='alert alert-danger'>Name cannot be empty</div>";
				return $errmsg;
			}
			if(empty($this->adminPass)){
				$errmsg = "<div class='alert alert-danger'>Password cannot be empty</div>";
				return $errmsg;
			}
			$result = $this->loginvalidate();
			if($result){
				session::init();
				session::set("adminlogin", true);
				session::set("adminID", $result->adminID);
				session::set("adminUSER", $result->adminUSER);
				session::set("loginmsg", "<div class='alert alert-success'><strong>Success!</strong> You are logged in.</div>");
				header("Location: index.php");
			}else{
				$nameerr = "<div class='alert alert-danger'>Username and password is not matched.</div>";
				return $nameerr;
			}
		}
		
		public function showquestion(){
			$sql ="select * from tbl_ques";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll();
			return $result;
		}
		public function deletequestionbyNo($quesNO){
			$tables = array("tbl_ques","tbl_ans");
			foreach($tables as $table){
			$sql ="delete from $table where quesNO= :quesNO";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':quesNO',$quesNO);
			$result = $stmt->execute();
			}
			if($result){
				$errmsg = "<div class='alert alert-danger'>Question deleted successfully</div>";
				return $errmsg;
			}
		}
		
		public function countquestion(){
			$sql ="select * from tbl_ques";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->execute();
			$result = $stmt->rowCount();
			return $result;
		}
		
		public function addquestion(){
			$answer = array();
			$answer[1] = $this->answer1;
			$answer[2] = $this->answer2;
			$answer[3] = $this->answer3;
			$answer[4] = $this->answer4;
			$sql = "insert into tbl_ques(quesNO,ques) values(:quesNO,:ques)";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':quesNO',$this->quesNO);
			$stmt->bindParam(':ques',$this->ques);
			$result = $stmt->execute();
			if($result){
				foreach($answer as $key=>$values){
					if($key == $this->rightANS){
						$sql = "insert into tbl_ans(quesNO,rightANS,ans) values(:quesNO,1,:ans)";
						$stmt = $this->db->PDO->prepare($sql);
						$stmt->bindParam(':quesNO',$this->quesNO);
						$stmt->bindParam(':ans',$values);
					}else{
						$sql = "insert into tbl_ans(quesNO,rightANS,ans) values(:quesNO,0,:ans)";
						$stmt = $this->db->PDO->prepare($sql);
						$stmt->bindParam(':quesNO',$this->quesNO);
						
						$stmt->bindParam(':ans',$values);
					}
					$result = $stmt->execute();
					if($result){
						continue;
					}else{
						echo "error occured";
					}
				}
				$msg = "<div class='alert alert-success'>question added successfully</div>";
				return $msg;
			}
		}
	}
?>