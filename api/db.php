<?php
// konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simpija";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Validasi koneksi database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
