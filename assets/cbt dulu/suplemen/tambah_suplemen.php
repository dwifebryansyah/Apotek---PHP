<?php 
	session_start();

	if(!isset($_SESSION['submit'])){
		header('Location: login.php');
		exit;
	}

	require '../config/koneksi.php';
	require '../config/function.php';
	
	if(isset($_POST['tambah'])){

		if(tambahSuplemen($_POST) > 0){
				echo "<script>
						alert('berhasil');document.location.href = 'suplemen.php';
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
  		<a href="suplemen.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 80px; padding:2px;">Kembali</a>
	</nav>
	<div class="container" style="padding-bottom: 30px;">
		<div style="width: 550px; height: 660px; background-color: ghostwhite; padding: 30px; border-radius: 10px; margin-left: 280px; margin-top: 40px; ">
			<form method="post">
				<h2 align="center">Tambah Data Suplemen</h2>
				<br>	
			  <div class="form-group">
			  	<?php 
			  	// KODE OTOMATIS
				$sql_max = mysqli_query($conn, "SELECT MAX(kd_suplemen) as maximal FROM tb_suplemen "); // ini hasilnya nyari kd_suplemen yang terbesar
				$sql1 = mysqli_query($conn, "SELECT * FROM tb_suplemen"); // ini hasilnya semua data di tb_suplemen
				$r_max = mysqli_fetch_array($sql_max); // ini hasilnya array kd_suplemen terbesar
				$num_max = mysqli_num_rows($sql1); // ini hasilnya semua jumlah baris yang ada di tb_suplemen
				$max_kode = $r_max['maximal']; // ini hasilnya array kd_suplemen terbesar
				$max_angka = substr($max_kode, 2); // ini hasilnya HANYA ANGKA dari $max_kode
				$max_angka++;

				// CARA LAMBAT (PASTI)
				if($num_max > 0){
					if($max_angka >= 1000){
						$angka_akhir = "KS".$max_angka;
					}elseif($max_angka >= 100){
						$angka_akhir = "KS0".$max_angka;
					}elseif($max_angka >= 10){
						$angka_akhir = "KS00".$max_angka;
					}elseif($max_angka >= 1){
						$angka_akhir = "KS000".$max_angka;
					}

				}else{
					$angka_akhir = "KS0001";
				}
			  	 ?>
			    <label for="kd_suplemen" style="font-size: 20px;">Kode Suplemen</label>
			    <input type="text" class="form-control" name="kd_suplemen" readonly value="<?= @$angka_akhir; ?>">
			  </div>
			  <div class="form-group">
			    <label for="nm_suplemen" style="font-size: 20px;">Nama Suplemen</label>
			    <input type="text" class="form-control" name="nm_suplemen" id="nm_suplemen">
			  </div>
			   <div class="form-group">
			    <label for="ktg_suplemen" style="font-size: 20px;">Kategori Suplemen</label>
			    <select name="ktg_suplemen" id="ktg_suplemen" class="form-control">
			    	<option value="">--Pilih--</option>
			    	<option value="kecantikan">Kecantikan</option>
			    	<option value="vitamin">Vitamin</option>
			    	<option value="herbal">Herbal</option>
			    </select>
			  </div>
			  <div class="form-group">
				<label for="pemasok" style="font-size: 20px;">Pemasok</label>
			    <input type="text" class="form-control" name="pemasok" id="pemasok">	  	
			  </div>
			   <div class="form-group">
			    <label for="harga" style="font-size: 20px;">Harga Suplemen</label>
			    <input type="text" class="form-control" name="harga" id="harga">
			  </div>
			   <div class="form-group">
			    <label for="jumlah" style="font-size: 20px;">Jumlah Suplemen</label>
			    <input type="text" class="form-control" name="jumlah" id="jumlah">
			  </div>
			  <input class="btn btn-primary" type="submit" name="tambah" value="Tambah" style="width: 150px; margin-left: 170px;">
			</form>
		</div>
	</div>
</body>
</html>