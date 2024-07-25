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

    <!-- Status Circle Styles -->
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

        .status-circle-red {
            display: inline-block;
            width: 12px;
            height: 12px;
            background-color: red;
            border-radius: 50%;
        }

        .status-circle-yellow {
            display: inline-block;
            width: 12px;
            height: 12px;
            background-color: #fbab00;
            border-radius: 50%;
        }

        .status-circle-blue {
            display: inline-block;
            width: 12px;
            height: 12px;
            background-color: blue;
            border-radius: 50%;
        }

        .status-circle-default {
            display: inline-block;
            width: 12px;
            height: 12px;
            background-color: gray;
            border-radius: 50%;
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
                <li><a href="data_rapat.php">Data Rapat</a></li>
                <li><a href="progres.php" class="active">Progress</a></li>

                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <!-- End Header -->

    <!-- Your content here -->
    <main>
        <div class="top-content-title">
            <h4>Meeting Issue >> <span style="color:red"> Progress</span></h4>
        </div>
        <div class="top-content">
            <button class="btn-add"></button>
            <div class="select-wrapper">
                <button class="btn-add filter-button" data-filter="all"
                    style="background-color: #1aa3e7;color: black;border: none;cursor: pointer;padding: 0px 20px; margin-right:20px">Semua</button>
                <button class="btn-add filter-button" data-filter="progress"
                    style="background-color: #c5c9cb;color: black;border: none;cursor: pointer;padding: 0px 20px; margin-right:20px">Progress</button>
                <button class="btn-add filter-button" data-filter="complete"
                    style="background-color: #c5c9cb;color: black;border: none;cursor: pointer;padding: 0px 20px;">Selesai</button>
            </div>
        </div>

        <table class="table" style="margin-top: 10px;">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col" colspan="2">Rapat</th>
                    <th scope="col">Lokasi</th>
                    <th scope="col">Topik</th>
                    <th scope="col">Tanggal Selesai</th>
                    <th scope="col">Action Step</th>
                    <th scope="col">PIC</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php
                // Anda harus mengganti ini dengan koneksi ke database Anda
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

                // Query untuk mengambil data dari join tabel rapat dan progres
                $sql = "SELECT r.id_rapat, r.judul, r.tanggal_rapat, r.lokasi, r.topik, r.tanggal_selesai, r.status, r.kategori, r.prioritas, p.action_step, p.pic 
                        FROM rapat r
                        LEFT JOIN progres p ON r.id_rapat = p.id_rapat";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        $statusClass = getStatusClass($row["status"]);
                        echo "<tr class='table-row' data-status='" . $statusClass . "'>
                                <td class='text-center'>" . $no . "</td>
                                <td class='bordered' width='150px'>
                                    " . $row["judul"] . "<br>
                                    <small>" . date("d/m/Y", strtotime($row["tanggal_rapat"])) . "</small>
                                </td>
                                <td class='bordered'>
                                    Status: <span class='status-circle-" . $statusClass . "'></span><br>
                                    Kategori: " . $row["kategori"] . "<br>
                                    Prioritas: " . $row["prioritas"] . "
                                </td>
                                <td class='text-center bordered'>" . $row["lokasi"] . "</td>
                                <td class='bordered'>" . $row["topik"] . "</td>
                                <td class='text-center bordered'>" . date("d/m/Y", strtotime($row["tanggal_selesai"])) . "</td>
                                <td class='text-center bordered'>" . $row["action_step"] . "</td>
                                <td class='text-center bordered'>" . $row["pic"] . "</td>
                              </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>Tidak ada data</td></tr>";
                }

                // Menutup koneksi
                $conn->close();

                function getStatusClass($status)
                {
                    switch ($status) {
                        case 'merah':
                            return 'red';
                        case 'kuning':
                            return 'yellow';
                        case 'biru':
                            return 'blue';
                        default:
                            return 'default';
                    }
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

            // Filter functionality
            const filterButtons = document.querySelectorAll('.filter-button');
            const tableRows = document.querySelectorAll('.table-row');

            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const filter = button.getAttribute('data-filter');

                    tableRows.forEach(row => {
                        const status = row.getAttribute('data-status');

                        if (filter === 'all') {
                            row.style.display = '';
                        } else if (filter === 'progress' && status === 'yellow') {
                            row.style.display = '';
                        } else if (filter === 'complete' && status === 'blue') {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    filterButtons.forEach(btn => btn.style.backgroundColor = '#c5c9cb');
                    button.style.backgroundColor = '#1aa3e7';
                });
            });
        });
    </script>
</body>

</html>