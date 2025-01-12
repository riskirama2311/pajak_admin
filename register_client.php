<?php
session_start();
require_once 'includes/db_connect.php'; // Koneksi ke database

// Inisialisasi variabel
$name = $email = $address = $phone = $description = "";
$name_err = $email_err = $address_err = $phone_err = $description_err = "";

// Proses saat form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi Nama
    if (empty(trim($_POST["name"]))) {
        $name_err = "Nama tidak boleh kosong.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validasi Email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Email tidak boleh kosong.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Format email tidak valid.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validasi Alamat
    if (empty(trim($_POST["address"]))) {
        $address_err = "Alamat tidak boleh kosong.";
    } else {
        $address = trim($_POST["address"]);
    }

    // Validasi Nomor Telepon
    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Nomor telepon tidak boleh kosong.";
    } elseif (!preg_match("/^[0-9]*$/", $_POST["phone"])) {
        $phone_err = "Nomor telepon hanya boleh berisi angka.";
    } else {
        $phone = trim($_POST["phone"]);
    }

    // Validasi Deskripsi Konsultasi
    if (empty(trim($_POST["description"]))) {
        $description_err = "Deskripsi konsultasi tidak boleh kosong.";
    } else {
        $description = trim($_POST["description"]);
    }

    // Jika validasi berhasil, masukkan data ke database
    if (empty($name_err) && empty($email_err) && empty($address_err) && empty($phone_err) && empty($description_err)) {
        // Query untuk menyisipkan data ke tabel client
        $sql = "INSERT INTO client (name, email, address, phone, description) VALUES (?, ?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameter
            $stmt->bind_param("sssss", $param_name, $param_email, $param_address, $param_phone, $param_description);
            
            // Set parameter
            $param_name = $name;
            $param_email = $email;
            $param_address = $address;
            $param_phone = $phone;
            $param_description = $description;
            
            // Eksekusi query
            if ($stmt->execute()) {
                // Buat session login untuk klien yang baru terdaftar
                $_SESSION["loggedin"] = true;
                $_SESSION["name"] = $name;

                // Redirect ke halaman dashboard klien
                header("location: admin/dashboard_klien.php");
                exit;
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
    <title>Daftar Klien - Website Konsultan Pajak</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: steelblue;
            font-family: Arial, sans-serif;
        }

        .register-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
            font-weight: bold;
        }

        .register-container .form-group {
            margin-bottom: 20px;
        }

        .register-container .form-control {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .register-container .btn-register {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .register-container .btn-register:hover {
            background-color: #0056b3;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .register-container .error-message {
            color: red;
            font-size: 0.9rem;
        }

        .register-container .text-center a {
            text-decoration: none;
            font-weight: bold;
            color: #007bff;
            transition: color 0.3s ease;
        }

        .register-container .text-center a:hover {
            color: #0056b3;
        }

        .register-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .register-header img {
            width: 80px;
            margin-bottom: 10px;
        }

        .register-header h1 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h2>Daftar Klien</h2>
        </div>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <!-- Nama -->
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?php echo $name; ?>" required>
                <span class="error-message"><?php echo $name_err; ?></span>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?php echo $email; ?>" required>
                <span class="error-message"><?php echo $email_err; ?></span>
            </div>

            <!-- Alamat -->
            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" id="address" name="address" rows="3" required><?php echo $address; ?></textarea>
                <span class="error-message"><?php echo $address_err; ?></span>
            </div>

            <!-- Nomor Telepon -->
            <div class="form-group">
                <label for="phone">No. Telepon</label>
                <input type="text" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" id="phone" name="phone" value="<?php echo $phone; ?>" required>
                <span class="error-message"><?php echo $phone_err; ?></span>
            </div>

            <!-- Deskripsi Konsultasi -->
            <div class="form-group">
                <label for="description">Deskripsi Konsultasi</label>
                <textarea class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>" id="description" name="description" rows="3" required><?php echo $description; ?></textarea>
                <span class="error-message"><?php echo $description_err; ?></span>
            </div>

            <!-- Tombol Daftar -->
            <button type="submit" class="btn-register">Daftar</button>
        </form>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
