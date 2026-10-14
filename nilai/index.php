<?php
session_start();
require "../koneksi.php";

if (!isset($_SESSION['status']) || $_SESSION['status'] !== "sukses") {
    header("Location: ../login.php");
    exit();
}

$sql = "SELECT nilai.*, siswa.nama AS nama_siswa, mapel.mapel AS nama_mapel, guru.nama AS nama_guru
        FROM nilai
        LEFT JOIN siswa ON nilai.nis = siswa.nis
        LEFT JOIN mapel ON nilai.id_mapel = mapel.id_mapel
        LEFT JOIN guru ON nilai.nip = guru.nip
        ORDER BY nilai.id_nilai DESC";
$result = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Nilai - System</title>
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
        .badge-nilai { font-size: 0.95rem; padding: 6px 12px; }
    </style>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="bi bi-file-earmark-spreadsheet-fill me-2"></i>Data Nilai</h3>
        <a href="../index.php" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <div class="card-glass">
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success py-2"><?= htmlspecialchars($_GET['msg']) ?></div>
        <?php endif; ?>

        <div class="mb-3 d-flex gap-2 flex-wrap">
            <a href="tambah.php" class="btn btn-info-custom"><i class="bi bi-plus-circle me-1"></i> Tambah Nilai</a>
            <a href="export.php" class="btn btn-success"><i class="bi bi-file-earmark-excel me-1"></i> Export Excel</a>
            <a href="print.php" target="_blank" class="btn btn-secondary"><i class="bi bi-printer me-1"></i> Print</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Mapel</th>
                        <th>Guru</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nis']) ?></td>
                        <td><?= htmlspecialchars($row['nama_siswa'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['nama_mapel'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['nama_guru'] ?? '-') ?></td>
                        <td><span class="badge bg-info badge-nilai"><?= htmlspecialchars($row['nilai']) ?></span></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id_nilai'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                            <a href="hapus.php?id=<?= $row['id_nilai'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php if ($no === 1): ?>
                    <tr><td colspan="7" class="text-center">Belum ada data.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
