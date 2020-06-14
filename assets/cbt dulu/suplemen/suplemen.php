<?php 
	session_start();

	require '../config/koneksi.php';
	require '../config/function.php';

	if(!isset($_SESSION['submit'])){
		header('Location: login.php');
		exit;
	}


	$suplemen = tampil("SELECT * FROM tb_suplemen");

	if(isset($_POST['search'])){
		$table = 'tb_suplemen';
		$kode = 'kd_suplemen';
		$nama = 'nama_suplemen';
		$suplemen = cari($_POST['tsearch'], $table, $kode, $nama);
	}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Suplemen</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body style="background-color: #eeeeee; ">
	<nav class="navbar navbar-dark bg-dark" style="color: rgba(232, 236, 241, 1);">
  		<h3>Apotek Caringin</h3>
  		<form class="form-inline" method="post">
	    	<input class="form-control mr-sm-2" type="search" placeholder="Search" name="tsearch">
	    	<input class="btn btn-outline-success" type="submit" name="search" value="Cari">
	  	</form> 
  		<a href="../home.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 80px; margin-left: 730px; padding:1px;">Kembali</a>
	</nav>
	<div class="container">
		<div style="width: 950px; height: 350px; background-color: ghostwhite; padding: 30px; border-radius: 10px; margin-left: 100px; margin-top: 40px; ">
			<table class="table table-hover table-light">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col">No</th>
			      <th scope="col">Kode</th>
			      <th scope="col">Nama Suplemen</th>
			      <th scope="col">Kategori Suplemen</th>
			      <th scope="col">Pemasok</th>
			      <th scope="col">Harga</th>
			      <th scope="col">Jumlah</th>
			      <th scope="col">&emsp;&emsp;&emsp;&emsp;Aksi</th>
			    </tr>
			  </thead>
			 <tbody>
			  	<?php $i= 1; ?>
				<?php foreach($suplemen as $row): ?>
			    <tr>
			      <th scope="row"><?= $i ?></th>
			      <td><?= $row['kd_suplemen']; ?></td>
			      <td><?= $row['nama_suplemen']; ?></td>
			      <td><?= $row['kategori_suplemen']; ?></td>
			      <td><?= $row['pemasok']; ?></td>
			      <td><?= $row['harga']; ?></td>
			      <td><?= $row['jumlah']; ?></td>
			      <td>
			      	<a onclick="return confirm('yakin ingin mengahapus?');" href="hapus_suplemen.php?hapus=<?= $row['kd_suplemen']; ?>">Hapus</a> |
			      	<a href="edit_suplemen.php?edit=<?= $row['kd_suplemen']; ?>">Update</a> |
			      	<a href="pasok_suplemen.php?pasok=<?= $row['kd_suplemen']; ?>">Pasok</a>
			      </td>
			    </tr>
			    <?php $i++ ?>
			<?php endforeach; ?>
			  </tbody>
			</table>
			<a href="tambah_suplemen.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 180px; padding:2px; float: right; margin-top: 0px;">Tambah Suplemen</a>
		</div>
	</div>
</body>
</html>