<?php 
	session_start();
	require '../config/koneksi.php';
	require '../config/function.php';

	// koneksi library FPDF
	require 'fpdf.php';
	// setting halaman PDF
	$pdf = new FPDF('L','mm','A4');
	// menambah halaman baru
	$pdf->AddPage();
	// setting jenis font
	$pdf->SetFont('arial', 'B', 16);
	// membuat string
	$pdf->Cell(77,7,'',0,0);
	$pdf->Cell(115,7,'Laporan Transaksi Harian',0,1,'C');
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->Cell(77,7,'',0,0);
	$pdf->Cell(110,7,'Jl.Haji Naik Bubur Dua Kali',0,1,'C');
	// setting spasi kebawah supaya tidak rapat
	$pdf->Cell(77,7,'',0,0);
	$pdf->Cell(200,7,'',0,1);

	$pdf->SetFont('Arial', 'B','10');
	$pdf->Cell(3,5,'',0,0);
	$pdf->Cell(8,5,'No',1,0,'C');
	$pdf->Cell(35,5,'Kode Transaksi',1,0,'C');
	$pdf->Cell(35,5,'Kode Barang',1,0,'C');
	$pdf->Cell(35,5,'Nama Barang',1,0,'C');
	$pdf->Cell(30,5,'Tanggal',1,0,'C');
	$pdf->Cell(25,5,'Harga',1,0,'C');
	$pdf->Cell(28,5,'Jumlah Awal',1,0,'C');
	$pdf->Cell(28,5,'Jumlah Akhir',1,0,'C');
	$pdf->Cell(25,5,'Jumlah Input',1,0,'C');
	$pdf->Cell(20,5,'Total',1,0,'C');
	$pdf->Cell(14,5,'',0,1);

	$pdf->SetFont('Arial','',10);

	$laporan = $_SESSION['laporan'];
	$query = tampil("SELECT * FROM laporan_transaksi");

	$hitungLaporan = count($laporan);
	

	$i= 1;
	
	if( $hitungLaporan == null):
		foreach($query as $row):
			$pdf->Cell(3,5,'',0,0);
			$pdf->Cell(8,5,$i,1,0,'C');
			$pdf->Cell(35,5,$row['kd_transaksi'],1,0,'C');
			$pdf->Cell(35,5,$row['kd_barang'],1,0,'C');
			$pdf->Cell(35,5,$row['nama_barang'],1,0,'C');
			$pdf->Cell(30,5,$row['tanggal_transaksi'],1,0,'C');
			$pdf->Cell(25,5,$row['harga'],1,0,'C');
			$pdf->Cell(28,5,$row['jumlah_awal'],1,0,'C');
			$pdf->Cell(28,5,$row['jumlah_akhir'],1,0,'C');
			$pdf->Cell(25,5,$row['jumlah_input'],1,0,'C');
			$pdf->Cell(20,5,$row['total'],1,0,'C');
			$pdf->Cell(14,5,'',0,1);

			$i++;
		endforeach;
	else:
		foreach($laporan as $row):
			$pdf->Cell(3,5,'',0,0);
			$pdf->Cell(8,5,$i,1,0,'C');
			$pdf->Cell(35,5,$row['kd_transaksi'],1,0,'C');
			$pdf->Cell(35,5,$row['kd_barang'],1,0,'C');
			$pdf->Cell(35,5,$row['nama_barang'],1,0,'C');
			$pdf->Cell(30,5,$row['tanggal_transaksi'],1,0,'C');
			$pdf->Cell(25,5,$row['harga'],1,0,'C');
			$pdf->Cell(28,5,$row['jumlah_awal'],1,0,'C');
			$pdf->Cell(28,5,$row['jumlah_akhir'],1,0,'C');
			$pdf->Cell(25,5,$row['jumlah_input'],1,0,'C');
			$pdf->Cell(20,5,$row['total'],1,0,'C');
			$pdf->Cell(14,5,'',0,1);

			$i++;
		endforeach;
	endif;

	for ($a=0; $a <= $hitungLaporan-1 ; $a++) { 
		$cek[] = $laporan[$a]['total'];
	}

	// cara menjumlahkan array
	$totalAkhir = array_sum($cek);
	// var_dump($totalAkhir);
	// die();	

	$pdf->SetFont('Arial', 'B','12');
	$pdf->Cell(10,5,'',0,1);
	$pdf->Cell(230,5,'',0,0);
	$pdf->Cell(20,5,'Total Akhir',0,0,'C');
	$pdf->Cell(5,5,':',0,0,'C');
	$pdf->Cell(17,5,$totalAkhir,0,0,'');
	

	$pdf->Output('','Laporan Transaksi');	
 ?>

 <!-- <script>
 	window.print();
 </script> -->