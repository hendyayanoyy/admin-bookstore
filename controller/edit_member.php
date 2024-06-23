<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];

    $query = "UPDATE members SET username='$username', password='$password', name='$name' WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: ../layout/panel_members.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
