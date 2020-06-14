<?php 
	session_start();

	if(!isset($_SESSION['submit'])){
		header('Location: login.php');
		exit;
	}

	require '../config/koneksi.php';
	require '../config/function.php';
	
	if(isset($_POST['tambah'])){

		if(tambahBarang($_POST) > 0){
				echo "<script>
						alert('berhasil');document.location.href = 'obat.php';
					</script>";
			}else{
				echo "<script>
					alert('gagal');
					</script>";
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
  		<a href="obat.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 80px; padding:2px;">Kembali</a>
	</nav>
	<div class="container" style="padding-bottom: 30px;">
		<div style="width: 550px; height: 660px; background-color: ghostwhite; padding: 30px; border-radius: 10px; margin-left: 280px; margin-top: 40px; ">
			<form method="post">
				<h2 align="center">Tambah Data Obat</h2>
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
			    <input type="text" class="form-control" name="nama_barang">
			  </div>
			   <div class="form-group">
			    <label for="ktg_barang" style="font-size: 20px;">Kategori Barang</label>
			    <select name="ktg_barang" class="form-control">
			    	<option value="">--Pilih--</option>
			    	<option value="obat">Obat</option>
			    	<option value="suplemen">Suplemen</option>
			    	<option value="alat kecantikan">Alat Kecantikan</option>
			    </select>
			  </div>
			  <div class="form-group">
				<label for="pemasok" style="font-size: 20px;">Pemasok</label>
			    <input type="text" class="form-control" name="pemasok" id="pemasok">	  	
			  </div>
			   <div class="form-group">
			    <label for="harga_beli" style="font-size: 20px;">Harga Beli</label>
			    <input type="text" class="form-control" name="harga_beli">
			  </div>

			  <div class="form-group">
			    <label for="harga_jual" style="font-size: 20px;">Harga Jual</label>
			    <input type="text" class="form-control" name="harga_jual" >
			  </div>
			   <div class="form-group">
			    <label for="jumlah" style="font-size: 20px;">Jumlah</label>
			    <input type="text" class="form-control" name="jumlah">
			  </div>
			  <input class="btn btn-primary" type="submit" name="tambah" value="Tambah" style="width: 150px; margin-left: 170px;">
			</form>
		</div>
	</div>
</body>
</html>