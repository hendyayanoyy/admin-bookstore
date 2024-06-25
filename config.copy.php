<?php

header('access-control-allow-origin: *');
header("access-control-allow-headers: *");
header("access-control-allow-methods: *");
header("access-control-allow-methods: POST, GET, OPTIONS, PUT, DELETE");
header("access-control-allow-headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Access-Control-Allow-Origin");
header("access-control-allow-credentials: true");
header("access-control-max-age: 86400");
header("access-control-allow-private-network: true");


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookstore";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
