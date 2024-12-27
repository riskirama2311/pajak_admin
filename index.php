<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Konsultan Pajak</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        /* Styling untuk halaman utama */
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        /* Header */
        .custom-header {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        .custom-header h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .custom-header p {
            font-size: 1rem;
            margin-top: 5px;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(90deg, #0056b3, #007bff);
            color: white;
            padding: 70px 20px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-size: 1.3rem;
            line-height: 1.6;
        }

        /* Login Box */
        .login-box {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 30px;
            background-color: white;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            margin-top: 50px;
        }

        .login-box h2 {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .login-box p {
            font-size: 1rem;
            color: #666;
            margin-bottom: 20px;
        }

        .login-box .btn-login {
            display: inline-block;
            padding: 12px 25px;
            font-size: 1.1rem;
            font-weight: bold;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .login-box .btn-login:hover {
            background-color: #0056b3;
            color: #fff;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Footer */
        .custom-footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 50px;
        }

        .custom-footer p {
            margin: 0;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <!-- Custom Header -->
    <div class="custom-header">
        <h1>Website Konsultan Pajak</h1>
        <p>Solusi terbaik untuk kebutuhan perpajakan Anda</p>
    </div>

    <!-- Hero Section -->
    <div class="hero-section">
        <h1>Selamat Datang di Website Konsultan Pajak</h1>
        <p>Kami menyediakan layanan konsultasi pajak profesional yang siap membantu Anda mengelola urusan perpajakan dengan mudah, aman, dan terpercaya.</p>
    </div>

    <!-- Login Box -->
    <div class="container mt-5">
    <div class="row justify-content-center">
        <!-- Login Admin -->
        <div class="col-md-4">
            <div class="login-box">
                <h2>Login Admin</h2>
                <p>Masuk sebagai admin untuk mengelola data klien dan konsultasi pajak.</p>
                <a href="login.php" class="btn-login">Masuk Sekarang</a>
            </div>
        </div>
        <!-- Login Konsultan -->
        <div class="col-md-4">
            <div class="login-box">
                <h2>Login Konsultan</h2>
                <p>Masuk sebagai konsultan untuk melihat klien dan riwayat konsultasi.</p>
                <a href="login_consultant.php" class="btn-login">Masuk Sekarang</a>
            </div>
        </div>
    </div>
</div>


    <!-- Custom Footer -->
    <div class="custom-footer">
        <p>&copy; <?php echo date("Y"); ?> Website Konsultan Pajak. Semua Hak Dilindungi.</p>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
