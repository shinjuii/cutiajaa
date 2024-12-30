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
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
} else {
    $id_user = isset($_POST['id_user']) ? input($_POST['id_user']) : '';
}
if (isset($_SESSION['nama'])) {
    $nama = $_SESSION['nama'];
} else {
    $nama = isset($_POST['nama']) ? input($_POST['nama']) : '';
}
if (isset($_SESSION['kode_departemen'])) {
    $kode_departemen = $_SESSION['kode_departemen'];
} else {
    $kode_departemen = isset($_POST['kode_departemen']) ? input($_POST['kode_departemen']) : '';
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
    $kode_departemen = input($_POST["kode_departemen"]);
    $alamat = input($_POST["alamat"]);
    $no_hp = input($_POST["no_telp"]);
    $awal = input($_POST["tanggal_mulai"]);
    $akhir = input($_POST["tanggal_selesai"]);

    // Query input untuk menginput data ke tabel peserta
    $sql = "INSERT INTO peserta (nama, kode_departemen, id_user, alamat, no_hp, tanggal_mulai, tanggal_selesai) 
            VALUES ('$nama', '$kode_departemen', '$id', '$alamat', '$no_hp', '$awal', '$akhir')";

    // Eksekusi query
    $hasil = mysqli_query($kon, $sql);

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body>


    
<div class="container container-fluid">
    <div class="card">
        <div class="card-header">Formulir Pengajuan Cuti</div>

        <div class="card-body">
            <form action="submit_form.php" method="POST">
                <div class="form-group">
                </div>

                <div class="form-group">
                    <label for="id_user">ID Pegawai <b class="text-danger">*</b></label>
                    <input type="text" class="form-control" name="id_user" id="id_user" value="<?php echo htmlspecialchars($id_user); ?>" readonly/>
                </div>

                <div class="form-group">
                    <label for="nama">Nama Pegawai <b class="text-danger">*</b></label>
                    <input type="text" class="form-control" name="nama" id="nama" value="<?php echo htmlspecialchars($nama); ?>" readonly/>
                </div>

                <div class="form-group">
                    <label for="kode_departemen">Departemen<b class="text-danger">*</b></label>
                    <input type="text" class="form-control" name="kode_departemen" id="kode_departemen" value="<?php echo htmlspecialchars($kode_departemen); ?>" readonly/>
                </div>
                
                
                <div class="form-group">
                    <label for="alamat">alamat <b class="text-danger">*</b></label>
                    <input type="text" class="form-control" name="alamat" id="alamat" value="<?php echo htmlspecialchars($alamat); ?>" readonly/>
                </div>
                
                <div class="form-group">
                    <label for="no_telp">No Telp <b class="text-danger">*</b></label>
                    <input type="text" class="form-control" name="no_telp" id="no_telp" value="<?php echo htmlspecialchars($no_telp); ?>" readonly/>
                </div>

                <div class="form-group">
                    <label for="tanggal_mulai">Tanggal Mulai <b class="text-danger">*</b></label>
                    <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" required/>
                </div>

                <div class="form-group">
                    <label for="tanggal_selesai ">Tanggal Berakhir <b class="text-danger">*</b></label>
                    <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai" required/>
                </div>
                
                <div class="form-group">
                    <label for="jenis_cuti ">Jenis Cuti <b class="text-danger">*</b></label>
                    <select id="jenis_cuti" name="jenis_cuti" required>
                        <option value="tahunan">Cuti Tahunan</option>
                        <option value="ayah">Cuti Ayah</option>
                        <option value="melahirkan">Cuti Melahirkan</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="jumlah_cuti">Jumlah Cuti<b class="text-danger">*</b></label>
                    <input type="text" class="form-control" name="jumlah_cuti" id="jumlah_cuti" required/>
                </div>
                
                <div class="form-group">
                    <label for="alasan">Alasan<b class="text-danger">*</b></label>
                    <textarea type="text" class="form-control" name="alasan" id="alasan" required></textarea>
                </div>

                <!-- Kolom status (disembunyikan) -->
                <input type="hidden" name="status" value="Sedang Diproses"/>

                <div class="form-group mt-2">
                    <button class="btn btn-primary" type="submit" name="submit">Ajukan</button>
                </div>
            </form>
            </form>

        </div>
    </div>
</div>

<script src="js/bootstrap.min.js"></script>
</body>
</html>