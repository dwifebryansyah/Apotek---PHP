<?php 

	session_start();

  if(!isset($_SESSION['submit'])){
    header('Location: logins.php');
    exit;
  }

	require '../config/koneksi.php';
	require '../config/function.php';

	$kodeK = kodeOtomatis('kd_kategori','tb_kategori','K');
	$kategori = "";
	$kategoriErr = "";
	$kategoriValidasi = true;
	$kategoriMsg = "";

	if(isset($_POST['tambah'])){

		$kategori = trim($_POST['kategori']);
		$table = 'tb_kategori';

		if(empty($kategori)){
			$kategoriErr = "Kategori tidak boleh kosong";
		}

		if(!preg_match("/^[a-zA-Z ]*$/",$kategori)){
			$kategoriValidasi = false;
			$kategoriMsg = "Hanya boleh huruf dan spasi yang diijinkan";
		}

		if($kategoriValidasi and !empty($kategori)){

			if(tambahKategori($_POST, $table) > 0){
        $_SESSION['tampilan'] = "tampilan";
			}else{
				echo "<script>
						alert('gagal');
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
   Tambah Kategori
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
            <a href="tambah_kategoris.php">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>Tambah Kategoris</p>
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
                <a class="nav-link" href="kategoris.php">
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
        	<div class="col-md-2">
        		
        	</div>
          	<div class="col-md-8">
            	<div class="card" style="padding: 10px;">
	              	<div class="card-header">
	                	<h4 class="card-title">Tambah Kategori</h4>
	              	</div>
	              	<hr>
	              	<div class="card-body">
						<div class="row">
						<div class="col-md-1">
							
						</div>
						<div class="col-md-10">
							<form method="post">
                        <?php if(isset($_SESSION['tampilan'])): ?>
                           <div class="flash-data" data-flashdata="<?= $_SESSION['tampilan'];  ?>"></div>
                        <?php endif; ?>
			                  <div class="row">
			                  	<div class="col-md-2"></div>
			                    <div class="col-md-8 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Kode Kategori</label>
			                        <input type="text" class="form-control" name="kd_barang" readonly value="<?= $kodeK ?>">
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-2"></div>
			                    <div class="col-md-8 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Kategori</label>
			                        <input type="text" class="form-control" name="kategori" value="<?= @$kategori; ?>">
                              <?= $kategoriErr.$kategoriMsg ?>
			                      </div>
			                    </div>
			                  </div>
			                  <div class="row">
				              	<div class="col-md-3">	
				              	</div>
				              	<div class="col-md-6" >
				                   	<button class="btn btn-primary btn-block" name="tambah" id="tambah">Tambah Kategori</button>
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
        title: 'Data Kategori',
        text: 'Berhasil di tambahkan',
        type: 'success'
      }).then((result) => {
        if (result.value){
          document.location.href='kategoris.php';
        }
      });
    }
  </script>

</body>

</html>