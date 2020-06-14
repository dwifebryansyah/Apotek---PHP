<?php 
	session_start();

	 if(!isset($_SESSION['submit'])){
    header('Location: ../logins.php');
    exit;
  }
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body style="background-color: #dcdde1; ">
	<nav class="navbar navbar-dark bg-dark" style="color: ghostwhite;">
  		<h3>Apotek Caringin</h3>
  		<a href="../home.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 80px; padding:2px;">Kembali</a>
	</nav>
	<div class="container" style="padding: 20px;">
		<div style="width: 650px; height: 350px; background-color: ghostwhite; padding: 30px; border-radius: 10px; margin-left: 220px; margin-top: 80px;">
			<form method="post">
				<div class="form-grup">
					<a href="obat_transaksi.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 50px; width: 130px; padding:2px; float: right; margin-top: 120px; margin-right: 130px; font-size: 25px;">Obat</a>
				</div>
				<div class="form-grup">
					<a href="suplemen_transaksi.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 50px; width: 130px; padding:2px; margin-top: 120px; margin-left: 130px; font-size: 25px;">Suplemen</a>
				</div>
			</form>
		</div>
	</div>
</body>
</html>