<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM books WHERE id=$id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No record found";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $year = $_POST['year'];
    $author = $_POST['author'];
    $rating = $_POST['rating'];

    // Use existing image if no new image is uploaded
    if (isset($_POST['existing_image'])) {
        $image = $_POST['existing_image'];
    }

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }

    $sql = "UPDATE books SET title='$title', description='$description', image='$image', year='$year', author='$author', rating='$rating' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        header("Location: ../layout/panel_booklist.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
