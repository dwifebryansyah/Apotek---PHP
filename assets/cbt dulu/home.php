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
	<title>Home</title>
	<link rel="stylesheet" href="css/bootstrap.css">
</head>
<body style="background-color: #54a0ff; ">
	<nav class="navbar navbar-dark bg-dark" style="color: rgba(232, 236, 241, 1);">
  		<h3>Apotek Caringin</h3>
  		<a href="logout.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 80px; padding:1px;" onclick="return confirm('anda yakin ingin logout');">Logout</a>
	</nav>
	<div class="container">
		<div class="card" style="width: 16rem; margin-top: 70px; background-color: #f1f2f6; float: left; ">
		  <img class="card-img-top" src="img/obat2.png" alt="Card image cap" style="width: 133px; margin-left: 22%; margin-top: 6%;">
		  <div class="card-body">
		    <h5 class="card-title">Barang</h5>
		    <p class="card-text">
		    	Some quick example text to build on the card title and make up the bulk of the card's content.
		    </p>
		    <a href="obat/barang.php" class="btn btn-primary" style="margin-top: 10px;">Klik Disini</a>
		  </div>
		</div>

		<div class="card" style="width: 16rem; margin-top: 70px; background-color: #f1f2f6; float: left; margin-left: 25px; ">
		  <img class="card-img-top" src="img/beli.png" alt="Card image cap" style="width: 147px; margin-left: 22%; margin-top: 5%;">
		  <div class="card-body">
		    <h5 class="card-title">Transaksi</h5>
		    <p class="card-text">
		    	Some quick example text to build on the card title and make up the bulk of the card's content.
		    </p>
		    <a href="transaksi/transaksi_barang.php" class="btn btn-primary">Klik Disini</a>
		  </div>
		</div>

		<div class="card" style="width: 16rem; margin-top: 70px;  background-color: #f1f2f6; float: left; margin-left: 25px;">
		  <img class="card-img-top" src="img/laporan.png" alt="Card image cap" style="width: 147px; margin-left: 22%; margin-top: 5%;">
		  <div class="card-body">
		    <h5 class="card-title">laporan</h5>
		    <p class="card-text">
		    	Some quick example text to build on the card title and make up the bulk of the card's content.
		    </p>
		    <a href="laporan/home_laporan.php" class="btn btn-primary">Klik Disini</a>
		  </div>
		</div>

	</div>
</body>
</html>