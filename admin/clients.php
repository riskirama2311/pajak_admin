<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
}
include('../includes/db_connect.php');

// Fetching all clients
$sql = "SELECT * FROM client";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Klien</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Styling untuk sidebar */
        #sidebar {
            background-color: #343a40;
            color: white;
            height: 100vh;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .nav-link {
            color: #f8f9fa !important;
            font-size: 1.1rem;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .nav-link:hover {
            background-color: #495057;
            color: #ffffff;
        }

        .nav-link.active {
            background-color: #007bff;
            color: #ffffff;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        #sidebar h4 {
            font-size: 1.5rem;
            color: #ffffff;
            text-align: center;
            padding: 10px 0;
        }

        /* Styling tambahan untuk tabel */
        .table {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary, .btn-warning, .btn-danger {
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include('../includes/header.php'); ?>

    <!-- Kontainer utama -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="clients.php">
                                <i class="fas fa-users"></i> Kelola Klien
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="consultations.php">
                                <i class="fas fa-file-alt"></i> Kelola Konsultasi Pajak
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Konten utama -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-4">
                <h2 class="mt-4">Daftar Klien</h2>
                <a href="add_client.php" class="btn btn-primary mb-3">Tambah Klien Baru</a>
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Nomor Telepon</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td>
                                <a href="edit_client.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="delete_client.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>

    <!-- Footer -->
    <?php include('../includes/footer.php'); ?>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
