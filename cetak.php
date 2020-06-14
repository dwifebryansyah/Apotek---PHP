<?php 

	require 'config/koneksi.php';
	require 'config/function.php';

	$laporan = tampil("SELECT * FROM tb_laporan_transaksi");
	// var_dump($laporan);
	// die();

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Laporan Transaksi</title>
	<link rel="stylesheet" href="css/bootstrap.css">
</head>
<body style="background-color: #eeeeee; ">
	</nav>
	<div class="container">
		<div style="width: 1250px; height: 400px; background-color: ghostwhite; padding: 30px; border-radius: 10px; margin-left: -70px; margin-top: 40px; ">
			<table class="table table-hover table-light">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col">No</th>
			      <th scope="col">Kode Laporan</th>
			      <th scope="col">Kode Barang</th>
			      <th scope="col">Nama Barang</th>
			      <th scope="col">Kategori Barang</th>
			      <th scope="col">Tanggal Transaksi</th>
			      <th scope="col">Jumlah Awal</th>
			      <th scope="col">Jumlah Akhir</th>
			      <th scope="col">Berkurang</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php $i= 1; ?>
				<?php foreach($laporan as $row): ?>
			    <tr>
			      <th scope="row"><?= $i ?></th>
			      <td><?= $row['kd_laporan_transaksi']; ?></td>
			      <td><?= $row['kd_barang']; ?></td>
			      <td><?= $row['nama_barang']; ?></td>
			      <td><?= $row['kategori_barang']; ?></td>
			      <td><?= $row['tanggal_transaksi']; ?></td>
			      <td>&emsp;<?= $row['jumlah_awal']; ?></td>
			      <td>&emsp;<?= $row['jumlah_akhir']; ?></td>
			      <td>&emsp;&emsp;<?= $row['berkurang']; ?></td>
			    </tr>
			    <?php $i++ ?>
			<?php endforeach; ?>
			  </tbody>
			</table>
			<script>
				window.print();
			</script>
		</div>
	</div>
</body>
</html>