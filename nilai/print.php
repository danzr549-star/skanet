<?php
session_start();
require "../koneksi.php";

if (!isset($_SESSION['status']) || $_SESSION['status'] !== "sukses") {
    header("Location: ../login.php");
    exit();
}

$sql = "SELECT nilai.nis, siswa.nama AS nama_siswa, siswa.kelas, mapel.mapel AS nama_mapel, guru.nama AS nama_guru, nilai.nilai
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
    <title>Cetak Data Nilai</title>
    <style>
        * { font-family: Arial, Helvetica, sans-serif; box-sizing: border-box; }
        body { margin: 30px; color: #000; }
        h2, p { text-align: center; margin: 4px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px 10px; text-align: left; font-size: 14px; }
        th { background: #eee; }
        .no-print { text-align: center; margin-bottom: 20px; }
        .no-print button {
            padding: 8px 20px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            background: #3a7bd5;
            color: #fff;
            cursor: pointer;
            margin: 0 5px;
        }
        @media print {
            .no-print { display: none; }
            body { margin: 10px; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.print()">🖨️ Cetak / Print</button>
        <button onclick="window.close()">Tutup</button>
    </div>

    <h2>DATA NILAI SISWA</h2>
    <p>SMKN 1 Takeran</p>
    <p>Tanggal cetak: <?= date("d-m-Y") ?></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Mapel</th>
                <th>Guru</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nis']) ?></td>
                <td><?= htmlspecialchars($row['nama_siswa'] ?? '-') ?></td>
                <td><?= htmlspecialchars($row['kelas'] ?? '-') ?></td>
                <td><?= htmlspecialchars($row['nama_mapel'] ?? '-') ?></td>
                <td><?= htmlspecialchars($row['nama_guru'] ?? '-') ?></td>
                <td><?= htmlspecialchars($row['nilai']) ?></td>
            </tr>
        <?php endwhile; ?>
        <?php if ($no === 1): ?>
            <tr><td colspan="7" style="text-align:center;">Belum ada data.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
