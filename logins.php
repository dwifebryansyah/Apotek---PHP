<?php
	session_start();

	require 'config/koneksi.php';
	require 'config/function.php';

	if(isset($_SESSION['submit'])){
		header("Location: dashboard.php");
		exit;
	}

  //base64_decode(data) -> buat un-enskripsi data
  //base64_encode(data) -> buat enskripsi data

	if(isset($_POST['submit'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $passAcak = base64_encode($pass);
    $cekpass = "";
    
    $users = tampil("SELECT * FROM tb_user WHERE username = '$user' ");

    if($users == ![]){
      $users = tampil("SELECT * FROM tb_user WHERE username = '$user' ")[0];
      $cekpass = base64_decode($users["password"]);
    }

    if($pass === @$cekpass){
      $_SESSION['submit'] = true;
      $_SESSION['username'] = $users['nama_depan'].' '.$users['nama_belakang'];
      // var_dump($users);
      // die();
      echo "<script>
            alert('selamat datang $_SESSION[username]');document.location.href = 'dashboard.php';
        </script>
        ";
    }else{
      // var_dump($users);
      // die();
        echo "<script>
            alert('username atau password anda mungkin salah');document.location.href = 'logins.php';
        </script>
        ";
    }
    
		// if(login($_POST) > 0){
  //     $_SESSION['submit'] = true;
  //     $_SESSION['username'] = $users['nama_depan'].' '.$users['nama_belakang'];
     
  //     echo "<script>
  //           alert('selamat datang $_SESSION[username]');document.location.href = 'dashboard.php';
  //       </script>
  //       ";
		// }else{
		// 	echo "<script>
		// 				alert('username atau password anda mungkin salah');document.location.href = 'logins.php';
		// 		</script>
		// 		";
		// }
	}
 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/animate.css">
</head>
<body>
<div class="container-fluid bgk">
  <div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12"></div>
      <div class="col-md-4 col-sm-4 col-xs-12">

  <form class="form-container animated fadeIn" action="" method="post">
    <h1 class="text-light text-center"><img src="assets/img/lgg.png" width="80px" alt=""><hr> Login</h1>
      <div class="form-group">
        <label for="exampleInputEmail1" class="text-light">Username</label>
        <input type="text" class="form-control" name="username" required id="exampleInputEmail1"  placeholder="masukkan username">
      </div>

      <div class="form-group">
        <label for="exampleInputPassword1" class="text-light">Password</label>
        <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="masukkan password">
      </div>

    <button class="btn btn-success btn-block" name="submit">Login</button>
  </form>

      </div>
  </div>
</div>
</body>
</html>