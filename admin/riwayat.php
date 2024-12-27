<?php
session_start();
require_once '../includes/db_connect.php';
include '../includes/header_konsultan.php'; // Tambahkan header

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'consultant') {
    header("Location: ../login_consultant.php");
    exit;
}

// Ambil riwayat konsultasi
$consultations_query = $conn->query("
    SELECT consultation.id, client.name, consultation.date, consultation.description 
    FROM consultation 
    JOIN client ON consultation.client_id = client.id 
    ORDER BY consultation.date DESC
");
$consultations = $consultations_query->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Konsultasi</title>
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

        /* Table styling */
        .table-striped {
            border: 1px solid #ddd;
            border-collapse: collapse;
            width: 100%;
        }

        .table-striped th, .table-striped td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
            vertical-align: middle;
        }

        .table-striped th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .table-striped tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .table-striped tr:nth-child(even) {
            background-color: #ffffff;
        }

        .table-striped tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="dashboard_consultant.php">Dashboard Konsultan</a>
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
        <a href="Konsultanclients.php">Klien</a>
        <a href="riwayat.php" class="active">Riwayat Konsultasi</a>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="container">
            <div class="row mb-4">
                <div class="col text-center">
                    <h2 class="mb-0">Riwayat Konsultasi</h2>
                    <p class="text-muted">Riwayat konsultasi dengan klien yang telah dilakukan.</p>
                </div>
            </div>

            <!-- Tabel Riwayat Konsultasi -->
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Klien</th>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($consultations as $index => $consultation): ?>
                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td><?= htmlspecialchars($consultation['name']); ?></td>
                                <td><?= htmlspecialchars($consultation['date']); ?></td>
                                <td><?= htmlspecialchars($consultation['description']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>
</body>
</html>
