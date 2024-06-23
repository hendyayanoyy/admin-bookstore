<?php
require '../config.php';

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../pages/login_page.php");
    exit();
}

// Nonaktifkan caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

// Ambil data admin dari basis data
$user_id = $_SESSION['username'];
$query = "SELECT * FROM admin WHERE username = '$user_id'";
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin VynStore</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        .eye-icon {
            width: 32px;
            /* Ukuran ikon yang diperbesar */
            height: 32px;
            /* Ukuran ikon yang diperbesar */
            filter: brightness(0) invert(1);
            /* Mengubah warna menjadi putih */
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Content -->
    <div class="ml-64">
        <div class="p-4">
            <h1 class="text-2xl font-semibold mb-4">Pengaturan Admin</h1>
            <div class="bg-white p-4 shadow-md rounded-md">
                <h2 class="text-lg font-semibold mb-2">Data Admin</h2>
                <div class="flex items-center mb-4">
                    <div class="w-1/3">Username:</div>
                    <div class="w-2/3"><?php echo $admin['username']; ?></div>
                </div>
                <div class="flex items-center mb-4">
                    <div class="w-1/3">Password:</div>
                    <div class="w-2/3">**********</div> <!-- Tampilkan tanda bintang untuk password -->
                </div>
                <a href="#" class="text-indigo-600 hover:underline" id="ubahPasswordLink">Ubah Password</a>
            </div>

            <!-- Form Ubah Password (awalnya disembunyikan) -->
            <div id="ubahPasswordForm" style="display: none;">
                <div class="bg-white p-4 shadow-md rounded-md mt-4">
                    <h2 class="text-lg font-semibold mb-2 mt-4">Ubah Password</h2>
                    <form action="../controller/edit_password_admin.php" method="post">
                        <div class="mb-4">
                            <label for="newPassword" class="block text-sm font-medium text-gray-700">Password Baru</label>
                            <input type="password" name="newPassword" id="newPassword" class="mt-1 p-2 w-full border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                            <input type="password" name="confirmPassword" id="confirmPassword" class="mt-1 p-2 w-full border rounded-md">
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">Simpan</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Ambil elemen tombol "Ubah Password" dan form ubah password
        const ubahPasswordLink = document.getElementById('ubahPasswordLink');
        const ubahPasswordForm = document.getElementById('ubahPasswordForm');

        // Tambahkan event listener untuk mengatur tampilan form ubah password
        ubahPasswordLink.addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah aksi default dari link

            // Toggle tampilan form ubah password
            if (ubahPasswordForm.style.display === 'none') {
                ubahPasswordForm.style.display = 'block';
            } else {
                ubahPasswordForm.style.display = 'none';
            }
        });
    </script>


</body>

</html>