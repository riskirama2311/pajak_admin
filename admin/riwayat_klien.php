<?php
session_start();
require_once '../includes/db_connect.php'; // Koneksi ke database
include '../includes/header_klien.php';

// Cek apakah user sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login_client.php");
    exit;
}

// Ambil data riwayat konsultasi (seperti pada riwayat.php)
$riwayat_query = $conn->query("SELECT riwayat_konsultasi.id, riwayat_konsultasi.name, riwayat_konsultasi.email, riwayat_konsultasi.description, DATE(riwayat_konsultasi.deleted_at) AS deleted_date 
                               FROM riwayat_konsultasi 
                               ORDER BY riwayat_konsultasi.deleted_at DESC");
$riwayat = $riwayat_query->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Konsultasi Klien</title>
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

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:nth-child(odd) {
            background-color: #ffffff;
        }

        tr:hover {
            background-color: #f1f1f1;
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
        <a href="riwayat_klien.php" class="active">Daftar Riwayat Konsultasi</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2 class="mb-4">Daftar Riwayat Konsultasi</h2>

        <!-- Tabel Riwayat -->
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Konsultasi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($riwayat) > 0): ?>
                    <?php $index = 1; ?>
                    <?php foreach ($riwayat as $row): ?>
                        <tr>
                            <td><?= $index++; ?></td>
                            <td><?= htmlspecialchars($row["name"]); ?></td>
                            <td><?= htmlspecialchars($row["email"]); ?></td>
                            <td><?= htmlspecialchars($row["description"]); ?></td>
                            <td><?= htmlspecialchars($row["deleted_date"]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Belum ada riwayat konsultasi.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>
</body>
</html>
