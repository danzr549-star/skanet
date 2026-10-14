<?php
session_start();
require "../koneksi.php";

if (!isset($_SESSION['status']) || $_SESSION['status'] !== "sukses") {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = mysqli_prepare($koneksi, "DELETE FROM siswa WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}
header("Location: index.php?msg=Data siswa berhasil dihapus");
exit();
