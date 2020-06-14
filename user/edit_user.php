<?php 
	session_start();

	if(!isset($_SESSION['submit'])){
		header('Location: ../logins.php');
		exit;
	}

	require '../config/koneksi.php';
	require '../config/function.php';

	$id = $_GET['edit'];

	$user = tampil("SELECT * FROM tb_user WHERE kd_user = '$id' ")[0];
	$cekUser =  $user['username'] == "SuperAdmin";
	$cekPass =  base64_decode($user['password']) == "SuperAdmin"; 
	// var_dump( $cekPass);
	// die();

	// $pilihKtg = "SELECT kategori FROM tb_kategori WHERE kategori <> '$user[kategori_user]' ";
	// $pilihKategori = mysqli_query($conn, $pilihKtg);

	$nama_depan = "";
	$namaDepanError = "";
	$nama_belakang = "";
	$namaBelakangError = "";
	$email = "";
	$no_hp = "";
	$username = "";
	$userError = "";
	$password = "";
	$passError = "";
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
	
	if(isset($_POST['update'])){

		$kode = $_POST['kd_user'];
		$nama_depan = $_POST['nama_depan'];
		$nama_belakang = $_POST['nama_belakang'];
		$email = $_POST['email'];
		$no_hp = $_POST['no_hp'];
		$username = $_POST['username'];
		$password = $_POST['password'];

		if(empty($nama_depan)){
			$namaDepanError = "Nama tidak boleh kosong";
		}

		if(empty($nama_belakang)){
			$namaBelakangError = "Nama tidak boleh kosong";
		}

		if(empty($username)){
			$userError = "Username tidak boleh kosong";
		}

		if(empty($password)){
			$passError = "Password tidak boleh kosong /";
		}

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
			$pass_panjang_error_msg = " Panjang pass min 8 digit";
		}

		// Cek semua input sudah diisi apa belum
		if($validasi_nama_depan and $validasi_nama_belakang and $validasi_email and $validasi_nohp and $validasi_user and $validasi_panjang_pass and !empty($nama_depan) and !empty($nama_belakang) and !empty($username) and !empty($password) ){

			if(editUser($_POST) > 0){
				echo "<script>
						alert('berhasil');document.location.href = 'user.php';
					</script>";
			}else{
				echo "<script>
					alert('Gagal, Anda tidak merubah data apapun');
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
   Edit User
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
        	<div class="col-md-2">
        		
        	</div>
          	<div class="col-md-8">
            	<div class="card" style="padding: 10px;">
	              	<div class="card-header">
	                	<h4 class="card-title">Edit User</h4>
	              	</div>
	              	<hr>
	              	<div class="card-body">
						<div class="row">
						<div class="col-md-1">
							
						</div>
						<div class="col-md-10">
							<form>
			                  <div class="row">	
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Kode User</label>
			                        <input type="text" class="form-control" autocomplete="off" placeholder="kode user" name="kd_user" readonly value="<?= $user['kd_user']; ?>">
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Nama Depan</label>
			                        <?php if(isset($_POST['update'])){ ?>
								    	<input type="text" class="form-control" autocomplete="off" name="nama_depan" value="<?= @$nama_depan; ?>">
								    	<?= $namaDepanError.$nama_depan_error_msg; ?>
									<?php }else{ ?>
										<input type="text" class="form-control" autocomplete="off" name="nama_depan" value="<?= $user['nama_depan']; ?>">
								    	<?= @$nama_depan_error_msg; ?>
									<?php } ?>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Nama Belakang</label>
			                        <?php if(isset($_POST['update'])){ ?>
								    	<input type="text" class="form-control" autocomplete="off" name="nama_belakang" value="<?= @$nama_belakang; ?>">
								    	<?= $namaBelakangError.$nama_belakang_error_msg; ?>
									<?php }else{ ?>
										<input type="text" class="form-control" autocomplete="off" name="nama_belakang" value="<?= $user['nama_belakang']; ?>">
								    	<?= @$nama_belakang_error_msg; ?>
									<?php } ?>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Email</label>
			                        <?php if(isset($_POST['update'])){ ?>
								    	<input type="text" class="form-control" autocomplete="off" name="email" value="<?= @$email; ?>">
								    	<?= $email_error_msg; ?>
									<?php }else{ ?>
										<input type="text" class="form-control" autocomplete="off" name="email" value="<?= $user['email']; ?>">
								    	<?= @$email_error_msg; ?>
									<?php } ?>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">No HP</label>
			                        <?php if(isset($_POST['update'])){ ?>
								    	<input type="text" class="form-control" autocomplete="off" name="no_hp" pattern="^\d{10}$" value="<?= @$no_hp; ?>">
								    	<?= $nohp_error_msg; ?>
									<?php }else{ ?>
										<input type="text" class="form-control" autocomplete="off" name="no_hp" pattern="^\d{10}$" value="<?= $user['no_hp']; ?>">
								    	<?= @$nohp_error_msg; ?>
									<?php } ?>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Username</label>
			                        <?php if( $cekUser ){ ?>
								    	<input type="text" class="form-control" readonly autocomplete="off" name="username" value="<?= $user['username']; ?>">
								    	<?= $userError.$user_error_msg; ?>
									<?php }elseif(isset($_POST['update'])){ ?>
										<input type="text" class="form-control" name="username" value="<?= @$username; ?>">
								    	<?= @$user_error_msg; ?>
									<?php }else{ ?>
										<input type="text" class="form-control" autocomplete="off" name="username" value="<?= $user['username']; ?>">
								    	<?= @$user_error_msg; ?>
									<?php } ?>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Password</label>
			                        <?php if( $cekPass ){ ?>
								    	<input type="text" class="form-control" readonly name="password" value="<?= base64_decode($user['password']) ?>">
									<?php }elseif( isset($_POST['update']) ){ ?>
										<input type="text" class="form-control" autocomplete="off" name="password" value="<?= @$password; ?>">
								    	<?= $passError.$pass_panjang_error_msg; ?>
									<?php }else{ ?>
										<input type="text" class="form-control" autocomplete="off" name="password" value="<?= base64_decode($user['password']); ?>">
								    	<?= @$pass_panjang_error_msg; ?>
									<?php } ?>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
				              	<div class="col-md-3">	
				              	</div>
				              	<div class="col-md-6" >
				                   	<button class="btn btn-primary btn-block" name="update">Update User</button>
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