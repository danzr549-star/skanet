<?php
session_start();
require "../koneksi.php";

if (!isset($_SESSION['status']) || $_SESSION['status'] !== "sukses") {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: index.php"); exit(); }

$stmt = mysqli_prepare($koneksi, "SELECT * FROM nilai WHERE id_nilai = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$data) { header("Location: index.php"); exit(); }

$siswaList = mysqli_query($koneksi, "SELECT nis, nama FROM siswa ORDER BY nama");
$mapelList = mysqli_query($koneksi, "SELECT id_mapel, mapel FROM mapel ORDER BY mapel");
$guruList  = mysqli_query($koneksi, "SELECT nip, nama FROM guru ORDER BY nama");

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis      = trim($_POST['nis']);
    $id_mapel = trim($_POST['id_mapel']);
    $nip      = trim($_POST['nip']);
    $nilai    = trim($_POST['nilai']);

    if ($nis === '' || $id_mapel === '' || $nip === '' || $nilai === '') {
        $error = "Semua field wajib diisi.";
    } else {
        $stmt = mysqli_prepare($koneksi, "UPDATE nilai SET nis=?, id_mapel=?, nip=?, nilai=? WHERE id_nilai=?");
        mysqli_stmt_bind_param($stmt, "sssii", $nis, $id_mapel, $nip, $nilai, $id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?msg=Data nilai berhasil diupdate");
            exit();
        } else {
            $error = "Gagal update data: " . mysqli_error($koneksi);
        }
    }
    $data = $_POST;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Nilai</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { background: linear-gradient(rgba(10,15,25,0.75), rgba(10,15,25,0.75)), url('../assets/bg-sekolah.jpg') no-repeat center center fixed; background-size: cover; min-height: 100vh; margin:0; padding:30px 20px; color:#fff; }
        .card-glass { background: rgba(255,255,255,0.08); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.18); border-radius:20px; padding:30px; max-width:600px; margin:0 auto; box-shadow: 0 15px 35px rgba(0,0,0,0.5); }
        .form-control, .form-select { background: rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); color:#fff; }
        .form-control:focus, .form-select:focus { background: rgba(255,255,255,0.15); color:#fff; box-shadow:none; border-color:#00d2ff; }
        .form-select option { color:#000; }
        .btn-info-custom { background: linear-gradient(45deg, #00d2ff, #3a7bd5); color:#fff; border:none; }
    </style>
</head>
<body>
<div class="container">
    <h3 class="mb-4 text-center"><i class="bi bi-pencil-square me-2"></i>Edit Nilai</h3>
    <div class="card-glass">
        <?php if ($error): ?><div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Siswa</label>
                <select name="nis" class="form-select" required>
                    <?php while ($s = mysqli_fetch_assoc($siswaList)): ?>
                        <option value="<?= htmlspecialchars($s['nis']) ?>" <?= $s['nis'] === $data['nis'] ? 'selected' : '' ?>><?= htmlspecialchars($s['nama']) ?> (<?= htmlspecialchars($s['nis']) ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Mapel</label>
                <select name="id_mapel" class="form-select" required>
                    <?php while ($m = mysqli_fetch_assoc($mapelList)): ?>
                        <option value="<?= htmlspecialchars($m['id_mapel']) ?>" <?= $m['id_mapel'] === $data['id_mapel'] ? 'selected' : '' ?>><?= htmlspecialchars($m['mapel']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Guru</label>
                <select name="nip" class="form-select" required>
                    <?php while ($g = mysqli_fetch_assoc($guruList)): ?>
                        <option value="<?= htmlspecialchars($g['nip']) ?>" <?= $g['nip'] === $data['nip'] ? 'selected' : '' ?>><?= htmlspecialchars($g['nama']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="form-label">Nilai</label>
                <input type="number" name="nilai" class="form-control" min="0" max="100" value="<?= htmlspecialchars($data['nilai']) ?>" required>
            </div>
            <button type="submit" class="btn btn-info-custom"><i class="bi bi-save me-1"></i> Update</button>
            <a href="index.php" class="btn btn-outline-light">Batal</a>
        </form>
    </div>
</div>
</body>
</html>
