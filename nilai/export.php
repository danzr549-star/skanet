<?php
session_start();
require "../koneksi.php";

if (!isset($_SESSION['status']) || $_SESSION['status'] !== "sukses") {
    header("Location: ../login.php");
    exit();
}

$sql = "SELECT nilai.nis, siswa.nama AS nama_siswa, mapel.mapel AS nama_mapel, guru.nama AS nama_guru, nilai.nilai
        FROM nilai
        LEFT JOIN siswa ON nilai.nis = siswa.nis
        LEFT JOIN mapel ON nilai.id_mapel = mapel.id_mapel
        LEFT JOIN guru ON nilai.nip = guru.nip
        ORDER BY nilai.id_nilai DESC";
$result = mysqli_query($koneksi, $sql);

$filename = "data-nilai-" . date("Y-m-d") . ".xls";

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

echo "\xEF\xBB\xBF"; // BOM biar karakter spesial kebaca benar di Excel
?>
<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
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
            <td><?= htmlspecialchars($row['nama_mapel'] ?? '-') ?></td>
            <td><?= htmlspecialchars($row['nama_guru'] ?? '-') ?></td>
            <td><?= htmlspecialchars($row['nilai']) ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
