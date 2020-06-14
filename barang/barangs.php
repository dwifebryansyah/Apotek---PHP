<?php 
	
	require '../config/koneksi.php';
	require '../config/function.php';

	session_start();

  if(!isset($_SESSION['submit'])){
    header('Location: ../logins.php');
    exit;
  }

	// $jumlahDataPerhalaman = 3;
	// $jumlahData = count(tampil("SELECT * FROM tb_barang"));
	// $jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman); // 3
	// $halamanAktif = ( isset($_GET['page']) ) ? $_GET['page'] : 1; // 1
	// $awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;
	
	//$barang = tampil("SELECT * FROM tb_barang LIMIT $awalData, $jumlahDataPerhalaman");
	$barang = tampil("SELECT * FROM tb_barang");


	if(isset($_POST['search'])){
		$table = 'tb_barang';
		$kode = 'kd_barang';
		$params = ['kd_barang','nama_barang','kategori_barang','pemasok'];
		$barang = cari($_POST['tsearch'], $table, $kode, $params);
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
   Apotek Caringin
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
            <a href="barangs.php">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>List Barang</p>
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
            <form method="post"> 
            <?php if(isset($_SESSION['tampilan'])): ?>
                           <div class="flash-data" data-flashdata="<?= $_SESSION['tampilan'];  ?>"></div>
                        <?php endif; ?> 
            <!-- search -->
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
                <a class="nav-link" href="../kategori/kategoris.php">
                  <i class="now-ui-icons design_bullet-list-67"></i>
                  <p>
                  	Kategori
                  </p>
                </a>
              </li>
               <li class="nav-item">
                <a class="nav-link" href="../satuan/satuan.php">
                  <i class="now-ui-icons business_chart-bar-32"></i>
                  <p>
                    Satuan
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
        </form>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card" style="padding: 10px;">
              <div class="card-header">
                <h4 class="card-title">Table Barang</h4>
              </div>
              <div class="card-body">
              	<div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                    	<tr>
	                    	<th>No</th>
	                    	<th>Kode</th>
	                    	<th>Nama</th>
	                    	<th>Kategori</th>
	                    	<th>Pemasok</th>
                        <th>Satuan</th>
	                    	<th>Harga Beli</th>
	                    	<th>Harga Jual</th>
	                    	<th>Jumlah</th>
	                    	<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aksi</th>
                    	</tr>
                    </thead>
                    <tbody>
                	<?php $i= 1; ?>
					<?php foreach($barang as $row): ?>
                      <tr>
	                     <td align="center"><?= $i;  ?></td>
	                     <td align="center"><?= $row['kd_barang'] ?></td>
	                     <td><?= $row['nama_barang'] ?></td>
	                     <td><?= $row['kategori_barang'] ?></td>
	                     <td><?= $row['pemasok'] ?></td>
                       <td><?= $row['satuan'] ?></td>
	                     <td align="center"><?= $row['harga_beli'] ?></td>
	                     <td align="center"><?= $row['harga_jual'] ?></td>
                      <?php if($row['jumlah'] == 0): ?>
	                       <th class="text-danger" align="center"><?= $row['jumlah'] ?></th>
                      <?php elseif($row['jumlah'] > 5): ?>
                        <td class="text-success" align="center"><?= $row['jumlah'] ?></td>
                      <?php elseif($row['jumlah'] < 5): ?>
                        <th class="text-warning" align="center"><?= $row['jumlah'] ?></th>
                      <?php endif; ?> 
	                     <td align="center">
                        <a onclick="return confirm('yakin ingin menghapus?');" href="../hapus.php?kode=<?='kd_barang'?>&tabel=<?='tb_barang'?>&hapus=<?= $row['kd_barang'] ?>&url=<?= 'barang/barangs' ?>" class="badge badge-danger">Hapus</a> |
						      	     <a href="edit_barangs.php?edit=<?= $row['kd_barang']; ?>" class="badge badge-success">Edit</a> |
						      	     <a href="pasok_barangs.php?pasok=<?= $row['kd_barang']; ?>" class="badge badge-primary">Pasok</a>
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
                   	<a class="btn btn-primary btn-block" href="tambah_barangs.php" style="color: white;" >Tambah Barang</a>
                </div>
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
        text: 'Berhasil di hapus',
        type: 'success'
      });
    }
  </script>
</body>

</html>