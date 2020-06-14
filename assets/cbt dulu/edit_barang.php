<?php 
	require '../config/koneksi.php';
	require '../config/function.php';

	$id = $_GET['edit'];

	$barang = tampil("SELECT * FROM tb_barang WHERE kd_barang = '$id' ")[0];

	$pilihKtg = "SELECT kategori FROM tb_kategori WHERE kategori <> '$barang[kategori_barang]' ";
	$pilihKategori = mysqli_query($conn, $pilihKtg);

	$nama = "";
	$namaError = "";
	$ktg = "--Pilih--";
	$harga_beli = "";
	$hargaBeliError = "";
	$harga_jual = "";
	$hargaJualError = "";
	$validasi_nama = true;
	$nama_error_msg = "";
	$validasi_hargabeli = true;
	$hargabeli_error_msg = "";
	$validasi_hargajual = true;
	$hargajual_error_msg = "";
	
	if(isset($_POST['edit'])){

		$nama = trim($_POST['nama_barang']);
		$ktg = $_POST['ktg_barang'];
		$harga_beli = trim($_POST['harga_beli']);
		$harga_jual = trim($_POST['harga_jual']);

		if(empty($nama)){
			$namaError = "Nama tidak boleh kosong";
		}

		if(empty($harga_beli)){
			$hargaBeliError = "Harga beli tidak boleh kosong/";
		}

		if(empty($harga_jual)){
			$hargaJualError = "Harga jual tidak boleh kosong/";
		}


		if(!preg_match("/^[a-zA-Z ]*$/",$nama)){
			$validasi_nama = false;
			$nama_error_msg = "Hanya boleh huruf dan spasi yang diijinkan";
		}

		if(!is_numeric($harga_beli)){
			$validasi_hargabeli = false;
			$hargabeli_error_msg = "Hanya boleh angka saja";
		}

		if(!is_numeric($harga_jual)){
			$validasi_hargajual = false;
			$hargajual_error_msg = "Hanya boleh angka saja";
		}

		// Cek semua input sudah diisi apa belum
		if($validasi_nama and $validasi_hargabeli and $validasi_hargajual and !empty($nama) and !empty($harga_beli) and !empty($harga_jual)){

			if(editBarang($_POST) > 0){
				echo "<script>
						alert('berhasil');document.location.href = 'barang.php';
					</script>";
			}else{
				echo "<script>
					alert('Gagal, Tidak boleh memasukan data yang sama dengan sebelumnya');
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
		<div style="width: 550px; height: 660px; background-color: ghostwhite; padding: 30px; border-radius: 10px; margin-left: 280px; margin-top: 40px; ">
			<form method="post">
				<h2 align="center">Update Data Barang</h2>
				<br>	
			  <div class="form-group">
			    <label for="kd_barang" style="font-size: 20px;">Kode</label>
			    <input type="text" class="form-control" name="kd_barang" readonly value="<?= $barang['kd_barang']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="nama_barang" style="font-size: 20px;">Nama Barang</label>
			    <?php if(isset($_POST['edit'])){ ?>
			    	<input type="text" class="form-control" name="nama_barang" value="<?= @$nama; ?>">
			    	<?= $namaError.$nama_error_msg; ?>
				<?php }else{ ?>
					<input type="text" class="form-control" name="nama_barang" value="<?= $barang['nama_barang']; ?>">
			    	<?= @$nama_error_msg; ?>
				<?php } ?>
			  </div>
			   <div class="form-group">
			    <label for="ktg_barang" style="font-size: 20px;">Kategori</label>
			    <select name="ktg_barang" class="form-control">
			    	<option selected value="<?= $barang['kategori_barang']; ?>"><?= $barang['kategori_barang']; ?></option>
			    	<?php foreach($pilihKategori as $row): ?>
				    	<?php if($barang['kategori_barang'] == $barang['kategori_barang']){ ?>
				    		<option value="<?= $row['kategori']; ?>"><?= $row['kategori']; ?></option>
						<?php } ?>
					<?php endforeach; ?>
			    </select>
			  </div>
			   <div class="form-group">
			    <label for="harga_beli" style="font-size: 20px;">Harga Beli</label>
			    <?php if(isset($_POST['edit'])){ ?>
			    	<input type="text" class="form-control" name="harga_beli" value="<?= @$harga_beli ?>">
			    	<?= $hargaBeliError.$hargabeli_error_msg; ?>
			    <?php }else{ ?>
					<input type="text" class="form-control" name="harga_beli" value="<?= $barang['harga_beli']; ?>">
			    	<?= @$hargabeli_error_msg; ?>
			    <?php } ?>
			  </div>
			   <div class="form-group">
			    <label for="harga_jual" style="font-size: 20px;">Harga Jual</label>
			    <?php if(isset($_POST['edit'])){ ?>
				    <input type="text" class="form-control" name="harga_jual" value="<?= @$harga_jual ?>">
				    <?= $hargaJualError.$hargajual_error_msg; ?>
				<?php }else{ ?>
					<input type="text" class="form-control" name="harga_jual" value="<?= $barang['harga_jual']; ?>">
				    <?= @$hargajual_error_msg; ?>
				 <?php } ?>
				  </div>
			  <input class="btn btn-primary" type="submit" name="edit" value="Edit" style="width: 150px; margin-left: 170px;">
			</form>
		</div>
	</div>
</body>
</html>