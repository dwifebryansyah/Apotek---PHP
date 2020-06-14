<?php 
	session_start();
	
	require '../config/koneksi.php';
	require '../config/function.php';

	if(!isset($_SESSION['submit'])){
		header('Location: login.php');
		exit;
	}

	$obat = tampil("SELECT * FROM tb_obat");

	if(isset($_POST['search'])){
		$table = 'tb_obat';
		$kode = 'kd_obat';
		$nama = 'nama_obat';
		$obat = cari($_POST['tsearch'], $table, $kode, $nama);
	}


 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Obat</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body style="background-color: #eeeeee; ">
	<nav class="navbar navbar-dark bg-dark" style="color: rgba(232, 236, 241, 1);">
  		<h3>Apotek Caringin</h3>
  		<form class="form-inline" method="post">
	    	<input class="form-control mr-sm-2" type="search" placeholder="Search" name="tsearch">
	    	<input class="btn btn-outline-success" type="submit" name="search" value="Cari">
	  	</form> 		
		<a href="../home.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height:40px; font-size: 18px; padding-top: 5px; margin-left: 730px;">Kembali</a>
	</nav>
	</nav>
	<div class="container" style="padding-bottom: 25px;">
		<div style="width: 950px; height: 350px; background-color: ghostwhite; padding: 30px; border-radius: 10px; margin-left: 100px; margin-top: 40px; ">
			<table class="table table-hover table-light">
			    <tr>
			    <thead class="thead-dark">
			      <th scope="col">No</th>
			      <th scope="col">Kode</th>
			      <th scope="col">Nama Obat</th>
			      <th scope="col">Kategori Obat</th>
			      <th scope="col">Pemasok</th>
			      <th scope="col">Harga</th>
			      <th scope="col">Jumlah</th>
			      <th scope="col">&emsp;&emsp;&emsp;&emsp;Aksi</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php $i= 1; ?>
				<?php foreach($obat as $row): ?>
			    <tr>
			      <th scope="row"><?= $i ?></th>
			      <td><?= $row['kd_obat']; ?></td>
			      <td><?= $row['nama_obat']; ?></td>
			      <td><?= $row['kategori_obat']; ?></td>
			      <td><?= $row['pemasok']; ?></td>
			      <td><?= $row['harga']; ?></td>
			      <td><?= $row['jumlah']; ?></td>
			      <td>
			      	<a onclick="return confirm('yakin ingin mengahapus?');" href="hapus_obat.php?hapus=<?= $row['kd_obat']; ?>">Hapus</a> |
			      	<a href="edit_obat.php?edit=<?= $row['kd_obat']; ?>">Update</a> |
			      	<a href="pasok_obat.php?pasok=<?= $row['kd_obat']; ?>">Pasok</a>
			      </td>
			    </tr>
			    <?php $i++ ?>
			<?php endforeach; ?>
			  </tbody>
			</table>
			<a href="tambah_obat.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 150px; padding:2px; float: right; margin-top: 0px;">Tambah Obat</a>
	</div>
</body>
</html>