<?php
session_start();
require_once 'includes/db_connect.php'; // Koneksi ke database

// Inisialisasi variabel
$name = $phone = "";
$name_err = $phone_err = $login_err = "";

// Proses saat form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi Nama
    if (empty(trim($_POST["name"]))) {
        $name_err = "Nama tidak boleh kosong.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validasi No. Telp
    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Nomor Telepon tidak boleh kosong.";
    } else {
        $phone = trim($_POST["phone"]);
    }

    // Jika validasi berhasil, proses login
    if (empty($name_err) && empty($phone_err)) {
        // Query untuk memeriksa kecocokan data di tabel client
        $sql = "SELECT id, name, phone FROM client WHERE name = ? AND phone = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameter
            $stmt->bind_param("ss", $param_name, $param_phone);
            
            // Set parameter
            $param_name = $name;
            $param_phone = $phone;
            
            // Eksekusi query
            if ($stmt->execute()) {
                $stmt->store_result();
                
                // Cek apakah data ditemukan
                if ($stmt->num_rows == 1) {
                    // Login berhasil, buat session
                    session_start();
                    $_SESSION["loggedin"] = true;
                    $_SESSION["name"] = $name;
                    
                    // Redirect ke halaman dashboard klien
                    header("location: admin/dashboard_klien.php");
                    exit;
                } else {
                    // Jika data tidak ditemukan
                    $login_err = "Nama atau nomor telepon salah.";
                }
            } else {
                echo "Oops! Terjadi kesalahan. Silakan coba lagi nanti.";
            }
            
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Klien - Website Konsultan Pajak</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: steelblue;
            font-family: 'Arial', sans-serif;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
            font-weight: bold;
        }

        .login-container .form-group {
            margin-bottom: 20px;
        }

        .login-container .form-control {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .login-container .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .login-container .btn-login:hover {
            background-color: #0056b3;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .login-container .error-message {
            color: red;
            font-size: 0.9rem;
        }

        .login-container .text-center a {
            text-decoration: none;
            font-weight: bold;
            color: #007bff;
            transition: color 0.3s ease;
        }

        .login-container .text-center a:hover {
            color: #0056b3;
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-header img {
            width: 80px;
            margin-bottom: 10px;
        }

        .login-header h1 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Header -->
        <div class="login-header">
            <h1>Login Klien</h1>
        </div>

        <!-- Pesan error -->
        <?php if (!empty($login_err)) { echo '<div class="alert alert-danger text-center">' . $login_err . '</div>'; } ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <!-- Nama -->
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?php echo $name; ?>" required>
                <span class="error-message"><?php echo $name_err; ?></span>
            </div>

            <!-- No. Telp -->
            <div class="form-group">
                <label for="phone">No. Telp</label>
                <input type="text" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" id="phone" name="phone" value="<?php echo $phone; ?>" required>
                <span class="error-message"><?php echo $phone_err; ?></span>
            </div>

            <!-- Tombol Login -->
            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <p class="mt-3 text-center">Belum punya akun? <a href="register_client.php">Daftar Sekarang</a></p>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
