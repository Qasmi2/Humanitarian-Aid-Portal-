<?php

require_once 'dbconfig.php';

class USER
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();                   // construct has used for database Connection 
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)                      //  argument take as an argument 
	{
		$stmt = $this->conn->prepare($sql);         // query execution 
		return $stmt;
	}
	
	public function lasdID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}
	// volunteer registration 
        
        public function v_register($uname,$email,$upass,$city,$country,$phone,$age,$code)
	{
		try
		{							
			$password = md5($upass);
			$stmt = $this->conn->prepare("INSERT INTO tbl_volunteer(userName,userEmail,userPass,userCity,userCountry,userPhone,userAge,tokenCode) 
			                    VALUES(:user_name, :user_mail, :user_pass,:city,:country,:phone,:age, :active_code)");
			$stmt->bindparam(":user_name",$uname);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":user_pass",$password);
                        $stmt->bindparam(":city",$city);
                        $stmt->bindparam(":country",$country);
                        $stmt->bindparam(":phone",$phone);
                        $stmt->bindparam(":age",$age);
                       // $stmt->bindbaram(":gender",$gender);
                        //$stmt->bindbaram(":education",$education);
                        //$stmt->bindbaram(":aboutyou",$aboutyou);
			$stmt->bindparam(":active_code",$code);
			$stmt->execute();	
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
        
        //Admin Registration 
	public function a_register($uname,$email,$upass,$city,$country,$phone,$organization,$website,$code)
	{
		try
		{							
			$password = md5($upass); //encrypted 
			$stmt = $this->conn->prepare("INSERT INTO tbl_admin(userName,userEmail,userPass,userCity,userCountry,userPhone,userOrganization,userWebsite,tokenCode) 
			                    VALUES(:user_name, :user_mail, :user_pass,:city,:country,:phone,:organization,:website,:active_code)");
			$stmt->bindparam(":user_name",$uname);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":user_pass",$password);  
                        $stmt->bindparam(":city",$city);
                        $stmt->bindparam(":country",$country);
                        $stmt->bindparam(":phone",$phone);
                        
                        
                        $stmt->bindparam(":organization",$organization);
                        $stmt->bindparam(":website",$website);
                       
			$stmt->bindparam(":active_code",$code);
			$stmt->execute();	
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	
	public function v_login($email,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM tbl_volunteer WHERE userEmail=:email_id");
			$stmt->execute(array(":email_id"=>$email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1)
			{
				if($userRow['userStatus']=="Y")
				{
					if($userRow['userPass']==md5($upass))
					{
						$_SESSION['userSession'] = $userRow['userID'];
						return true;
					}
					else
					{
						header("Location: VsignIn.php?error");
						exit;
					}
				}
				else
				{
					header("Location: VsignIn.php?inactive");
					exit;
				}	
			}
			else
			{
				header("Location: VsignIn.php?error");
				exit;
			}		
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	
        
        
        public function a_login($email,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM tbl_admin WHERE userEmail=:email_id");
			$stmt->execute(array(":email_id"=>$email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1)
			{
				if($userRow['userStatus']=="Y")
				{
					if($userRow['userPass']==md5($upass))
					{
						$_SESSION['userSession'] = $userRow['userID'];
						return true;
					}
					else
					{
						header("Location: AsignIn.php?error");
						exit;
					}
				}
				else
				{
					header("Location: AsignIn.php?inactive");
					exit;
				}	
			}
			else
			{
				header("Location: AsignIn.php?error");
				exit;
			}		
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
        
	
	public function is_logged_in()
	{
		if(isset($_SESSION['userSession']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function logout()
	{
		session_destroy();
		$_SESSION['userSession'] = false;
	}
	
	function send_mail($email,$message,$subject)
	{						
		require_once('mailer/class.phpmailer.php');
          
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;                  
		$mail->SMTPSecure = "tls";            
		$mail->Host       = "smtp.gmail.com";      
		$mail->Port       = 587;             
		$mail->AddAddress($email); 
		$mail->Username="nadeemqasmi40@gmail.com    ";
		$mail->Password="lwqwnxltktcnnqum";          
		$mail->SetFrom('nadeemqasmi40@gmail.com','HAP');
		$mail->AddReplyTo("nadeemqasmi40@gmail.com","HAP");
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
	}	
}