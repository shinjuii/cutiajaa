<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Memastikan sesi aktif
}

// Hapus semua data sesi
session_unset(); // Menghapus semua variabel sesi
$_SESSION = []; // Mengosongkan array sesi

// Hapus cookie sesi jika digunakan
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login
header('Location: ../index.php');
exit();
?>