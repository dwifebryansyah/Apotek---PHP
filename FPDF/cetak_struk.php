<?php 
	
	require '../config/koneksi.php';

	// koneksi library FPDF
	require 'fpdf.php';
	// setting halaman PDF
	$pdf = new FPDF('L','mm','A4');
	// menambah halaman baru
	$pdf->AddPage();
	// setting jenis font
	$pdf->SetFont('Arial', 'B', 16);
	// membuat string
	$pdf->Cell(10,7,'',0,1);
	$pdf->Cell(10,7,'',0,1);
	$pdf->Cell(192,7,'Struk Pembayaran Apotek Caringin',0,1,'R');
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->Cell(290,7,'Jl.Haji Naik Bubur Dua Kali',0,1,'C');
	$pdf->Cell(289,7,'Telp.(0283) 3317403 / 324861',0,1,'C');
	// setting spasi kebawah supaya tidak rapat
	$pdf->Cell(10,7,'',0,1);

	$tanggal = mktime(date('m'),date('d'),date('Y'));
	$tanggals = date('d-M-Y, ',$tanggal);
	$time = date('ymd');
	date_default_timezone_set('Asia/Jakarta');
	$jam = date("H:i");

	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(87,5,'',0,0);
	$pdf->Cell(25,5,'Tanggal',0,0,'');
	$pdf->Cell(3,5,':',0,0,'');
	$pdf->Cell(50,5,$tanggals.$jam,0,1,'');
	$pdf->Cell(87,5,'',0,0);
	$pdf->Cell(25,5,'Kode Struk',0,0,'');
	$pdf->Cell(3,5,':',0,0,'');
	$pdf->Cell(20,5,'S'.$time,0,1,'');
	$pdf->Cell(87,5,'',0,0);
	$pdf->Cell(130,5,'__________________________________________________________',0,1,'');
	$pdf->Cell(87,5,'',0,0);
	$pdf->Cell(40,5,'Nama Barang',0,0);
	$pdf->Cell(27,5,'',0,0);
	$pdf->Cell(10,5,'Qty',0,0,'R');
	$pdf->Cell(17,5,'Harga',0,0,'R');
	$pdf->Cell(20,5,'Subtotal',0,1,'R');
	$pdf->Cell(87,5,'',0,0);
	$pdf->Cell(100,5,'-------------------------------------------------------------------------------------------------',0,1,'');

	$query = mysqli_query($conn, "SELECT * FROM tb_struk");//1
	$query1 = mysqli_query($conn, "SELECT subtotal,bayar,kembalian FROM tb_struk");//2
	$ambil = mysqli_fetch_assoc($query1);

	while($row = mysqli_fetch_assoc($query)){
	$pdf->Cell(87,5,'',0,0);
	$pdf->Cell(40,5,$row['nama_barang'],0,0,'');
	$pdf->Cell(27,5,'',0,0);
	$pdf->Cell(10,5,$row['jumlah'],0,0,'R');
	$pdf->Cell(17,5,$row['harga'],0,0,'R');
	$pdf->Cell(21,5,$row['total'],0,1,'R');
}

	$pdf->Cell(87,5,'',0,0);
	$pdf->Cell(130,5,'__________________________________________________________',0,1,'');
	$pdf->Cell(87,5,'',0,1);

	for ($i= 1; $i <= 1 ; $i++) { 
	$pdf->Cell(137,5,'',0,0);
	$pdf->Cell(30,5,'Total',0,0,'');
	$pdf->Cell(10,5,':',0,0,'');
	$pdf->Cell(25,5,$ambil['subtotal'],0,1,'R');

	$pdf->Cell(137,5,'',0,0);
	$pdf->Cell(30,5,'Bayar',0,0,'');
	$pdf->Cell(10,5,':',0,0,'');
	$pdf->Cell(25,5,$ambil['bayar'],0,1,'R');
	}

	$pdf->Cell(137,5,'',0,0);
	$pdf->Cell(65,5,'------------------------------------------------------',0,1,'');

	for ($i= 1; $i <= 1 ; $i++) { 
	$pdf->Cell(137,5,'',0,0);
	$pdf->Cell(30,5,'Kembalian',0,0,'');
	$pdf->Cell(10,5,':',0,0,'');
	$pdf->Cell(25,5,$ambil['kembalian'],0,1,'R');
	$pdf->Cell(137,5,'',0,1);	
	}

	$pdf->Cell(137,5,'',0,1);
	$pdf->SetFont('Arial', '', 12);
	$pdf->Cell(87,5,'',0,0);
	$pdf->Cell(90,5,'Terima kasih atas kunjungan anda',0,1,'R');
	$pdf->Cell(87,5,'',0,0);
	$pdf->Cell(97,5,'Semoga anda puas dengan layanan kami',0,1,'R');
	$pdf->Cell(87,5,'',0,0);
	$pdf->Cell(100,5,'------------------------------------------------------------',0,1,'R');
	$pdf->Cell(87,5,'',0,0);
	$pdf->SetFont('Arial', 'I', 12);
	$pdf->Cell(68,5,'"Pembeli Adalah',0,0,'R');
	$pdf->Cell(20,5,'Raja"',0,0,'');


	$pdf->Output('','laporan');	

	$clearTable = mysqli_query($conn, "TRUNCATE TABLE tb_struk");//3
 ?>

 <!-- <script>
 	window.print();
 </script> -->