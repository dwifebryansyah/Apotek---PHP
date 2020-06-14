<?php 
	session_start();

	if(!isset($_SESSION['submit'])){
		header('Location: logins.php');
		exit;
	}

	require '../config/koneksi.php';
	require '../config/function.php';

	$id = $_GET['hapus'];
	//$jumlah = $_GET['jumlah'];
	// var_dump($id);
	// die(); 

		if(hapusUser($id) > 0){
			echo "<script>
					alert('berhasil di hapus');document.location.href = 'user.php';
				</script>";
		}else{
			echo "<script>
					alert('gagal di hapus');
				</script>";
		}
 ?>