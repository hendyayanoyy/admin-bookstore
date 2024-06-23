<?php
require '../config.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login_page.php");
    exit();
}

// Nonaktifkan caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

// Ambil data admin dari basis data
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM admins WHERE id = $user_id";
$result = mysqli_query($conn, $query);

// Periksa apakah query berhasil dieksekusi
if ($result) {
    // Ambil baris data admin
    $admin = mysqli_fetch_assoc($result);
} else {
    // Handle kesalahan jika query tidak berhasil dieksekusi
    echo "Error: " . mysqli_error($conn);
}

// Tutup koneksi ke basis data
mysqli_close($conn);
