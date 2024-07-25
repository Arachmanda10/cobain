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
                <li><a href="progres.php">Progress</a></li>
                <li><a href="data_user.php" class="active">Data Pengguna</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <!-- End Header -->

    <!-- Your content here -->
    <main>
        <div class="top-content-title">
            <h4>Meeting Issue >> <span style="color:red"> Data Pengguna</span></h4>
        </div>
        <div class="top-content">
            <button class="btn-add"><a href="add_user.php" style="color:black;font-weight:400;">Tambah Data</a></button>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Id Pengguna</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Username</th>
                    <th scope="col">Role</th>
                    <th scope="col">Bagian</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Koneksi ke database
                $servername = "localhost";
                $usernameDB = "root";
                $passwordDB = "";
                $dbname = "db_rapat";

                $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

                // Memeriksa koneksi
                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }

                // Query untuk mengambil data pengguna
                $sql = "SELECT id_pengguna, nama, username, role, bagian FROM pengguna";
                $result = $conn->query($sql);

                if ($result === FALSE) {
                    echo "<tr><td colspan='7' class='text-center'>Error: " . $conn->error . "</td></tr>";
                } elseif ($result->num_rows > 0) {
                    $no = 1;
                    // Output data setiap baris
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='text-center'>{$no}</td>";
                        echo "<td class='bordered text-center'>{$row['id_pengguna']}</td>";
                        echo "<td class='bordered text-center'>{$row['nama']}</td>";
                        echo "<td class='bordered text-center'>{$row['username']}</td>";
                        echo "<td class='text-center bordered'>{$row['role']}</td>";
                        echo "<td class='bordered text-center'>{$row['bagian']}</td>";
                        echo "<td class='action-icons'>
                                <div class='icons'>
                                    <a href='edit_user.php?id={$row['id_pengguna']}'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'>
                                        <path d='M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z' />
                                    </svg></a>
                                    <a href='delete_user.php?id={$row['id_pengguna']}'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='28' height='28'>
                                        <path fill='red' d='M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z' />
                                    </svg></a>
                                </div>
                              </td>";
                        echo "</tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
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

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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
