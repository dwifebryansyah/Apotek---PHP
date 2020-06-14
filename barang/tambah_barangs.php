<?php 
	session_start();

	if(!isset($_SESSION['submit'])){
		header('Location: ../logins.php');
		exit;
	}

	require '../config/koneksi.php';
	require '../config/function.php';

	$nama = "";
	$pemasok = "";
	$ktg = "--Pilih--";
	$satuan = "--Pilih--";
	$harga_beli = "";
	$harga_jual = "";
	$jumlah = "";
	$jumlah_min_error;
	$validasi_nama = true;
	$nama_error_msg = "";
	$validasi_pemasok = true;
	$pemasok_error_msg = "";
	$validasi_hargabeli = true;
	$hargabeli_error_msg = "";
	$validasi_hargajual = true;
	$hargajual_error_msg = "";
	$validasi_jumlah = true;
	$jumlah_error_msg = "";
	
	// SELECT tb_kategori
	$queryKategori = mysqli_query($conn, "SELECT kategori FROM tb_kategori");

	// SELECT tb_satuan
	$querySatuan = mysqli_query($conn, "SELECT satuan FROM tb_satuan");

	if(isset($_POST['tambah'])){

		$nama = $_POST['nama_barang'];
		$pemasok = $_POST['pemasok'];
		$ktg = $_POST['ktg_barang'];
		$satuan = $_POST['satuan'];
		$harga_beli = $_POST['harga_beli'];
		// var_dump($harga_beli);
		// die();
		$harga_jual = $_POST['harga_jual'];
		$jumlah = $_POST['jumlah'];

		// kode validasi nama hanya boleh huruf a-z, A-Z dan spasi
		if(!preg_match("/^[a-zA-Z ]*$/",$nama)){
			$validasi_nama = false;
			$nama_error_msg = "Hanya boleh huruf dan spasi yang diijinkan";
		}

		if(!preg_match("/^[a-zA-Z ]*$/",$pemasok)){
			$validasi_pemasok = false;
			$pemasok_error_msg = "Hanya boleh huruf dan spasi yang diijinkan";
		}

		if(!is_numeric($harga_beli)){
			$validasi_hargabeli = false;
			$hargabeli_error_msg = "Hanya boleh angka saja";
		}

		if(!is_numeric($harga_jual)){
			$validasi_hargajual = false;
			$hargajual_error_msg = "Hanya boleh angka saja";
		}

		if( !is_numeric($jumlah) ){
			$validasi_jumlah = false;
			$jumlah_error_msg = "Hanya boleh angka saja";
		}elseif($jumlah < 0){
			$validasi_jumlah = false;
			$jumlah_error_msg = "kalo nambah gaboleh min";
		}

		// Cek semua input sudah diisi apa belum
		if($validasi_nama and $validasi_pemasok and $validasi_hargabeli and $validasi_hargajual and $validasi_jumlah){

				$table = 'tb_barang';

				if(tambahBarang($_POST,$table) > 0){
					$_SESSION['tampilan'] = "tampilan";
				}else{
					echo "<script>
						alert('nama ada barang sama!');document.location.href = 'tambah_barangs.php';
						</script>";
			}
		}		
	}


 ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
   Tambah Barang
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
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          Apotek Caringin
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li>
            <a href="dashboard.php">
              <i class="now-ui-icons design_app"></i>
              <p>Dashboard</p>
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
              <li class="nav-item">
                <a class="nav-link" href="barangs.php">
                  <i class="now-ui-icons arrows-1_minimal-left"></i>
                  <p>
                  	Back
                  </p>
                </a>
              </li>
             
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
      	<form method="post">
      		<?php if(isset($_SESSION['tampilan'])): ?>
                           <div class="flash-data" data-flashdata="<?= $_SESSION['tampilan'];  ?>"></div>
                        <?php endif; ?>
        <div class="row">
        	<div class="col-md-2">
        		
        	</div>
          	<div class="col-md-8">
            	<div class="card" style="padding: 10px;">
	              	<div class="card-header">
	                	<h4 class="card-title">Tambah Barang</h4>
	              	</div>
	              	<hr>
	              	<div class="card-body">
						<div class="row">
						<div class="col-md-1">
							
						</div>
						<div class="col-md-10">
							<form>
			                  <div class="row">
			                  	<?php 
							  	// KODE OTOMATIS
								$sql_max = mysqli_query($conn, "SELECT MAX(kd_barang) as maximal FROM tb_barang "); // ini hasilnya nyari kd_barang yang terbesar
								$sql1 = mysqli_query($conn, "SELECT * FROM tb_barang"); // ini hasilnya semua data di tb_barang
								$r_max = mysqli_fetch_array($sql_max); // ini hasilnya array kd_barang terbesar
								$num_max = mysqli_num_rows($sql1); // ini hasilnya semua jumlah baris yang ada di tb_barang
								$max_kode = $r_max['maximal']; // ini hasilnya array kd_barang terbesar
								$max_angka = substr($max_kode, 2); // ini hasilnya HANYA ANGKA dari $max_kode
								// var_dump($max_angka);
								// die();
								$max_angka++;

								// CARA LAMBAT (PASTI)
								if($num_max > 0){
									if($max_angka >= 1000){
										$angka_akhir = "B".$max_angka;
									}elseif($max_angka >= 100){
										$angka_akhir = "B0".$max_angka;
									}elseif($max_angka >= 10){
										$angka_akhir = "B00".$max_angka;
									}elseif($max_angka >= 1){
										$angka_akhir = "B000".$max_angka;
									}

								}else{
									$angka_akhir = "B0001";
								}

								
							  	 ?>
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Kode Barang</label>
			                        <input type="text" name="kd_barang" class="form-control" readonly placeholder="kode barang" value="<?= @$angka_akhir; ?>">
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Nama Barang</label>
			                        <input type="text" name="nama_barang" class="form-control" placeholder="Nama Barang" autocomplete="off" value="<?= @$nama ?>">			                        
									<?= @$nama_error_msg; ?>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Kategori Barang</label>
			                        <select name="ktg_barang" class="form-control" required>
								    	<option value="<?= @$ktg; ?>"><?= @$ktg; ?></option>
								    	<?php foreach($queryKategori as $row): ?>
								    		<option value="<?= $row['kategori'] ?>"><?= $row['kategori'] ?></option>
								    	<?php endforeach; ?>
								    </select>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Pemasok</label>
			                        <input type="text" class="form-control" placeholder="Pemasok" name="pemasok" autocomplete="off" value="<?= @$pemasok; ?>">
			                        <?= @$pemasok_error_msg; ?>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Satuan Barang</label>
			                        <select name="satuan" class="form-control" required>
								    	<option value="<?= @$satuan; ?>"><?= @$satuan; ?></option>
								    	<?php foreach($querySatuan as $row): ?>
								    		<option value="<?= $row['satuan'] ?>"><?= $row['satuan'] ?></option>
								    	<?php endforeach; ?>
								    </select>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Harga Beli</label>
			                        <input type="text" class="form-control" autocomplete="off" placeholder="Harga Beli" name="harga_beli" value="<?= @$harga_beli; ?>">
			                        <?= @$hargabeli_error_msg; ?>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Harga Jual</label>
			                        <input type="text" class="form-control" autocomplete="off" placeholder="Harga Jual" name="harga_jual" value="<?= @$harga_jual; ?>">
			                        <?= @$hargajual_error_msg; ?>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Jumlah</label>
			                        <input type="text" class="form-control" autocomplete="off" placeholder="Jumlah" name="jumlah" value="<?= @$jumlah; ?>">
			                        <?= @$jumlah_error_msg; ?>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
				              	<div class="col-md-3">	
				              	</div>
				              	<div class="col-md-6" >
				                   	<button class="btn btn-primary btn-block" name="tambah">Tambah Barang</button>
				                </div>
				              </div>                                  
			                </form>
						</div>
						</div>
						<br><br>
	              	</div>
          		</div>
            </div>
            <div class="col-md-2">
            </div>
          </div>
      </form>
      </div>
      <footer class="footer">
        <div class="container">
          
        </div>
      </footer>
    </div>
  </div>

  <?php unset($_SESSION['tampilan']) ?>

  <!--   Core JS Files   -->
  <script src="../swal/sweetalert2.all.min.js"></script> 
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
  <script>
    const flashData = $('.flash-data').data('flashdata');
    if(flashData){
      swal({
        title: 'Data Barang',
        text: 'Berhasil di tambahkan',
        type: 'success'
      }).then((result) => {
        if (result.value){
          document.location.href='barangs.php';
        }
      });
    }
  </script>
</body>

</html>