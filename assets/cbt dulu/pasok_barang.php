<?php 
	require '../config/koneksi.php';
	require '../config/function.php';

	$id = $_GET['pasok'];

	$obat = tampil("SELECT * FROM tb_barang WHERE kd_barang = '$id' ")[0];

	$jumlah = "";
	$jumlahError = "";
	$validasi_jumlah = true;
	$jumlah_error_msg = "";

	if(isset($_POST['pasok'])){

		$jumlah = trim($_POST['jumlah']);

		if(empty($jumlah)){
			$jumlahError = "Jumlah tidak boleh kosong/";
		}

		if(!is_numeric($jumlah)){
			$validasi_jumlah = false;
			$jumlah_error_msg = "Hanya boleh angka saja";
		}

		// Cek semua input sudah diisi apa belum
		if($validasi_jumlah and !empty($jumlah)){

			if(pasokBarang($_POST) > 0 ){
				echo "<script>
							alert('berhasil memasok');document.location.href = 'barang.php';
						</script>";
			}else{
				echo "<script>
							alert('gagal');document.location.href = 'barang.php';
						</script>";
			}
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
  		<a href="barang.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 80px; padding:2px;">Kembali</a>
	</nav>
	<div class="container" style="padding-bottom: 30px;">
		<div style="width: 550px; height: 660px; background-color: ghostwhite; padding: 30px; border-radius: 10px; margin-left: 280px; margin-top: 40px; ">
			<form method="post">
				<h2 align="center">Memasok Data Barang</h2>
				<br>	
			  <div class="form-group">
			    <label for="kd_barang" style="font-size: 20px;">Kode</label>
			    <input type="text" class="form-control" name="kd_barang"  readonly value="<?= $obat['kd_barang']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="nama_barang" style="font-size: 20px;">Nama</label>
			    <input type="text" class="form-control" name="nama_barang" readonly value="<?= $obat['nama_barang']; ?>">
			  </div>
			  <div class="form-group">
				<label for="pemasok" style="font-size: 20px;">Pemasok</label>
			    <input type="text" class="form-control" name="pemasok" readonly value="<?= $obat['pemasok']; ?>">	  	
			  </div>
			  <div class="form-group">
			  		<label for="tanggal_pasok" style="font-size: 20px;">Tanggal Pasok</label>
			  		<?php $tanggal = date('d/m/Y'); ?>
			  		<input type="text" class="form-control" name="tanggal_pasok" value="<?= $tanggal ?>" readonly >
			  	</div>
			   <div class="form-group">
			    <label for="jumlah" style="font-size: 20px;">Jumlah </label>
			    <input type="text" class="form-control" name="jumlah" value="<?= @$jumlah; ?>" require>
			    <?= $jumlahError.$jumlah_error_msg; ?>
			  </div>
			  <input class="btn btn-primary" type="submit" name="pasok" value="Pasok" style="width: 150px; margin-left: 170px;">
			</form>
		</div>
	</div>
</body>
</html>