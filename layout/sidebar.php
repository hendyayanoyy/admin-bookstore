<?php
include '../config.php';

// Mengambil jumlah buku dari tabel books
$query = "SELECT COUNT(*) as total FROM books";
$result = mysqli_query($conn, $query);
if ($result) {
    $data = mysqli_fetch_assoc($result);
    $totalBooks = $data['total'];
} else {
    $totalBooks = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="fixed flex flex-col top-0 left-0 w-64 bg-indigo-100 h-full border-r">

        <div class="flex items-center justify-center h-14 border-b">
            <div class="font-bold text-indigo-600 text-2xl">VynStore</div>
        </div>

        <div class="overflow-y-auto overflow-x-hidden flex-grow">
            <ul class="flex flex-col py-4 space-y-1">
                <!-- dashboard -->
                <li>
                    <a href="../layout/panel_dashboard.php" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-indigo-50 text-gray-600 hover:text-indigo-800 border-l-4 border-transparent hover:border-indigo-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <i class="fas fa-home"></i>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Dashboard</span>
                    </a>
                </li>

                <!-- booklist -->
                <li>
                    <a href="../layout/panel_booklist.php" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-indigo-50 text-gray-600 hover:text-indigo-800 border-l-4 border-transparent hover:border-indigo-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <i class="fas fa-book"></i>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Book List</span>
                        <span class="px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-green-500 bg-green-50 rounded-full"><?php echo $totalBooks; ?></span>
                    </a>
                </li>
                <!-- List Transaction -->
                <li>
                    <a href="list_transaction.php" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-indigo-50 text-gray-600 hover:text-indigo-800 border-l-4 border-transparent hover:border-indigo-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <i class="fas fa-receipt"></i>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">List Transaction</span>
                    </a>
                </li>
                <!-- Setting -->
                <li>
                    <a href="setting_admin.php" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-indigo-50 text-gray-600 hover:text-indigo-800 border-l-4 border-transparent hover:border-indigo-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <i class="fa-solid fa-gear"></i> </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Setting</span>
                    </a>
                </li>

                <li>
                    <a href="../controller/logout.php" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-indigo-50 text-gray-600 hover:text-indigo-800 border-l-4 border-transparent hover:border-indigo-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <i class="fas fa-sign-out-alt"></i>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Sidebar Ends -->

</body>

</html>