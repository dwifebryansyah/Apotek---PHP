<?php 
	session_start();
	
	require '../config/koneksi.php';
	require '../config/function.php';

	if(!isset($_SESSION['submit'])){
		header('Location: login.php');
		exit;
	}

	$jumlahDataPerhalaman = 3;
	$jumlahData = count(tampil("SELECT * FROM tb_barang"));
	$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman); // 3
	$halamanAktif = ( isset($_GET['page']) ) ? $_GET['page'] : 1; // 1
	$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;
	
	$obat = tampil("SELECT * FROM tb_barang LIMIT $awalData, $jumlahDataPerhalaman");


	if(isset($_POST['search'])){
		$table = 'tb_barang';
		$kode = 'kd_barang';
		$nama = 'nama_barang';
		$obat = cari($_POST['tsearch'], $table, $kode, $nama);
	}


 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Obat</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../js/bootstrap.min.js">
	<link rel="stylesheet" href="../js/bootstrap.js">

</head>
<body style="background-color: #eeeeee; ">
	<nav class="navbar navbar-dark bg-dark" style="color: rgba(232, 236, 241, 1);">
  		<h3>Apotek Caringin</h3>
  		<form class="form-inline" method="post" style="margin-right: 660px;">
	    	<input class="form-control mr-2" type="search" placeholder="Search" name="tsearch">
	    	<input class="btn btn-outline-danger" type="submit" name="search" value="Cari">
	  	</form>
	  	<a href="../kategori.php" class="btn btn-outline-success">Kategori</a>
		<a href="../home.php" class="btn btn-outline-primary">Kembali</a>
	</nav>
	</nav>
	<div class="container" style="padding-bottom: 25px;">
		<div style="width: 1000px; height: 470px; background-color: ghostwhite; padding: 30px; border-radius: 10px; margin-left: 100px; margin-top: 40px; ">
			<table class="table table-hover table-light">
			    <tr>
			    <thead class="thead-dark">
			      <th scope="col">No</th>
			      <th scope="col">Kode</th>
			      <th scope="col">Nama </th>
			      <th scope="col">Kategori </th>
			      <th scope="col">Pemasok</th>
			      <th scope="col">Harga Beli</th>
			      <th scope="col">Harga Jual</th>
			      <th scope="col">Jumlah</th>
			      <th scope="col">&emsp;&emsp;&emsp;&emsp;Aksi</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php $i= $awalData + 1; ?>
				<?php foreach($obat as $row): ?>
			    <tr>
			      <th scope="row"><?= $i ?></th>
			      <td><?= $row['kd_barang']; ?></td>
			      <td><?= $row['nama_barang']; ?></td>
			      <td><?= $row['kategori_barang']; ?></td>
			      <td><?= $row['pemasok']; ?></td>
			      <td><?= $row['harga_beli']; ?></td>
			      <td><?= $row['harga_jual']; ?></td>
			      <td><?= $row['jumlah']; ?></td>
			      <td>
			      	<a onclick="return confirm('yakin ingin mengahapus?');" href="hapus_barang.php?hapus=<?= $row['kd_barang']; ?>">Hapus</a> |
			      	<a href="edit_barang.php?edit=<?= $row['kd_barang']; ?>">Update</a> |
			      	<a href="pasok_barang.php?pasok=<?= $row['kd_barang']; ?>">Pasok</a>
			      </td>
			    </tr>
			    <?php $i++ ?>
			<?php endforeach; ?>
			  </tbody>
			</table>

			<?php if( $halamanAktif == 1): ?>
				<a href="barang.php?page=<?= $halamanAktif ?>"></a>
			<?php else: ?>
				<a href="barang.php?page=<?= $halamanAktif - 1 ?>">&laquo</a>
			<?php endif; ?>

			<?php for ($i=1; $i <= $jumlahHalaman ; $i++) { ?>
				<?php if( $i == $halamanAktif ): ?>
						<a href="barang.php?page=<?= $i ?>" style="font-weight: bold" ><?= $i ?></a>
				<?php else: ?>
					<a href="barang.php?page=<?= $i ?>" ><?= $i ?></a>
				<?php endif; ?>
			<?php } ?>
			
			<?php if( $halamanAktif == $jumlahHalaman): ?>
				<a href="barang.php?page=<?= $halamanAktif ?>"></a>
			<?php else: ?>
				<a href="barang.php?page=<?= $halamanAktif + 1 ?>">&raquo</a>
			<?php endif; ?>


			<a href="tambah_barang.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 150px; padding:2px; float: right; margin-top: 0px;">Tambah Barang</a>
		</div>
	</div>	
</body>
</html>