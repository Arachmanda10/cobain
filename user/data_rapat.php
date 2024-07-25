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

// Mengambil filter status dari request
$statusFilter = isset($_GET['rapat']) ? $_GET['rapat'] : 'Semua Rapat';

// Query untuk menampilkan data rapat berdasarkan filter
if ($statusFilter == 'Selesai') {
    $sql = "SELECT * FROM rapat WHERE status = 'biru'";
} elseif ($statusFilter == 'Progress') {
    $sql = "SELECT * FROM rapat WHERE status = 'kuning'";
} else {
    $sql = "SELECT * FROM rapat";
}

$result = $conn->query($sql);
?>

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
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="192x192"  href="../favicon/android-icon-192x192.png">
    <style>
        .keterangan {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .keterangan-item {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .circle {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .red {
            background-color: red;
        }

        .yellow {
            background-color: #fbab00;
        }

        .blue {
            background-color: blue;
        }

        .action-icons {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .action-icons .icons {
            display: flex;
            gap: 10px;
        }

        .action-icons .btn-detail {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #1ae76c;
            border: none;
            color: white;
            padding: 0px 10px;
            cursor: pointer;

            text-decoration: none;
        }

        .action-icons .btn-detail:hover {
            background-color: #ff0000;
            color: #f5f6f7;
        }
    </style>
</head>

<body>
    <!-- ======= Header ======= -->
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

                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <!-- End Header -->

    <!-- Your content here -->
    <main>
        <div class="top-content-title">
            <h4>Meeting Issue >> <span style="color:red"> Data Rapat</span></h4>
        </div>
        <div class="top-content">
            <button class="btn-add"></button>
            <div class="select-wrapper">
                <form action="data_rapat.php" method="GET">
                    <select id="rapat" name="rapat" required style="padding: 0px 80px;">
                        <option value="Semua Rapat" <?php if ($statusFilter == 'Semua Rapat')
                            echo 'selected'; ?>>Semua
                            Rapat</option>
                        <option value="Selesai" <?php if ($statusFilter == 'Selesai')
                            echo 'selected'; ?>>Selesai</option>
                        <option value="Progress" <?php if ($statusFilter == 'Progress')
                            echo 'selected'; ?>>Progress
                        </option>
                    </select>

                    <button type="submit" class="cari">Cari</button>
                </form>
            </div>
        </div>

        <table class="table" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col" colspan="2">Rapat</th>
                    <th scope="col">Lokasi</th>
                    <th scope="col">Topik</th>
                    <th scope="col">Tanggal Selesai</th>

                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $no = 1;
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $statusColor = '';
                        if ($row["status"] == 'biru') {
                            $statusColor = 'blue';
                        } elseif ($row["status"] == 'kuning') {
                            $statusColor = '#fbab00';
                        } else {
                            $statusColor = 'red';
                        }

                        echo "<tr>";
                        echo "<td class='text-center'>" . $no++ . "</td>";
                        echo "<td class='bordered' width='150px'>";
                        echo $row["judul"] . "<br>";
                        echo "<small>" . $row["tanggal_rapat"] . "</small>";
                        echo "</td>";
                        echo "<td class='bordered'>";
                        echo "Status: <span class='status-circle' style='background-color: $statusColor;'></span><br>";
                        echo "Kategori: " . $row["kategori"] . "<br>";
                        echo "Prioritas: " . $row["prioritas"];
                        echo "</td>";
                        echo "<td class='text-center bordered'>" . $row["lokasi"] . "</td>";
                        echo "<td class='bordered'>" . $row["topik"] . "</td>";
                        echo "<td class='text-center bordered'>" . $row["tanggal_selesai"] . "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align:center;'>Tidak ada data</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="keterangan">
            <div class="keterangan-item">
                <div class="circle red"></div>
                <span>Non Progress</span>
            </div>
            <div class="keterangan-item">
                <div class="circle yellow"></div>
                <span>In Progress</span>
            </div>
            <div class="keterangan-item">
                <div class="circle blue"></div>
                <span>Complete</span>
            </div>
        </div>


    </main>

    <!-- ======= Footer ======= -->
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

    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
            const navbar = document.querySelector('#navbar');

            mobileNavToggle.addEventListener('click', function () {
                navbar.classList.toggle('navbar-mobile');
                mobileNavToggle.classList.toggle('bi-x');
            });
        });
    </script>
</body>

</html>