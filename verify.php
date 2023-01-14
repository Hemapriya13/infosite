<?php

session_start();

if(isset($_GET['code'])){
	require_once('chatuser.php');

	$user_obj= new Chatuser;

	 $user_obj->setVerifyCode($_GET['code']);

	 if($user_obj->is_code_verified()){
	 		$user_obj->setUserStatus('Enable');

	 		if($user_obj->enable_account()){
	 			$_SESSION['success_msg']='Hurrah! Your account has been verified successfully...';
	 			header('location:index.php');

	 		}
	 }
	 else{
	 	return false;
	 }
}

?>


<!DOCTYPE html>
<html lang="en">

	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Verification-Infosphere</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>
<body>

</body>
</html>