<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
	
}
$koneksi = mysqli_connect("localhost","root","","cutiaja");

//login eak

if(isset($_POST['login'])){
	$username = $_POST['uname'];
	$password = $_POST['psw'];

	$cekuser = mysqli_query($koneksi,"select * from user where username='$username' and password= '$password'");
	$hitung = mysqli_num_rows($cekuser);

	if($hitung>0){
		//data ada

		$ambildatarole = mysqli_fetch_array($cekuser);
		$role = $ambildatarole['role'];

		$_SESSION['id_user'] = $ambildatarole['id_user'];
		$_SESSION['nama'] = $ambildatarole['nama'];
		$_SESSION['kode_departemen'] = $ambildatarole['kode_departemen'];
		$_SESSION['alamat'] = $ambildatarole['alamat'];
		$_SESSION['no_telp'] = $ambildatarole['no_telp'];
		$_SESSION['tanggal_mulai'] = $ambildatarole['tanggal_mulai'];
		$_SESSION['tanggal_selesai'] = $ambildatarole['tanggal_selesai'];
		$_SESSION['jenis_cuti'] = $ambildatarole['jenis_cuti'];
		$_SESSION['jumlah_cuti'] = $ambildatarole['jumlah_cuti'];
		$_SESSION['alasan'] = $ambildatarole['alasan'];
		
		if($role=='admin'){
			$_SESSION['log'] = 'Logged';
			$_SESSION['role'] = 'admin';
			header('location:admin');
		}if($role=='pegawai'){
			$_SESSION['log'] = 'Logged';
			$_SESSION['role'] = 'pegawai';
			header('location:user');
		}if($role=='kepala') {
			$_SESSION['log'] = 'Logged';
			$_SESSION['role'] = 'kepala';
			header('location:kepala');
		}
	} 
	}
?>