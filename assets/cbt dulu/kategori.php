<?php 
	session_start();
	
	require 'config/koneksi.php';
	require 'config/function.php';

	if(!isset($_SESSION['submit'])){
		header('Location: login.php');
		exit;
	}

	$kategori = tampil("SELECT * FROM tb_kategori");

	if(isset($_POST['search'])){
		$table = 'tb_kategori';
		$kode = 'kd_kategori';
		$nama = 'kategori';

		$kategori = cari($_POST['tsearch'], $table, $kode, $nama);
	}


 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Obat</title>
	<link rel="stylesheet" href="css/bootstrap.css">
</head>
<body style="background-color: white; ">
	<nav class="navbar navbar-dark bg-dark" style="color: rgba(232, 236, 241, 1);">
  		<h3>Apotek Caringin</h3>
  		<form class="form-inline" method="post" style="margin-right: 500px;">
	    	<input class="form-control mr-2" type="search" placeholder="Search" name="tsearch">
	    	<input class="btn btn-outline-danger" type="submit" name="search" value="Cari">
	  	</form>
	  	<a href="tambah_kategori.php" class="btn btn-outline-success">Tambah Kategori Barang</a>
		<a href="obat/barang.php" class="btn btn-outline-primary">Kembali</a>
	</nav>
	</nav>
	<div class="container mt-3">
		<br><br>
		<div class="row">
			<div class="col-md-4">
				
			</div>
			<div class="col-md-4">
				<h3>Daftar Kategori</h3>
				<ul class="list-group mt-3">
					<?php foreach($kategori as $row): ?>
						<li class="list-group-item d-flex justify-content-between align-items-center"><?= $row['kategori'] ?>
				  			<a href="edit_kategori.php?id=<?= $row['kd_kategori']; ?>" class="badge badge-primary ml-auto mr-2">Edit</a>

				  			<a onclick="return confirm('yakin ingin mengahapus?');" href="hapus.php?kode=<?='kd_kategori'?>&tabel=<?='tb_kategori'?>&hapus=<?= $row['kd_kategori'] ?>&url=<?= 'kategori' ?>" class="badge badge-primary">hapus</a>
				  		</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
</body>
</html>