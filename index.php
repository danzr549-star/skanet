<?php
session_start();

// Pengecekan apakah pengguna sudah login
if (!isset($_SESSION['status']) || $_SESSION['status'] !== "sukses") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Utama - System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * { 
            font-family: 'Poppins', sans-serif; 
        }

        body {
            background: linear-gradient(rgba(10,15,25,0.75), rgba(10,15,25,0.75)), url('assets/bg-sekolah.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            margin: 0;
            padding: 30px 20px;
            color: #fff;
        }

        .dashboard-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .welcome-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 20px;
            padding: 30px;
            color: #fff;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            margin-bottom: 30px;
        }

        .menu-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 20px;
            padding: 25px;
            color: #fff;
            text-align: center;
            text-decoration: none;
            display: block;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .menu-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
            border-color: #00d2ff;
            color: #fff;
            box-shadow: 0 15px 30px rgba(0, 210, 255, 0.3);
        }

        .menu-card i {
            font-size: 3rem;
            color: #00d2ff;
            margin-bottom: 15px;
            display: inline-block;
        }

        .menu-card h4 {
            font-weight: 600;
            margin: 0;
        }

        .btn-danger-custom {
            background: linear-gradient(45deg, #ff416c, #ff4b2b);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 10px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 65, 108, 0.4);
        }

        .btn-danger-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(255, 65, 108, 0.7);
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container dashboard-container">
    <div class="welcome-card text-center">
        <i class="bi bi-person-circle display-4 text-info mb-2"></i>
        <h2>Selamat Datang!</h2>
        <p class="mb-3">Halo, <b><?= htmlspecialchars($_SESSION['username'] ?? 'User'); ?></b>. Silakan pilih menu di bawah untuk mengelola data:</p>
        <a href="logout.php" class="btn btn-danger-custom">
            <i class="bi bi-box-arrow-right me-1"></i> LOGOUT
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-lg-3">
            <a href="guru/index.php" class="menu-card">
                <i class="bi bi-person-badge-fill"></i>
                <h4>Data Guru</h4>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="siswa/index.php" class="menu-card">
                <i class="bi bi-people-fill"></i>
                <h4>Data Siswa</h4>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="mapel/index.php" class="menu-card">
                <i class="bi bi-journal-bookmark-fill"></i>
                <h4>Data Mapel</h4>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="nilai/index.php" class="menu-card">
                <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                <h4>Data Nilai</h4>
            </a>
        </div>
    </div>
</div>

</body>
</html>