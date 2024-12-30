<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['log']) || $_SESSION['log'] !== 'Logged') {
    header('Location: login.php'); // Redirect ke halaman login jika belum login
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Riwayat Cuti</title>
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

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
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

            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="#">
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
                                <a class="dropdown-item" href="profil.php">
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
                            <!-- Logout Modal-->
                            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Yakin ingin logout?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Pilih "Logout" jika Anda ingin keluar dari akun Anda.</div>
                            <div class="modal-footer">
                            <button class="btn btn-secondary text-white" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-primary text-white" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

            <!-- Main Content -->
            
            <div id="content">
                

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Judul -->
                    
                    <div class="card">
                        <div class="card-body">
                            Riwayat Cuti Pegawai
                        </div>
                    </div>

                    <!-- Tabel -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">No</th>
                            <th scope="col">Tanggal Diajukan</th>
                            <th scope="col">Jenis Cuti</th>
                            <th scope="col">Tanggal Mulai</th>
                            <th scope="col">Status</th>
                            <th colspan="3" scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php include "../koneksi.php";

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    echo "<tr><td colspan='100%'>Silakan login terlebih dahulu.</td></tr>";
    exit();
}

// Query untuk mengambil data formulir berdasarkan id_user dan status Pending
// Query untuk mengambil data formulir berdasarkan id_user dan status "disetujui" atau "ditolak"
$sql = "SELECT * FROM formulir WHERE id_user = ? AND (status = 'disetujui' OR status = 'ditolak')";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $_SESSION['id_user']);
$stmt->execute();
$result = $stmt->get_result();

// Periksa apakah data ditemukan
if ($result->num_rows < 1) {
    echo "<tr><td colspan='100%'>Tidak ada data yang ditemukan!</td></tr>";
} else {
    $no = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$row['tanggal_diajukan']}</td>
                                    <td>{$row['jenis_cuti']}</td>
                                    <td>{$row['tanggal_mulai']}</td>
                                    <td>{$row['status']}</td>
                                    <td>
                                    <a href='detail_riwayatp.php?id_formulir={$row['id_formulir']}' class='btn'><i class='fas fa-edit mr-2'></i> Klik</a>
                                    </td>
                                </tr>";
        $no++;
    }
}

// Tutup statement
$stmt->close();

?>

                       
                    </tbody>
                        
                    </table>

                    
                        

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