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
	$pdf->Cell(180,7,'Laporan Pasok Harian',0,1,'R');
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->Cell(295,7,'Jl.Haji Naik Bubur Dua Kali',0,1,'C');
	// setting spasi kebawah supaya tidak rapat
	$pdf->Cell(10,7,'',0,1);

	$pdf->SetFont('Arial', 'B','10');
	$pdf->Cell(10,6,'NO',1,0,'C');
	$pdf->Cell(45,6,'KODE PASOK',1,0,'C');
	$pdf->Cell(45,6,'KODE BARANG',1,0,'C');
	$pdf->Cell(50,6,'NAMA BARANG',1,0,'C');
	$pdf->Cell(45,6,'PEMASOK',1,0,'C');
	$pdf->Cell(50,6,'TANGGAL PASOK',1,0,'C');
	$pdf->Cell(32,6,'JUMLAH',1,1,'C');

	$pdf->SetFont('Arial','',10);

	$laporan = $_SESSION['laporan'];
	$query = tampil("SELECT * FROM laporan_pasok");
	
	$hitungLaporan = count($laporan);
	//$hitungQuery = count($query);
	
	$i= 1;
	if( $hitungLaporan == null):	
		foreach($query as $row):
			$pdf->Cell(10,6,$i,1,0,'C');
			$pdf->Cell(45,6,$row['kd_pasok'],1,0,'C');
			$pdf->Cell(45,6,$row['kd_barang'],1,0,'C');
			$pdf->Cell(50,6,$row['nama_barang'],1,0,'C');
			$pdf->Cell(45,6,$row['pemasok'],1,0,'C');
			$pdf->Cell(50,6,$row['tanggal_pasok'],1,0,'C');
			$pdf->Cell(32,6,$row['jumlah'],1,1,'C');

			$i++;
		endforeach;
	else:
		foreach($laporan as $row):
			$pdf->Cell(10,6,$i,1,0,'C');
			$pdf->Cell(45,6,$row['kd_pasok'],1,0,'C');
			$pdf->Cell(45,6,$row['kd_barang'],1,0,'C');
			$pdf->Cell(50,6,$row['nama_barang'],1,0,'C');
			$pdf->Cell(45,6,$row['pemasok'],1,0,'C');
			$pdf->Cell(50,6,$row['tanggal_pasok'],1,0,'C');
			$pdf->Cell(32,6,$row['jumlah'],1,1,'C');

			$i++;
		endforeach;
	endif;

	$pdf->Output('','Laporan Pasok');	
 ?>

 <!-- <script>
 	window.print();
 </script> -->