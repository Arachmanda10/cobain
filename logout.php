<?php
// Mulai sesi
session_start();

// Hapus semua data sesi
session_unset();

// Hapus sesi
session_destroy();

// Arahkan kembali ke halaman login
header("Location: index.php");
exit();
?>
