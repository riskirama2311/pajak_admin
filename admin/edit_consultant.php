<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit();
}

include('../includes/db_connect.php');

// Menangani aksi update konsultan
if (isset($_POST['update_consultant'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];

    // Memeriksa apakah password diubah dan menangani dengan benar
    $password = !empty($_POST['password']) ? $_POST['password'] : null; // Tanpa hashing password

    // Menggunakan prepared statement untuk menghindari SQL Injection
    if ($password) {
        // Jika password diubah, update dengan password baru
        $sql_update = "UPDATE konsultan SET username = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("ssi", $username, $password, $id);
    } else {
        // Jika password tidak diubah, hanya update username
        $sql_update = "UPDATE konsultan SET username = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("si", $username, $id);
    }

    if ($stmt->execute()) {
        $_SESSION['message'] = "Konsultan berhasil diperbarui!";
        header('Location: consultants.php');
        exit();
    } else {
        $_SESSION['error'] = "Terjadi kesalahan: " . $stmt->error;
    }
}

// Mengambil data konsultan untuk di-edit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_get = "SELECT * FROM konsultan WHERE id = ?";
    $stmt = $conn->prepare($sql_get);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $konsultan = $result->fetch_assoc();
} else {
    header('Location: consultants.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Konsultan</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container mt-5">
        <h2>Edit Konsultan</h2>

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

        <form action="edit_consultant.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($konsultan['id']); ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($konsultan['username']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password (Kosongkan jika tidak ingin diubah)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" name="update_consultant" class="btn btn-primary">Perbarui</button>
        </form>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
