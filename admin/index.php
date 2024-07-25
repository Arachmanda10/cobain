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
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
  <link rel="icon" type="image/png" sizes="192x192"  href="../favicon/android-icon-192x192.png">
  <style>
  /* Style for stat boxes */
  .stat-box {
    background-color: #fff;
    border-radius: 10px;
    padding: 25px 15px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
    display: flex;
    align-items: center;
     /* Tambahkan baris ini */
  }

  .stat-box .text-wrapper {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
  }

  .stat-box i {
    font-size: 36px;
    margin-right: 20px;
  }

  .stat-box h3 {
    margin-left: 20px;
    font-size: 24px;
    font-weight: 700;
    color: #333;
  }

  .stat-box p {
    margin-left: 20px;
    font-size: 36px;
    font-weight: 700;
    color: #333;
    
  }

  /* Style for different rapat statuses */
  .rapat-selesai {
    background-color: #8dc6ff; /* Light blue */
    color: #333; /* White text */
  }

  .rapat-berjalan {
    background-color: #ffd166; /* Yellow/orange */
    color: #333; /* Black text */
  }

  .rapat-belum-dimulai {
    background-color: #ff9999; /* Light red */
    color: #333; /* Black text */
  }

  .stat-box {
  /* Aturan CSS yang telah ada */
  text-align: center; /* Menengahkan teks */
}

.stat-box h3, .stat-box p {
  /* Aturan CSS yang telah ada */
  display: inline-block; /* Mengatur elemen h3 dan p sebagai blok inline */
}

.stat-box p {
  /* Aturan CSS yang telah ada */
  margin-top: 5px; /* Jarak antara teks dan angka */
}
</style>

</head>

<body>
  <?php
  // Mulai sesi
  session_start();

  // Periksa apakah pengguna telah login
  if (!isset($_SESSION['username'])) {
      header("Location: ../login.php");
      exit();
  }

  $username = $_SESSION['username'];
  $servername = "localhost";
  $username_db = "root"; // Ganti dengan username database Anda
  $password_db = ""; // Ganti dengan password database Anda
  $dbname = "db_rapat"; // Ganti dengan nama database Anda
  
  $conn = new mysqli($servername, $username_db, $password_db, $dbname);

  // Periksa koneksi
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Query untuk mengambil data rapat dari tabel rapat
  $sql = "SELECT * FROM rapat";
  $result = $conn->query($sql);

  // Inisialisasi variabel untuk menyimpan jumlah rapat berdasarkan status
  $selesai_count = 0;
  $berjalan_count = 0;
  $belum_dimulai_count = 0;

  // Periksa apakah ada hasil dari query
  if ($result->num_rows > 0) {
    // Loop melalui setiap baris hasil
    while ($row = $result->fetch_assoc()) {
      // Periksa status rapat dan tambahkan ke jumlah yang sesuai
      if ($row["status"] == "biru") {
        $selesai_count++;
      } elseif ($row["status"] == "kuning") {
        $berjalan_count++;
      } elseif ($row["status"] == "merah") {
        $belum_dimulai_count++;
      }
    }
  } else {
    echo "0 results";
  }

  // Tutup koneksi ke database
  $conn->close();
  ?>

  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      
      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="index.php" class="active">Beranda</a></li>
          <li><a href="data_rapat.php">Data Rapat</a></li>
          <li><a href="progres.php">Progress</a></li>
          <li><a href="data_user.php">Data Pengguna</a></li>
          <li><a href="../logout.php" >Logout</a></li>
        </ul>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero">

    <div class="info d-flex align-items-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 text-center">
            <h2 data-aos="fade-down">Selamat Datang <span><?php echo $username; ?></span></h2>
          </div>
        </div>
      </div>
    </div>

    <div id="hero-carousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">

      <div class="carousel-item active" style="background-image: url(assets/img/hero-carousel/hero1.jpg)">
      </div>
      <div class="carousel-item" style="background-image: url(assets/img/hero-carousel/hero2.jpg)"></div>
      <div class="carousel-item" style="background-image: url(assets/img/hero-carousel/hero3.jpg)"></div>
      <div class="carousel-item" style="background-image: url(assets/img/hero-carousel/hero4.jpg)"></div>
      

      <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
      </a>

      <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
      </a>

    </div>

  </section><!-- End Hero Section -->
  <main>
  <section class="stats">
  <div class="container">
    <div class="row">
    <div class="col-lg-4 col-md-6">
    <div class="stat-box rapat-selesai">
        <i class="bi bi-check-circle"></i>
        <div class="text-wrapper">
            <h3>Rapat Selesai</h3>
            <p><?php echo $selesai_count; ?></p>
        </div>
    </div>
</div>
<div class="col-lg-4 col-md-6">
    <div class="stat-box rapat-berjalan">
        <i class="bi bi-hourglass-split"></i>
        <div class="text-wrapper">
            <h3>Rapat Berjalan</h3>
            <p><?php echo $berjalan_count; ?></p>
        </div>
    </div>
</div>
<div class="col-lg-4 col-md-6">
    <div class="stat-box rapat-belum-dimulai">
        <i class="bi bi-clock"></i>
        <div class="text-wrapper">
            <h3>Rapat Belum Dimulai</h3>
            <p><?php echo $belum_dimulai_count; ?></p>
        </div>
    </div>
</div>

    </div>
  </div>
</section>

    
    <section class="faq">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <h4>Frequently Asked Questions (FAQ)</h4>
            <div class="accordion" id="faqAccordion">
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Apa itu MyReport?
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    MyReport adalah platform yang digunakan untuk mengelola dan memantau progress dari berbagai rapat dan tugas terkait.
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Bagaimana cara mengubah status rapat?
                  </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    Untuk mengubah status rapat, Anda dapat masuk ke halaman 'Progress', pilih rapat yang ingin diubah statusnya, dan pilih status yang sesuai dari daftar yang tersedia.  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Bagaimana cara memulai menggunakan MyReport?
                  </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                  Untuk memulai menggunakan MyReport, Anda perlu membuat akun pengguna. Setelah masuk, Anda akan diarahkan ke beranda MyReport.
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  Apakah MyReport dapat diakses dari perangkat seluler?
                  </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                  Ya, MyReport dirancang responsif dan dapat diakses dari berbagai perangkat, termasuk ponsel pintar dan tablet. Anda dapat mengakses dan mengelola rapat serta tugas-tugas terkait dari mana saja dan kapan saja.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

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

</body>

</html>
