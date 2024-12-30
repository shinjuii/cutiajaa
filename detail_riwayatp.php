<?php
session_start();
include "../koneksi.php";

// Fungsi untuk mencegah inputan karakter yang tidak sesuai
function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Periksa apakah parameter id_formulir tersedia di URL
if (isset($_GET['id_formulir'])) {
    $id_formulir = intval($_GET['id_formulir']); // Pastikan ID adalah angka

// Query untuk mengambil data berdasarkan id_formulir
$stmt = $koneksi->prepare("SELECT formulir.*, user.nama, user.alamat, user.no_telp 
                                FROM formulir
                                JOIN user ON formulir.id_user = user.id_user
                                WHERE formulir.id_formulir = ?");
$stmt->bind_param("i", $id_formulir); // Bind parameter id_formulir

// Eksekusi statement
$stmt->execute();
$result = $stmt->get_result(); // Ambil hasilnya

// Ambil data formulir
$data = $result->fetch_assoc();

// Jika data tidak ditemukan, tampilkan pesan kesalahan
    if (!$data) {
        echo "Data tidak ditemukan!";
        exit();
    }
} else {
    echo "ID formulir tidak ditemukan!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Detail Riwayat pegawai</title>
    <!-- Template untuk font-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Css-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="reviewkepala.css">
</head>

<body id>

            <!-- Main Content -->
            <div id="content">
                
                <!-- Isi Content -->
                <div class="container-fluid" style="padding-left: 12%; padding-right: 12%;">

                    <!-- Judul -->
                    <div class="form-container">
                        
                        <h2 style="font-family: 'Montserrat', sans-serif;"> Review Formulir Pengajuan Cuti</h2>
                        <form action="proses_review.php" method="POST">

                        <input type="hidden" name="id_formulir" value="<?= htmlspecialchars($id_formulir); ?>">
                        <input type="hidden" name="action" value="approve">

                        <label for="nama">Nama Pegawai:</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" readonly/>
                            

                        <label for="id_user">Id Pegawai:</label>
                            <input type="text" class="form-control" id="id_user" name="id_user" value="<?= htmlspecialchars($data['id_user']); ?>" readonly/>
                         

                        <label for="alamat">Alamat:</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?= htmlspecialchars($data['alamat']); ?>" readonly/>

                        <label for="no telp">No Telp:</label>
                            <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= htmlspecialchars($data['no_telp']); ?>" readonly/>
                          
                            <label for="tanggal_diajukan">Tanggal Diajukan:</label>
                            <input type="date" class="form-control" name="tanggal_diajukan" id="tanggal_diajukan" value="<?= htmlspecialchars($data['tanggal_diajukan']); ?>" readonly/>

                        <label for="tanggal_mulai">Tanggal Mulai:</label>
                        <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" value="<?= htmlspecialchars($data['tanggal_mulai']); ?>" readonly/>
            

                        <label for="tanggal_selasai">Tanggal Selesai:</label>
                        <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai" value="<?= htmlspecialchars($data['tanggal_selesai']); ?>" readonly/>
            

                        <label for="jenis_cuti">Jenis Cuti:</label>
                        <input type="text" class="form-control" name="jenis_cuti" id="jenis_cuti" value="<?= htmlspecialchars($data['jenis_cuti']); ?>" readonly/>

                        <label for="jumlah_cuti">Jumlah Cuti:</label>
                            <input type="text" class="form-control" id="jumlah_cuti" name="jumlah_cuti" value="<?= htmlspecialchars($data['jumlah_cuti']); ?>" readonly/>
                           

                        <label for="alasan">Alasan:</label>
                        <textarea class="form-control" id="alasan" name="alasan" required readonly><?= htmlspecialchars($data['alasan']); ?></textarea>

                        <label for="alasan_penolakan">Alasan Ditolak:</label>
                        <textarea class="form-control" id="alasan_penolakan" name="alasan_penolakan" required readonly><?= htmlspecialchars($data['alasan_penolakan']); ?></textarea>

                        

                        <input type="hidden" name="id_user" value="<?= $data['id_user']; ?>">
                        <button type="cancel" name="action" value="cancel" class="btn btn-secondary text-white">Kembali</button>
                        

                        
        </div>
    </div>
</div>

<script>
    // Menangani klik tombol "Setujui"
document.querySelector("button[name='action'][value='approve']").addEventListener("click", function(event) {
    // Tombol setujui akan langsung submit form tanpa pop-up
    document.querySelector('form').submit();
});

// Menampilkan pop-up ketika tombol "Tolak" diklik
document.querySelector("button[name='action'][value='reject']").addEventListener("click", function(event) {
    event.preventDefault(); // Mencegah form untuk submit langsung

    // Menampilkan modal untuk alasan penolakan
    $('#rejectModal').modal('show');
});

// Mengirim alasan penolakan dan submit form
document.querySelector("#rejectModal button[type='submit']").addEventListener("click", function() {
    // Menambahkan alasan penolakan ke dalam form sebelum submit
    var alasanPenolakan = document.getElementById("alasan_penolakan").value;
    if (alasanPenolakan) {
        var alasanInput = document.createElement('input');
        alasanInput.type = 'hidden';
        alasanInput.name = 'alasan_penolakan';
        alasanInput.value = alasanPenolakan;
        document.querySelector('form').appendChild(alasanInput);
        
        // Submit form
        document.querySelector('form').submit();
    } else {
        alert("Alasan penolakan harus diisi.");
    }
});
</script>

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