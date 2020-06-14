<?php 
	session_start();

	$_SESSION = [];
	session_unset();
	session_destroy();

	echo "<script>alert('anda telah keluar!')</script>";
	header('Location: login.php');
	exit;
 ?>