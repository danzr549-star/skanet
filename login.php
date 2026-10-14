<?php
session_start();
require "koneksi.php";

// Kalau sudah login, langsung ke dashboard
if (isset($_SESSION['status']) && $_SESSION['status'] === "sukses") {
    header("Location: index.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = mysqli_prepare($koneksi, "SELECT id, username, password FROM users WHERE username = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && $password === $user['password']) {
        $_SESSION['status']   = "sukses";
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id']  = $user['id'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body {
            background: linear-gradient(rgba(10,15,25,0.75), rgba(10,15,25,0.75)), url('assets/bg-sekolah.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            color: #fff;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        }
        .form-control {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.15);
            color: #fff;
            box-shadow: none;
            border-color: #00d2ff;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.6); }
        .btn-login {
            background: linear-gradient(45deg, #00d2ff, #3a7bd5);
            border: none;
            color: #fff;
            font-weight: 600;
            width: 100%;
            padding: 10px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <i class="bi bi-shield-lock-fill display-4 text-info"></i>
            <h3 class="mt-2">Login System</h3>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-login">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </button>
        </form>
    </div>
</body>
</html>
