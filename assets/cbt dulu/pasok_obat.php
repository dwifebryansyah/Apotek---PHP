<?php 
	require '../config/koneksi.php';
	require '../config/function.php';

	$id = $_GET['pasok'];

	$obat = tampil("SELECT * FROM tb_obat WHERE kd_obat = '$id' ")[0];

	if(isset($_POST['pasok'])){
		if(pasokObat($_POST) > 0 ){
			echo "<script>
						alert('berhasil memasok');document.location.href = 'obat.php';
					</script>";
		}else{
			echo "<script>
						alert('gagal');document.location.href = 'obat.php';
					</script>";
		}
	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Pasok Obat</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body style="background-color: #dcdde1; ">
	<nav class="navbar navbar-dark bg-dark" style="color: ghostwhite;">
  		<h3>Apotek Caringin</h3>
  		<a href="obat.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 80px; padding:2px;">Kembali</a>
	</nav>
	<div class="container" style="padding-bottom: 30px;">
		<div style="width: 550px; height: 660px; background-color: ghostwhite; padding: 30px; border-radius: 10px; margin-left: 280px; margin-top: 40px; ">
			<form method="post">
				<h2 align="center">Pasok Data Obat</h2>
				<br>	
			  <div class="form-group">
			    <label for="kd_obat" style="font-size: 20px;">Kode Obat</label>
			    <input type="text" class="form-control" name="kd_obat"  id="kd_obat" readonly value="<?= $obat['kd_obat']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="nama_obat" style="font-size: 20px;">Nama Obat</label>
			    <input type="text" class="form-control" name="nama_obat" id="nama_obat" readonly value="<?= $obat['nama_obat']; ?>">
			  </div>
			  <div class="form-group">
				<label for="pemasok" style="font-size: 20px;">Pemasok</label>
			    <input type="text" class="form-control" name="pemasok" id="pemasok" readonly value="<?= $obat['pemasok']; ?>">	  	
			  </div>
			  <div class="form-group">
			  		<label for="tanggal_pasok" style="font-size: 20px;">Tanggal Transaksi</label>
			  		<input type="date" class="form-control" name="tanggal_pasok" id="tanggal_pasok">
			  	</div>
			   <div class="form-group">
			    <label for="jumlah" style="font-size: 20px;">Jumlah Obat</label>
			    <input type="text" class="form-control" name="jumlah" id="jumlah" >
			  </div>
			  <input class="btn btn-primary" type="submit" name="pasok" value="Pasok" style="width: 150px; margin-left: 170px;">
			</form>
		</div>
	</div>
</body>
</html>