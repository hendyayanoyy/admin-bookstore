<?php
include './config.php';

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../pages/login_page.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validasi apakah password baru dan konfirmasi password sesuai
    if ($newPassword !== $confirmPassword) {
        echo "Password baru dan konfirmasi password tidak sesuai.";
        exit();
    }

    // Hash password baru sebelum disimpan
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Ambil username admin dari session
    $username = $_SESSION['username'];

    // Query untuk mengupdate password admin
    $query = "UPDATE admin SET password = '$hashedPassword' WHERE username = '$username'";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        echo "Password admin berhasil diperbarui.";
        header("Location: ../layout/setting_admin.php");
        // Tutup koneksi ke database
        mysqli_close($conn);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
