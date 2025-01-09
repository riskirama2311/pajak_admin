<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit();
}
include('../includes/db_connect.php');

// Query untuk menghitung jumlah klien
$sql_clients = "SELECT COUNT(*) AS total_clients FROM client";
$result_clients = $conn->query($sql_clients);
$total_clients = $result_clients->fetch_assoc()['total_clients'];

// Query untuk menghitung jumlah admin
$sql_admins = "SELECT COUNT(*) AS total_admins FROM admin";
$result_admins = $conn->query($sql_admins);
$total_admins = $result_admins->fetch_assoc()['total_admins'];

// Query untuk menghitung jumlah konsultan
$sql_consultants = "SELECT COUNT(*) AS total_consultants FROM konsultan";
$result_consultants = $conn->query($sql_consultants);
$total_consultants = $result_consultants->fetch_assoc()['total_consultants'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Styling untuk sidebar */
        #sidebar {
            background-color: #343a40; /* Warna gelap */
            color: white;
            height: 100vh; /* Full height */
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Menambahkan shadow */
        }

        /* Warna teks untuk menu */
        .nav-link {
            color: #f8f9fa !important; /* Warna putih terang untuk teks */
            font-size: 1.1rem; /* Ukuran font sedikit lebih besar */
            padding: 10px 20px;
            border-radius: 5px;
        }

        /* Efek hover pada menu */
        .nav-link:hover {
            background-color: #495057; /* Background saat hover */
            color: #ffffff; /* Warna teks tetap putih saat hover */
        }

        /* Mengubah warna untuk item menu aktif */
        .nav-link.active {
            background-color: #007bff; /* Background biru untuk menu aktif */
            color: #ffffff;
        }

        /* Mengatur jarak antar item menu */
        .nav-item {
            margin-bottom: 10px;
        }

        /* Styling untuk header dashboard */
        #sidebar h4 {
            font-size: 1.5rem;
            color: #ffffff;
            text-align: center;
            padding: 10px 0;
        }

        /* Styling untuk konten dashboard */
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .card-icon {
            font-size: 3rem;
            color: #007bff;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1.2rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <!-- Kontainer utama -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <!-- Menu Kelola Klien -->
                        <li class="nav-item">
                            <a class="nav-link" href="clients.php">
                                <i class="fas fa-users"></i> Kelola Klien
                            </a>
                        </li>
                        <!-- Menu Kelola Konsultan -->
                        <li class="nav-item">
                            <a class="nav-link" href="consultants.php">
                                <i class="fas fa-user-md"></i> Kelola Konsultan
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Konten utama -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-4">
                <h2 class="mt-4">Dashboard</h2>
                <p class="text-muted">Selamat datang, Admin!</p>

                <!-- Statistik -->
                <div class="row mt-4">
                    <!-- Kotak Total Klien -->
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="card-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h5 class="card-title mt-3">Total Klien</h5>
                                <p class="card-text"><?php echo $total_clients; ?> Klien</p>
                            </div>
                        </div>
                    </div>
                    <!-- Kotak Total Admin -->
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="card-icon">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <h5 class="card-title mt-3">Total Admin</h5>
                                <p class="card-text"><?php echo $total_admins; ?> Admin</p>
                            </div>
                        </div>
                    </div>
                    <!-- Kotak Total Konsultan -->
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="card-icon">
                                    <i class="fas fa-user-md"></i>
                                </div>
                                <h5 class="card-title mt-3">Total Konsultan</h5>
                                <p class="card-text"><?php echo $total_consultants; ?> Konsultan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
