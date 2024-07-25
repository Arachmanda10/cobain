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

// Memeriksa apakah id_rapat telah diset
if (isset($_GET['id_rapat'])) {
    $id_rapat = $_GET['id_rapat'];

    // Mempersiapkan statement SQL untuk menghapus rapat berdasarkan id
    $stmt = $conn->prepare("DELETE FROM rapat WHERE id_rapat = ?");
    $stmt->bind_param("i", $id_rapat);

    // Menjalankan statement SQL
    if ($stmt->execute()) {
        echo "<div class='success-message'>Data rapat berhasil dihapus</div>";
    } else {
        echo "<div class='error-message'>Gagal menghapus data rapat</div>";
    }

    $stmt->close();
} else {
    echo "<div class='error-message'>ID rapat tidak ditemukan</div>";
}

$conn->close();

// Redirect kembali ke halaman data_rapat.php
echo "<script>window.location.href='data_rapat.php';</script>";
?>
