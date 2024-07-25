-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Bulan Mei 2024 pada 07.55
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rapat`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bagian`
--

CREATE TABLE `bagian` (
  `id_bagian` varchar(5) NOT NULL,
  `bagian` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `bagian`
--

INSERT INTO `bagian` (`id_bagian`, `bagian`) VALUES
('hcx01', 'Quality Manager'),
('hcx02', 'Workforce'),
('hcx03', 'Business Partne');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` varchar(5) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `bagian` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama`, `username`, `password`, `role`, `bagian`) VALUES
('aad01', 'administrator', 'admin', '123', 'admin', '-'),
('uux02', 'agus', 'agus', '123', 'user', 'Workforce');

--
-- Trigger `pengguna`
--
DELIMITER $$
CREATE TRIGGER `before_insert_pengguna` BEFORE INSERT ON `pengguna` FOR EACH ROW BEGIN
    DECLARE prefix CHAR(3);
    DECLARE max_id INT;
    DECLARE new_id VARCHAR(5);

    IF NEW.role = 'admin' THEN
        SET prefix = 'aad';
    ELSE
        SET prefix = 'uux';
    END IF;

    SELECT COALESCE(MAX(CAST(SUBSTRING(id_pengguna, 4) AS UNSIGNED)), 0) + 1 INTO max_id FROM pengguna WHERE id_pengguna LIKE CONCAT(prefix, '%');

    SET new_id = CONCAT(prefix, LPAD(max_id, 2, '0'));

    SET NEW.id_pengguna = new_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `prioritas`
--

CREATE TABLE `prioritas` (
  `id_prioritas` varchar(5) NOT NULL,
  `data_prioritas` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `prioritas`
--

INSERT INTO `prioritas` (`id_prioritas`, `data_prioritas`) VALUES
('pri01', 'I. selesai s.d 2 Minggu'),
('pri02', 'II. selesai s.d 2 Bulan'),
('pri03', 'III. selesai s.d 3 Bulan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `progres`
--

CREATE TABLE `progres` (
  `id_progres` int(11) NOT NULL,
  `id_rapat` int(11) NOT NULL,
  `action_step` varchar(255) NOT NULL,
  `pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `progres`
--

INSERT INTO `progres` (`id_progres`, `id_rapat`, `action_step`, `pic`) VALUES
(1, 1, 'in progress', 'Quality Manager'),
(2, 2, 'complete', 'Quality Manager');

--
-- Trigger `progres`
--
DELIMITER $$
CREATE TRIGGER `update_status_rapat_delete` AFTER DELETE ON `progres` FOR EACH ROW BEGIN
    DECLARE progress_count INT;

    SELECT COUNT(*)
    INTO progress_count
    FROM progres
    WHERE id_rapat = OLD.id_rapat
      AND (action_step = 'in progress' OR action_step = 'complete');

    IF progress_count = 0 THEN
        UPDATE rapat
        SET status = 'merah'
        WHERE id_rapat = OLD.id_rapat;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_status_rapat_insert` AFTER INSERT ON `progres` FOR EACH ROW BEGIN
    IF NEW.action_step = 'in progress' THEN
        UPDATE rapat
        SET status = 'kuning'
        WHERE id_rapat = NEW.id_rapat;
    ELSEIF NEW.action_step = 'complete' THEN
        UPDATE rapat
        SET status = 'biru'
        WHERE id_rapat = NEW.id_rapat;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_status_rapat_update` AFTER UPDATE ON `progres` FOR EACH ROW BEGIN
    IF NEW.action_step = 'in progress' THEN
        UPDATE rapat
        SET status = 'kuning'
        WHERE id_rapat = NEW.id_rapat;
    ELSEIF NEW.action_step = 'complete' THEN
        UPDATE rapat
        SET status = 'biru'
        WHERE id_rapat = NEW.id_rapat;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rapat`
--

CREATE TABLE `rapat` (
  `id_rapat` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `tanggal_rapat` date NOT NULL,
  `prioritas` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `lokasi` varchar(20) NOT NULL,
  `topik` text NOT NULL,
  `tanggal_selesai` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `rapat`
--

INSERT INTO `rapat` (`id_rapat`, `judul`, `tanggal_rapat`, `prioritas`, `status`, `kategori`, `lokasi`, `topik`, `tanggal_selesai`) VALUES
(1, 'peninjauan kembali alumni', '2024-05-25', 'I. selesai s.d 2 Minggu', 'kuning', 'Quality Manager', 'HC', 'meninjau ', '2024-05-25'),
(2, 'peninjauan kembali alumni 2021', '2024-05-28', 'I. selesai s.d 2 Minggu', 'biru', 'Workforce', 'HC', '1. melakukan tinjauan kembali', '2024-05-28');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bagian`
--
ALTER TABLE `bagian`
  ADD PRIMARY KEY (`id_bagian`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `prioritas`
--
ALTER TABLE `prioritas`
  ADD PRIMARY KEY (`id_prioritas`);

--
-- Indeks untuk tabel `progres`
--
ALTER TABLE `progres`
  ADD PRIMARY KEY (`id_progres`),
  ADD KEY `id_rapat` (`id_rapat`);

--
-- Indeks untuk tabel `rapat`
--
ALTER TABLE `rapat`
  ADD PRIMARY KEY (`id_rapat`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `progres`
--
ALTER TABLE `progres`
  MODIFY `id_progres` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `rapat`
--
ALTER TABLE `rapat`
  MODIFY `id_rapat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `progres`
--
ALTER TABLE `progres`
  ADD CONSTRAINT `progres_ibfk_1` FOREIGN KEY (`id_rapat`) REFERENCES `rapat` (`id_rapat`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
