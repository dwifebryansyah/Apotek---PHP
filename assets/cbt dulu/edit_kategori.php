<?php 
	require 'config/koneksi.php';
	require 'config/function.php';

	$id = $_GET['id'];
	$kategori = tampil("SELECT * FROM tb_kategori WHERE kd_kategori = '$id'")[0];

	$nameKategori = "";
	$kategoriErr = "";
	$kategoriValidasi = true;
	$kategoriMsg = "";

	if(isset($_POST['update'])){

		$nameKategori = trim($_POST['kategori']);

		if(empty($nameKategori)){
			$kategoriErr = "Kategori tidak boleh kosong";
		}

		if(!preg_match("/^[a-zA-Z ]*$/",$nameKategori)){
			$kategoriValidasi = false;
			$kategoriMsg = "Hanya boleh huruf dan spasi yang diijinkan";
		}

		if($kategoriValidasi and !empty($nameKategori)){

			if(editKategori($_POST) > 0){
					echo "<script>
							alert('berhasil');document.location.href = 'kategori.php';
						</script>";
				}else{
					echo "<script>
						alert('Gagal,Nama kategori sama dengan sebelumnya');
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
  		<a href="kategori.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 80px; padding:2px;">Kembali</a>
	</nav>
	<div class="container" style="padding-bottom: 30px;">
		<div style="width: 550px; height: 400px; background-color: ghostwhite; padding: 30px; border-radius: 10px; margin-left: 280px; margin-top: 40px; ">
			<form method="post">
				<h2 align="center">Update Data Barang</h2>
				<br>	
			  <div class="form-group">
			    <label>Kode Kategori</label>
			    <input type="text" class="form-control" name="kd_kategori" readonly value="<?= $kategori['kd_kategori']; ?>">
			  </div>
			    <div class="form-group">
			    <label>Kategori Barang</label>
			    <?php if(isset($_POST['update'])){ ?>
				    <input type="text" class="form-control" name="kategori" value="<?= @$nameKategori; ?>">
				     <?= $kategoriErr.$kategoriMsg ?>
			 	<?php }else{ ?>
					 <input type="text" class="form-control" name="kategori" value="<?= $kategori['kategori']; ?>">
				     <?= $kategoriErr.$kategoriMsg ?>
			 	<?php } ?>
			  </div>
			  <input class="btn btn-primary" type="submit" name="update" value="Update" style="margin-top: 30px; width: 150px; margin-left: 170px;">
			</form>
		</div>
	</div>
</body>
</html>