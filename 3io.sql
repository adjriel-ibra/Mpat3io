-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 18 Des 2025 pada 03.38
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `3io`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `mitra`
--

CREATE TABLE `mitra` (
  `id_mitra` int(11) NOT NULL,
  `email_mitra` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `nama_mitra` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mitra`
--

INSERT INTO `mitra` (`id_mitra`, `email_mitra`, `username`, `nama_mitra`, `alamat`, `password`) VALUES
(1, 'test@test', 'aku ngetes mitra', 'aku mitra', 'dekat tambak boyo', '123123'),
(2, 'admin@admin', 'admin ganteng', 'admin mitra ganteng', 'dekat rumah admin', '$2y$10$GgFGzo0LZhQFREeIhe.mUOzuwI1BFuErmMEAFsV9mXGCaVcqX7m0K'),
(3, 'asd@gmail', '123', '123', 'dekat kampus amikom', '$2y$10$7t8jYASudFA2kYxZ/9G2X.uQLBKI1RWblzQcSgLLEbxmsTO55J4si'),
(8, 'adj@amikom', 'adj', 'adj', 'amikom', '$2y$10$eFw6oDyWpn/2njoXz9Vkce/ZPIOuHGM7VZCZLYQIeUTEV/65xweCu'),
(9, 'adj@adminn', 'admin', 'admin', 'qwerty', '$2y$10$e21qriCdGM/cQX/p8tSBtuylR46.MCdSbrKLa/bcO1BUHIJnIlcZm'),
(10, 'darman@amikom', 'darman', 'darman', 'amikom', '$2y$10$oxtNfumZLWNoREWzySsx3ehYna6GL3JX/dV1HtUbsPYS5jwAlvzJO');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penyewa`
--

CREATE TABLE `penyewa` (
  `id_penyewa` int(11) NOT NULL,
  `email_penyewa` varchar(255) NOT NULL,
  `nama_penyewa` varchar(255) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `no_telp` varchar(12) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penyewa`
--

INSERT INTO `penyewa` (`id_penyewa`, `email_penyewa`, `nama_penyewa`, `profile`, `no_telp`, `password`) VALUES
(1, 'test@penyewa', 'aku nyoba nyewa', '', '082122212121', '$2y$10$.ArWt6XZQ.HDrdwbJj/DUOe15ICDui3tpEVfcWhiB1VAsUGwiQp7q'),
(3, 'admin@admin', 'admin', '', '123321', '$2y$10$gTMgJgpQDodBr4rrPtaQr.J9chHRUKJKOIzBoaOnILFFRKJFvSEaW'),
(4, 'test@test', 'www', '', '222', '$2y$10$.ArWt6XZQ.HDrdwbJj/DUOe15ICDui3tpEVfcWhiB1VAsUGwiQp7q'),
(5, 'adj@adj', 'adj', '', '123321', '$2y$10$M8NnrdUfrng4XJ7cFrFBNOh7WEg1mHKYVLPoDn/fzoO92uVgWcWCO'),
(6, 'adjriel@amikom', 'adjriel ibra', '', '08999999999', '$2y$10$99cm0GQyRxlcPJAzfKM.0e/chbnAdESdYAKzc568VrqNxgDundhba'),
(7, 'adj@amikom', 'adj ganteng', '', '123321', '$2y$10$1uNVPE5zd4i0n99wQ2YoBe6qva/6Bmm2efv8yUSUFaLGzJOaJZNE.'),
(8, 'darman@amikom', 'darman', '', '082222222', '$2y$10$v5s7jmWwBmkNFVpiJ1tFxOD8CUI0g6c62muXFns/KnjJozfnIkp4K');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_penyewa` int(11) NOT NULL,
  `id_villa` int(11) NOT NULL,
  `id_mitra` int(11) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `tgl_check_in` datetime NOT NULL,
  `tgl_check_out` datetime NOT NULL,
  `tgl_pesanan` datetime NOT NULL,
  `status_pesanan` enum('pending','confirm','checkin','checkout','cancelled','expitred','refund requested','refunded','no show') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_penyewa`, `id_villa`, `id_mitra`, `total_harga`, `tgl_check_in`, `tgl_check_out`, `tgl_pesanan`, `status_pesanan`) VALUES
(1, 3, 1, 1, 2100000.00, '2025-11-30 14:48:02', '2025-11-30 14:48:02', '2025-11-30 14:48:02', 'cancelled'),
(2, 3, 5, 1, 2200000.00, '2025-12-09 15:48:40', '2025-12-09 15:48:40', '2025-12-09 15:48:40', 'checkin'),
(3, 3, 11, 2, 2100000.00, '2025-12-17 16:48:02', '2025-12-17 16:48:02', '2025-12-17 16:48:02', 'pending');

-- --------------------------------------------------------

--
-- Struktur dari tabel `villa`
--

CREATE TABLE `villa` (
  `id_villa` int(11) NOT NULL,
  `id_mitra` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `nama_villa` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(225) NOT NULL,
  `status_villa` enum('tersedia','booked','reparasi') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `villa`
--

INSERT INTO `villa` (`id_villa`, `id_mitra`, `harga`, `nama_villa`, `deskripsi`, `gambar`, `status_villa`) VALUES
(1, 1, 100000.00, 'villa ganteng', 'tempat nongkrong orang ganteng', 'asset/Uploads/dummy_villa.png', 'booked'),
(4, 1, 213312.00, 'villa fast', 'tempat fast banget', 'asset/Uploads/dummy_villa.png', 'tersedia'),
(5, 1, 213312.00, '23 villa', '23 villa buat anak 23', 'asset/Uploads/dummy_villa.png', 'tersedia'),
(11, 2, 777777.00, 'test gambar', 'test gambar semoga bisa\r\n', 'asset/Uploads/pngegg.png', 'booked'),
(12, 2, 2222222.00, 'test gambar ke 2', 'dah lah', 'asset/Uploads/pngegg.png', 'tersedia'),
(14, 2, 123123.00, 'admin', 'qweqweq', 'asset/Uploads/9ce5279b649ac178cc4f4965c861f06b.png', 'tersedia'),
(15, 2, 1231231.00, '123131', 'qqweqeqeqw', 'asset/Uploads/b075c60afef81af1b226cf8ab38ddf6f.png', 'tersedia');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `mitra`
--
ALTER TABLE `mitra`
  ADD PRIMARY KEY (`id_mitra`);

--
-- Indeks untuk tabel `penyewa`
--
ALTER TABLE `penyewa`
  ADD PRIMARY KEY (`id_penyewa`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_penyewa` (`id_penyewa`),
  ADD KEY `id_villa` (`id_villa`),
  ADD KEY `id_mitra` (`id_mitra`);

--
-- Indeks untuk tabel `villa`
--
ALTER TABLE `villa`
  ADD PRIMARY KEY (`id_villa`),
  ADD KEY `id_mitra` (`id_mitra`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `mitra`
--
ALTER TABLE `mitra`
  MODIFY `id_mitra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `penyewa`
--
ALTER TABLE `penyewa`
  MODIFY `id_penyewa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `villa`
--
ALTER TABLE `villa`
  MODIFY `id_villa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_mitra`) REFERENCES `mitra` (`id_mitra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`id_penyewa`) REFERENCES `penyewa` (`id_penyewa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pesanan_ibfk_3` FOREIGN KEY (`id_villa`) REFERENCES `villa` (`id_villa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `villa`
--
ALTER TABLE `villa`
  ADD CONSTRAINT `villa_ibfk_1` FOREIGN KEY (`id_mitra`) REFERENCES `mitra` (`id_mitra`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
