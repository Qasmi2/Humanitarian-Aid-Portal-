<?php
session_start();     // session start ...
require_once 'class.user.php';  //  include User Class Assess it's functions 
$user_login = new USER();      // object initilazation 
 
//if($user_login->is_logged_in()!="")            // if user is already login then go to volunteers page 
//{ 
//	
//    $user_login->redirect('volunteer.php');      
//        
//}

if(isset($_POST['volunteer-login-btn']))      // if Click on vounteers button then get Email and password  and login it.
{
	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtupass']);
	
	if($user_login->v_login($email,$upass))     // if email and password are true then redirect volunteer page 
	{
		$user_login->redirect('volunteer.php');     
	}
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login | Humanitarian Aid Portal </title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  <body id="login">
    <div class="container">
		<?php 
		if(isset($_GET['inactive']))
		{
			?>
            <div class='alert alert-error'>
				<button class='close' data-dismiss='alert'>&times;</button>
				<strong>Sorry!</strong> This Account is not Activated Go to your Inbox and Activate it. 
			</div>
            <?php
		}
		?>
        <form class="form-signin" method="post">
        <?php
        if(isset($_GET['error']))
		{
			?>
            <div class='alert alert-success'>
				<button class='close' data-dismiss='alert'>&times;</button>
				<strong>Wrong Details!</strong>
			</div>
            <?php
		}
		?>
        <h2 class="form-signin-heading">Volunteers SignIn</h2><hr />
        <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
        <input type="password" class="input-block-level" placeholder="Password" name="txtupass" required />
     	<hr />
        <button class="btnlog btn-large "  type="submit" name="volunteer-login-btn"> Sign in</button>
        <a href="Vsignup.php" style="float:right;" class="btn btn-large">Sign Up</a><hr />
        <a href="VforgetPass.php">Lost your Password ? </a>
        <a href="index.html">G0 Main Page</a>
      </form>

    </div> <!-- /container -->
    <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
     <script type="text/javascript" src="assets/jquery.backstretch.min.js"></script>
     <script>
        $.backstretch("assets/bg1.png", {speed: 900});
    </script>
  </body>
</html>



