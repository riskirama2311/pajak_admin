<?php
session_start();
require_once '../includes/db_connect.php'; // Koneksi ke database
include '../includes/header_klien.php';

// Cek apakah user sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login_client.php");
    exit;
}

// Ambil data klien berdasarkan sesi
$name = $_SESSION["name"];
$sql = "SELECT * FROM client WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();
$client = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Klien</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        /* Global styles */
        body {
            background-color: #f5f5f5;
            font-family: 'Arial', sans-serif;
        }

        /* Header styling */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background-color: #343a40;
            color: white;
            z-index: 1000;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
        }

        .header .navbar {
            padding: 0 20px;
        }

        .header .btn-logout {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .header .btn-logout:hover {
            background-color: #c82333;
            color: #fff;
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.2);
        }

        /* Sidebar styling */
        .sidebar {
            position: fixed;
            top: 60px;
            left: 0;
            height: calc(100vh - 60px);
            width: 220px;
            background-color: #212529;
            padding-top: 20px;
            color: white;
            overflow-y: auto;
            box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar a {
            color: white;
            display: block;
            padding: 12px 20px;
            font-size: 15px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #343a40;
            border-left: 4px solid #007bff;
        }

        .sidebar a.active {
            background-color: #007bff;
            border-left: 4px solid #0056b3;
        }

        /* Content styling */
        .content {
            margin-left: 240px;
            margin-top: 60px;
            padding: 30px;
            min-height: calc(100vh - 60px);
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Footer styling */
        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 15px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        /* Card styling */
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow: hidden;
        }

        .card-body {
            padding: 20px;
        }

        /* Enhanced main content */
        .content h2 {
            text-align: center;
            color: #007bff;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .card-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #007bff;
            text-align: center;
        }

        .card hr {
            margin: 20px 0;
            border: 0;
            height: 1px;
            background: #ddd;
        }

        .card p {
            font-size: 1rem;
            line-height: 1.6;
            margin: 10px 0;
        }

        .info-label {
            font-weight: bold;
            color: #555;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="dashboard_klien.php">Dashboard Klien</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="../logout.php" class="btn btn-logout">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="riwayat_klien.php">Daftar Riwayat Konsultasi</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Selamat Datang di Dashboard Klien</h2>

        <!-- Kartu Informasi Klien -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Informasi Anda</h5>
                <hr>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <div>
                        <p><span class="info-label">Nama:</span></p>
                        <p><span class="info-label">Email:</span></p>
                        <p><span class="info-label">Alamat:</span></p>
                        <p><span class="info-label">No. Telepon:</span></p>
                        <p><span class="info-label">Deskripsi:</span></p>
                    </div>
                    <div style="text-align: right;">
                        <p><?php echo htmlspecialchars($client["name"]); ?></p>
                        <p><?php echo htmlspecialchars($client["email"]); ?></p>
                        <p><?php echo htmlspecialchars($client["address"]); ?></p>
                        <p><?php echo htmlspecialchars($client["phone"]); ?></p>
                        <p><?php echo htmlspecialchars($client["description"]); ?></p>
                    </div>
                </div>
                <div class="text-center">
                    <a href="riwayat_klien.php" class="btn btn-primary">Lihat Riwayat Klien yang Sudah Konsultasi</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>
</body>
</html>
