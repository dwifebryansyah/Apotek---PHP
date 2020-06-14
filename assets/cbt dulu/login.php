<?php
	session_start();

	require 'config/koneksi.php';
	require 'config/function.php';

	if(isset($_SESSION['submit'])){
		header("Location: home.php");
		exit;
	}

	$user = tampil("SELECT * FROM tb_user")[0];

	if(isset($_POST['submit'])){

		if(login($_POST) > 0){
			$_SESSION['submit'] = true;
			$_SESSION['username'] = $user['nama'];
			echo "<script>
						alert('selamat datang $_SESSION[username] ');document.location.href = 'home.php';
				</script>
				";
		}else{
			echo "<script>
						alert('username atau password anda mungkin salah');document.location.href = 'login.php';
				</script>
				";
		}
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="css/bootstrap.css">
</head>
<body style="background-color: #dcdde1; ">
	<nav class="navbar navbar-dark bg-dark" style="color: ghostwhite;">
  		<h3>Apotek Caringin</h3>
  		<!-- <a href="registrasi.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 80px; padding:2px;">Daftar</a> -->
	</nav>
	<div class="container">
		<div style="width: 550px; height: 490px; background-color: ghostwhite; padding: 30px; border-radius: 10px; margin-left: 280px; margin-top: 40px; ">
			<form method="post">
				<img src="img/apotek1.png" style="width: 180px; height:120px; margin-left: 150px; ">
				<h2 align="center">Silahkan Login</h2>
				<br>	
			  <div class="form-group">
			    <label for="username" style="font-size: 20px;">Username</label>
			    <input type="text" class="form-control" name="username" placeholder="Enter Username">
			  </div>
			  <div class="form-group">
			    <label for="password" style="font-size: 20px;">Password</label>
			    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
			  </div>
			  <input class="btn btn-primary" type="submit" name="submit" value="Login" style="width: 150px; margin-left: 170px;">
			</form>
		</div>
	</div>
</body>
</html>