<?php 
	require 'koneksi.php';
	require 'function.php';

	if(isset($_POST['submit'])){
		if(tambahUser($_POST) > 0){
			echo "<script>
						alert('akun berhasil di daftarkan:)');document.location.href = 'login.php';
				</script>
				";

		}else{
			echo "<script>
						alert('anda gagal membuat akun:)');
				</script>
				";
		}
	}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" href="css/bootstrap.css">
</head>
<body style="background-color: #dcdde1; ">
	<nav class="navbar navbar-dark bg-dark" style="color: ghostwhite;">
  		<h3>Apotek Caringin</h3>
  		<a href="login.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="height: 40px; width: 80px; padding:1px;">Masuk</a>
	</nav>
	<div class="container" style="padding-bottom: 30px;">
		<div style="width: 550px; height: 850px; background-color: ghostwhite; padding: 30px; border-radius: 10px; margin-left: 280px; margin-top: 40px; ">
			<form method="post">
				<img src="img/apotek1.png" style="width: 180px; height:120px; margin-left: 150px; ">
				<h2 align="center">Silahkan Daftar</h2>
				<br>
				<div class="form-group">
				    <label for="nama" style="font-size: 20px;">Nama</label>
				    <input type="text" class="form-control" name="nama" placeholder="Masukan Nama Anda">
			  	</div>
			  	<div class="form-group">
				    <label for="nip" style="font-size: 20px;">NIP</label>
				    <input type="text" class="form-control" name="nip" placeholder="Masukan Nip Anda">
			 	</div>
			 	<div class="form-group">
				    <label for="email" style="font-size: 20px;">Email</label>
				    <input type="email" class="form-control" name="email" placeholder="Masukan Email Anda">
			  	</div>
			  	<div class="form-group">
			    	<label for="no_hp" style="font-size: 20px;">No.Hp</label>
			    	<input type="number" class="form-control" name="no_hp" placeholder="Masukan No.Hp Anda">
			  	</div>
				<div class="form-group">
				    <label for="username" style="font-size: 20px;">Username</label>
				    <input type="text" class="form-control" name="username" placeholder="Masukan Username">
			  	</div>
			  	<div class="form-group">
				    <label for="password" style="font-size: 20px;">Password</label>
				    <input type="password" class="form-control" name="password" placeholder="Masukan Password">
			  	</div>
			  	<input class="btn btn-primary" type="submit" name="submit" value="Daftar" style="width: 150px; margin-left: 170px;">
			</form>
		</div>
	</div>
</body>
</html>