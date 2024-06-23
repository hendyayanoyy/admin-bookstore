<?php
include '../config.php';

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../pages/login_page.php");
    exit();
}

// Set cache control headers to prevent caching
header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0");

// Mengambil jumlah buku dari tabel books
$query = "SELECT COUNT(*) as total FROM books";
$result = mysqli_query($conn, $query);
if ($result) {
    $data = mysqli_fetch_assoc($result);
    $totalBooks = $data['total'];
} else {
    $totalBooks = 0;
}

// Mengambil total admin dari tabel admin
$query = "SELECT COUNT(*) as total FROM admin";
$result = mysqli_query($conn, $query);
if ($result) {
    $data = mysqli_fetch_assoc($result);
    $totalAdmins = $data['total'];
} else {
    $totalAdmins = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - VynStore</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include 'sidebar.php'; ?>

    <div class="ml-64">
        <div class="p-8">
            <h1 class="mb-6 font-bold text-3xl">Yooo, <br> Welcome, <?php echo $_SESSION['username']; ?> !!</h1>
            <!-- books -->
            <div class="container mt-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h5 class="text-lg font-semibold mb-4 flex items-center">
                            <i class="fas fa-book text-indigo-600 mr-3"></i>
                            Books
                        </h5>
                        <div class="text-xl text-indigo-600"><?php echo $totalBooks; ?></div>
                    </div>

                    <!-- admin -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h5 class="text-lg font-semibold mb-4 flex items-center">
                            <i class="fas fa-users-cog text-indigo-600 mr-3"></i>
                            Admin
                        </h5>
                        <div class="text-xl text-indigo-600"><?php echo $totalAdmins; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>