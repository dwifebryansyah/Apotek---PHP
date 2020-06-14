<?php 
	session_start();

	require '../config/koneksi.php';
	require '../config/function.php';

	if(!isset($_SESSION['submit'])){
		header('Location: login.php');
		exit;
	}

	$jumlah = "";
	$validasi_jumlah = true;
	$jumlah_error_msg = "";
	$bayar = "";
	$validasi_bayar = true;
	$bayar_error_msg = "";
	$total = "";


	// SAAT ON CHANGE AUTO NAMPILIN VALUES
	if(isset($_POST['nama_barang'])){
		$kode = $_POST['nama_barang']; // result is nama_barang
		$sql = "SELECT * FROM tb_barang";
		$query = mysqli_query($conn, $sql);
		$res = mysqli_fetch_assoc($query);

		if($kode == $res['nama_barang']){
			$output = $res['nama_barang'];
		}else{
			$output = $kode;
		}
		//var_dump(@$kode);
		//die();

		$_SESSION['nama_barang'] = $kode;	
	}


	if(isset($_POST['search'])){
		$table = 'tb_barang';
		$kode = 'kd_barang';
		$nama = 'nama_barang';
		$obat = cari($_POST['tsearch'], $table, $kode, $nama);
	}

	// Pilih
	if(isset($_POST['pilih'])){
			
		if($_POST['nama_barang'] == null){
			$pilihErrr = "Harus di isi semua";
			echo "<script>
					alert('$pilihErrr');
				</script>";
		}else{

			$jumlah = $_POST['jumlah'];

			if(!is_numeric($jumlah)){
				$validasi_jumlah = false;
				$jumlah_error_msg = "Hanya boleh angka saja";
			}

			// Cek semua input sudah diisi apa belum
			if($validasi_jumlah){

				if(pilihBarang($_POST) > 0){
					echo "<script>
								alert('Berhasil');document.location.href = '../transaksi/transaksi_barang.php';
							</script>";
					}else{
						echo "<script>
							alert('Gagal');
						</script>";
				}
			}
		}
	}

	//Selesai Belanja
	if(isset($_POST['selesai'])){
		$hitung = selesaiBelanja("SELECT SUM(total) AS totalAkhir FROM tb_detail_transaksi ");
		$tanggal = date('d/m/Y');

		$sql = mysqli_query($conn, "SELECT * FROM tb_detail_transaksi");
		$ambil = mysqli_fetch_all($sql);

		$row = mysqli_num_rows($sql);
		$rows = $row - 1;

		if( @$_POST['totals'] == null ){
			$pilihErrr = "Harus di isi semua";
			echo "<script>
					alert('$pilihErrr');
				</script>";
		}else{

			for ($i=0; $i <= $rows; $i++) { 

			$kode = $ambil[$i]['2'];
			$nama = $ambil[$i]['1'];
			$ktg = $ambil[$i]['3'];
			$harga = $ambil[$i]['4'];
			$jumlah = $ambil[$i]['5'];
			$total = $ambil[$i]['6'];

			//$kodeLT = kodeOtomatis('kd_laporan_transaksi','tb_laporan_transaksi','LT');
			$kodeT = kodeOtomatis('kd_transaksi','tb_transaksi','T');

			// ngambil data arraynya
			$sql1 = "SELECT * FROM tb_barang WHERE kd_barang = '$kode' ";
			$query = mysqli_query($conn, $sql1);
			$query1 = mysqli_fetch_assoc($query);
			$jumlah_awal = $query1['jumlah'];// jumlah 	awal

			// ubah jumlah data
			$jumlah_akhir = $jumlah_awal - $jumlah;// jumlah akhir

			// masukin data ke tabel laporan transaksi
			// $sql4 = "INSERT INTO tb_laporan_transaksi VALUES ('$kodeLT','$kode','$nama','$ktg', '$tanggal' ,'$jumlah_awal','$jumlah_akhir', '$jumlah') ";
			// mysqli_query($conn, $sql4);

			// Update data tabel barang
			$sql2 = "UPDATE tb_barang SET jumlah = '$jumlah_akhir' WHERE kd_barang = '$kode' ";
			mysqli_query($conn, $sql2);
			
			// masukin data ke tabel transaksi
			$sql3 = mysqli_query($conn, "INSERT INTO tb_transaksi VALUES ('$kodeT','$kode','$nama','$ktg','$tanggal','$harga','$jumlah_awal','$jumlah_akhir','$jumlah','$total' ) ");
			// nambah 1 data ke tabel detail laporan transaksi

			}

			$sql5 = "SELECT SUM(subtotal) AS subtotal FROM tb_detail_laporan_transaksi WHERE subtotal = '0' ";
			$query2 = mysqli_query($conn, $sql5);
			$ambil2 = mysqli_fetch_assoc($query2);
			$subtotal = $ambil2;

			if( $subtotal['subtotal'] == 0 ){
				$sql6 = mysqli_query($conn, "TRUNCATE TABLE tb_detail_laporan_transaksi");

				for ($i=0; $i <= $rows; $i++) { 

				$kode = $ambil[$i]['2'];
				$nama = $ambil[$i]['1'];
				$ktg = $ambil[$i]['3'];
				$harga = $ambil[$i]['4'];
				$jumlah = $ambil[$i]['5'];
				$total = $ambil[$i]['6'];

				$sql7 = mysqli_query($conn, " INSERT INTO tb_detail_laporan_transaksi (nama_barang,harga,jumlah,total) VALUES ('$nama','$harga','$jumlah','$total') ");
				}
			}else{

			for ($i=0; $i <= $rows; $i++) { 

			$kode = $ambil[$i]['2'];
			$nama = $ambil[$i]['1'];
			$ktg = $ambil[$i]['3'];
			$harga = $ambil[$i]['4'];
			$jumlah = $ambil[$i]['5'];
			$total = $ambil[$i]['6'];

			$sql8 = mysqli_query($conn, " INSERT INTO tb_detail_laporan_transaksi (nama_barang,harga,jumlah,total) VALUES ('$nama','$harga','$jumlah','$total') ");

									}
			}


			$sql9 = mysqli_query($conn, "TRUNCATE TABLE tb_detail_transaksi");
		}

	}

	// Membayar
	if(isset($_POST['membayar'])){
		$total = $_POST['total'];
		$bayar = $_POST['bayar'];

		if(!is_numeric($bayar)){
			$validasi_bayar = false;
			$bayar_error_msg = "Hanya boleh angka saja";
		}


		// Cek semua input sudah diisi apa belum
		if($validasi_bayar){

			$membayar = $bayar - $total;
			// $tampungTotal = $total;
			// $tampungBayar = $bayar;

			$query = "UPDATE tb_detail_laporan_transaksi SET subtotal = '$total', bayar = '$bayar', kembalian = '$membayar', tanggal = '$_POST[tanggal_transaksi]' ";
			$sql = mysqli_query($conn, $query );
		}
	}

	//CETAK
	if(isset($_POST['cetak'])){
		$query = mysqli_query($conn, "TRUNCATE TABLE tb_detail_laporan_transaksi");
	}

	$pilihErrr = "";

	$sql = "SELECT * FROM tb_barang";
	$query = mysqli_query($conn, $sql);

	$sql2 = "SELECT * FROM tb_detail_transaksi";
	$query2 = mysqli_query($conn, $sql2);

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Transaksi Obat</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body style="background-color: #eeeeee; ">
	<nav class="navbar navbar-dark bg-dark" style="color: rgba(232, 236, 241, 1);">
  		<h3>Apotek Caringin</h3>
  		<a href="../home.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 80px; padding:1px;">Kembali</a>
	</nav>
	<div class="container" ><br>
		<div class="container" style="background-color: white; padding: 30px; ">
			<form method="post">
				<h2 align="center">Transaksi Obat!</h2>
				<br><br>
				<div style="margin-left: 500px; width: 0px; height: 0px;">
					<table class="table">
						<tr>
							<th scope="col">No</th>
							<th scope="col">Nama</th>
							<th scope="col">Kode</th>
							<th scope="col">Kategori</th>
							<th scope="col">Harga</th>
							<th scope="col">Jmlh</th>
							<th scope="col">Total</th>
							<th scope="col">Aksi</th>							
						</tr>
						<?php $i = 1 ?>
						<?php foreach($query2 as $row): ?>
						<tr>
							<td><?= $i ?></td>
							<td><?= $row['nama_barang'] ?></td>
							<td><?= $row['kd_barang'] ?></td>
							<td><?= $row['kategori_barang'] ?></td>
							<td><?= $row['harga'] ?></td>
							<td><?= $row['jumlah'] ?></td>
							<td>
								<input type="text" class="form-control" name="totals" style="font-size: 10px; text-align: center; width: 60px;" value="<?= $row['total'] ?>" readonly>
							</td>
							<td>
								<a onclick="return confirm('yakin ingin mengahapus?');" href="../hapus.php?kode=<?='kd_barang'?>&tabel=<?='tb_detail_transaksi'?>&hapus=<?= $row['kd_barang'] ?>&url=<?= 'transaksi/transaksi_barang' ?>">hapus</a>
							</td>
						</tr>
						<?php $i++ ?>
						<?php endforeach; ?>
					</table>
					
					 <div class="col-md-2">
				    		<input class="btn btn-success" type="submit" name="selesai" value="Selesai" style="margin-left: 420px;">
				    </div>
				</div>
			 	<div class="form-group row">
				    <div class="col-md-2">
					    <label for="nama_barang" style="font-size: 15px;">Nama Barang</label>
					    <select name="nama_barang" class="form-control" onchange="this.form.submit()">
					    	<option selected value="">--Pilih--</option>
					    	<?php foreach($query as $ambil): ?>
					    		<option value="<?= $ambil['nama_barang']; ?>"><?= $ambil['nama_barang']; ?></option>
					    		<?php if( $ambil['nama_barang'] == $output){ ?>
									<option selected value="<?= @$output ?>"><?= @$output ?></option>
					    		<?php } ?>
					    	<?php endforeach; ?>
					    	<option value="">Reset</option>
					    </select>
				    </div>
			  	</div> 
			 	<div class="form-group row">
			 		<div class="col-md-2">
					    <label for="kd_barang" style="font-size: 15px;">Kode</label>
					    <?php 
					    	if(isset($_SESSION['nama_barang'])){
					    		$sql = mysqli_query($conn, "SELECT * FROM tb_barang WHERE nama_barang = '$_SESSION[nama_barang]' ");
					    		$result = mysqli_fetch_assoc($sql);
						 ?>
					    <input type="text" class="form-control" name="kd_barang" readonly value="<?= $result['kd_barang'] ?>">
						<?php } else { ?>
						<input type="text" class="form-control" name="kd_barang" readonly value=""> 
						<?php } ?>
					</div>
					<div class="col-md-2">
				    	<label for="ktg_barang" style="font-size: 15px;">Kategori</label>
				    	<input type="text" class="form-control" name="ktg_barang" readonly value="<?= @$result['kategori_barang'] ?>">
			  		</div>
			  		<div class="col-md-1">
					    <label for="harga" style="font-size: 15px;">Harga</label>
							<input type="text" class="form-control" name="harga" readonly value="<?= @$result['harga_jual']; ?>" style="width: 100px;">
			  		</div>
			  	</div>
			  	<div class="form-group row">
			  		<div class="col-md-2">
					    <label style="font-size: 15px;">Jumlah</label>
					    <?php if( @$_POST['nama_barang'] == !null ){ ?>
					    	<input type="text" class="form-control" name="jumlah" value="<?= @$jumlah; ?>" required>
					    	<?= $jumlah_error_msg ?>
					    <?php }else{ ?>
							<input type="text" class="form-control" name="jumlah" value="" readonly>
					    <?php } ?>
				    </div>
				    <div class="col-md-1">
				    	<input class="btn btn-success" type="submit" name="pilih" value="Pilih" style="margin-top: 30px;">
				    </div>
			  	</div>

			  	<div class="form-group row">
			  		<div class="col-md-2">
				  		<label style="font-size: 15px;">SubTotal</label>
				  		<?php if( isset($_POST['membayar']) ){ ?>
				  			<input type="text" class="form-control" name="total" readonly value="<?= @$total; ?>">
				  		<?php }else{ ?>
							<input type="text" class="form-control" name="total" readonly value="<?= @$hitung['totalAkhir'] ?>">
				  		<?php } ?>
			  		</div>
			  		<div class="col-md-2">
					    <label for="bayar" style="font-size: 15px;">Bayar</label>
					    <?php if( isset($_POST['membayar']) and !is_numeric(@$_POST['bayar']) ) { ?>
					    	<input type="text" class="form-control" name="bayar" value="<?= @$bayar;?>" required>
					    	<?= $bayar_error_msg; ?>
						<?php }elseif ( isset($_POST['selesai']) and !is_null(@$_POST['totals']) ) { ?>
							<input type="text" class="form-control" name="bayar" value="<?= @$bayar;?>" required>
					    	<?= $bayar_error_msg; ?>
						<?php }elseif ( is_numeric(@$_POST['bayar']) ) { ?>
							<input type="text" class="form-control" name="bayar" value="<?= @$bayar;?>" required readonly>
						<?php }else{ ?>
							<input type="text" class="form-control" name="bayar" value="<?= @$bayar; ?>" readonly>
							<?= $bayar_error_msg; ?>
						<?php } ?>
				    </div>
				     <div class="col-md-1">
				     	<?php if( isset($_POST['selesai']) and @$_POST['totals'] == !null ){ ?>
				    		<input class="btn btn-success" type="submit" name="membayar" value="Buy" style="margin-top: 30px;">
				    	<?php } elseif ( isset($_POST['membayar']) and !is_numeric(@$_POST['bayar']) ) { ?>
				    		<input class="btn btn-success" type="submit" name="membayar" value="Buy" style="margin-top: 30px;">
				    	<?php }else{ ?>
							<input class="btn btn-success" type="submit" name="membayar" disabled="disabled" value="Buy" style="margin-top: 30px;">
				    	<?php } ?>
				    </div>
			  	</div>
			  	<div class="form-group row">
			  		<div class="col-md-2">
					    <label for="kembalian" style="font-size: 15px;">Kembalian</label>
					    <input type="text" class="form-control" name="kembalian" value="<?= @$membayar ?>" readonly style="font-size: 14px;">
				    </div>
				    <div class="col-md-2">
				  		<label for="tanggal_transaksi" style="font-size: 15px;">Tanggal</label>
				  		<?php $tanggal = date('d/m/Y'); ?>
				  		<input type="text" class="form-control" name="tanggal_transaksi" readonly value="<?= $tanggal; ?>" style="font-size: 14px;">
			  		</div>
			  		<div class="col-md-2">
			  			<?php if(isset($_POST['membayar'])){ ?>
				  				<a href="../FPDF/cetak_struk.php" class="btn btn-success" style=" margin-top: 30px; font-size: 15px;">
									Cetak
								</a>
					  	<?php }else{ ?>
								<a href="../FPDF/cetak_struk.php" class="btn btn-success disabled	" style="margin-top: 30px; font-size: 15px;">
								Cetak
								</a>
					  	<?php } ?>
			  		</div>	
			  	</div>
			</form>
		</div>
	</div>
	<br><br>
</body>
</html>