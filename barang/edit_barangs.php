<?php 
	session_start();

	if(!isset($_SESSION['submit'])){
		header('Location: ../logins.php');
		exit;
	}

	require '../config/koneksi.php';
	require '../config/function.php';

	$id = $_GET['edit'];

	$barang = tampil("SELECT * FROM tb_barang WHERE kd_barang = '$id' ")[0];

	$pilihKtg = "SELECT kategori FROM tb_kategori WHERE kategori <> '$barang[kategori_barang]' ";
	$pilihKategori = mysqli_query($conn, $pilihKtg);

	$pilihStn = "SELECT satuan FROM tb_satuan WHERE satuan <> '$barang[satuan]' ";
	$pilihSatuan = mysqli_query($conn, $pilihStn);

	$nama = "";
	$namaError = "";
	$ktg = "--Pilih--";
	$harga_beli = "";
	$hargaBeliError = "";
	$harga_jual = "";
	$hargaJualError = "";
	$validasi_nama = true;
	$nama_error_msg = "";
	$validasi_hargabeli = true;
	$hargabeli_error_msg = "";
	$validasi_hargajual = true;
	$hargajual_error_msg = "";
	
	if(isset($_POST['update'])){

		$nama = trim($_POST['nama_barang']);
		$ktg = $_POST['ktg_barang'];
		$harga_beli = trim($_POST['harga_beli']);
		$harga_jual = trim($_POST['harga_jual']);

		if(empty($nama)){
			$namaError = "Nama tidak boleh kosong";
		}

		if(empty($harga_beli)){
			$hargaBeliError = "Harga beli tidak boleh kosong/";
		}

		if(empty($harga_jual)){
			$hargaJualError = "Harga jual tidak boleh kosong/";
		}


		if(!preg_match("/^[a-zA-Z ]*$/",$nama)){
			$validasi_nama = false;
			$nama_error_msg = "Hanya boleh huruf dan spasi yang diijinkan";
		}

		if(!is_numeric($harga_beli)){
			$validasi_hargabeli = false;
			$hargabeli_error_msg = "Hanya boleh angka saja";
		}

		if(!is_numeric($harga_jual)){
			$validasi_hargajual = false;
			$hargajual_error_msg = "Hanya boleh angka saja";
		}

		// Cek semua input sudah diisi apa belum
		if($validasi_nama and $validasi_hargabeli and $validasi_hargajual and !empty($nama) and !empty($harga_beli) and !empty($harga_jual)){

			if(editBarang($_POST) > 0){
				$_SESSION['tampilan'] = "tampilan";
			}else{
				echo "<script>
					alert('Gagal, Tidak boleh memasukan data yang sama dengan sebelumnya');
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
   Edit Barang
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
            <a href="edit_barangs.php">
              <i class="now-ui-icons design-2_ruler-pencil"></i>
              <p>Edit Barang</p>
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
	                	<h4 class="card-title">Edit Barang</h4>
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
			                        <label style="font-size: 15px;">Kode Barang</label>
			                        <input type="text" class="form-control" placeholder="kode barang" name="kd_barang" readonly value="<?= $barang['kd_barang']; ?>">
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Nama Barang</label>
			                        <?php if(isset($_POST['edit'])){ ?>
								    	<input type="text" class="form-control" autocomplete="off" name="nama_barang" value="<?= @$nama; ?>">
								    	<?= $namaError.$nama_error_msg; ?>
									<?php }else{ ?>
										<input type="text" class="form-control" autocomplete="off" name="nama_barang" value="<?= $barang['nama_barang']; ?>">
								    	<?= @$nama_error_msg; ?>
									<?php } ?>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Kategori Barang</label>
			                        <select name="ktg_barang" class="form-control">
								    	<option selected value="<?= $barang['kategori_barang']; ?>"><?= $barang['kategori_barang']; ?></option>
								    	<?php foreach($pilihKategori as $row): ?>
									    	<?php if($barang['kategori_barang'] == $barang['kategori_barang']){ ?>
									    		<option value="<?= $row['kategori']; ?>"><?= $row['kategori']; ?></option>
											<?php } ?>
										<?php endforeach; ?>
								    </select>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Satuan Barang</label>
			                        <select name="satuan" class="form-control">
								    	<option selected value="<?= $barang['satuan']; ?>"><?= $barang['satuan']; ?></option>
								    	<?php foreach($pilihSatuan as $row): ?>
									    	<?php if($barang['satuan'] == $barang['satuan']){ ?>
									    		<option value="<?= $row['satuan']; ?>"><?= $row['satuan']; ?></option>
											<?php } ?>
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
			                        <?php if(isset($_POST['edit'])){ ?>
								    	<input type="text" class="form-control" autocomplete="off" name="harga_beli" value="<?= @$harga_beli ?>">
								    	<?= $hargaBeliError.$hargabeli_error_msg; ?>
								    <?php }else{ ?>
										<input type="text" class="form-control" autocomplete="off" name="harga_beli" value="<?= $barang['harga_beli']; ?>">
								    	<?= @$hargabeli_error_msg; ?>
								    <?php } ?>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
			                  	<div class="col-md-1"></div>
			                    <div class="col-md-9 pr-1">
			                      <div class="form-group">
			                        <label style="font-size: 15px;">Harga Jual</label>
			                        <?php if(isset($_POST['edit'])){ ?>
									    <input type="text" class="form-control" autocomplete="off" name="harga_jual" value="<?= @$harga_jual ?>">
									    <?= $hargaJualError.$hargajual_error_msg; ?>
									<?php }else{ ?>
										<input type="text" class="form-control" autocomplete="off" name="harga_jual" value="<?= $barang['harga_jual']; ?>">
									    <?= @$hargajual_error_msg; ?>
									 <?php } ?>
			                      </div>
			                    </div>
			                  </div>

			                  <div class="row">
				              	<div class="col-md-3">	
				              	</div>
				              	<div class="col-md-6" >
				                   	<button class="btn btn-primary btn-block" name="update">Update Barang</button>
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
        text: 'Berhasil di Update',
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