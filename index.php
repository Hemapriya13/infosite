<?php
session_start();

if(isset($_SESSION['success_msg'])){
	echo "<div class='alert  alert-success alert-dismissible text-center mt-3' role='alert'><button type='button' class='btn-close' data-bs-dismiss='alert'></button>Account Verified : ".$_SESSION['success_msg']."</div>";
	unset($_SESSION['success_msg']);


    		

}

?>
<!DOCTYPE html>
<html lang="en">

	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Registeration-Infosphere</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>
<body>

</body>
</html>