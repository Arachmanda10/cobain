<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>MyReport</title>
<meta content="" name="description">
<meta content="" name="keywords">
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
   
    .header .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
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
    .form input[type="date"],
    .form select,
    .form textarea {
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
    .status-container {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        
    }
    .status-radio {
        display: none;
    }
    .status-label {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 100px;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .status-label:not(:last-child) {
        margin-right: 20px;
    }
    .status-merah {
        
        background-color: red;
    }
    .status-kuning {
        background-color: #fbab00;
    }
    .status-biru {
        background-color: blue;
    }
    .status-label.selected {
        border-color: black;
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
            <li><a href="data_rapat.php" class="active">Data Rapat</a></li>
            <li><a href="progres.php">Progress</a></li>
            <li><a href="data_user.php">Data Pengguna</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<main>
    <div class="top-content-title">
        <h4>Meeting Issue Review >> <span style="color:red"> Data Rapat</span></h4>
    </div>
    <div class="top-content">
        <button class="btn-add"><a href="data_rapat.php" style="color:black;font-weight:400">Kembali</a></button>
    </div>

    <div class="form">
        <form action="add_rapat.php" method="post">
            <label for="judul">Judul Rapat</label>
            <input type="text" id="judul" name="judul" required>
            
            <label for="tanggal_rapat">Tanggal Rapat</label>
            <input type="date" id="tanggal_rapat" name="tanggal_rapat" required>
            
            <label for="prioritas">Prioritas</label>
            <select id="prioritas" name="prioritas" required>
                <option value="I. selesai s.d 2 Minggu">I. selesai s.d 2 Minggu</option>
                <option value="II. selesai s.d 2 Bulan">II. selesai s.d 2 Bulan</option>
                <option value="III. selesai s.d 3 Bulan">III. selesai s.d 3 Bulan</option>
            </select>
            
            <label for="status">Status</label>
            <div class="status-container">
                <input type="radio" id="status_merah" name="status" value="merah" class="status-radio" required>
                <label for="status_merah" class="status-label status-merah"></label>
                
                <input type="radio" id="status_kuning" name="status" value="kuning" class="status-radio" required>
                <label for="status_kuning" class="status-label status-kuning"></label>
                
                <input type="radio" id="status_biru" name="status" value="biru" class="status-radio" required>
                <label for="status_biru" class="status-label status-biru"></label>
            </div>
            
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori" required>
                <option value="Quality Manager">Quality Manager</option>
                <option value="Workforce">Workforce</option>
                <option value="Business Partner">Business Partner</option>
            </select>
            
            <label for="lokasi">Lokasi</label>
            <input type="text" id="lokasi" name="lokasi" required>
            
            <label for="topik">Topik</label>
            <textarea id="topik" name="topik" rows="4" required></textarea>
            
            <label for="tanggal_selesai">Tanggal Selesai</label>
            <input type="date" id="tanggal_selesai" name="tanggal_selesai" required>
            
            <input type="submit" value="Tambah Rapat">
        </form>
    </div>

    <?php
// Anda harus mengganti ini dengan koneksi ke database Anda
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_rapat";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memeriksa apakah metode permintaan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $judul = $_POST["judul"];
    $tanggal_rapat = $_POST["tanggal_rapat"];
    $prioritas = $_POST["prioritas"];
    $status = $_POST["status"];
    $kategori = $_POST["kategori"];
    $lokasi = $_POST["lokasi"];
    $topik = $_POST["topik"];
    $tanggal_selesai = $_POST["tanggal_selesai"];

    // Query untuk menambah data rapat
    $sql = "INSERT INTO rapat (judul, tanggal_rapat, prioritas, status, kategori, lokasi, topik, tanggal_selesai) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Menyiapkan statement
    if ($stmt = $conn->prepare($sql)) {
        // Mengikat parameter
        $stmt->bind_param("ssssssss", $judul, $tanggal_rapat, $prioritas, $status, $kategori, $lokasi, $topik, $tanggal_selesai);

        // Menjalankan statement
        if ($stmt->execute()) {
            echo "<div class='success-message'>Rapat berhasil ditambahkan.</div>";
        } else {
            echo "<div class='error-message'>Gagal menambahkan rapat.</div>";
        }

        // Menutup statement
        $stmt->close();
    } else {
        echo "<div class='error-message'>Error: " . $conn->error . "</div>";
    }
}

// Menutup koneksi
$conn->close();
?>

    </main>
     <footer id="footer" class="footer">
        <div class="footer-legal text-center position-relative">
            <div class="copyright">
                &copy; Copyright <strong><span>MyReport</span></strong>. All Rights Reserved
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

   
    <script>
        var statusLabels = document.querySelectorAll('.status-label');
        statusLabels.forEach(function(label) {
            label.addEventListener('click', function() {
                statusLabels.forEach(function(lbl) {
                    lbl.classList.remove('selected');
                });
                label.classList.add('selected');
            });
        });
    </script>

</body>
</html>
