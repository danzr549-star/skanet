<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "skanet_dani"; // <-- Pastikan di sini 'skanet_dani'

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
