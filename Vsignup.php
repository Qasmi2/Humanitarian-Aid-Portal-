<?php
session_start();
require_once 'class.user.php';

$reg_user = new USER();

//if($reg_user->is_logged_in()!="")
//{
//	$reg_user->redirect('volunteer.php');
//}


if(isset($_POST['btn-signup']))
{
	$uname =     trim($_POST['txtuname']);
	$email =     trim($_POST['txtemail']);
	$upass =     trim($_POST['txtpass']);
        $city =      trim($_POST['city']);
        $country =   trim($_POST['country']);
        $phone =     trim($_POST['phonno']);
        $age =       trim($_POST['age']);
        
       // $education =   trim($_POST['education']);
       // $aboutyou =   trim($_POST['aboutyou']);
	$code = md5(uniqid(rand()));
	
	$stmt = $reg_user->runQuery("SELECT * FROM tbl_volunteer WHERE userEmail=:email_id");
	$stmt->execute(array(":email_id"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if($stmt->rowCount() > 0)
	{
		$msg = "
		      <div class='alert alert-error'>
				<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Sorry !</strong>  email allready exists , Please Try another one
			  </div>
			  ";
	}
	else
	{
		if($reg_user->v_register($uname,$email,$upass,$city,$country,$phone,$age,$code))
		{			
			$id = $reg_user->lasdID();		
			$key = base64_encode($id);
			$id = $key;
			
			$message = "					
						Hello $uname,
						<br /><br />
						Welcome to HAP!<br/>
						To complete your registration  please , just click following link<br/>
						<br /><br />
						<a href='http://localhost/ExtendFYP/Vverify.php?id=$id&code=$code'>Click HERE to Activate :)</a>
						<br /><br />
						Thanks,";
						
			$subject = "Confirm Registration";
						
			$reg_user->send_mail($email,$message,$subject);	
			$msg = "
					<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Success!</strong>  We've sent an email to $email.
                    Please click on the confirmation link in the email to create your account. 
			  		</div>
					";
		}
		else
		{
			echo "sorry , Query could no execute...";
		}		
	}
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Sign up | HAP</title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
     <script type="text/javascript" src="assets/jquery.backstretch.min.js"></script>
     <script>
        $.backstretch("assets/bg1.png", {speed: 500});
    </script>
  </head>
  <body id="login">
    <div class="container">
				<?php if(isset($msg)) echo $msg;  ?>
        
      <form class="form-signin" method="post">
          <a href="index.html">Go WEBPAGE </a>
           <br/><hr/>
        <h2 class="form-signin-heading">Volunteer Sign Up</h2><hr />
        <input type="text" class="input-block-level" placeholder="*Username" name="txtuname" required />
        <input type="email" class="input-block-level" placeholder="*Email address" name="txtemail" required />
        <input type="password" class="input-block-level" placeholder="*Password" name="txtpass" required />
        <input type="text" class="input-block-level" placeholder="City Name " name="city"  />
        <input type="text" class="input-block-level" placeholder="Country Name" name="country"  />
        <input type="number" class="input-block-level" placeholder="Phone no. e.g +92xxxxxxxxxx. " name="phonno"  />
        <input type="number" class="input-block-level" placeholder="AGE e.g 22  " name="age"  />
        
        
       
     	<hr />
        <button class="btnreg btn-large "  type="submit" name="btn-signup">Sign Up</button>
        <a href="VsignIn.php" style="float:right;" class="btn btn-large">Sign In</a> 
        <br/><hr/>
        <a href="index.html">Go WEB PAGE </a>
      </form>

        
    
    </div> <!-- /container -->
   
    <script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
   
  </body>
</html>