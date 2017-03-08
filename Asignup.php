<?php
session_start();
require_once 'class.user.php';

$reg_user = new USER();

//if($reg_user->is_logged_in()!="")
//{
//	$reg_user->redirect('admin.php');
//}


if(isset($_POST['btn-signup']))
{
	$uname =     trim($_POST['txtuname']);
	$email =     trim($_POST['txtemail']);
	$upass =     trim($_POST['txtpass']);
        $city =      trim($_POST['cityi']);
        $country =   trim($_POST['countryi']);
        $phone =     trim($_POST['phonno']);
        
        $organization =    trim($_POST['organization']);
        $website = trim($_POST['website']);
       // $aboutorg =  trim($_POST['aboutorg']);
	$code = md5(uniqid(rand()));
	
	$stmt = $reg_user->runQuery("SELECT * FROM tbl_admin WHERE userEmail=:email_id");
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
		if($reg_user->a_register($uname,$email,$upass,$city,$country,$phone,$organization,$website,$code))
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
						<a href='http://localhost/ExtendFYP/Averify.php?id=$id&code=$code'>Click HERE to Activate :)</a>
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
          <a href="index.html" > Go to site </a> 
          <hr/>
         
        <h2 class="form-signin-heading"> Admin Sign Up</h2><hr />
      
        <input type="text" class="input-block-level" placeholder="*UserName" name="txtuname" required />
         
        <input type="email" class="input-block-level" placeholder="*Email" name="txtemail" required />
        <input type="password" class="input-block-level" placeholder="*Password" name="txtpass" required />
        <input type="text" class="input-block-level" placeholder="*City Name " name="cityi" required="" />
        <input type="text" class="input-block-level" placeholder="*Country Name" name="countryi" required />
        <input type="number" class="input-block-level" placeholder="Phone NO. e.g +92xxxxxxxxxx. " name="phonno"  />
        
        <input type="text" class="input-block-level" placeholder="Foundation Name e.g. Ahdi foundation PAK " name="organization"  />
        <input type="text" class="input-block-level" placeholder="foundation WEBSITE e.g http://www.solutionathome.com " name="website"  />
         
       
     	<hr />
        <button class="btnreg btn-large "  type="submit" name="btn-signup">Sign Up</button>
        <a href="AsignIn.php" style="float:right;" class="btn btn-large">Sign In</a>
        <hr />
        <a href="index.html" > Go to site </a>
      </form>

       
    
    </div> <!-- /container -->
    
    <script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    
      
  </body>
</html>
