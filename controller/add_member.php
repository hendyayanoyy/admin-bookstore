<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];

    $query = "INSERT INTO members (username, password, name) VALUES ('$username', '$password', '$name')";

    if (mysqli_query($conn, $query)) {
        header("Location: ../layout/panel_members.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
