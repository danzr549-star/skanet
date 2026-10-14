<?php
session_start();
require "../koneksi.php";

if (!isset($_SESSION['status']) || $_SESSION['status'] !== "sukses") {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = mysqli_prepare($koneksi, "DELETE FROM nilai WHERE id_nilai = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}
header("Location: index.php?msg=Data nilai berhasil dihapus");
exit();
