<?php
// Mulai sesi dan cek login admin
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include('../includes/db_connect.php');

// Query untuk mengambil data konsultasi
$sql = "SELECT * FROM consultation ORDER BY date DESC"; // Ambil data konsultasi berdasarkan tanggal
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultations - Admin Pajak</title>
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
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Efek hover pada menu */
        .nav-link:hover {
            background-color: #495057; /* Background abu gelap saat hover */
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

        /* Styling header sidebar */
        #sidebar h4 {
            font-size: 1.5rem;
            color: #ffffff;
            text-align: center;
            padding: 10px 0;
        }

        /* Styling untuk tabel */
        .table {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan */
            overflow: hidden;
        }

        .table thead {
            background-color: #007bff;
            color: #ffffff;
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Styling untuk heading utama */
        h2 {
            color: #007bff;
            font-weight: bold;
        }

        /* Styling tambahan untuk konten utama */
        main {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Tombol untuk aksi */
        .btn-action {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-action:hover {
            background-color: #0056b3;
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
                            <a class="nav-link <?php echo ($_SERVER['REQUEST_URI'] == '/clients.php' ? 'active' : ''); ?>" href="clients.php">
                                <i class="fas fa-users"></i> Kelola Klien
                            </a>
                        </li>
                        <!-- Menu Kelola Konsultasi Pajak -->
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($_SERVER['REQUEST_URI'] == '/consultations.php' ? 'active' : ''); ?>" href="consultations.php">
                                <i class="fas fa-file-alt"></i> Kelola Konsultasi Pajak
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
                <h2 class="text-center mb-4">Konsultasi Pajak - Admin</h2>

                <!-- Tabel untuk menampilkan konsultasi -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Client ID</th>
                            <th>Tanggal Konsultasi</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Menampilkan data konsultasi dari hasil query
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['client_id']}</td>
                                        <td>{$row['date']}</td>
                                        <td>{$row['description']}</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center'>Tidak ada konsultasi tersedia.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close(); // Tutup koneksi database
?>