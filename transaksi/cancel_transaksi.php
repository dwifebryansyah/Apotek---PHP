<?php 
	session_start();

	if(!isset($_SESSION['submit'])){
		header('Location: logins.php');
		exit;
	}

	require '../config/koneksi.php';
	require '../config/function.php';

	$id = $_GET['hapus'];
	$jumlah = $_GET['jumlah'];
	// var_dump($jumlah);
	// die(); 

		if(cancelTransaksi($id, $jumlah) > 0){
			echo "<script>
					alert('berhasil di cancel');document.location.href = 'transaksi_barangs.php';
				</script>";
		}else{
			echo "<script>
					alert('gagal di cancel');
				</script>";
		}
 ?>