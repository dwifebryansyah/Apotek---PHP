<?php 
	session_start();

	require '../config/koneksi.php';
	require '../config/function.php';

	 if(!isset($_SESSION['submit'])){
    header('Location: ../logins.php');
    exit;
  }

	$jumlah = "";
	$validasi_jumlah = true;
	$jumlah_error_msg = "";
	$bayar = "";
  $bayarErorr = "";
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

      $sql = mysqli_query($conn, "SELECT * FROM tb_barang WHERE nama_barang = '$_SESSION[nama_barang]' ");
      $result = mysqli_fetch_assoc($sql);

      $jumlahDatabase = $result['jumlah'];
      $cekJumlah = $jumlah <= $jumlahDatabase;

      if( $jumlah == 0 ){
        echo "<script>
          alert('Tidak boleh memasukan jumlah 0');
        </script>";
      } elseif($jumlah < 0){
        $validasi_jumlah = false;
        $jumlah_error_msg = "kalo nambah gaboleh min";
      } elseif ( $cekJumlah ){
        
        if(!is_numeric($jumlah)){
          $validasi_jumlah = false;
          $jumlah_error_msg = "Hanya boleh angka saja";
      }

      // Cek semua input sudah diisi apa belum
      if($validasi_jumlah){

        if(pilihBarang($_POST) > 0){
          echo "<script>
                alert('Berhasil');document.location.href = '../transaksi/transaksi_barangs.php';
              </script>";
          }else{
            echo "<script>
              alert('Gagal');
            </script>";
          }
        }

      }else{
        echo "<script>
          alert('Jumlah barang di stok tidak mencukupi');
        </script>";
      }

		}
	}

	//Selesai Belanja
	if(isset($_POST['selesai'])){
    $hitung = selesaiBelanja("SELECT SUM(total) AS totalAkhir FROM tb_keranjang ");
		$tanggal = date('Y-m-d');

		$sql = mysqli_query($conn, "SELECT * FROM tb_keranjang");//2
		$ambil = mysqli_fetch_all($sql);

		$row = mysqli_num_rows($sql);
		$rows = $row - 1;

		if( @$_POST['totals'] == null ){
			$pilihErrr = "Harus di isi semua";
			echo "<script>
					alert('$pilihErrr');
				</script>";
		}else{

  			$sql5 = "SELECT SUM(subtotal) AS subtotal FROM tb_struk WHERE subtotal = '0' ";//1
  			$query2 = mysqli_query($conn, $sql5);
  			$ambil2 = mysqli_fetch_assoc($query2);
  			$subtotal = $ambil2;

  			if( $subtotal['subtotal'] == 0 ){

          $sql = mysqli_query($conn, "SELECT * FROM tb_struk");
          $ambils = mysqli_fetch_all($sql);

          $rowStruk = mysqli_num_rows($sql);
          $rowsStruk = $rowStruk - 1;

          for ($i=0; $i <= $rowsStruk; $i++) { 

            $id = $ambils[$i]['0'];
            $jumlah = $ambils[$i]['3'];
            $nama = $ambils[$i]['1'];

            $sql1 = mysqli_query($conn, "SELECT * FROM tb_barang WHERE nama_barang = '$nama' ");
            $ambil1 = mysqli_fetch_assoc($sql1);
            $jumlahBarang = $ambil1['jumlah'];

            $jumlahAkhir = $jumlahBarang + $jumlah;

            $sql2 = "UPDATE tb_barang SET jumlah = '$jumlahAkhir' WHERE nama_barang = '$nama' ";
            $cek = mysqli_query($conn, $sql2);

            $sql6 = mysqli_query($conn, "DELETE FROM tb_struk WHERE id = '$id' ");


          }

          

  				for ($i=0; $i <= $rows; $i++) { 

  				$kode = $ambil[$i]['2'];
  				$nama = $ambil[$i]['1'];
  				$ktg = $ambil[$i]['3'];
  				$harga = $ambil[$i]['4'];
  				$jumlah = $ambil[$i]['5'];
  				$total = $ambil[$i]['6'];

  				$sql7 = mysqli_query($conn, " INSERT INTO tb_struk (nama_barang,harga,jumlah,total) VALUES ('$nama','$harga','$jumlah','$total') ");//3
  				}

  			}else{

  			for ($i=0; $i <= $rows; $i++) { 

  			$kode = $ambil[$i]['2'];
  			$nama = $ambil[$i]['1'];
  			$ktg = $ambil[$i]['3'];
  			$harga = $ambil[$i]['4'];
  			$jumlah = $ambil[$i]['5'];
  			$total = $ambil[$i]['6'];

  			$sql8 = mysqli_query($conn, " INSERT INTO tb_struk (nama_barang,harga,jumlah,total) VALUES ('$nama','$harga','$jumlah','$total') ");//4

  									}
			}

		}

	}

	// Membayar
	if(isset($_POST['membayar'])){
    
		$total = $_POST['total'];
		$bayar = $_POST['bayar']; 

		if(!is_numeric($bayar)){
      $_SESSION['total'] = $total;
			$validasi_bayar = false;
			$bayar_error_msg = "Hanya boleh angka saja/tidak boleh kosong";
		}elseif (empty($bayar)) {
      $bayarErorr = "Bayar tidak boleh kosong";
    }


		// Cek semua input sudah diisi apa belum
		if($validasi_bayar and !empty($bayar)){

      $cek = $bayar < $total;
      // var_dump($cek);
      // die();

      if($cek){
        $_SESSION['total'] = $total;
          echo "<script>
          alert('Uang anda tidak cukup');
        </script>";
      }else{
          $membayar = $bayar - $total;
          $tanggal = date('Y-m-d');

          $sql2 = mysqli_query($conn, "SELECT * FROM tb_keranjang");//2
          $ambil = mysqli_fetch_all($sql2);

          $row = mysqli_num_rows($sql2);
          $rows = $row - 1;

          // var_dump($rows);
          // die();

          //$kodeLT = kodeOtomatis('kd_laporan_transaksi','tb_laporan_transaksi','LT');
          $kodeT = kodeOtomatis('kd_transaksi','tb_transaksi','T');

          for ($i=0; $i <= $rows; $i++) { 

          $kode = $ambil[$i]['2'];
          $nama = $ambil[$i]['1'];
          $ktg = $ambil[$i]['3'];
          $harga = $ambil[$i]['4'];
          $jumlah = $ambil[$i]['5'];
          $total = $ambil[$i]['6'];

          // ngambil data arraynya
          $sql1 = "SELECT * FROM tb_barang WHERE kd_barang = '$kode' ";
          $query = mysqli_query($conn, $sql1);
          $query1 = mysqli_fetch_assoc($query);
          $jumlah_awal = $query1['jumlah'];// jumlah  awal

          // ubah jumlah data
          $jumlah_akhir = $jumlah_awal - $jumlah;// jumlah akhir
            
          // masukin data ke tabel transaksi
          $sql3 = "INSERT INTO tb_transaksi VALUES ('$kodeT','$kode','$nama','$ktg','$tanggal','$harga','$jumlah_awal','$jumlah_akhir','$jumlah','$total' ) ";
          $qry = mysqli_query($conn, $sql3);
          // var_dump($sql3 );
          //   die();

        }

          $query = "UPDATE tb_struk SET subtotal = '$total', bayar = '$bayar', kembalian = '$membayar', tanggal = '$_POST[tanggal_transaksi]' ";//5
          $sql = mysqli_query($conn, $query );

           $sql9 = mysqli_query($conn, "TRUNCATE TABLE tb_keranjang");//3
      }
		}
	}

	//CETAK
	if(isset($_POST['cetak'])){
    
		$query = mysqli_query($conn, "TRUNCATE TABLE tb_struk");//6
	}

  // cancel transaksi
  if(isset($_POST['cancel'])) {
    $sql = " SELECT * FROM tb_keranjang ";
    $query = mysqli_query($conn, $sql);
    $ambil = mysqli_fetch_all($query);
    $rows = mysqli_num_rows($query);

    
    for ($i=0; $i <= $rows-1; $i++) { 

        $kode = [];
        $kode = $ambil[$i]['2'];

        $sql1 = "DELETE FROM tb_keranjang WHERE kd_barang = '$kode' ";
        $query1 = mysqli_query($conn, $sql1);

        // var_dump($query1);
        // die();
    }

   echo "<script>
          alert('data tercancel');
        </script>";

  }

	$pilihErrr = "";

	$sql = "SELECT * FROM tb_barang";
	$query = mysqli_query($conn, $sql);

	$sql2 = "SELECT * FROM tb_keranjang";//4
	$query2 = mysqli_query($conn, $sql2);

 ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
   Transaksi Barang
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/now-ui-dashboard.css?v=1.2.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="orange">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
         <a href="../dashboard.php" class="simple-text text-center logo-normal">
          <img src="../assets/img/apotek1.png" width="70px" alt=""><br> Apotek Caringin
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li>
            <a href="../dashboard.php">
              <i class="now-ui-icons design_app"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="active ">
            <a href="transaksi_barangs.php">
              <i class="now-ui-icons shopping_cart-simple"></i>
              <p>Transaksi Barang</p>
            </a>
          </li>        
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg fixed-top navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo">Apotek Caringin</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            
            <ul class="navbar-nav">
              </li>
               <li class="nav-item">
                <a class="nav-link" href="transaksi_barangs.php">
                  <i class="now-ui-icons arrows-1_refresh-69"></i>
                  <p>
                    Refresh
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../dashboard.php">
                  <i class="now-ui-icons arrows-1_minimal-left"></i>
                  <p>
                  	Back
                  </p>
                </a>

            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">

      	<div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="title">Transaksi Barang</h5>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-10">
            <div class="card">
              <div class="card-header">
                <h5 class="title">Ayo Bayar</h5>
              </div>
              <div class="card-body">
                <form method="post">

                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>Nama Barang</label>
                        <select name="nama_barang" class="form-control" onchange="this.form.submit()">
                        <option selected value="">--Pilih--</option>
                        <?php foreach($query as $ambil): ?>
                          <option value="<?= $ambil['nama_barang']; ?>"><?= $ambil['nama_barang'] ?></option>
                          <?php if( $ambil['nama_barang'] == $output){ ?>
                          <option selected value="<?= @$output ?>"><?= @$output ?></option>
                          <?php } ?>
                        <?php endforeach; ?>
                        <option value="">Reset</option>
                      </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-3 pr-1">
                      <div class="form-group">
                        <label>Kode Barang</label>
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
                    </div>
                    <div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label>Kategori</label>
                        <input type="text" class="form-control" name="ktg_barang" readonly value="<?= @$result['kategori_barang'] ?>">
                      </div>
                    </div>
                    <div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label>Harga</label>
                        <input type="text" class="form-control" name="harga" readonly value="<?= @$result['harga_jual']; ?>" >
                      </div>
                    </div>
                  </div>

        				  <div class="row">
        					<div class="col-md-3 pr-1">
                      <div class="form-group">
                        <label>Jumlah</label>
                        <?php if( @$_POST['nama_barang'] == !null ){ ?>
                          <input type="text" class="form-control" name="jumlah" value="<?= @$jumlah; ?>" required>
                          <?= $jumlah_error_msg ?>
                        <?php }else{ ?>
                        <input type="text" class="form-control" name="jumlah" value="" readonly>
                        <?php } ?>
                      </div>
                    </div>
				        <div class="col-md-2 mt-3" >
  				     	  <button class="btn btn-info btn-block" name="pilih">Pesan</button>
  			        </div>
				      </div>
            </form>
          </div>
        </div>
      </div>
    </div>
        <form method="post">
      	<div class="row">

      		<div class="col-md-8">
            <div class="card p-2">
            	<div class="card-header">
                	<h5 class="card-title">Table Barang</h5>
              	</div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table" style="font-size: 13px;">
                    <thead class=" text-muted">
                    	<tr>
	                    	<th>No</th>
	                    	<th>Nama</th>
	                    	<th>Kode</th>
                        <th>Kategori</th>
	                    	<th>Harga</th>
	                    	<th>Jumlah</th>
	                    	<th>Subtotal</th>
	                    	<th>Aksi</th>
                    	</tr>
                    </thead>
                    <tbody>
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
                          <input type="text" class="form-control" name="totals" style="font-size: 10px; text-align: center; width: 80px;" value="<?= $row['total'] ?>" readonly>
                        </td>
                        <td>
                          <?php if(isset($_POST['selesai'])): ?>
                            <a onclick="return confirm('yakin ingin mencancel?');" class="btn btn-danger disabled" disabled href="cancel_transaksi.php?hapus=<?= $row['kd_barang']; ?>&jumlah=<?= $row['jumlah'] ?>">Cancel</a>
                          <?php else: ?>
                            <a onclick="return confirm('yakin ingin mencancels?');" class="badge badge-danger p-1" href="cancel_transaksi.php?hapus=<?= $row['kd_barang']; ?>&jumlah=<?= $row['jumlah'] ?>">Cancel</a>
                          <?php endif; ?>
                        </td>
                    	</tr>
                      <?php $i++ ?>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
             	</div>
              </div>      
          	</div>
            
          	<div class="row">
              	<div class="col-md-9">	
              	</div>
              	<div class="col-md-3" >
                   	<input class="btn btn-info" type="submit" name="selesai" value="Selesai">
                </div>
              </div>
            
          </div>
  
    <!-- isi konten 2 -->

          <div class="col-md-4">
          	<div class="card p-3">
              <div class="card-body">
              	<div class="row">
	                <div class="col-md-5 pr-1">
	                   <div class="form-group">
	                     <label>Total</label>
	                     <?php if( isset($_POST['membayar']) ){ ?>
                        <input type="text" class="form-control" name="total" readonly value="<?= @$_SESSION['total'] ?>">
                      <?php }else{ ?>
                      <input type="text" class="form-control" name="total" readonly value="<?= @$hitung['totalAkhir'] ?>">
                      <?php } ?>
	                   </div>
                  </div>
                  <div class="col-md-5 pr-1">
                    <div class="form-group">
                      <label>Bayar</label>
                      <?php if( isset($_POST['membayar']) and !is_numeric(@$_POST['bayar']) ) { ?>
                        <input type="text" class="form-control" name="bayar" value="<?= @$bayar;?>" >
                        <?= $bayar_error_msg.$bayarErorr ?>
                      <?php }elseif ( isset($_POST['selesai']) and !is_null(@$_POST['totals']) and !is_null(@$_POST['total']) ) { ?>
                      <input type="text" class="form-control" name="bayar" value="<?= @$bayar;?>">
                        <?= $bayar_error_msg.$bayarErorr; ?>
                      <?php }elseif ( is_numeric(@$_POST['bayar']) and @$cek ) { ?>
                      <input type="text" class="form-control" name="bayar" value="<?= @$bayar;?>" >
                      <?= $bayar_error_msg.$bayarErorr; ?>
                      <?php }else{ ?>
                      <input type="text" class="form-control" name="bayar" value="<?= @$bayar; ?>" readonly>
                      <?= $bayar_error_msg.$bayarErorr; ?>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3 pl-1 ml-3" >
				     	      <?php if( isset($_POST['selesai']) and @$_POST['totals'] == !null ){ ?>
                      <input class="btn btn-success" type="submit" name="membayar" value="Buy">
                    <?php } elseif ( isset($_POST['membayar']) and !is_numeric(@$_POST['bayar']) ) { ?>
                      <input class="btn btn-success" type="submit" name="membayar" value="Buy">

                    <?php } elseif ( isset($_POST['membayar']) and @$cek ) { ?>
                      <input class="btn btn-success" type="submit" name="membayar" value="Buy">

                    <?php }else{ ?>
                    <input class="btn btn-success" type="submit" name="membayar" disabled="disabled" value="Buy">
                    <?php } ?>
			           </div>
                 <div class="col-md-3 pl-1 ml-3" >
                    <?php if( isset($_POST['selesai']) and @$_POST['totals'] == !null ){ ?>
                      <input class="btn btn-danger" type="submit" name="cancel" value="Cancel Transaksi">
                    <?php } elseif ( isset($_POST['membayar']) and !is_numeric(@$_POST['bayar']) ) { ?>
                      <input class="btn btn-danger" type="submit" name="cancel" value="Cancel Transaksi">

                    <?php } elseif ( isset($_POST['membayar']) and @$cek ) { ?>
                      <input class="btn btn-danger" type="submit" name="cancel" value="Cancel Transaksi">

                    <?php }else{ ?>
                    <input class="btn btn-danger" type="submit" name="cancel" disabled="disabled" value="Cancel Transaksi">
                    <?php } ?>
                 </div>
                </div>
                <div class="row">
                	<div class="col-md-5 pr-1">
	                      <div class="form-group">
	                        <label>Kembalian</label>
	                        <input type="text" class="form-control" name="kembalian" value="<?= @$membayar ?>" readonly style="font-size: 14px;">
	                </div>
                    </div>
                    <div class="col-md-5 pr-1">
                      <div class="form-group">
                        <label>Tanggal</label>
                        <?php $tanggal = date('Y-m-d'); ?>
                          <input type="text" class="form-control" name="tanggal_transaksi" readonly value="<?= $tanggal; ?>" style="font-size: 13px;">
                      </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-md-3 pl-1 ml-3" >
				            <?php if( isset($_POST['membayar']) and @$cek ){ ?>
                      <a href="../FPDF/cetak_struk.php" class="btn btn-primary disabled" style="color: white;">
                      Cetak
                    </a>
                    <?php } elseif ( isset($_POST['membayar']) ) { ?>
                      <a href="../FPDF/cetak_struk.php" class="btn btn-primary  " >
                    Cetak
                    </a>
                    <?php }else{ ?>
                      <a href="../FPDF/cetak_struk.php" class="btn btn-primary disabled " style="color: ghostwhite;" >
                      Cetak
                      </a>
                    <?php } ?>
			           </div>
                </div>

              </div>
              </form>
          	</div>
          </div>

        </div>
     </div>

      <footer class="footer">
        <div class="container">
          
        </div>
      </footer>
    </div>
  </div>

  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/now-ui-dashboard.min.js?v=1.2.0" type="text/javascript"></script>
  <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
</body>

</html>