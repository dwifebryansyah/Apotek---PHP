<?php 
  session_start();

   if(!isset($_SESSION['submit'])){
    header('Location: ../logins.php');
    exit;
  }

	require '../config/koneksi.php';
	require '../config/function.php';

	$laporan = tampil("SELECT * FROM laporan_pasok ORDER BY kd_pasok DESC");


	if(isset($_POST['search'])){
    // var_dump($_POST);
    // die();
		$table = 'laporan_pasok';
		$kode = 'kd_pasok';
		$params = ['kd_barang','nama_barang','pemasok'];

    $laporan = cari($_POST['tsearch'], $table, $kode, $params);
	}

  if(isset($_POST['cari'])){
    $dari = $_POST['dari'];
    $sampai = $_POST['sampai'];
    $between = ['dari'=>$dari,'sampai'=>$sampai];
    $table = 'laporan_pasok';
    $tanggal = 'tanggal_pasok';
    $kode = 'kd_pasok';
    $nama = 'nama_barang';
    $laporan = cari2($between, $table, $kode, $nama, $tanggal);

  }

  $_SESSION['laporan'] = $laporan;
 

 ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
   Laporan Pasoks
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
        <a href="dashboard.php" class="simple-text text-center logo-normal">
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
            <a href="laporan_pasoks.php">
              <i class="now-ui-icons files_paper"></i>
              <p>Laporan Pasok</p>
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
            <!-- search -->
            <form method="post">  
            <ul class="navbar-nav">
              <li class="nav-item">
                 <div class="input-group no-border mt-1">
                    <input type="text" name="tsearch" class="form-control" placeholder="Search...">
                    <div class="input-group-append">
                      <div class="input-group-text">                  
                      </div>
                    </div>
                  </div>
              </li>
              <li class="nav-item">
                <input type="submit" class="btn btn-info btn-sm" name="search" value="Cari" style="font-size: 13px; border-radius: 12px;">
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../laporan/home_laporans.php">
                  <i class="now-ui-icons arrows-1_minimal-left"></i>
                  <p>
                  	Back
                  </p>
                </a>
              </li>
              	
            </ul>
             </form>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <form method="post">
      <div class="panel-header panel-header-sm">
      </div>
      <br>
      <div class="content">
        <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  
                  <div class="col-md-3">
                    <h5 class="text-info">Cari Berdasarkan Tanggal :</h5>
                  </div>
                  <div class="col-md-3">
                    <label>Dari</label>
                    <input type="date" name="dari" class="form-control">
                  </div>
                
                  <div class="col-md-3">
                    <label>Sampai</label>
                    <input type="date" name="sampai" class="form-control">
                  </div>

                  <div class="col-md-1 mt-3">
                    <button class="btn btn-primary" name="cari">Cari</button>
                  </div>
                  
                  
              </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card" style="padding: 10px;">
              <div class="card-header">
                <h4 class="card-title">Table Laporan Pasok</h4>
              </div>
              <div class="card-body">
              	<div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                    	<tr>
	                    	<th>No</th>
	                    	<th>&nbsp;&nbsp;&nbsp;&nbsp;Kode Pasok</th>
	                    	<th>&nbsp;&nbsp;&nbsp;&nbsp;Kode Barang</th>
                        <th>Nama Barang</th>
	                    	<th>Pemasok</th>
	                    	<th>&nbsp;&nbsp;&nbsp;&nbsp;Tanggal Pasok</th>
	                    	<th>&nbsp;&nbsp;Jumlah</th>	                   
                    	</tr>
                    </thead>
                    <tbody>
                      <?php $i= 1; ?>
                      <?php foreach($laporan as $row): ?>
                    	<tr>
	                    	<th scope="row"><?= $i ?></th>
                        <td align="center"><?= $row['kd_pasok']; ?></td>
                        <td align="center"><?= $row['kd_barang']; ?></td>
                        <td><?= $row['nama_barang']; ?></td>
                        <td><?= $row['pemasok']; ?></td>
                        <td align="center"><?= $row['tanggal_pasok']; ?></td>
                        <td align="center"><?= $row['jumlah']; ?></td>
                        
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
                   <a href="../FPDF/cetak_pasok.php" class="btn btn-primary btn-block">
                    Cetak
                  </a>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
      </form>
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