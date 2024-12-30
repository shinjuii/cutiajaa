<?php
session_start();

//Include file koneksi, untuk koneksikan ke database
include "../koneksi.php";

//Fungsi untuk mencegah inputan karakter yang tidak sesuai
function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Periksa apakah session nama sudah ada atau berasal dari input POST
if (isset($_SESSION['nama'])) {
    $nama = $_SESSION['nama'];
} else {
    $nama = isset($_POST['nama']) ? input($_POST['nama']) : '';
}
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
} else {
    $id_user = isset($_POST['id_user']) ? input($_POST['id_user']) : '';
}
if (isset($_SESSION['alamat'])) {
    $alamat = $_SESSION['alamat'];
} else {
    $alamat = isset($_POST['alamat']) ? input($_POST['alamat']) : '';
}
if (isset($_SESSION['no_telp'])) {
    $no_telp = $_SESSION['no_telp'];
} else {
    $no_telp = isset($_POST['no_telp']) ? input($_POST['no_telp']) : '';
}



// Cek apakah ada kiriman form dari method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = input($_POST["id_user"]);
    $alamat = input($_POST["alamat"]);
    $no_hp = input($_POST["no_telp"]);
    

    // Query input untuk menginput data ke tabel peserta
    $sql = "INSERT INTO user (nama, id_user, alamat, no_hp) 
            VALUES ('$nama', '$id', '$alamat', '$no_hp')";

    // Eksekusi query
    $hasil = mysqli_query($koneksi, $sql);

    // Kondisi apakah berhasil atau tidak
    if ($hasil) {
        header("Location:index.php");
    } else {
        echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profil</title>
    <!-- Template untuk font-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Css-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>

<body id>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-8AA65A sidebar " id="bg-custom">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" ">
                <div class="sidebar-brand-icon rotate-n-15">
                </div>
                <div class="sidebar-brand-text mx-3" id="user-head">PEGAWAI</div>
            </a>

            <hr class="sidebar-divider my-0">
            <img alt="Profile Picture" src="images.jpg" class="profile-image"/>
            <p><?php echo htmlspecialchars($_SESSION['nama']); ?></p>

            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span></a>
            </li>
            

            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="riwayatp.php">
                    <i class="fas fa-bell"></i>
                    <span>Riwayat Cuti</span></a>
            </li>

            <hr class="sidebar-divider">

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

        <!--Navbar-->
        <nav class="navbar navbar-expand navbar-light topbar navbar-custom">

                    <!-- Garis tiga buat nampilin sidebar -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    
                    <ul class="navbar-nav ml-auto">

                        <!-- NOTIFIKASI -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notifikasi
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">Pegawai baru saja mengajukan cuti kepada Anda</span>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Profile -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-white-600 small"><?php echo htmlspecialchars($_SESSION['nama']); ?></span>
                                <img class="img-profile rounded-circle"
                                    src="images.jpg">
                            </a>
                            <!-- Kunjungi profile -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                               <!-- Keluar dari akun --> 
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

            <!-- Main Content -->
            <div id="content">
                

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Tabel -->
                    <div class="form-container">
                    <img alt="Foto Profil" src="<?php echo $_SESSION['foto_user']; ?>" class="profile-image" />
                        <h2>Profil Pegawai</h2>
                        <form action="" method="post" enctype="multipart/form-data">
            <label for="nama">Nama Pegawai:</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($nama); ?>" readonly/>

            <label for="email">Id Pegawai:</label>
            <input type="text" id="id_user" name="id_user" value="<?php echo htmlspecialchars($id_user); ?>" readonly/>

            <label for="alamat">Alamat:</label>
            <input type="text" id="alamat" name="alamat" value="<?php echo htmlspecialchars($alamat); ?>" readonly/>

            <label for="no telp">No Telp:</label>
            <input type="text" id="no_telp" name="no_telp" value="<?php echo htmlspecialchars($no_telp); ?>" readonly/>

            <div class="form-group mt-2">
                <a href="ubahprofil.php" class="btn btn-primary text-white">Ubah</a>
            </div>
        </form>
    </div>

                    
                        

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>