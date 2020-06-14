<?php 
	session_start();

	if(!isset($_SESSION['submit'])){
		header('Location: logins.php');
		exit;
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/qq.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Dashboard</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="assets/css/now-ui-dashboard.css?v=1.2.0" rel="stylesheet"/>
        <link rel="stylesheet" href="assets/css/animate.css">
        <link href="assets/demo/demo.css" rel="stylesheet" />
    <script src="assets/js/core/jquery.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/js/now-ui-dashboard.min.js?v=1.2.0" type="text/javascript"></script>
</head>
<body class="">
  <!-- SIDE BAR  -->
    <div class="sidebar" data-color="orange">
      <div class="logo">
        <a href="dashboard.php" class="simple-text text-center logo-normal">
          <img src="assets/img/apotek1.png" width="70px" alt=""><br> Apotek Caringin
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="active ">
            <a href="dashboard.php">
              <i class="now-ui-icons design_app"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="user/tambah_user.php">
              <i class="now-ui-icons users_single-02"></i>
              <p>Tambah User</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">

<!-- NAVBAR -->
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
      <a class="navbar-brand" href="dashboard.php" style="font-size: 22px;">Dashboard</a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-bar navbar-kebab"></span>
      <span class="navbar-toggler-bar navbar-kebab"></span>
      <span class="navbar-toggler-bar navbar-kebab"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navigation">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="now-ui-icons users_single-02"></i>
            <p>
              <span class="d-lg-none d-md-block">Some Actions</span>
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="logouts.php" onclick="return confirm('Anda ingin keluar?')">Logout</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- ISI KONTENNYA -->

      <div class="panel-header panel-header-sm animated fadeInDown"></div>
		
		<!-- satu -->
      <div class="content">
        <div class="row">
          <div class="col-lg-4">
            <div class="card card-chart animated fadeInLeft">
              <div class="card-header">
                <h4 class="card-title">
                  <img src="assets/img/Edit.png" width="50px" alt="">
                  Barang
                </h4><hr>
                <div class="">
                  <h5>Lihat, Ubah, Hapus, Tambah data barang disini</h5>
                </div>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <a href="barang/barangs.php" class="btn btn-primary btn-block btn-sm text-white text-monospace">Ubah data</a>
                </div>
                 <!-- 1 -->
              </div>
            </div>
          </div>
			
		<!-- dua -->
          <div class="col-lg-4 col-md-6">
            <div class="card card-chart animated fadeInDown">
              <div class="card-header">
                <h4 class="card-title">
                  <img src="assets/img/icon3.png" width="50px" alt="">
                  Transaksi
                </h4><hr>
                <div class="">
                    <h5>Pembelian barang dan cetak struk bisa di lakukan disini </h5>
                </div>
              </div>
              <div class="card-footer">
                <div class="stats">
                    <a href="transaksi/transaksi_barangs.php" class="btn btn-primary btn-block btn-sm text-white text-monospace">Transaksi</a>
                </div>
              </div>
            </div>
          </div>

          <!-- tiga -->
          <div class="col-lg-4 col-md-6">
            <div class="card card-chart animated fadeInRight">
              <div class="card-header">
                <h4 class="card-title">
                  <img src="assets/img/laporan1.png" width="50px" alt="">
                  Laporan
                </h4><hr>
                <div class="">
                  <h5>
                    Melihat data laporan transaksi dan laporan pasok
                  </h5>
                </div>
              </div>
              <div class="card-footer">
                <div class="stats">
                    <a href="laporan/home_laporans.php" class="btn btn-primary btn-block btn-sm text-white text-monospace">Lihat Laporan</a>
                </div>
              </div>
            </div>
          </div>
        </div>
		
		<!-- isi kontek ke-2 -->
		<div class="content">
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h5 class="title">Profile Apotek</h5>
                <hr>
              </div>
              <div class="card-body">
                <div class="jumbotron">
                  <h2 class="display-4">Selamat Datang Di Apotek Caringin</h2>
                  <p class="lead">Disini kami menyediakan beberapa obat atau hal hal lainnya.</p>
                  <hr class="my-2">
                  <p>It uses utility classes for typography and spacing to space content out container.</p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card card-user">
              <div class="image">
                <img src="assets/img/bg5.jpg" alt="...">
              </div>
              <div class="card-body">
                <div class="author">
                 
                    <img class="avatar border-gray" src="assets/img/df.png" alt="...">
                    <h5 class="title text-primary">Apotek Caringin</h5>
                
                  <p class="description text-muted">
                    Anda Sembuh Kami Senang
                  </p>
                </div>
                <p class="description text-center text-muted">
                  Kabupaten Bogor, Kecamatan Caringin
                  <br>JL. Raya Ciawi - Sukabumi
                  <br> Pasar Caringin
                </p>
                <p class="description text-center text-muted blockquote blockquote-muted">
                  Contact Us: 822-323-1096
                  <br>&copy; Dimas Roger Widianto, Dwi Febryansyah
                </p>
                
              </div>
            </div>
          </div>
        </div>
      </div>


        <div class="row">

	<div class="container animated fadeInUp">
  		<div class="content">
    		<div class="row">
        </form>
      </div>
  </div>
  </div>
                    
        </div>
    </div>
    <footer class="footer animated fadeInRight">
       
        </div>
    </footer>
</div>
<!-- </div> -->
</body>
</html>
