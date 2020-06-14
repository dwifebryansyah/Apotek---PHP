<?php 	
	session_start();

	require '../config/koneksi.php';
	require '../config/function.php';

	if(!isset($_SESSION['submit'])){
		header('Location: login.php');
		exit;
	}

	if(isset($_POST['kd_suplemen'])){
		$kode = $_POST['kd_suplemen']; // result is kd_suplemen
		$sql = "SELECT * FROM tb_suplemen";
		$query = mysqli_query($conn, $sql);
		$res = mysqli_fetch_assoc($query);
		// var_dump($res);
		// die();

		if($kode == $res['kd_suplemen']){
			$output = $res['kd_suplemen'];
		}else{
			$output = $kode;
		}
		$_SESSION['kd_suplemen'] = $kode;
	}

	if(isset($_POST['beli'])){

		if(transaksiSuplemen($_POST) > 0){
			echo "<script>
						alert('berhasil');document.location.href = '../suplemen/suplemen.php';
					</script>";
		}else{
			echo "<script>
						alert('gagal');
					</script>";
		}
	}

	$sql = "SELECT * FROM tb_suplemen";
	$query = mysqli_query($conn, $sql);

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Transaksi Suplemen</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body style="background-color: #eeeeee; ">
	<nav class="navbar navbar-dark bg-dark" style="color: rgba(232, 236, 241, 1);">
  		<h3>Apotek Caringin</h3>
  		<a href="home_transaksi.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 80px; padding:1px;">Kembali</a>
	</nav>
	<div class="container" style="padding-bottom: 30px;">
		<div style="width: 550px; height: 750px; background-color: ghostwhite; padding: 30px; border-radius: 10px; margin-left: 280px; margin-top: 40px; ">
			<form method="post">
				<h2 align="center">Masukan Suplemen!</h2>
				<br>
			 	<div class="form-group">
				    <label for="kd_suplemen" style="font-size: 20px;">Kode Barang</label>
				    <select name="kd_suplemen" class="form-control" onchange="this.form.submit()">
				    	<option value="0">--Pilih--</option>
				    	<?php foreach($query as $ambil): ?>
				    		<option value="<?= $ambil['kd_suplemen']; ?>"><?= $ambil['kd_suplemen']; ?></option>
				    		<?php if( $ambil['kd_suplemen'] == $output){ ?>
								<option selected value="<?= @$output ?>"><?= @$output ?></option>
				    		<?php } ?>
				    	<?php endforeach; ?>
				    </select>
			  	</div> 
			 	<div class="form-group">
				    <label for="nama_suplemen" style="font-size: 20px;">Nama Barang</label>
				    <?php 
				    	if(isset($_SESSION['kd_suplemen'])){
				    		$sql = mysqli_query($conn, "SELECT * FROM tb_suplemen WHERE kd_suplemen = '$_SESSION[kd_suplemen]' ");
				    		$result = mysqli_fetch_assoc($sql);
					 ?>
				    <input type="text" class="form-control" name="nama_suplemen" id="nama_suplemen" readonly value="<?= $result['nama_suplemen'] ?>">
				    <?php } else { ?>
					<input type="text" class="form-control" name="nama_suplemen" id="nama_suplemen" readonly value=""> 
					<?php } ?>
			  	</div>
			  	<div class="form-group">
			    	<label for="ktg_suplemen" style="font-size: 20px;">Kategori Barang</label>
			    	<input type="text" class="form-control" name="ktg_suplemen" id="ktg_suplemen" readonly value="<?= @$result['kategori_suplemen'] ?>">	
			  	</div>
				<div class="form-group">
				    <label for="harga" style="font-size: 20px;">Harga</label>
				     <input type="text" class="form-control" name="harga" id="harga" readonly value="<?= @$result['harga'] ?>">
			  	</div>
			  	<div class="form-group">
			  		<label for="tanggal_transaksi" style="font-size: 20px;">Tanggal Transaksi</label>
			  		<input type="date" class="form-control" name="tanggal_transaksi" id="tanggal_transaksi">
			  	</div>
			  	<div class="form-group">
				    <label for="jumlah" style="font-size: 20px;">Jumlah</label>
				    <input type="text" class="form-control" name="jumlah" id="jumlah" >
			  	</div>
			  	<input class="btn btn-primary" type="submit" name="beli" value="Proses" style="width: 150px; margin-left: 170px;">
			</form>
		</div>
	</div>
</body>
</html>	