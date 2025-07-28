-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Bulan Mei 2025 pada 02.35
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ketos`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_alternatif`
--

CREATE TABLE `t_alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `kelas` varchar(5) NOT NULL,
  `tahun` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_alternatif`
--

INSERT INTO `t_alternatif` (`id_alternatif`, `nama_siswa`, `kelas`, `tahun`) VALUES
(32, 'Abi', 'XIIB', '2025'),
(35, 'Budi', 'XIIB', '2025'),
(36, 'Cahya', 'XIIC', '2025'),
(37, 'Dede', 'VIIA', '2025'),
(38, 'Erik', 'VIIC', '2025'),
(39, 'Fani', 'VIIE', '2025'),
(40, 'Gita', 'VIIB', '2025'),
(41, 'Hani', 'VIID', '2025');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kriteria`
--

CREATE TABLE `t_kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `kriteria` varchar(100) NOT NULL,
  `bobot` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_kriteria`
--

INSERT INTO `t_kriteria` (`id_kriteria`, `kriteria`, `bobot`) VALUES
(1, 'Visi Misi', 20),
(2, 'Makalah', 10),
(3, 'Poster', 10),
(4, 'Kepemimpinan', 25),
(5, 'Wawancara', 35);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_penilaian`
--

CREATE TABLE `t_penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `id_subkriteria` int(11) NOT NULL,
  `nilai` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_penilaian`
--

INSERT INTO `t_penilaian` (`id_penilaian`, `id_alternatif`, `id_subkriteria`, `nilai`) VALUES
(90, 32, 3, 3),
(91, 32, 7, 3),
(92, 32, 11, 3),
(93, 32, 15, 3),
(94, 32, 19, 3),
(105, 35, 2, 4),
(106, 35, 7, 3),
(107, 35, 11, 3),
(108, 35, 14, 4),
(109, 35, 20, 2),
(110, 36, 3, 3),
(111, 36, 7, 3),
(112, 36, 11, 3),
(113, 36, 14, 4),
(114, 36, 20, 2),
(115, 37, 3, 3),
(116, 37, 7, 3),
(117, 37, 11, 3),
(118, 37, 15, 3),
(119, 37, 19, 3),
(120, 38, 3, 3),
(121, 38, 7, 3),
(122, 38, 10, 4),
(123, 38, 15, 3),
(124, 38, 19, 3),
(125, 39, 3, 3),
(126, 39, 7, 3),
(127, 39, 10, 4),
(128, 39, 14, 4),
(129, 39, 20, 2),
(130, 40, 3, 3),
(131, 40, 7, 3),
(132, 40, 11, 3),
(133, 40, 14, 4),
(134, 40, 19, 3),
(135, 41, 3, 3),
(136, 41, 7, 3),
(137, 41, 10, 4),
(138, 41, 14, 4),
(139, 41, 18, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_subkriteria`
--

CREATE TABLE `t_subkriteria` (
  `id_subkriteria` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `subkriteria` varchar(100) NOT NULL,
  `bobot` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_subkriteria`
--

INSERT INTO `t_subkriteria` (`id_subkriteria`, `id_kriteria`, `subkriteria`, `bobot`) VALUES
(2, 1, '86-100', 4),
(3, 1, '71-85', 3),
(4, 1, '56-70', 2),
(5, 1, '<55', 1),
(6, 2, '86-100', 4),
(7, 2, '71-85', 3),
(8, 2, '56-70', 2),
(9, 2, '<55', 1),
(10, 3, '86-100', 4),
(11, 3, '71-85', 3),
(12, 3, '56-70', 2),
(13, 3, '<55', 1),
(14, 4, 'Sangat Baik', 4),
(15, 4, 'Baik', 3),
(16, 4, 'Cukup', 2),
(17, 4, 'Kurang', 1),
(18, 5, '86-100', 4),
(19, 5, '71-85', 3),
(20, 5, '56-70', 2),
(21, 5, '<55', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_alternatif`
--
ALTER TABLE `t_alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indeks untuk tabel `t_kriteria`
--
ALTER TABLE `t_kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `t_penilaian`
--
ALTER TABLE `t_penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `id_alternatif` (`id_alternatif`),
  ADD KEY `id_subkriteria` (`id_subkriteria`);

--
-- Indeks untuk tabel `t_subkriteria`
--
ALTER TABLE `t_subkriteria`
  ADD PRIMARY KEY (`id_subkriteria`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_alternatif`
--
ALTER TABLE `t_alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `t_kriteria`
--
ALTER TABLE `t_kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `t_penilaian`
--
ALTER TABLE `t_penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT untuk tabel `t_subkriteria`
--
ALTER TABLE `t_subkriteria`
  MODIFY `id_subkriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `t_penilaian`
--
ALTER TABLE `t_penilaian`
  ADD CONSTRAINT `t_penilaian_ibfk_1` FOREIGN KEY (`id_alternatif`) REFERENCES `t_alternatif` (`id_alternatif`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_penilaian_ibfk_2` FOREIGN KEY (`id_subkriteria`) REFERENCES `t_subkriteria` (`id_subkriteria`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_subkriteria`
--
ALTER TABLE `t_subkriteria`
  ADD CONSTRAINT `t_subkriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `t_kriteria` (`id_kriteria`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
