<?php
include '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM books WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
        header("Location: ../layout/panel_booklist.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
}
