<?php
// Pesan sukses
$success_message = "";

// Pastikan ID pengguna telah diberikan
if (isset($_GET['id'])) {
    // Tangkap ID pengguna dari URL
    $id_pengguna = $_GET['id'];

    // Koneksi ke database
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

    // Query untuk menghapus data pengguna berdasarkan ID
    $sql = "DELETE FROM pengguna WHERE id_pengguna = ?";

    // Menyiapkan statement
    if ($stmt = $conn->prepare($sql)) {
        // Mengikat parameter
        $stmt->bind_param("s", $id_pengguna);

        // Menjalankan statement
        if ($stmt->execute()) {
            // Set pesan sukses
            $success_message = "Data pengguna berhasil dihapus.";

            // Redirect ke halaman data_user.php setelah menghapus
            header("Location: data_user.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Menutup statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    // Menutup koneksi
    $conn->close();
} else {
    // Jika ID pengguna tidak diberikan
    $success_message = "ID pengguna tidak ditemukan.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Pengguna</title>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
        }

        .message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php if (!empty($success_message)) : ?>
        <div class="message">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>
</body>

</html>
