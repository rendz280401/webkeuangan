<?php
$host = "localhost"; // Ganti dengan host database Anda
$user = "root";      // Ganti dengan username database Anda
$pass = "";          // Ganti dengan password database Anda
$dbname = "manajemen"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

