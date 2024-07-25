<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="192x192"  href="../favicon/android-icon-192x192.png">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
        }
        .form {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 20px auto;
        }
        .form label {
            display: block;
            margin: 10px 0 5px;
            font-weight: 600;
        }
        .form input[type="text"],
        .form input[type="password"],
        .form select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
        .form input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<header id="header" class="header">
    <div class="top-bar d-flex align-items-center justify-content-between">
        <img src="assets/img/logo.png" alt="Logo Pertamina" class="logo">
        <h4 class="nav-text">MyReport</h4>
        <i class="bi bi-list mobile-nav-toggle"></i>
    </div>
    <nav id="navbar" class="navbar">
        <ul class="container-xl d-flex justify-content-between">
            <li><a href="index.php">Beranda</a></li>
            <li><a href="data_rapat.php">Data Rapat</a></li>
            <li><a href="progres.php">Progress</a></li>
            <li><a href="data_user.php" class="active">Data Pengguna</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
<main>
    <div class="top-content-title">
        <h4>Meeting Issue Review >> <span style="color:red"> Edit Pengguna</span></h4>
    </div>
    <div class="top-content">
        <button class="btn-add"><a href="data_user.php" style="color:black;font-weight:400">Kembali</a></button>
    </div>
    <div class="form">
        <?php
        // Koneksi ke database
        $servername = "localhost";
        $usernameDB = "root";
        $passwordDB = "";
        $dbname = "db_rapat";

        // Membuat koneksi
        $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

        // Memeriksa koneksi
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Mengambil ID dari URL
        if (isset($_GET['id'])) {
            $id_pengguna = $_GET['id'];

            // Query untuk mengambil data pengguna berdasarkan ID
            $sql = "SELECT * FROM pengguna WHERE id_pengguna = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $id_pengguna);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $nama = $row['nama'];
                    $username = $row['username'];
                    $role = $row['role'];
                    $bagian = $row['bagian'];
                } else {
                    echo "Data tidak ditemukan.";
                    exit;
                }

                $stmt->close();
            } else {
                echo "Error: " . $conn->error;
                exit;
            }
        } else {
            echo "ID tidak ditemukan.";
            exit;
        }
        ?>

        <form action="edit_user.php?id=<?php echo $id_pengguna; ?>" method="post">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?php echo $nama; ?>" required>
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
            
            <label for="password">Password (Kosongkan jika tidak ingin mengubah):</label>
            <input type="password" id="password" name="password">
            
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="admin" <?php if ($role == 'admin') echo 'selected'; ?>>Admin</option>
                <option value="user" <?php if ($role == 'user') echo 'selected'; ?>>User</option>
            </select>
            
            <label for="bagian">Bagian:</label>
            <select id="bagian" name="bagian" required>
                <option value="-" <?php if ($bagian == '-') echo 'selected'; ?>>-</option>
                <option value="Quality Manager" <?php if ($bagian == 'Quality Manager') echo 'selected'; ?>>Quality Manager</option>
                <option value="Workforce" <?php if ($bagian == 'Workforce') echo 'selected'; ?>>Workforce</option>
                <option value="Business Partner" <?php if ($bagian == 'Business Partner') echo 'selected'; ?>>Business Partner</option>
            </select>
            
            <input type="submit" value="Update Pengguna">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Mengambil data dari form
            $nama = $_POST["nama"];
            $username = $_POST["username"];
            $password = $_POST["password"];
            $role = $_POST["role"];
            $bagian = $_POST["bagian"];

            // Query untuk memperbarui data pengguna
            if (empty($password)) {
                $sql = "UPDATE pengguna SET nama = ?, username = ?, role = ?, bagian = ? WHERE id_pengguna = ?";
            } else {
                $sql = "UPDATE pengguna SET nama = ?, username = ?, password = ?, role = ?, bagian = ? WHERE id_pengguna = ?";
            }

            if ($stmt = $conn->prepare($sql)) {
                if (empty($password)) {
                    $stmt->bind_param("sssss", $nama, $username, $role, $bagian, $id_pengguna);
                } else {
                    $stmt->bind_param("ssssss", $nama, $username, $password, $role, $bagian, $id_pengguna);
                }

                if ($stmt->execute()) {
                    echo "Pengguna berhasil diperbarui.";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                $stmt->close();
            } else {
                echo "Error: " . $conn->error;
            }

            $conn->close();
        }
        ?>
    </div>
</main>
<footer id="footer" class="footer">
    <div class="footer-legal text-center position-relative">
        <div class="copyright">
            &copy; Copyright <strong><span>MyReport</span></strong>. All Rights Reserved
        </div>
    </div>
</footer>
<!-- End Footer -->

<a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
</body>
</html>
