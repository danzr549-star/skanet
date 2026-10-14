<?php
session_start();
require "../koneksi.php";

if (!isset($_SESSION['status']) || $_SESSION['status'] !== "sukses") {
    header("Location: ../login.php");
    exit();
}

$result = mysqli_query($koneksi, "SELECT * FROM mapel ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mapel - System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { background: linear-gradient(rgba(10,15,25,0.75), rgba(10,15,25,0.75)), url('../assets/bg-sekolah.jpg') no-repeat center center fixed; background-size: cover; min-height: 100vh; margin:0; padding:30px 20px; color:#fff; }
        .card-glass { background: rgba(255,255,255,0.08); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.18); border-radius:20px; padding:25px; box-shadow: 0 15px 35px rgba(0,0,0,0.5); }
        .table { color: #fff; }
        .table thead { border-bottom: 2px solid rgba(255,255,255,0.2); }
        .table td, .table th { vertical-align: middle; border-color: rgba(255,255,255,0.1); }
        .btn-info-custom { background: linear-gradient(45deg, #00d2ff, #3a7bd5); color: #fff; border: none; }
        .btn-info-custom:hover { color: #fff; opacity: 0.9; }
    </style>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="bi bi-journal-bookmark-fill me-2"></i>Data Mapel</h3>
        <a href="../index.php" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <div class="card-glass">
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success py-2"><?= htmlspecialchars($_GET['msg']) ?></div>
        <?php endif; ?>

        <div class="mb-3">
            <a href="tambah.php" class="btn btn-info-custom"><i class="bi bi-plus-circle me-1"></i> Tambah Mapel</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID Mapel</th>
                        <th>Kode Mapel</th>
                        <th>Nama Mapel</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['id_mapel']) ?></td>
                        <td><?= htmlspecialchars($row['kode_mapel'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['mapel']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                            <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php if ($no === 1): ?>
                    <tr><td colspan="5" class="text-center">Belum ada data.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
