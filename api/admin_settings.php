<?php
include '../config.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login_page.php");
    exit();
}

// Nonaktifkan caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM admins WHERE id = $user_id";
$result = mysqli_query($conn, $query);

if ($result) {
    $admin = mysqli_fetch_assoc($result);
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
