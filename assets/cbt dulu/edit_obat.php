<?php 
	require '../config/koneksi.php';
	require '../config/function.php';

	$id = $_GET['edit'];

	$obat = tampil("SELECT * FROM tb_obat WHERE kd_obat = '$id' ")[0];
	
	if(isset($_POST['edit'])){
		if(editObat($_POST) > 0){
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
				<h2 align="center">Edit Data Obat</h2>
				<br>	
			  <div class="form-group">
			    <label for="kd_obat" style="font-size: 20px;">Kode Obat</label>
			    <input type="text" class="form-control" name="kd_obat"  id="kd_obat" readonly value="<?= $obat['kd_obat']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="nm_obat" style="font-size: 20px;">Nama Obat</label>
			    <input type="text" class="form-control" name="nm_obat" id="nm_obat" value="<?= $obat['nama_obat']; ?>">
			  </div>
			   <div class="form-group">
			    <label for="ktg_obat" style="font-size: 20px;">Kategori Obat</label>
			    <select name="ktg_obat" class="form-control">
			    	<option selected value="<?= $obat['kategori_obat']; ?>"><?= $obat['kategori_obat']; ?></option>
			    	<?php 
			    		if($obat['kategori_obat'] == 'tablet'){
			    	?>
			    		<option value="pil">Pil</option>
			    		<option value="sirup">Sirup</option>
					<?php }elseif($obat['kategori_obat'] == 'pil') { ?>
			    		<option value="tablet">Tablet</option>
			    		<option value="sirup">Sirup</option>
			    	<?php }else{ ?>
			    		<option value="tablet">Tablet</option>
			    		<option value="pil">Pil</option>
			    	<?php } ?>
			    </select>
			  </div>
			   <div class="form-group">
			    <label for="harga" style="font-size: 20px;">Harga Obat</label>
			    <input type="text" class="form-control" name="harga" id="harga"  value="<?= $obat['harga']; ?>">
			  </div>
			  <input class="btn btn-primary" type="submit" name="edit" value="Edit" style="width: 150px; margin-left: 170px;">
			</form>
		</div>
	</div>
</body>
</html>s