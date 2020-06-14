<?php 
	
	require 'koneksi.php';

	function login($login){
		global $conn;

		$user = $login['username'];
		$pass = $login['password'];

		$query = ("SELECT * FROM tb_user WHERE username = '$user' && password = '$pass' ");
		$result = mysqli_query($conn, $query);

		return mysqli_affected_rows($conn);
	}

	function tambahUser($tambah, $tabel){
		global $conn;

		$kode = $tambah['kd_user'];
		$nama_depan = $tambah['nama_depan'];
		$nama_belakang = $tambah['nama_belakang'];
		$email = $tambah['email'];
		$no_hp = $tambah['no_hp'];
		
		$username = $tambah['username'];
		$password = $tambah['password'];
		$passAcak = base64_encode($password);
		// var_dump($passAcak);
		// die();

		//cek apa kode barang ada yang sama
		$result = tampil("SELECT kd_user as cekKode FROM tb_user");
		$ambil = $result;

		$query = mysqli_query($conn, "SELECT * FROM tb_user");
		$row = mysqli_num_rows($query);
		$rows = $row - 1;

			for ($i=0; $i <= $rows; $i++) { 
			
				if($kode == $ambil[$i]['cekKode']){
					$cek = $ambil[$i]['cekKode'];
				}
			}

			if($kode == @$cek){
				echo "<script>
							alert('Nama kode sama!');document.location.href = '../tambah_user.php';
						</script>";
			}else{
				$query1 = ("INSERT INTO $tabel VALUES ('$kode','$nama_depan','$nama_belakang','$email','$no_hp', '$username' ,'$passAcak') ");
				$result = mysqli_query($conn, $query1);
			}

			// var_dump($cek);
			// die();

		return mysqli_affected_rows($conn);
	}

	function tambahBarang($tambah, $tabel){
		global $conn;

		$kode = $tambah['kd_barang'];
		$nama = $tambah['nama_barang'];
		$kategori = $tambah['ktg_barang'];
		$satuan = $tambah['satuan'];
		$pemasok = $tambah['pemasok'];
		$jumlah = $tambah['jumlah'];
		$hargaBeli = $tambah['harga_beli'];
		$hargaJual = $tambah['harga_jual'];

		//cek apa nama barang ada yang sama
		$result = tampil("SELECT nama_barang as cekNama FROM tb_barang");
		$ambil = $result;

		$query = mysqli_query($conn, "SELECT * FROM tb_barang");
		$row = mysqli_num_rows($query);
		$rows = $row - 1;

			for ($i=0; $i <= $rows; $i++) { 
			
				if($nama == $ambil[$i]['cekNama']){
					$cek = $ambil[$i]['cekNama'];
				}
			}

			if($nama == @$cek){
				echo "<script>
							alert('Nama barang sama!');document.location.href = '../barang/tambah_barangs.php';
						</script>";
			}else{
				$query1 = ("INSERT INTO $tabel VALUES ('$kode','$nama','$kategori','$pemasok','$satuan','$hargaBeli', '$hargaJual' ,'$jumlah') ");
				$result = mysqli_query($conn, $query1);
			}

			// var_dump($cek);
			// die();

		return mysqli_affected_rows($conn);
	}

	function tambahKategori($tambah, $tabel){
		global $conn;

		$kode = $tambah['kd_barang'];
		$kategori = $tambah['kategori'];

		//cek apa nama barang ada yang sama
		$result = tampil("SELECT kategori as cekKategori FROM tb_kategori");
		$ambil = $result;

		$query1 = mysqli_query($conn, "SELECT * FROM tb_kategori");
		$row = mysqli_num_rows($query1);
		$rows = $row - 1;
		$cekKategori = "";

			for ($i=0; $i <= $rows; $i++) { 
			
				if($kategori == $ambil[$i]['cekKategori']){
					$cekKategori = $ambil[$i]['cekKategori'];
				}
			}

			if($kategori == $cekKategori){
				echo "<script>
							alert('Nama kategori ada yang sama!');document.location.href = 'tambah_kategoris.php';
						</script>";
			}else{
				$query = ("INSERT INTO $tabel VALUES ('$kode','$kategori') ");
				$result = mysqli_query($conn, $query);
			}

		return mysqli_affected_rows($conn);
	}

	function tambahSatuan($tambah, $tabel){
		global $conn;

		$kode = $tambah['kd_satuan'];
		// var_dump($kode);
		// die();
		$satuan = $tambah['satuan'];

		//cek apa nama barang ada yang sama
		$result = tampil("SELECT satuan as cekSatuan FROM tb_satuan");
		$ambil = $result;

		$query1 = mysqli_query($conn, "SELECT * FROM tb_satuan");
		$row = mysqli_num_rows($query1);
		$rows = $row - 1;
		$cekSatuan = "";

			for ($i=0; $i <= $rows; $i++) { 
			
				if($satuan == $ambil[$i]['cekSatuan']){
					$cekSatuan = $ambil[$i]['cekSatuan'];
				}
			}

			if($satuan == $cekSatuan){
				echo "<script>
							alert('Nama satuan ada yang sama!');document.location.href = 'tambah_satuan.php';
						</script>";
			}else{
				$query = ("INSERT INTO $tabel VALUES ('$kode','$satuan') ");
				$result = mysqli_query($conn, $query);
			}

		return mysqli_affected_rows($conn);
	}


	function tampil($tampil){
		global $conn;
		
		$result = mysqli_query($conn, $tampil);

		$rows = [];
		while($row =  mysqli_fetch_assoc($result)){
			$rows[] = $row;
		}

		return $rows;
	}

	function transaksiObat($transaksi){
		global $conn;

		$kode = $transaksi['kd_obat'];
		$nama = $transaksi['nama_obat'];
		$kategori = $transaksi['ktg_obat'];
		$harga = $transaksi['harga'];
		$jumlah = $transaksi['jumlah'];// pengurang
		$tanggal = $transaksi['tanggal_transaksi'];

		// ngambil data arraynya
		$sql1 = "SELECT * FROM tb_obat WHERE kd_obat = '$kode' ";
		$query = mysqli_query($conn, $sql1);
		$query1 = mysqli_fetch_assoc($query);

		$jumlah_awal = $query1['jumlah'];// jumlah awal

		// masukin data ke tabel transaksi
		$sql = "INSERT INTO tb_transaksi VALUES ('','$kode','$nama','$kategori', '$tanggal' ,'$harga','$jumlah') ";
		mysqli_query($conn, $sql);

		// ubah jumlah data
		$jumlah_akhir = $query1['jumlah']-$jumlah;// jumlah akhir
		$sql2 = "UPDATE tb_obat SET jumlah = '$jumlah_akhir' WHERE kd_obat = '$kode' ";
		mysqli_query($conn, $sql2);

		// KODE OTOMATIS
		$sql_max = mysqli_query($conn, "SELECT MAX(kd_laporan_transaksi) as maximal FROM tb_laporan_transaksi "); // ini hasilnya nyari kd_laporan_transaksi yang terbesar
		$sql1 = mysqli_query($conn, "SELECT * FROM tb_laporan_transaksi"); // ini hasilnya semua data di tb_laporan_transaksi
		$r_max = mysqli_fetch_array($sql_max); // ini hasilnya array kd_laporan_transaksi terbesar
		$num_max = mysqli_num_rows($sql1); // ini hasilnya semua jumlah baris yang ada di tb_laporan_transaksi
		$max_kode = $r_max['maximal']; // ini hasilnya array kd_laporan_transaksi terbesar
		$max_angka = substr($max_kode, 2); // ini hasilnya HANYA ANGKA dari $max_kode
		$max_angka++;

		// CARA LAMBAT (PASTI)
		if($num_max > 0){
			if($max_angka >= 1000){
				$angka_akhir = "LT".$max_angka;
			}elseif($max_angka >= 100){
				$angka_akhir = "LT0".$max_angka;
			}elseif($max_angka >= 10){
				$angka_akhir = "LT00".$max_angka;
			}elseif($max_angka >= 1){
				$angka_akhir = "LT000".$max_angka;
			}
		}else{
			$angka_akhir = "LT0001";
		}

		// masukin data ke tabel laporan transaksi
		$sql = "INSERT INTO tb_laporan_transaksi VALUES ('$angka_akhir','$kode','$nama','$kategori', '$tanggal' ,'$jumlah_awal','$jumlah_akhir', '$jumlah') ";
		mysqli_query($conn, $sql);

		return mysqli_affected_rows($conn);
	}


	function transaksiSuplemen($transaksi){
		global $conn;

		$kode = $transaksi['kd_suplemen'];
		$nama = $transaksi['nama_suplemen'];
		$kategori = $transaksi['ktg_suplemen'];
		$harga = $transaksi['harga'];
		$jumlah = $transaksi['jumlah'];// pengurangan
		$tanggal = $transaksi['tanggal_transaksi'];

		// ngambil data arraynya
		$sql1 = "SELECT * FROM tb_suplemen WHERE kd_suplemen = '$kode' ";
		$query = mysqli_query($conn, $sql1);
		$query1 = mysqli_fetch_assoc($query);

		$jumlah_awal = $query1['jumlah'];// jumlah awal

		// masukin data ke tabel transaksi
		$sql = "INSERT INTO tb_transaksi VALUES ('$kode','$nama','$kategori','$tanggal','$harga','$jumlah') ";
		mysqli_query($conn, $sql);

		// ubah jumlah data
		$jumlah_akhir = $query1['jumlah']-$jumlah;// jumlah akhir
		$sql2 = "UPDATE tb_suplemen SET jumlah = '$jumlah_akhir' WHERE kd_suplemen = '$kode' ";
		mysqli_query($conn, $sql2);

		// KODE OTOMATIS
		$sql_max = mysqli_query($conn, "SELECT MAX(kd_laporan_transaksi) as maximal FROM tb_laporan_transaksi "); // ini hasilnya nyari kd_laporan_transaksi yang terbesar
		$sql1 = mysqli_query($conn, "SELECT * FROM tb_laporan_transaksi"); // ini hasilnya semua data di tb_laporan_transaksi
		$r_max = mysqli_fetch_array($sql_max); // ini hasilnya array kd_laporan_transaksi terbesar
		$num_max = mysqli_num_rows($sql1); // ini hasilnya semua jumlah baris yang ada di tb_laporan_transaksi
		$max_kode = $r_max['maximal']; // ini hasilnya array kd_laporan_transaksi terbesar
		$max_angka = substr($max_kode, 2); // ini hasilnya HANYA ANGKA dari $max_kode
		$max_angka++;

		// CARA LAMBAT (PASTI)
		if($num_max > 0){
			if($max_angka >= 1000){
				$angka_akhir = "LT".$max_angka;
			}elseif($max_angka >= 100){
				$angka_akhir = "LT0".$max_angka;
			}elseif($max_angka >= 10){
				$angka_akhir = "LT00".$max_angka;
			}elseif($max_angka >= 1){
				$angka_akhir = "LT000".$max_angka;
			}
		}else{
			$angka_akhir = "LT0001";
		}

		// masukin data ke tabel laporan transaksi
		$sql = "INSERT INTO tb_laporan_transaksi VALUES ('$angka_akhir','$kode','$nama','$kategori', '$tanggal' ,'$jumlah_awal','$jumlah_akhir', '$jumlah') ";
		mysqli_query($conn, $sql);

		return mysqli_affected_rows($conn);
	}

	function hapus($id, $kode, $table){
		global $conn;

		$sql =  "DELETE FROM $table WHERE $kode = '$id' ";
		$cek = mysqli_query($conn,$sql);
		// var_dump($sql);
		// die();
		
		return mysqli_affected_rows($conn);
	}

	function cancelTransaksi($id, $jumlah){
		global $conn;


		// ngambil jumlah data base
		$sql1 = "SELECT * FROM tb_barang WHERE kd_barang = '$id' ";
		$query2 = mysqli_query($conn, $sql1);
		$query3 = mysqli_fetch_assoc($query2);
		$jumlah_awal = $query3['jumlah'];// jumlah 	awal

		$updateJumlah = $jumlah_awal + $jumlah;

		$sql2 = " UPDATE tb_barang SET jumlah = '$updateJumlah' WHERE kd_barang = '$id' ";
		$query4 = mysqli_query($conn, $sql2);
		// var_dump($query4);
		// die();

		$sql =  "DELETE FROM tb_keranjang WHERE kd_barang = '$id' ";
		$cek = mysqli_query($conn,$sql);
		// var_dump($sql);
		// die();
		
		return mysqli_affected_rows($conn);
	}

	function hapusUser($id){
		global $conn;


		// ngambil jumlah data base
		$sql1 = "SELECT * FROM tb_user WHERE kd_user = '$id' ";
		$query2 = mysqli_query($conn, $sql1);
		$query3 = mysqli_fetch_assoc($query2);

		$userSuper = $query3['username'];
		$passSuper = base64_decode($query3['password']);
		$cek = $passSuper == 'SuperAdmin';
		// var_dump($cek);
		// die();

		if($cek){
			echo "<script>alert('Tidak boleh menghapus admin super');document.location.href = 'user.php';</script>";
		}else{
			$sql =  "DELETE FROM tb_user WHERE kd_user = '$id' ";
			$cek = mysqli_query($conn,$sql);
		}

		// var_dump($sql);
		// die();
		
		return mysqli_affected_rows($conn);
	}

	function hapusBarang($id){
		global $conn;

		$cek = mysqli_query($conn, "DELETE FROM tb_barang WHERE kd_barang= '$id' ");
		// var_dump($cek);
		// die();


		return mysqli_affected_rows($conn);
	}

	function hapusObat($id){
		global $conn;

		$cek = mysqli_query($conn, "DELETE FROM tb_obat WHERE kd_obat= '$id' ");
		// var_dump($cek);
		// die();


		return mysqli_affected_rows($conn);
	}

	function hapusSuplemen($id){
		global $conn;

		$cek = mysqli_query($conn, "DELETE FROM tb_suplemen WHERE kd_suplemen= '$id' ");
		// var_dump($cek);
		// die();


		return mysqli_affected_rows($conn);
	}

	function hapusLaporanPasok($id){
		global $conn;

		$cek = mysqli_query($conn, "DELETE FROM tb_laporan_pasok WHERE kd_laporan_pasok = '$id' ");
		// var_dump($cek);
		// die();


		return mysqli_affected_rows($conn);
	}

	function hapusLaporanTransaksi($id){
		global $conn;

		$cek = mysqli_query($conn, "DELETE FROM tb_laporan_transaksi WHERE kd_laporan_transaksi = '$id' ");
		// var_dump($cek);
		// die();


		return mysqli_affected_rows($conn);
	}

	function editSatuan($edit){
		global $conn;
		
		$kode = $edit['kd_satuan'];
		$satuan = $edit['satuan'];

		$sql = "UPDATE tb_satuan SET
				satuan = '$satuan'
				WHERE kd_satuan = '$_GET[id]' ";

		$cek = mysqli_query($conn, $sql);
		return mysqli_affected_rows($conn);
	}

	function editKategori($edit){
		global $conn;
		
		$kode = $edit['kd_kategori'];
		$kategori = $edit['kategori'];

		$sql = "UPDATE tb_kategori SET
				kategori = '$kategori'
				WHERE kd_kategori = '$_GET[id]' ";

		$cek = mysqli_query($conn, $sql);
		return mysqli_affected_rows($conn);
	}

	function editUser($edit){
		global $conn;
		
		$kode = $edit['kd_user'];
		// var_dump($kode); die();
		$nama_depan = $edit['nama_depan'];
		$nama_belakang = $edit['nama_belakang'];
		$email = $edit['email'];
		$no_hp = rtrim($edit['no_hp']);
		$username = $edit['username'];
		$password = $edit['password'];
		$cekpass = base64_encode($password);
		// var_dump($cekpass);
		// die();

		$sql = "UPDATE tb_user SET 
				kd_user = '$kode', 
				nama_depan = '$nama_depan',
				nama_belakang = '$nama_belakang',
				email = '$email',
				no_hp = '$no_hp',
				username = '$username',
				password = '$cekpass'
				WHERE kd_user = '$_GET[edit]' ";

		mysqli_query($conn, $sql);

		return mysqli_affected_rows($conn);
	}

	function editBarang($edit){
		global $conn;
		
		$kode = $edit['kd_barang'];
		$nama = $edit['nama_barang'];
		$kategori = $edit['ktg_barang'];
		$hargaBeli = $edit['harga_beli'];
		$hargaJual = $edit['harga_jual'];
		$satuan = $edit['satuan'];

		$sql = "UPDATE tb_barang SET 
				kd_barang = '$kode', 
				nama_barang = '$nama',
				kategori_barang = '$kategori',
				satuan = '$satuan',
				harga_beli = '$hargaBeli',
				harga_jual = '$hargaJual'
				WHERE kd_barang = '$_GET[edit]' ";
		// var_dump($sql); die();

		mysqli_query($conn, $sql);

		return mysqli_affected_rows($conn);
	}

	function editObat($edit){
		global $conn;
		
		$kode = $edit['kd_obat'];
		// var_dump($kode); die();
		$nama = $edit['nm_obat'];
		$kategori = $edit['ktg_obat'];
		$harga = $edit['harga'];
		// $jumlah = $edit['jumlah'];

		$sql = "UPDATE tb_obat SET 
				kd_obat = '$kode', 
				nama_obat = '$nama',
				kategori_obat = '$kategori',
				harga = '$harga'
				WHERE kd_obat = '$_GET[edit]' ";

		mysqli_query($conn, $sql);

		return mysqli_affected_rows($conn);
	}

	function editSuplemen($edit){
		global $conn;
		
		$kode = $edit['kd_suplemen'];
		// var_dump($kode); die();
		$nama = $edit['nama_suplemen'];
		$kategori = $edit['ktg_suplemen'];
		$harga = $edit['harga'];
		// $jumlah = $edit['jumlah'];

		$sql = "UPDATE tb_suplemen SET 
				kd_suplemen = '$kode', 
				nama_suplemen = '$nama',
				kategori_suplemen = '$kategori',
				harga = '$harga'
				WHERE kd_suplemen = '$_GET[edit]' ";

		mysqli_query($conn, $sql);

		return mysqli_affected_rows($conn);
	}

		function pasokBarang($pasok){
		global $conn;

		$kode = $pasok['kd_barang'];
		$nama = $pasok['nama_barang'];
		$pemasok = $pasok['pemasok'];
		$jumlah = $pasok['jumlah'];
		$tanggal = $pasok['tanggal_pasok'];
		

		$sql = "SELECT * FROM tb_barang WHERE kd_barang = '$kode' ";
		$query = mysqli_query($conn, $sql);
		$query1 = mysqli_fetch_assoc($query);

		// KODE OTOMATIS
		$sql_max = mysqli_query($conn, "SELECT MAX(kd_pasok) as maximal FROM tb_pasok "); // ini hasilnya nyari kd_laporan_pasok yang terbesar
		$sql1 = mysqli_query($conn, "SELECT * FROM tb_pasok"); // ini hasilnya semua data di tb_pasok
		$r_max = mysqli_fetch_array($sql_max); // ini hasilnya array kd_laporan_pasok terbesar
		$num_max = mysqli_num_rows($sql1); // ini hasilnya semua jumlah baris yang ada di tb_pasok
		$max_kode = $r_max['maximal']; // ini hasilnya array kd_laporan_pasok terbesar
		$max_angka = substr($max_kode, 2); // ini hasilnya HANYA ANGKA dari $max_kode
		$max_angka++;

		// CARA LAMBAT (PASTI)
		if($num_max > 0){
			if($max_angka >= 1000){
				$angka_akhir = "P".$max_angka;
			}elseif($max_angka >= 100){
				$angka_akhir = "P0".$max_angka;
			}elseif($max_angka >= 10){
				$angka_akhir = "P00".$max_angka;
			}elseif($max_angka >= 1){
				$angka_akhir = "P000".$max_angka;
			}
		}else{
			$angka_akhir = "P0001";
		}

		$sql2 = "INSERT INTO tb_pasok VALUES ('$angka_akhir','$kode','$nama','$pemasok','$tanggal','$jumlah')";
		$query4 = mysqli_query($conn, $sql2);
		// var_dump($sql2);
		// die();
		
		$jumlahAkhir = $query1['jumlah'] + $jumlah;
		$sql1 = "UPDATE tb_barang SET jumlah = '$jumlahAkhir' WHERE kd_barang = '$kode' ";
		$query3 = mysqli_query($conn, $sql1);

		return mysqli_affected_rows($conn);
	}

	function pasokObat($pasok){
		global $conn;

		$kode = $pasok['kd_obat'];
		$nama = $pasok['nama_obat'];
		$pemasok = $pasok['pemasok'];
		$jumlah = $pasok['jumlah'];
		$tanggal = $pasok['tanggal_pasok'];
		

		$sql = "SELECT * FROM tb_obat WHERE kd_obat = '$kode' ";
		$query = mysqli_query($conn, $sql);
		$query1 = mysqli_fetch_assoc($query);

		// KODE OTOMATIS
		$sql_max = mysqli_query($conn, "SELECT MAX(kd_laporan_pasok) as maximal FROM tb_laporan_pasok "); // ini hasilnya nyari kd_laporan_pasok yang terbesar
		$sql1 = mysqli_query($conn, "SELECT * FROM tb_laporan_pasok"); // ini hasilnya semua data di tb_laporan_pasok
		$r_max = mysqli_fetch_array($sql_max); // ini hasilnya array kd_laporan_pasok terbesar
		$num_max = mysqli_num_rows($sql1); // ini hasilnya semua jumlah baris yang ada di tb_laporan_pasok
		$max_kode = $r_max['maximal']; // ini hasilnya array kd_laporan_pasok terbesar
		$max_angka = substr($max_kode, 2); // ini hasilnya HANYA ANGKA dari $max_kode
		$max_angka++;

		// CARA LAMBAT (PASTI)
		if($num_max > 0){
			if($max_angka >= 1000){
				$angka_akhir = "LP".$max_angka;
			}elseif($max_angka >= 100){
				$angka_akhir = "LP0".$max_angka;
			}elseif($max_angka >= 10){
				$angka_akhir = "LP00".$max_angka;
			}elseif($max_angka >= 1){
				$angka_akhir = "LP000".$max_angka;
			}
		}else{
			$angka_akhir = "LP0001";
		}

		$sql2 = "INSERT INTO tb_laporan_pasok VALUES ('$angka_akhir','$kode','$nama','$pemasok','$tanggal','$jumlah')";
		$query4 = mysqli_query($conn, $sql2);
		
		$jumlahAkhir = $query1['jumlah'] + $jumlah; 
		$sql1 = "UPDATE tb_obat SET jumlah = '$jumlahAkhir' WHERE kd_obat = '$kode' ";
		$query3 = mysqli_query($conn, $sql1);

		return mysqli_affected_rows($conn);
	}

	function pasokSuplemen($pasok){
		global $conn;

		$kode = $pasok['kd_suplemen'];
		$nama = $pasok['nama_suplemen'];
		$pemasok = $pasok['pemasok'];
		$jumlah = $pasok['jumlah'];
		$tanggal = $pasok['tanggal_pasok'];

		$sql = "SELECT * FROM tb_suplemen WHERE kd_suplemen = '$kode' ";
		$query = mysqli_query($conn, $sql);
		$query1 = mysqli_fetch_assoc($query);

		// KODE OTOMATIS
		$sql_max = mysqli_query($conn, "SELECT MAX(kd_laporan_pasok) as maximal FROM tb_laporan_pasok "); // ini hasilnya nyari kd_laporan_pasok yang terbesar
		$sql1 = mysqli_query($conn, "SELECT * FROM tb_laporan_pasok"); // ini hasilnya semua data di tb_laporan_pasok
		$r_max = mysqli_fetch_array($sql_max); // ini hasilnya array kd_laporan_pasok terbesar
		$num_max = mysqli_num_rows($sql1); // ini hasilnya semua jumlah baris yang ada di tb_laporan_pasok
		$max_kode = $r_max['maximal']; // ini hasilnya array kd_laporan_pasok terbesar
		$max_angka = substr($max_kode, 2); // ini hasilnya HANYA ANGKA dari $max_kode
		$max_angka++;

		// CARA LAMBAT (PASTI)
		if($num_max > 0){
			if($max_angka >= 1000){
				$angka_akhir = "LP".$max_angka;
			}elseif($max_angka >= 100){
				$angka_akhir = "LP0".$max_angka;
			}elseif($max_angka >= 10){
				$angka_akhir = "LP00".$max_angka;
			}elseif($max_angka >= 1){
				$angka_akhir = "LP000".$max_angka;
			}
		}else{
			$angka_akhir = "LP0001";
		}

		$sql2 = "INSERT INTO tb_laporan_pasok VALUES ('$angka_akhir','$kode','$nama','$pemasok','$tanggal','$jumlah')";
		$query4 = mysqli_query($conn, $sql2);
		
		$jumlahAkhir = $query1['jumlah'] + $jumlah; 
		$sql1 = "UPDATE tb_suplemen SET jumlah = '$jumlahAkhir' WHERE kd_suplemen = '$kode' ";
		$query3 = mysqli_query($conn, $sql1);

		return mysqli_affected_rows($conn);
	}

	function cari($cari, $table, $kode, $parameter = []){
		global $conn;
		
		$tabel = $table;
		$kd = $kode;
		$params = $parameter;
		$count = count($params)-1;
		
		$row = [];
		$sqlOR = "OR";

		for ($i=0; $i <= $count; $i++) { 
			$row[] = $params[$i];
			if($i >= $count):
				$loop[] = " $params[$i] LIKE '%$cari%'";
			else:
				$loop[] = " $params[$i] LIKE '%$cari%' $sqlOR";
			endif;

		}

		//$tes = $loop[0].=$loop[1].=$loop[2].=$loop[3];

		$tes = implode('', $loop);

		// var_dump($tes);
		// die();	

		$sql = "SELECT * FROM $tabel WHERE ";
		$sqlGabung = $sql.=$tes;

		return tampil($sqlGabung);
	}

	function cari2($cari = [], $table, $kode, $nama, $tanggal){
		global $conn;
		
		// var_dump($cari);
		// die();
		$tabel = $table;
		$kd = $kode;
		$name = $nama;
		$dari = $cari['dari'];
		$sampai = $cari['sampai'];

		$sql = "SELECT * FROM  $table WHERE $tanggal BETWEEN '$dari' AND '$sampai' ORDER BY $kd DESC";
		return tampil($sql);

	}

	function selesaiBelanja($hitung){
		global $conn;

		$query = mysqli_query($conn, $hitung);
		$ambil = mysqli_fetch_array($query);
		return $ambil;
	}

	function kodeOtomatis($kode, $tabel, $nameKode){
		global $conn;
		// KODE OTOMATIS
		$sql_max = mysqli_query($conn, "SELECT MAX($kode) as maximal FROM $tabel "); // ini hasilnya nyari kd_laporan_transaksi yang terbesar
		$sql1 = mysqli_query($conn, "SELECT * FROM $tabel"); // ini hasilnya semua data di tb_laporan_transaksi
		$r_max = mysqli_fetch_array($sql_max); // ini hasilnya array kd_laporan_transaksi terbesar
		$num_max = mysqli_num_rows($sql1); // ini hasilnya semua jumlah baris yang ada di tb_laporan_transaksi
		$max_kode = $r_max['maximal']; // ini hasilnya array kd_laporan_transaksi terbesar
		$max_angka = substr($max_kode, 2); // ini hasilnya HANYA ANGKA dari $max_kode
		$max_angka++;

		// CARA LAMBAT (PASTI)
		if($num_max > 0){
			if($max_angka >= 1000){
				$angka_akhir = $nameKode.$max_angka;
			}elseif($max_angka >= 100){
				$angka_akhir = $nameKode."0".$max_angka;
			}elseif($max_angka >= 10){
				$angka_akhir = $nameKode."00".$max_angka;
			}elseif($max_angka >= 1){
				$angka_akhir = $nameKode."000".$max_angka;
			}
		}else{
			$angka_akhir = $nameKode."0001";
		}

		return $angka_akhir;
	}

	function pilihBarang($pilih){
		global $conn;

		$nama = $pilih['nama_barang'];
		$kode = $pilih['kd_barang'];
		$kategori = $pilih['ktg_barang'];
		$harga = trim($pilih['harga']);
		$jumlah = trim($pilih['jumlah']);

		$total = $harga * $jumlah;

		// ngambil jumlah data base
		$sql1 = "SELECT * FROM tb_barang WHERE kd_barang = '$kode' ";
		$query2 = mysqli_query($conn, $sql1);
		$query3 = mysqli_fetch_assoc($query2);
		$jumlah_awal = $query3['jumlah'];// jumlah 	awal

		$updateJumlah = $jumlah_awal - $jumlah;
		// var_dump($updateJumlah);
		// die();

		//cek apa nama barang ada yang sama
		$result = tampil("SELECT jumlah,nama_barang AS cekNama FROM tb_keranjang");
		$ambil = $result;
		
		$query1 = mysqli_query($conn, "SELECT * FROM tb_keranjang");
		$row = mysqli_num_rows($query1);
		$rows = $row - 1;

		for ($i=0; $i <= $rows; $i++) { 
			
				if($nama == $ambil[$i]['cekNama']){
					$cekNama = $ambil[$i]['cekNama'];
					$cekJumlah = $ambil[$i]['jumlah'];
				}

			}

		$jumlahAkhir = @$cekJumlah + @$jumlah;
		$total = $harga * $jumlahAkhir;	

		if($nama == @$cekNama){

			$query1 = "UPDATE tb_keranjang SET jumlah = '$jumlahAkhir', total = '$total'  WHERE nama_barang = '$cekNama' ";
			$result = mysqli_query($conn, $query1);

			$sql2 = " UPDATE tb_barang SET jumlah = '$updateJumlah' WHERE kd_barang = '$kode' ";
			$query4 = mysqli_query($conn, $sql2);

		}else{
			$sql = "INSERT INTO tb_keranjang VALUES ('','$nama', '$kode', '$kategori', '$harga', '$jumlah','$total') ";
			$query = mysqli_query($conn, $sql);

			$sql2 = " UPDATE tb_barang SET jumlah = '$updateJumlah' WHERE kd_barang = '$kode' ";
			$query4 = mysqli_query($conn, $sql2);
		}

		return mysqli_affected_rows($conn);
	}

 ?>