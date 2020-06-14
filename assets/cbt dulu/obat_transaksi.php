<?php 
	session_start();

	require '../config/koneksi.php';
	require '../config/function.php';

	if(!isset($_SESSION['submit'])){
		header('Location: login.php');
		exit;
	}

	// SAAT ON CHANGE AUTO NAMPILIN VALUES
	if(isset($_POST['nama_obat'])){
		$kode = $_POST['nama_obat']; // result is kd_obat
		$sql = "SELECT * FROM tb_obat";
		$query = mysqli_query($conn, $sql);
		$res = mysqli_fetch_assoc($query);

		if($kode == $res['nama_obat']){
			$output = $res['nama_obat'];
		}else{
			$output = $kode;
		}

		$_SESSION['nama_obat'] = $kode;	

		// if($_POST['kd_obat'] == null){
		// 	$_SESSION['kd_obat'] = $kode;
		// }

		// var_dump($_SESSION['kd_obat']);
		// die();
	}

	// Transaksi
	if(isset($_POST['beli'])){

		if(transaksiObat($_POST) > 0){
			echo "<script>
						alert('berhasil');document.location.href = '../obat/obat.php';
					</script>";
		}else{
			echo "<script>
						alert('gagal');
					</script>";
		}
	}

	// HITUNG
	if(isset($_POST['hitung'])) {

		if(hitung($_POST) == true){
			hitung();
			$cek = $tampung;
			var_dump($cek);
			die();
		}

	}

	// CEK
	if(isset($_POST['cek'])){

		$cek = $tampung;
		
	}



	$sql = "SELECT * FROM tb_obat";
	$query = mysqli_query($conn, $sql);

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Transaksi Obat</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body style="background-color: #eeeeee; ">
	<nav class="navbar navbar-dark bg-dark" style="color: rgba(232, 236, 241, 1);">
  		<h3>Apotek Caringin</h3>
  		<a href="home_transaksi.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 80px; padding:1px;">Kembali</a>
	</nav>
	<div class="container" style="padding-bottom: 40px; padding-top: 40px; " >
		<div class="container" style="width: 1300px; height: 700px; background-color: salmon; padding: 30px; ">
			<form method="post">
				<h2 align="center">Transaksi Obat!</h2>
				<br><br>
			 	<div class="form-group row">
				    <div class="col-md-3">
					    <label for="nama_obat" style="font-size: 20px;">Nama Barang</label>
					    <select name="nama_obat" class="form-control" onchange="this.form.submit()">
					    	<option selected value="pilih">--Pilih--</option>
					    	<?php foreach($query as $ambil): ?>
					    		<option value="<?= $ambil['nama_obat']; ?>"><?= $ambil['nama_obat']; ?></option>
					    		<?php if( $ambil['nama_obat'] == $output){ ?>
									<option selected value="<?= @$output ?>"><?= @$output ?></option>
					    		<?php } ?>
					    	<?php endforeach; ?>
					    	<option value="">Reset</option>
					    </select>
				    </div>
			  	</div> 
			  	<br>
			 	<div class="form-group row">
			 		<div class="col-md-2">
					    <label for="kd_obat" style="font-size: 20px;">Kode Barang</label>
					    <?php 
					    	if(isset($_SESSION['nama_obat'])){
					    		$sql = mysqli_query($conn, "SELECT * FROM tb_obat WHERE nama_obat = '$_SESSION[nama_obat]' ");
					    		$result = mysqli_fetch_assoc($sql);
						 ?>
					    <input type="text" class="form-control" name="kd_obat" id="kd_obat" readonly value="<?= $result['kd_obat'] ?>">
						<?php } else { ?>
						<input type="text" class="form-control" name="kd_obat" id="kd_obat" readonly value=""> 
						<?php } ?>
					</div>
					<div class="col-md-2">
				    	<label for="ktg_obat" style="font-size: 20px;">Kategori Barang</label>
				    	<input type="text" class="form-control" name="ktg_obat" id="ktg_obat" readonly value="<?= @$result['kategori_obat'] ?>">
			  		</div>
			  		<div class="col-md-2">
					    <label for="harga" style="font-size: 20px;">Harga</label>
					    <input type="text" class="form-control" name="harga" id="harga" readonly value="<?= @$result['harga'] ?>">
			  		</div>
			  	</div>
			  	<div class="form-group row">
			  		<div class="col-md-3">
					    <label for="jumlah" style="font-size: 20px;">Jumlah</label>
					    <input type="text" class="form-control" name="jumlah" id="jumlah" >
				    </div>
				    <div class="col-md-1">
				    	<input class="btn btn-success" type="submit" name="hitung" value="Hitung" style="margin-top: 38px;">
				    </div>
				    <div class="col-md-1">
				    	<input class="btn btn-success" type="submit" name="cek" value="Cek" style="margin-top: 38px;">
				    </div>
			  	</div>
			  	<hr style="width: 520px; float: left;">
			  	<br><br>
			  	<div class="form-group row">
			  		<div class="col-md-3">
				  		<label for="total" style="font-size: 20px;">Total Harga</label>
				  		<input type="text" class="form-control" name="total" id="total" readonly>
			  		</div>
			  		<div class="col-md-3">
					    <label for="bayar" style="font-size: 20px;">Bayar</label>
					    <input type="text" class="form-control" name="bayar" id="bayar" readonly >
				    </div>
			  	</div>
			  	<div class="form-group row">
			  		<div class="col-md-3">
					    <label for="kembalian" style="font-size: 20px;">Kembalian</label>
					    <input type="text" class="form-control" name="kembalian" id="kembalian" readonly >
				    </div>
				    <div class="col-md-3">
				  		<label for="tanggal_transaksi" style="font-size: 20px;">Tanggal Transaksi</label>
				  		<input type="date" class="form-control" name="tanggal_transaksi" id="tanggal_transaksi">
			  		</div>
			  	</div>
			  	<input class="btn btn-success btn-lg" disabled="disabled" type="submit" name="beli" value="Proses" style="float: right; margin-top: 50px;">
			</form>
		</div>
	</div>
</body>
</html>