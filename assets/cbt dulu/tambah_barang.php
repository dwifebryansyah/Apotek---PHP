<?php 
	session_start();

	if(!isset($_SESSION['submit'])){
		header('Location: login.php');
		exit;
	}

	require '../config/koneksi.php';
	require '../config/function.php';

	$nama = "";
	$pemasok = "";
	$ktg = "--Pilih--";
	$harga_beli = "";
	$harga_jual = "";
	$jumlah = "";
	$validasi_nama = true;
	$nama_error_msg = "";
	$validasi_pemasok = true;
	$pemasok_error_msg = "";
	$validasi_hargabeli = true;
	$hargabeli_error_msg = "";
	$validasi_hargajual = true;
	$hargajual_error_msg = "";
	$validasi_jumlah = true;
	$jumlah_error_msg = "";
	
	// SELECT tb_kategori
	$queryKategori = mysqli_query($conn, "SELECT kategori FROM tb_kategori");

	if(isset($_POST['tambah'])){

		$nama = $_POST['nama_barang'];
		$pemasok = $_POST['pemasok'];
		$ktg = $_POST['ktg_barang'];
		$harga_beli = $_POST['harga_beli'];
		$harga_jual = $_POST['harga_jual'];
		$jumlah = $_POST['jumlah'];

		// kode validasi nama hanya boleh huruf a-z, A-Z dan spasi
		if(!preg_match("/^[a-zA-Z ]*$/",$nama)){
			$validasi_nama = false;
			$nama_error_msg = "Hanya boleh huruf dan spasi yang diijinkan";
		}

		if(!preg_match("/^[a-zA-Z ]*$/",$pemasok)){
			$validasi_pemasok = false;
			$pemasok_error_msg = "Hanya boleh huruf dan spasi yang diijinkan";
		}

		if(!is_numeric($harga_beli)){
			$validasi_hargabeli = false;
			$hargabeli_error_msg = "Hanya boleh angka saja";
		}

		if(!is_numeric($harga_jual)){
			$validasi_hargajual = false;
			$hargajual_error_msg = "Hanya boleh angka saja";
		}

		if(!is_numeric($jumlah)){
			$validasi_jumlah = false;
			$jumlah_error_msg = "Hanya boleh angka saja";
		}

		// Cek semua input sudah diisi apa belum
		if($validasi_nama and $validasi_pemasok and $validasi_hargabeli and $validasi_hargajual and $validasi_jumlah){

				$table = 'tb_barang';

				if(tambahBarang($_POST,$table) > 0){
					echo "<script>
							alert('berhasil');document.location.href = 'barang.php';
						</script>";
				}else{
					echo "<script>
						alert('nama barang sama!');
						</script>";
			}
		}		
	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Barang</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body style="background-color: #dcdde1; ">
	<nav class="navbar navbar-dark bg-dark" style="color: ghostwhite;">
  		<h3>Apotek Caringin</h3>
  		<a href="barang.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 80px; padding:2px;">Kembali</a>
	</nav>
	<div class="container" style="padding-bottom: 30px;">
		<div style="width: 550px; height: 800px; background-color: ghostwhite; padding: 30px; border-radius: 10px; margin-left: 280px; margin-top: 40px; ">
			<form method="post">
				<h2 align="center">Tambah Barang</h2>
				<br>	
			  <div class="form-group">
			  	<?php 
			  	// KODE OTOMATIS
				$sql_max = mysqli_query($conn, "SELECT MAX(kd_barang) as maximal FROM tb_barang "); // ini hasilnya nyari kd_barang yang terbesar
				$sql1 = mysqli_query($conn, "SELECT * FROM tb_barang"); // ini hasilnya semua data di tb_barang
				$r_max = mysqli_fetch_array($sql_max); // ini hasilnya array kd_barang terbesar
				$num_max = mysqli_num_rows($sql1); // ini hasilnya semua jumlah baris yang ada di tb_barang
				$max_kode = $r_max['maximal']; // ini hasilnya array kd_barang terbesar
				$max_angka = substr($max_kode, 2); // ini hasilnya HANYA ANGKA dari $max_kode
				// var_dump($max_angka);
				// die();
				$max_angka++;

				// CARA LAMBAT (PASTI)
				if($num_max > 0){
					if($max_angka >= 1000){
						$angka_akhir = "B".$max_angka;
					}elseif($max_angka >= 100){
						$angka_akhir = "B0".$max_angka;
					}elseif($max_angka >= 10){
						$angka_akhir = "B00".$max_angka;
					}elseif($max_angka >= 1){
						$angka_akhir = "B000".$max_angka;
					}

				}else{
					$angka_akhir = "B0001";
				}

				
			  	 ?>
			    <label for="kd_barang" style="font-size: 20px;">Kode Barang</label>
			    <input type="text" class="form-control" name="kd_barang" readonly value="<?= @$angka_akhir; ?>">
			  </div>
			  <div class="form-group">
			    <label for="nama_barang" style="font-size: 20px;">Nama Barang</label>
			    <input type="text" class="form-control" name="nama_barang" value="<?= @$nama ?>" required>
			    <?php if(isset($_POST['tambah'])) { ?>
				    <div class="alert alert-info" role ="alert">
				    	<?= @$nama_error_msg; ?>
				    </div>
				<?php } ?>
			  </div>
			   <div class="form-group">
			    <label for="ktg_barang" style="font-size: 20px;">Kategori Barang</label>
			    <select name="ktg_barang" class="form-control" required>
			    	<option value="<?= @$ktg; ?>"><?= @$ktg; ?></option>
			    	<?php foreach($queryKategori as $row): ?>
			    		<option value="<?= $row['kategori'] ?>"><?= $row['kategori'] ?></option>
			    	<?php endforeach; ?>
			    </select>
			  </div>
			  <div class="form-group">
				<label for="pemasok" style="font-size: 20px;">Pemasok</label>
			    <input type="text" class="form-control" name="pemasok" value="<?= @$pemasok; ?>" required>
			    	<?= @$pemasok_error_msg; ?>	 	
			  </div>
			   <div class="form-group">
			    <label for="harga_beli" style="font-size: 20px;">Harga Beli</label>
			    <input type="text" class="form-control" name="harga_beli" value="<?= @$harga_beli; ?>" required>
				<?= @$hargabeli_error_msg; ?>	 
			  </div>

			  <div class="form-group">
			    <label for="harga_jual" style="font-size: 20px;">Harga Jual</label>
			    <input type="text" class="form-control" name="harga_jual" value="<?= @$harga_jual; ?>" required>
			    <?= @$hargajual_error_msg; ?>	 
			  </div>
			   <div class="form-group">
			    <label for="jumlah" style="font-size: 20px;">Jumlah</label>
			    <input type="text" class="form-control" name="jumlah" value="<?= @$jumlah; ?>" required>
			    <?= @$jumlah_error_msg; ?>	 
			  </div>
			  <input class="btn btn-primary" type="submit" value="Tambah" style="width: 150px; margin-left: 170px;">
			</form>
		</div>
	</div>
</body>
</html>