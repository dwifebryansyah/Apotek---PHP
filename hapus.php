<?php 
	session_start();

	if(!isset($_SESSION['submit'])){
		header('Location: logins.php');
		exit;
	}

	require 'config/koneksi.php';
	require 'config/function.php';

	$id = $_GET['hapus'];
	$kode = $_GET['kode'];
	$table = $_GET['tabel'];
	$url = $_GET['url'];
	// var_dump($kode);
	// die(); 

		if(hapus($id, $kode, $table) > 0){
			$_SESSION['tampilan'] = "tampilan";
			echo "<script>
				document.location.href = '$url.php';
				</script>";
		}else{
			echo "<script>
					alert('gagal di hapus');
				</script>";
		}
 ?>

