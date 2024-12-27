<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}
include('../includes/db_connect.php');

$id = $_GET['id'];
$sql = "SELECT * FROM client WHERE id = $id";
$result = $conn->query($sql);
$client = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $description = $_POST['description'];

    $sql = "UPDATE client SET name='$name', email='$email', address='$address', phone='$phone', description='$description' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header('Location: clients.php');
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Klien</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container mt-5">
        <h2>Edit Klien</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="<?php echo $client['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $client['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="address" class="form-control" required><?php echo $client['address']; ?></textarea>
            </div>
            <div class="mb-3">
                <label>Telepon</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $client['phone']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" required><?php echo $client['description']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</body>
</html>
