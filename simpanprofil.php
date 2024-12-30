<?php
// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "cutiaja");

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Fungsi untuk mencegah inputan karakter yang tidak sesuai
function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Cek apakah ada kiriman form dari method post
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = input($_POST["nama"]);
    $id_user = input($_POST["id_user"]);
    $alamat = input($_POST["alamat"]);
    $no_telp = input($_POST["no_telp"]);
    
    
    // Status default

        $status = 'Sedang diproses'; // Atur default jika tidak ada

    // Query input menginput data kedalam tabel peserta
    $sql ="UPDATE users SET nama = '$nama', id_user = '$id_user', alamat = '$alamat', no_telp = '$no_telp', WHERE id_user = '$id_user'";

    // Mengeksekusi/menjalankan query diatas
    $hasil = mysqli_query($koneksi, $sql);

    // Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
    if ($hasil) {
        header("Location: index.php");
        exit(); // Pastikan untuk keluar setelah redirect
    } else {
        echo "<div class='alert alert-danger'> Data Gagal disimpan: " . mysqli_error($koneksi) . "</div>";
    }
}

// Menutup koneksi
mysqli_close($koneksi);
?>