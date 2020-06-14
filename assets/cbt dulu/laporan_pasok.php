<?php 

	require '../config/koneksi.php';
	require '../config/function.php';

	$laporan = tampil("SELECT * FROM laporan_pasok");


	if(isset($_POST['search'])){
		$table = 'laporan_pasok';
		$kode = 'kd_pasok';
		$nama = 'nama_barang';
		$laporan = cari($_POST['tsearch'], $table, $kode, $nama);
	}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Laporan Pasok</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body style="background-color: #eeeeee; ">
	<nav class="navbar navbar-dark bg-dark" style="color: rgba(232, 236, 241, 1);">
  		<h3>Apotek Caringin</h3>
  		<form class="form-inline" method="post">
	    	<input class="form-control mr-sm-2" type="search" placeholder="Search" name="tsearch">
	    	<input class="btn btn-outline-success" type="submit" name="search" value="Cari">
	  	</form> 
  		<a href="home_laporan.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 80px; margin-left: 730px; padding:1px;">Kembali</a>
	</nav>
	</nav>
	<div class="container">
		<div style="width: 1000px; height: 400px; background-color: ghostwhite; padding: 30px; border-radius: 10px; margin-left: 70px; margin-top: 40px; ">
			<table class="table table-hover table-light">
			  <thead class="thead-dark">
			    <tr>
			    	<th scope="col">No</th>
			      	<th scope="col">Kode Pasok</th>
			      	<th scope="col">Kode Barang</th>
			      	<th scope="col">Nama Barang</th>
			      	<th scope="col">Pemasok</th>
			      	<th scope="col">Tanggal Pasok</th>
			     	<th scope="col">Jumlah</th>
			      	<th scope="col">Aksi</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php $i= 1; ?>
				<?php foreach($laporan as $row): ?>
			    <tr>
			      	<th scope="row"><?= $i ?></th>
			      	<td><?= $row['kd_pasok']; ?></td>
			      	<td><?= $row['kd_barang']; ?></td>
			      	<td><?= $row['nama_barang']; ?></td>
			      	<td><?= $row['pemasok']; ?></td>
			      	<td><?= $row['tanggal_pasok']; ?></td>
			      	<td>&emsp;<?= $row['jumlah']; ?></td>
			      	<td>
			      		<a onclick="return confirm('yakin ingin mengahapus?');" href="../hapus.php?kode=<?='kd_pasok'?>&tabel=<?='tb_pasok'?>&hapus=<?= $row['kd_pasok'] ?>&url=<?= 'laporan/laporan_pasok' ?>">Hapus</a>
			      	</td>
			    </tr>
			    <?php $i++ ?>
			<?php endforeach; ?>
			  </tbody>
			</table>
			<div class="form-grup">
				<a href="../FPDF/cetak_pasok.php" class="btn btn-danger btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 150px; padding:2px; margin-top: 0px; float: right; font-size: 20px;">
					Cetak
				</a>
			</div>
		</div>
	</div>
</body>
</html>