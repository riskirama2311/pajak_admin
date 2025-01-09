<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit();
}
include('../includes/db_connect.php');

// Menangani aksi tambah konsultan
if (isset($_POST['add_consultant'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; // Simpan password tanpa di-hash

    $sql_add = "INSERT INTO konsultan (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql_add) === TRUE) {
        $_SESSION['message'] = "Konsultan berhasil ditambahkan!";
        header('Location: consultants.php');
        exit();
    } else {
        $_SESSION['error'] = "Terjadi kesalahan: " . $conn->error;
    }
}

// Menangani aksi update konsultan
if (isset($_POST['update_consultant'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = !empty($_POST['password']) ? $_POST['password'] : null; // Jika password kosong, jangan ubah

    if ($password) {
        $sql_update = "UPDATE konsultan SET username='$username', password='$password' WHERE id=$id";
    } else {
        $sql_update = "UPDATE konsultan SET username='$username' WHERE id=$id";
    }

    if ($conn->query($sql_update) === TRUE) {
        $_SESSION['message'] = "Konsultan berhasil diperbarui!";
        header('Location: consultants.php');
        exit();
    } else {
        $_SESSION['error'] = "Terjadi kesalahan: " . $conn->error;
    }
}

// Menangani aksi delete konsultan
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM konsultan WHERE id=$id";
    if ($conn->query($sql_delete) === TRUE) {
        $_SESSION['message'] = "Konsultan berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Terjadi kesalahan: " . $conn->error;
    }
    header('Location: consultants.php');
    exit();
}

// Mengambil data konsultan
$sql_consultants = "SELECT * FROM konsultan";
$result_consultants = $conn->query($sql_consultants);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Konsultan</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Pastikan sidebar dan header sesuai dengan yang ada di dashboard.php */
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

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="clients.php">
                                <i class="fas fa-users"></i> Kelola Klien
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="consultants.php">
                                <i class="fas fa-user-md"></i> Kelola Konsultan
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-4">
                <h2 class="mt-4">Kelola Konsultan</h2>

                <?php
                if (isset($_SESSION['message'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
                    unset($_SESSION['message']);
                }

                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']);
                }
                ?>

                <!-- Tabel Daftar Konsultan -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_consultants->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo htmlspecialchars($row['password']); ?></td> <!-- Menampilkan password plaintext -->
                                    <td>
                                        <a href="edit_consultant.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus konsultan ini?');">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Button untuk Menambah Konsultan -->
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addConsultantModal">
                    <i class="fas fa-plus"></i> Tambah Konsultan
                </button>

                <!-- Modal Tambah Konsultan -->
                <div class="modal fade" id="addConsultantModal" tabindex="-1" aria-labelledby="addConsultantModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addConsultantModalLabel">Tambah Konsultan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="consultants.php" method="POST">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="add_consultant">Tambah</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
