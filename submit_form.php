<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cutiaja";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari formulir
$id_user = $_POST['id_user'];
$tanggal_mulai = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];
$jenis_cuti = $_POST['jenis_cuti'];
$jumlah_cuti = (int)$_POST['jumlah_cuti'];
$alasan = $_POST['alasan'];

// Daftar hari libur (bisa diganti dengan data dari database)
$hari_libur = ["2024-01-05", "2024-04-07"]; // Contoh hari libur nasional

// Hitung jumlah hari kerja antara tanggal mulai dan tanggal selesai
$tanggal_mulai_obj = new DateTime($tanggal_mulai);
$tanggal_selesai_obj = new DateTime($tanggal_selesai);
$interval = $tanggal_mulai_obj->diff($tanggal_selesai_obj);

// Iterasi setiap hari dalam rentang tanggal
$selisih_hari = 0;
for ($date = $tanggal_mulai_obj; $date <= $tanggal_selesai_obj; $date->modify('+1 day')) {
    $current_date = $date->format('Y-m-d');
    $day_of_week = $date->format('N'); // 1 = Senin, 7 = Minggu

    // Abaikan hari libur dan akhir pekan (Sabtu dan Minggu)
    if (!in_array($current_date, $hari_libur) && $day_of_week < 6) {
        $selisih_hari++;
    }
}

// Validasi apakah jumlah hari kerja sesuai dengan jumlah cuti yang diajukan
if ($selisih_hari != $jumlah_cuti) {
    echo "Jumlah hari kerja ($selisih_hari hari) tidak sesuai dengan jumlah cuti yang diajukan ($jumlah_cuti hari).";
    exit();
}

// Ambil sisa cuti pengguna berdasarkan jenis cuti
$sql_cuti = "SELECT * FROM cuti WHERE id_user = $id_user AND jenis_cuti = '$jenis_cuti'";
$result_cuti = $conn->query($sql_cuti);

if ($result_cuti->num_rows > 0) {
    $cuti = $result_cuti->fetch_assoc();

    // Validasi apakah sisa cuti mencukupi
    if ($cuti['sisa_cuti'] >= $jumlah_cuti) {
        // Kurangi sisa cuti
        $sisa_cuti_baru = $cuti['sisa_cuti'] - $jumlah_cuti;
        $sql_update_cuti = "UPDATE cuti SET sisa_cuti = $sisa_cuti_baru WHERE id_cuti = " . $cuti['id_cuti'];
        $conn->query($sql_update_cuti);

        // Simpan data ke tabel formulir_pengajuan
        $sql_insert_formulir = "INSERT INTO formulir (id_user, tanggal_mulai, tanggal_selesai, jenis_cuti, jumlah_cuti, alasan) 
                                VALUES ('$id_user', '$tanggal_mulai', '$tanggal_selesai','$jenis_cuti', $jumlah_cuti, '$alasan')";
        if ($conn->query($sql_insert_formulir) === TRUE) {
            // Redirect ke halaman dashboard
            header("Location: index.php");
            exit(); // Pastikan script berhenti setelah redirect
        } else {
            echo "Gagal menyimpan pengajuan: " . $conn->error;
        }
    } else {
        echo "Sisa cuti tidak mencukupi untuk jenis cuti $jenis_cuti.";
    }
} else {
    echo "Data sisa cuti untuk user dan jenis cuti ini tidak ditemukan.";
}

// Tutup koneksi
$conn->close();
?>
