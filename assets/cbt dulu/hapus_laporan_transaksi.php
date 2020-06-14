<?php 
	require '../config/koneksi.php';
	require '../config/function.php';

	$id = $_GET['hapus'];
	// var_dump($id);
	// die(); 

		if(hapusLaporanTransaksi($id) > 0){
			echo "<script>
					alert('berhasil di hapus');document.location.href = 'laporan_transaksi.php';
				</script>";
		}else{
			echo "<script>
					alert('gagal di hapus');
				</script>";
		}
 ?>