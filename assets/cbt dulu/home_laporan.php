<?php 
	session_start();

	if(!isset($_SESSION['submit'])){
		header('Location: login.php');
		exit;
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Home Laporan</title>
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
					<a href="laporan_transaksi.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 50px; width: 220px; padding:2px; float: right; margin-top: 120px; margin-right: 60px; font-size: 25px;">Laporan Transaksi</a>
				</div>
				<div class="form-grup">
					<a href="laporan_pasok.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 50px; width: 180px; padding:2px; margin-top: 120px; margin-left: 70px; font-size: 25px;">Laporan Pasok</a>
				</div>
			</form>
		</div>
	</div>
</body>
</html>