<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $year = $_POST['year'];
    $author = $_POST['author'];
    $rating = $_POST['rating'];
    $image = '';

    if (isset($_FILES['image'])) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        // Move the uploaded file to the server
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $sql = "INSERT INTO books (title, description, image, year, author, rating) VALUES ('$title', '$description', '$image', '$year', '$author', '$rating')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("Location: ../layout/panel_booklist.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
