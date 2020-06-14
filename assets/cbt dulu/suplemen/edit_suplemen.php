<?php 
	require '../config/koneksi.php';
	require '../config/function.php';

	$id = $_GET['edit'];

	$suplemen = tampil("SELECT * FROM tb_suplemen WHERE kd_suplemen = '$id' ")[0];
	
	if(isset($_POST['edit'])){
		if(editSuplemen($_POST) > 0){
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
				<h2 align="center">Tambah Data Obat</h2>
				<br>	
			  <div class="form-group">
			    <label for="kd_suplemen" style="font-size: 20px;">Kode Obat</label>
			    <input type="text" class="form-control" name="kd_suplemen"  id="kd_suplemen" value="<?= $suplemen['kd_suplemen']; ?>" readonly>
			  </div>
			  <div class="form-group">
			    <label for="nama_suplemen" style="font-size: 20px;">Nama Obat</label>
			    <input type="text" class="form-control" name="nama_suplemen" id="nama_suplemen" value="<?= $suplemen['nama_suplemen']; ?>">
			  </div>
			   <div class="form-group">
			    <label for="ktg_suplemen" style="font-size: 20px;">Kategori Obat</label>
			    <select name="ktg_suplemen" class="form-control">
			    	<option selected value="<?= $suplemen['kategori_suplemen']; ?>"><?= $suplemen['kategori_suplemen']; ?></option>
			    	<?php 
			    		if($suplemen['kategori_suplemen'] == 'kecantikan'){
			    	?>
			    		<option value="vitamin">Pil</option>
			    		<option value="herbal">Sirup</option>
					<?php }elseif($suplemen['kategori_suplemen'] == 'herbal') { ?>
			    		<option value="vitamin">Tablet</option>
			    		<option value="kecantikan">Sirup</option>
			    	<?php }else{ ?>
			    		<option value="herbal">Tablet</option>
			    		<option value="kecantikan">Pil</option>
			    	<?php } ?>
			    </select>
			  </div>
			   <div class="form-group">
			    <label for="harga" style="font-size: 20px;">Harga Obat</label>
			    <input type="text" class="form-control" name="harga" id="harga"  value="<?= $suplemen['harga']; ?>">
			  </div>
			  <input class="btn btn-primary" type="submit" name="edit" value="Edit" style="width: 150px; margin-left: 170px;">
			</form>
		</div>
	</div>
</body>
</html>s