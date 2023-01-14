<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Excepetion;

require 'vendor/autoload.php';
// testing inputs 
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
if(isset($_POST['register'])){
	$firstname = test_input($_POST['user_fname']);
	$lastname = test_input($_POST['user_lname']);
    $username = test_input($_POST['user_name']);
    $email = test_input($_POST['user_email']);
    $mobile = test_input($_POST['user_mobile']);
    $password = test_input($_POST['user_password']);
    $cpassword = test_input($_POST['user_cpassword']);
 	
 	 if($password!=$cpassword){
    	echo '<div class="alert alert-warning alert-dismissible fade show text-center mt-3" role="alert">
Password must be same <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
    else{


    	session_start();

    	if(isset($_SESSION['user_data'])){
    		echo "<div class='alert  alert-primary alert-dismissible fade show  text-center mt-3' role='alert'><button type='button' class='btn-close' data-bs-dismiss='alert'></button>Already Logged In</div>";
    	}

    	require_once('chatuser.php');

    	$user_obj= new Chatuser;

    	$user_obj->setUserName($username);

    	$user_obj->setUserEmail($email);

    	$user_obj->setUserMobile($mobile);

    	$user_obj->setUserPwd(password_hash($password, PASSWORD_DEFAULT));

    	$user_obj->setUserStatus('Disabled');

    	$user_obj->setUserCreatedOn(date('Y-m-d H:i:s'));

    	$user_obj->setVerifyCode(md5(uniqid()));

    	$user_data= $user_obj->get_user_data_by_email();

    	$uniq_user=$user_obj->uniq_user();

    	if($uniq_user){echo "<div class='alert  alert-warning alert-dismissible fade show  text-center mt-3' role='alert'><button type='button' class='btn-close' data-bs-dismiss='alert'></button>User name already taken!</div>";}
    	if(is_array($user_data)&& count($user_data)>0){
    		echo "<div class='alert  alert-warning alert-dismissible fade show  text-center mt-3' role='alert'><button type='button' class='btn-close' data-bs-dismiss='alert'></button>User Email Already Exist!! Try Login</div>";

    	}
    	else{

    		if($user_obj->save_Data()){
    			$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'infosite2127@gmail.com';                     //SMTP username
    $mail->Password   = 'mlrlepinpjqwsinz';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('infosite2127@gmail.com', 'Infosite');
    $mail->addAddress($user_obj->getUserEmail(), 'Joe User');     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('infosite2127@gmail.com', 'Information');

    //Attachments
  //  $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
  //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Verification Email';
    $mail->Body    = '<p>Thank you for registering your account with Infosite.</p><p>Kindly verify your account by clicking the link.</p><p><a href="http://localhost/infosphere/verify.php?code='.$user_obj->getVerifyCode().'">click here to verify</a>Thank You...</p>';

    $mail->AltBody = "Click the link to verify your account... http://localhost/infosphere/verify.php?code=".$user_obj->getVerifyCode();

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
/*
    			$mail = new PHPMailer();                    // create a new object

		   		$mail->isSMTP();                            // Set mailer to use SMTP
		    	$mail->Host      = 'smtp.gmail.com';        // Specify main and backup SMTP servers
		    	$mail->SMTPAuth  = true;                    // Enable SMTP authentication
		    	$mail->CharSet   = "UTF-8";
		    	$mail->SMTPDebug = 2;                       // Enable verbose debug output
		   		$mail->isHTML(true);                        // Set email format to HTML

    			$mail->Username='infosite2127@gmail.com';

    			$mail->Password='hk@2127.';

    			$mail->SMTPSecure   = 'tls';                // Enable TLS encryption, `ssl` also accepted
    			$mail->Port         = 587; 		

    			$mail->setFrom("infosite2127@gmail.com");

    			$mail->addAddress($user_obj->getUserEmail());

    			$mail->isHTML(true);

    			$mail->Subject="Registeration Verification-Verify that its you";

    			$mail->Body='<p>Thank You For registering for Infosite</p><p>This is verification email Click the link to verify your account<a href="http://localhost/infosphere/verify.php?code='.$user_obj->getVerifyCode().'"> click here to verify</a></p><p>Thank You...</p>';

    			
    			if(!$mail->Send()) {
       		 		$error = 'Mail error: '.$mail->ErrorInfo;
        				return false;
    			} else {
        				echo "<script>alert('Message sent!')</script>";
        				return true;
    } */




    			echo "<div class='alert  alert-success alert-dismissible fade show  text-center mt-3' role='alert'><button type='button' class='btn-close' data-bs-dismiss='alert'></button>Registeration Successfull !!! verification email Sent to".$user_obj->getUserEmail()."verify your email before login </div>";
    		}
    		else{
    			echo "<div class='alert  alert-danger alert-dismissible fade show text-center mt-3' role='alert'> <button type='button' class='btn-close' data-bs-dismiss='alert'></button>Something Went Wrong !!!</div>";
    		}
    	}
 


    }

}
   
?>  
<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Registeration-Infosphere</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>
<style type="text/css">
	.container{
		max-width: 700px;
	}
</style>
<body >
<nav class="lh-lg"><br><br></nav>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="container mt-2" name="register_form" id="reg_form">

<div class="row gx-2 ">	
	<br>
	<h2 class="text-center text-white lh-lg bg-secondary">User Registeration</h2>
	<span class="col-6">
	<label for="fname" class="form-label">First Name</label>
	<input type="text" name="user_fname" class="form-control" id="fname" size="25" placeholder="First Name..." ><br>
	</span>
	<span class="col-6">
	<label for="lname" class="form-label">Last Name</label>
	<input type="text" name="user_lname" class="form-control " id="lname" size="25" placeholder="Last Name..."><br>
</span>
<span>
	<label for="uname" class="form-label">User Name</label>
	<input type="text" name="user_name" class="form-control" id="uname" size="25"  pattern="^[\w](?!.*?\@.{2})[\w.]{1,28}[\w]$" title="The length must be between 3 and 30 characters.
The accepted characters are like you said: a-z A-Z 0-9 dot(.), @, underline(_).
It's not allowed to have two or more consecutive dots in a row.
It's not allowed to start or end the username with a dot. " placeholder="User Name..." required><br>
</span>
<span class="col-6">
	<label for="email" class="form-label">Email</label>
	<input type="text" name="user_email" class="form-control" id="email" size="25" pattern="^[\w-\.]+@([\w-]+\.)+[\w-]{2,}$" placeholder="name@example.com" required><br>
</span>
<span class="col-6">
	<label for="mobile" class="form-label">Mobile Number</label>
	<input type="tel" name="user_mobile" class="form-control" id="uname" size="25" placeholder="Enter Mobile Number ..." required><br>
</span>
<span class="col-6 form-group">
	<label for="password" class="form-label">Password</label> 
	<input  data-toggle="password" type="password" name="user_password" class="form-control" id="password" size="25" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$" title="Password must be Minimum eight characters, at least one letter, one number and one special character:" placeholder="Enter Password..." required>
	<br>

</span>
<span class="col-6 form-group"><label for="cpassword" class="form-label">Confirm Password</label>
	<input data-toggle="password" type="password" name="user_cpassword" class="form-control" id="cpassword" size="25" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$" title="Password must be Minimum eight characters, at least one letter, one number and one special character:" placeholder="Repeat Password..." required><br>
</span>
	<div class="col-12 text-center"><button type="submit" class="btn btn-lg btn-secondary" name="register" value="Register">Sign Up</button></div>

</div>

</div>
</form>
</div>
</body>
		
		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js"></script>
</html>