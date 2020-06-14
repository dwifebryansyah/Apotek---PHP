<?php 

	require '../config/koneksi.php';
	require '../config/function.php';

	$laporan = tampil("SELECT * FROM laporan_transaksi");
	// var_dump($laporan);
	// die();

	if(isset($_POST['search'])){
		$table = 'laporan_transaksi';
		$kode = 'kd_transaksi';
		$nama = 'nama_barang';
		$laporan = cari($_POST['tsearch'], $table, $kode, $nama);
	}

 ?>
 
<!DOCTYPE html>
<html>
<head>
	<title>Laporan Transaksi</title>
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
		<div style="width: 1300px; height: 400px; background-color: ghostwhite; padding: 30px; border-radius: 10px; margin-left: -90px; margin-top: 40px; ">
			<table class="table table-hover table-light">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col">No</th>
			      <th scope="col">Kode Transaksi</th>
			      <th scope="col">Kode Barang</th>
			      <th scope="col">Nama Barang</th>
			      <th scope="col">Tanggal Transaksi</th>
			      <th scope="col">Harga</th>
			      <th scope="col">Jumlah Awal</th>
			      <th scope="col">Jumlah Akhir</th>
			      <th scope="col">Jumlah Input</th>
			      <th scope="col">Total</th>
			      <th scope="col">Aksi</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php $i= 1; ?>
				<?php foreach($laporan as $row): ?>
			    <tr>
			      <th scope="row"><?= $i ?></th>
			      <td><?= $row['kd_transaksi']; ?></td>
			      <td><?= $row['kd_barang']; ?></td>
			      <td><?= $row['nama_barang']; ?></td>
			      <td><?= $row['tanggal_transaksi']; ?></td>
			      <td><?= $row['harga']; ?></td>
			      <td>&emsp;&emsp;<?= $row['jumlah_awal']; ?></td>
			      <td>&emsp;&emsp;<?= $row['jumlah_akhir']; ?></td>
			      <td>&emsp;&emsp;<?= $row['jumlah_input']; ?></td>
			      <td><?= $row['total']; ?></td>
			      <td>
			      	<a onclick="return confirm('yakin ingin mengahapus?');" href="../hapus.php?kode=<?='kd_transaksi'?>&tabel=<?='tb_transaksi'?>&hapus=<?= $row['kd_transaksi'] ?>&url=<?= 'laporan/laporan_transaksi' ?>">Hapus</a>
			      </td>
			    </tr>
			    <?php $i++ ?>
			<?php endforeach; ?>
			  </tbody>
			</table>
			<div class="form-grup">
				<a href="../FPDF/cetak_transaksi.php" class="btn btn-danger btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 150px; padding:2px; margin-top: 0px; float: right; font-size: 20px;">
					Cetak
				</a>
			</div>
		</div>
	</div>
</body>
</html>