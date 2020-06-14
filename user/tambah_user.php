<?php 
	session_start();

	if(!isset($_SESSION['submit'])){
		header('Location: logins.php');
		exit;
	}

	require '../config/koneksi.php';
	require '../config/function.php';

	$nama_depan = "";
	$nama_belakang = "";
	$email = "";
	$no_hp = "";
	$username = "";
	$password = "";
	$passkonfirm = "";
	$validasi_nama_depan = true;
	$nama_depan_error_msg = "";
	$validasi_nama_belakang = true;
	$nama_belakang_error_msg = "";
	$validasi_email = true;
	$email_error_msg = "";
	$validasi_nohp = true;
	$nohp_error_msg = "";
	$validasi_user = true;
	$user_error_msg = "";
	$validasi_panjang_pass = true;
	$pass_panjang_error_msg = "";
	$validasi_pass = true;
	$pass_error_msg = "";

	$_SESSION['pass'] = $password;

	if(isset($_POST['tambah'])){

		$kode = $_POST['kd_user'];
		$nama_depan = $_POST['nama_depan'];
		$nama_belakang = $_POST['nama_belakang'];
		$email = $_POST['email'];
		$no_hp = $_POST['no_hp'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$passkonfirm = $_POST['passkonfirm'];

		// kode validasi nama hanya boleh huruf a-z, A-Z dan spasi
		if(!preg_match("/^[a-zA-Z ]*$/",$nama_depan)){
			$validasi_nama_depan = false;
			$nama_depan_error_msg = "Hanya boleh huruf dan spasi yang diijinkan";
		}

		if(!preg_match("/^[a-zA-Z ]*$/",$nama_belakang)){
			$validasi_nama_belakang = false;
			$nama_belakang_error_msg = "Hanya boleh huruf dan spasi yang diijinkan";
		}

		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$validasi_email = false;
			$email_error_msg = "format email salah";
		}

		if(!is_numeric($no_hp)){
			$validasi_nohp = false;
			$nohp_error_msg = "Only can number and must 10 digits";
		}

		if(!preg_match("/^[a-zA-Z]*$/",$username)){
			$validasi_user = false;
			$user_error_msg = "Hanya boleh huruf dan spasi yang diijinkan";
		}

		if(strlen($password) < 8){
			$validasi_panjang_pass = false;
			$pass_panjang_error_msg = "Panjang pass min 8 digit";
		}

		if($password != $passkonfirm){
			$validasi_pass = false;
			$pass_error_msg = "pass konfirmasi tidak sama";
		}

		// Cek semua input sudah diisi apa belum
		if($validasi_nama_depan and $validasi_nama_belakang and $validasi_email and $validasi_nohp and $validasi_user and $validasi_panjang_pass and $validasi_pass){

				$table = 'tb_user';

				if(tambahUser($_POST,$table) > 0){
					echo "<script>
							alert('berhasil');document.location.href = 'user.php';
						</script>";
				}else{
					echo "<script>
						alert('nama ada barang sama!');document.location.href = 'tambah_user.php';
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
   Tambah User
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
            <a href="tambah_user.php">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Tambah User</p>
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
                <a class="nav-link" href="user.php">
                  <i class="now-ui-icons users_single-02"></i>
                  <p>
                  	Lihat User
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
        <div class="row">
        	<div class="col-md-1"></div>
          	<div class="col-md-10">
            	<div class="card" style="padding: 10px;">
	              	<div class="card-header">
	                	<h4 class="card-title">Tambah User</h4>
	              	</div>
	              	<hr>
	              	<div class="card-body">
						<div class="row">
						<div class="col-md-1">
							
						</div>
						<div class="col-md-10">
							<form method="post">
			                  <div class="row">
			                  	<?php 
							  	// KODE OTOMATIS
								$sql_max = mysqli_query($conn, "SELECT MAX(kd_user) as maximal FROM tb_user "); // ini hasilnya nyari kd_barang yang terbesar
								$sql1 = mysqli_query($conn, "SELECT * FROM tb_user"); // ini hasilnya semua data di tb_barang
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
										$angka_akhir = "U".$max_angka;
									}elseif($max_angka >= 100){
										$angka_akhir = "U0".$max_angka;
									}elseif($max_angka >= 10){
										$angka_akhir = "U00".$max_angka;
									}elseif($max_angka >= 1){
										$angka_akhir = "U000".$max_angka;
									}

								}else{
									$angka_akhir = "U0001";
								}

								
							  	 ?>
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-10">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Kode User</label>
			                        <input type="text" name="kd_user" class="form-control" readonly value="<?= @$angka_akhir; ?>">
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-5">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Nama Depan</label>
			                        <input type="text" name="nama_depan" autocomplete="off" class="form-control" required placeholder="Nama Depan" value="<?= @$nama_depan; ?>">
			                        <?= $nama_depan_error_msg ?>
			                      </div>
			                    </div>
			                  
			                  	
			                    <div class="col-md-5">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Nama Belakang</label>
			                        <input type="text" name="nama_belakang" autocomplete="off" class="form-control" required placeholder="Nama Belakang" value="<?= @$nama_belakang; ?>">
			                        <?= $nama_belakang_error_msg ?>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-5">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Email</label>
			                        <input type="te" class="form-control" autocomplete="off" placeholder="Email" name="email" required value="<?= @$email; ?>">
			                        <?= $email_error_msg ?>
			                      </div>
			                    </div>
			                 
			                    <div class="col-md-5">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">No Hp</label>
			                        <input type="tel" class="form-control" autocomplete="off" placeholder="xxxxxxxxxx" pattern="^\d{10}$" required name="no_hp" value="<?= @$no_hp; ?>">
			                        <?= $nohp_error_msg ?>     
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-10">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Username</label>
			                        <input type="text" class="form-control" autocomplete="off" placeholder="Username" required name="username" value="<?= @$username; ?>">
			                        <?= $user_error_msg ?>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-10">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Password</label>
			                        <input type="password" class="form-control" placeholder="Password" required name="password" value="<?= @$password; ?>">
			                        <?= $pass_panjang_error_msg ?>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-10">
			                      <div class="form-group">			                    
										<label style="font-size: 15px;" >Re-Password</label>
				                        <input type="password" class="form-control" required placeholder="re pass" name="passkonfirm" value="<?= @$passkonfirm; ?>">
				                        <?= $pass_error_msg ?>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
				              	<div class="col-md-3">	
				              	</div>
				              	<div class="col-md-6" >
				                   	<button class="btn btn-primary btn-block" name="tambah">Tambah User</button>
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