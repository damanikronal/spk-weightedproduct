-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 31. Januari 2013 jam 03:33
-- Versi Server: 5.0.67
-- Versi PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wp_dss`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bobot_kriteria`
--

CREATE TABLE IF NOT EXISTS `bobot_kriteria` (
  `id_jurusan` varchar(3) collate latin1_general_ci NOT NULL,
  `id_kriteria` varchar(5) collate latin1_general_ci NOT NULL,
  `nama_kriteria` varchar(50) collate latin1_general_ci NOT NULL,
  `bobot` float NOT NULL,
  `norm_bobot` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `bobot_kriteria`
--

INSERT INTO `bobot_kriteria` (`id_jurusan`, `id_kriteria`, `nama_kriteria`, `bobot`, `norm_bobot`) VALUES
('1', '1', 'Nilai Mata Pelajaran', 74, 0.19),
('1', '2', 'Hasil Psikotes', 95, 0.24),
('1', '3', 'Kepribadian', 50, 0.13),
('1', '4', 'Absensi', 85, 0.22),
('1', '5', 'Wawancara', 85, 0.22),
('2', '1', 'Nilai Mata Pelajaran', 74, 0.2),
('2', '2', 'Hasil Psikotes', 90, 0.24),
('2', '3', 'Kepribadian', 45, 0.12),
('2', '4', 'Absensi', 80, 0.21),
('2', '5', 'Wawancara', 85, 0.23);

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE IF NOT EXISTS `guru` (
  `nip` varchar(30) collate latin1_general_ci NOT NULL,
  `nama_guru` varchar(100) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`nip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`nip`, `nama_guru`) VALUES
('1710980', 'Roy Sunggara'),
('1710981', 'Dewi Lestari'),
('1710982', 'Agung Permana'),
('1710984', 'Karen');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil`
--

CREATE TABLE IF NOT EXISTS `hasil` (
  `id_kelas` varchar(5) collate latin1_general_ci NOT NULL,
  `nis` varchar(30) collate latin1_general_ci NOT NULL,
  `pil_jur` varchar(3) collate latin1_general_ci NOT NULL,
  `bobot_jur` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `hasil`
--

INSERT INTO `hasil` (`id_kelas`, `nis`, `pil_jur`, `bobot_jur`) VALUES
('1', '056701', '2', 0.4559),
('1', '056701', '1', 0.5441),
('1', '056702', '1', 0.4229),
('1', '056702', '2', 0.5771),
('1', '056703', '1', 0.4551),
('1', '056703', '2', 0.5449);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE IF NOT EXISTS `jurusan` (
  `id_jurusan` varchar(3) collate latin1_general_ci NOT NULL,
  `nama_jurusan` varchar(32) collate latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `nama_jurusan`) VALUES
('1', 'IPA'),
('2', 'IPS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE IF NOT EXISTS `kelas` (
  `id_kelas` int(5) NOT NULL,
  `nama_kelas` varchar(30) collate latin1_general_ci NOT NULL,
  `wali_kelas` varchar(100) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id_kelas`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `wali_kelas`) VALUES
(1, 'X-1', '1710980'),
(2, 'X-2', '1710981');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE IF NOT EXISTS `kriteria` (
  `id_kriteria` varchar(5) collate latin1_general_ci NOT NULL,
  `nama_kriteria` varchar(50) collate latin1_general_ci NOT NULL,
  `tipe` enum('COST','BENEFIT') collate latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `tipe`) VALUES
('1', 'Nilai Mata Pelajaran', 'BENEFIT'),
('2', 'Hasil Psikotes', 'BENEFIT'),
('3', 'Kepribadian', 'BENEFIT'),
('4', 'Absensi', 'BENEFIT'),
('5', 'Wawancara', 'BENEFIT');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mata_pelajaran`
--

CREATE TABLE IF NOT EXISTS `mata_pelajaran` (
  `kd_pelajaran` varchar(3) collate latin1_general_ci NOT NULL,
  `nm_pelajaran` varchar(100) collate latin1_general_ci NOT NULL,
  `id_jurusan` varchar(3) collate latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`kd_pelajaran`, `nm_pelajaran`, `id_jurusan`) VALUES
('P08', 'Sosiologi', '2'),
('P07', 'Sejarah', '2'),
('P06', 'Geografi', '2'),
('P05', 'Ekonomi', '2'),
('P04', 'Kimia', '1'),
('P03', 'Fisika', '1'),
('P02', 'Biologi', '1'),
('P01', 'Matematika', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu` varchar(30) collate latin1_general_ci NOT NULL,
  `link` varchar(50) collate latin1_general_ci NOT NULL,
  `status` enum('admin','wali_kelas','kepsek','siswa') collate latin1_general_ci NOT NULL default 'siswa',
  `aktif` enum('y','n') collate latin1_general_ci NOT NULL,
  `urutan` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`menu`, `link`, `status`, `aktif`, `urutan`) VALUES
('Data Siswa', '?modul=siswa', 'admin', 'y', 3),
('Kriteria Penilaian', '?modul=kriteria', 'admin', 'y', 6),
('Bobot Kriteria', '?modul=bobot', 'admin', 'y', 7),
('Evaluasi Penjurusan SMA', '?modul=evaluasi', 'admin', 'y', 8),
('Lap.Eval.Penjurusan SMA', '?modul=laporan', 'admin', 'y', 9),
('Pilihan Jurusan', '?modul=jurusan', 'admin', 'y', 1),
('Data Guru', '?modul=guru', 'admin', 'y', 4),
('Penilaian Siswa', '?modul=pelajaran', 'wali_kelas', 'y', 5),
('Data Kelas', '?modul=kelas', 'admin', 'y', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE IF NOT EXISTS `pengguna` (
  `nip` varchar(30) collate latin1_general_ci NOT NULL,
  `username` varchar(30) collate latin1_general_ci NOT NULL,
  `password` varchar(32) collate latin1_general_ci NOT NULL,
  `level` enum('admin','wali_kelas','kepsek','siswa') collate latin1_general_ci NOT NULL default 'siswa',
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`nip`, `username`, `password`, `level`) VALUES
('1710984', 'karen', 'ba952731f97fb058035aa399b1cb3d5c', 'admin'),
('056701', '056701', 'a169c457cbcf8e2e40ba91cf8da4741d', 'siswa'),
('056702', '056702', 'b2b1744ea43725805e36eafb1d77539b', 'siswa'),
('056703', '056703', 'abb463f4ed473dce9d99a06bb48bb184', 'siswa'),
('1710980', '1710980', '4bdf2b7d3db54cee090935ba61203d7e', 'wali_kelas'),
('1710981', '1710981', '4f6699f258b9f6e63397a2bd71d5a37b', 'wali_kelas'),
('1710982', '1710982', '8e7a3e85113a2a3ff88026973f1e57fc', 'kepsek');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjurusan`
--

CREATE TABLE IF NOT EXISTS `penjurusan` (
  `id_kelas` varchar(5) collate latin1_general_ci NOT NULL,
  `nis` varchar(30) collate latin1_general_ci NOT NULL,
  `id_jurusan` varchar(3) collate latin1_general_ci NOT NULL,
  `id_kriteria` varchar(5) collate latin1_general_ci NOT NULL,
  `nilai` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `penjurusan`
--

INSERT INTO `penjurusan` (`id_kelas`, `nis`, `id_jurusan`, `id_kriteria`, `nilai`) VALUES
('1', '056702', '2', '3', 97),
('1', '056702', '2', '2', 90),
('1', '056702', '2', '1', 85),
('1', '056702', '1', '5', 54),
('1', '056702', '1', '4', 95),
('1', '056702', '1', '3', 65),
('1', '056702', '1', '2', 50),
('1', '056702', '1', '1', 74),
('1', '056701', '2', '5', 80),
('1', '056701', '2', '4', 90),
('1', '056701', '2', '3', 85),
('1', '056701', '2', '2', 45),
('1', '056701', '2', '1', 74),
('1', '056701', '1', '5', 85),
('1', '056701', '1', '4', 95),
('1', '056701', '1', '3', 85),
('1', '056701', '1', '2', 75),
('1', '056701', '1', '1', 85),
('1', '056702', '2', '4', 90),
('1', '056702', '2', '5', 87),
('1', '056703', '1', '1', 56),
('1', '056703', '1', '2', 70),
('1', '056703', '1', '3', 67),
('1', '056703', '1', '4', 78),
('1', '056703', '1', '5', 60),
('1', '056703', '2', '1', 80),
('1', '056703', '2', '2', 80),
('1', '056703', '2', '3', 90),
('1', '056703', '2', '4', 76),
('1', '056703', '2', '5', 75);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE IF NOT EXISTS `siswa` (
  `id_kelas` varchar(5) collate latin1_general_ci NOT NULL,
  `nis` varchar(30) collate latin1_general_ci NOT NULL,
  `nama_siswa` varchar(100) collate latin1_general_ci NOT NULL,
  `sts` enum('Y','N','F') collate latin1_general_ci NOT NULL default 'N',
  PRIMARY KEY  (`nis`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_kelas`, `nis`, `nama_siswa`, `sts`) VALUES
('1', '056701', 'Putri Anggraini', 'F'),
('1', '056702', 'Reza Saptia', 'F'),
('1', '056703', 'Anggar Dwi Kurniawan', 'F');
