<?php
include '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus member berdasarkan id
    $query = "DELETE FROM members WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        // Redirect kembali ke halaman panel_members.php setelah berhasil menghapus
        header("Location: ../layout/panel_members.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    // Redirect jika id tidak ada
    header("Location: ../layout/panel_members.php");
}
