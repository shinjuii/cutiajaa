<?php
session_start();

// Include file koneksi
include "../koneksi.php";

// Fungsi untuk mencegah inputan karakter yang tidak sesuai
function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Ambil data dari session atau input POST
$nama = $_SESSION['nama'] ?? input($_POST['nama']);
$alamat = $_SESSION['alamat'] ?? input($_POST['alamat']);
$no_telp = $_SESSION['no_telp'] ?? input($_POST['no_telp']);

// Cek apakah ada kiriman form dari method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_user = input($_POST["id_user"]);
    $tanggal_mulai = input($_POST["tanggal_mulai"]);
    $tanggal_selesai = input($_POST["tanggal_selesai"]);
    $jenis_cuti = input($_POST["jenis_cuti"]);
    $jumlah_cuti = input($_POST["jumlah_cuti"]);
    $alasan = htmlspecialchars(input($_POST["alasan"]));

    // Validasi data
    if (empty($id_user) || empty($jenis_cuti) || empty($jumlah_cuti) || empty($tanggal_mulai) || empty($tanggal_selesai)) {
        echo "<div class='alert alert-danger'>Semua field wajib diisi.</div>";
        exit;
    }

    // Validasi tanggal
    if (strtotime($tanggal_mulai) > strtotime($tanggal_selesai)) {
        echo "<div class='alert alert-danger'>Tanggal mulai tidak boleh lebih besar dari tanggal selesai.</div>";
        exit;
    }

    // Cek sisa cuti
    $sql = "SELECT sisa_cuti FROM cuti WHERE id_user = ? AND jenis_cuti = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("ii", $id_user, $jenis_cuti);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $sisa_cuti = $row['sisa_cuti'];

        if ($jumlah_cuti > $sisa_cuti) {
            echo "<div class='alert alert-danger'>Error: Sisa cuti tidak mencukupi untuk jenis cuti ini.</div>";
        } else {
            // Masukkan data pengajuan cuti
            $sql_insert = "INSERT INTO formulir (id_user, nama, alamat, no_telp, jenis_cuti, jumlah_cuti, tanggal_mulai, tanggal_selesai, alasan) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_insert = $kon->prepare($sql_insert);
            $stmt_insert->bind_param("issssisss", $id_user, $nama, $alamat, $no_telp, $jenis_cuti, $jumlah_cuti, $tanggal_mulai, $tanggal_selesai, $alasan);

            if ($stmt_insert->execute()) {
                // Kurangi sisa cuti
                $sql_update = "UPDATE cuti SET sisa_cuti = sisa_cuti - ? WHERE id_user = ? AND jenis_cuti = ?";
                $stmt_update = $kon->prepare($sql_update);
                $stmt_update->bind_param("iis", $jumlah_cuti, $id_user, $jenis_cuti);

                if ($stmt_update->execute()) {
                    echo "<div class='alert alert-success'>Pengajuan cuti berhasil!</div>";
                    header("Location: index.php");
                    exit;
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $stmt_update->error . "</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Error: " . $stmt_insert->error . "</div>";
            }
        }
    } else {
        echo "<div class='alert alert-danger'>Error: Jenis cuti ini tidak ditemukan untuk karyawan.</div>";
    }

    $stmt->close();
    $kon->close();
}
?>
