<?php 

	session_start();

	if(!isset($_SESSION['submit'])){
		header('Location: login.php');
		exit;
	}

	require 'config/koneksi.php';
	require 'config/function.php';

	$kodeK = kodeOtomatis('kd_kategori','tb_kategori','K');
	$kategori = "";
	$kategoriErr = "";
	$kategoriValidasi = true;
	$kategoriMsg = "";

	if(isset($_POST['tambah'])){

		$kategori = trim($_POST['kategori']);
		$table = 'tb_kategori';

		if(empty($kategori)){
			$kategoriErr = "Kategori tidak boleh kosong";
		}

		if(!preg_match("/^[a-zA-Z ]*$/",$kategori)){
			$kategoriValidasi = false;
			$kategoriMsg = "Hanya boleh huruf dan spasi yang diijinkan";
		}

		if($kategoriValidasi and !empty($kategori)){

			if(tambahKategori($_POST, $table) > 0){
				echo "<script>
						alert('berhasil');document.location.href = 'kategori.php';
					</script>";
			}else{
				echo "<script>
						alert('gagal');
					</script>";
			}
		}
	}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Barang</title>
	<link rel="stylesheet" href="css/bootstrap.css">
</head>
<body style="background-color: #dcdde1; ">
	<nav class="navbar navbar-dark bg-dark" style="color: ghostwhite;">
  		<h3>Apotek Caringin</h3>
  		<a href="kategori.php" class="btn btn-outline-success" style="margin-left: 940px;">Kategori</a>
  		<a href="obat/barang.php" class="btn btn-outline-primary">Kembali</a>
	</nav>
	<div class="container" style="padding-bottom: 30px;">
		<div style="width: 550px; height: 400px; background-color: ghostwhite; padding: 30px; border-radius: 10px; margin-left: 280px; margin-top: 40px; ">
			<form method="post">
				<h2 align="center">Tambah Kategori Barang</h2>
				<br>	
			  <div class="form-group">
			    <label style="font-size: 20px;">Kode Barang</label>
			    <input type="text" class="form-control" name="kd_barang" readonly value="<?= $kodeK ?>">
			  </div>
			  <div class="form-group">
			    <label style="font-size: 20px;">Kategori Barang</label>
			    <input type="text" class="form-control" name="kategori" value="<?= @$kategori; ?>">
			    <?= $kategoriErr.$kategoriMsg ?>
			  </div>
			  <input class="btn btn-primary" type="submit" name="tambah" value="Tambah" style="width: 150px; margin-top: 50px; margin-left: 170px;">
			</form>
		</div>
	</div>
</body>
</html>