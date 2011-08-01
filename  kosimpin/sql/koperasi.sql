-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 01. Agustus 2011 jam 14:56
-- Versi Server: 5.1.30
-- Versi PHP: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `koperasi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE IF NOT EXISTS `anggota` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomor_anggota` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tglmasuk` date NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `telpon` varchar(35) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `ip_input` varchar(30) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nomor_anggota` (`nomor_anggota`),
  KEY `nama` (`nama`,`tglmasuk`,`alamat`,`telpon`,`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`id`, `nomor_anggota`, `nama`, `tglmasuk`, `alamat`, `telpon`, `email`, `tgl_input`, `ip_input`, `password`) VALUES
(1, '07030001', 'Ahmad Satiri', '2007-01-31', '-', '-', '-', '2010-09-27 12:36:06', '', '202cb962ac59075b964b07152d234b70'),
(2, '07030002', 'Farid Ma''ruf', '2000-09-05', 'telaga Mas', '-', '-', '2010-09-28 15:42:52', '127.0.0.1', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_akun`
--

CREATE TABLE IF NOT EXISTS `daftar_akun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_account` varchar(50) NOT NULL,
  `nama_account` varchar(100) NOT NULL,
  `normal_account` varchar(5) NOT NULL COMMENT 'debit atau kredit',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nomor_account` (`nomor_account`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data untuk tabel `daftar_akun`
--

INSERT INTO `daftar_akun` (`id`, `nomor_account`, `nama_account`, `normal_account`) VALUES
(1, '001', 'Kas', 'd'),
(2, '005', 'Tabungan', 'k'),
(3, '002', 'Bank', 'd'),
(4, '003', 'Piutang (Pinjaman Anggota)', 'd'),
(5, '004', 'Jasa Pinjaman', 'd'),
(6, '006', 'Biaya', 'k');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gledger`
--

CREATE TABLE IF NOT EXISTS `gledger` (
  `id_jurnal` bigint(20) NOT NULL AUTO_INCREMENT,
  `nomor_account` varchar(30) NOT NULL,
  `debit_value` decimal(10,0) NOT NULL,
  `kredit_value` decimal(10,0) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `tgl_input` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `ip_input` varchar(50) NOT NULL,
  `nomor_dokumen` varchar(30) DEFAULT NULL,
  `batch_info` varchar(100) NOT NULL,
  PRIMARY KEY (`id_jurnal`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data untuk tabel `gledger`
--

INSERT INTO `gledger` (`id_jurnal`, `nomor_account`, `debit_value`, `kredit_value`, `tgl_transaksi`, `tgl_input`, `id_user`, `ip_input`, `nomor_dokumen`, `batch_info`) VALUES
(1, '001', 15000, 0, '2010-10-11', '2010-10-11 10:04:16', 1, 'localhost', '', ''),
(2, '005', 0, 15000, '2010-10-11', '2010-10-11 10:04:16', 1, 'localhost', '', ''),
(3, '001', 12500, 0, '2010-10-11', '2010-10-11 10:04:33', 1, 'localhost', '', ''),
(4, '005', 0, 12500, '2010-10-11', '2010-10-11 10:04:33', 1, 'localhost', '', ''),
(5, '003', 100000, 0, '2010-10-11', '2010-10-11 13:24:12', 1, 'localhost', '', ''),
(6, '004', 10000, 0, '2010-10-11', '2010-10-11 13:24:12', 1, 'localhost', '', ''),
(7, '001', 0, 100000, '2010-10-11', '2010-10-11 13:24:12', 1, 'localhost', '', ''),
(8, '001', 1250, 0, '2010-10-11', '2010-10-11 13:54:36', 1, 'localhost', '', ''),
(9, '005', 0, 1250, '2010-10-11', '2010-10-11 13:54:36', 1, 'localhost', '', ''),
(10, '001', 1260, 0, '2010-10-11', '2010-10-11 13:56:01', 1, 'localhost', '', '111010-135601'),
(11, '005', 0, 1260, '2010-10-11', '2010-10-11 13:56:01', 1, 'localhost', '', '111010-135601'),
(12, '003', 1500000, 0, '2010-10-11', '2010-10-11 13:57:13', 1, 'localhost', '', '11102010-135713'),
(13, '004', 150000, 0, '2010-10-11', '2010-10-11 13:57:13', 1, 'localhost', '', '11102010-135713'),
(14, '001', 0, 1500000, '2010-10-11', '2010-10-11 13:57:13', 1, 'localhost', '', '11102010-135713'),
(15, '003', 1400000, 0, '2010-10-11', '2010-10-11 13:59:30', 1, 'localhost', '', '-11102010-135930'),
(16, '004', 140000, 0, '2010-10-11', '2010-10-11 13:59:30', 1, 'localhost', '', '-11102010-135930'),
(17, '001', 0, 1400000, '2010-10-11', '2010-10-11 13:59:30', 1, 'localhost', '', '-11102010-135930'),
(18, '003', 1400000, 0, '2010-10-11', '2010-10-11 13:59:42', 1, 'localhost', '', 'value-11102010-135942'),
(19, '004', 140000, 0, '2010-10-11', '2010-10-11 13:59:42', 1, 'localhost', '', 'value-11102010-135942'),
(20, '001', 0, 1400000, '2010-10-11', '2010-10-11 13:59:42', 1, 'localhost', '', 'value-11102010-135942'),
(21, '003', 1400000, 0, '2010-10-11', '2010-10-11 13:59:51', 1, 'localhost', '', '72-11102010-135951'),
(22, '004', 140000, 0, '2010-10-11', '2010-10-11 13:59:51', 1, 'localhost', '', '72-11102010-135951'),
(23, '001', 0, 1400000, '2010-10-11', '2010-10-11 13:59:51', 1, 'localhost', '', '72-11102010-135951'),
(24, '001', 1000000, 0, '2010-10-11', '2010-10-11 14:03:58', 1, 'localhost', '', '63-11102010-140358'),
(25, '003', 0, 1000000, '2010-10-11', '2010-10-11 14:03:58', 1, 'localhost', '', '63-11102010-140358'),
(26, '006', 15000, 0, '2010-10-12', '2010-10-12 10:01:48', 1, 'localhost', '', '68-12102010-100148'),
(27, '001', 0, 15000, '2010-10-12', '2010-10-12 10:01:48', 1, 'localhost', '', '68-12102010-100148'),
(28, '001', 15000, 0, '2011-07-20', '2011-07-20 12:32:31', 1, 'localhost', '', '61-20072011-123231'),
(29, '005', 0, 15000, '2011-07-20', '2011-07-20 12:32:31', 1, 'localhost', '', '61-20072011-123231'),
(30, '003', 150000, 0, '2011-07-27', '2011-07-27 17:37:53', 1, 'localhost', '', '73-27072011-173753'),
(31, '004', 15000, 0, '2011-07-27', '2011-07-27 17:37:53', 1, 'localhost', '', '73-27072011-173753'),
(32, '001', 0, 150000, '2011-07-27', '2011-07-27 17:37:53', 1, 'localhost', '', '73-27072011-173753');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_pembayaran_pinjaman`
--

CREATE TABLE IF NOT EXISTS `jenis_pembayaran_pinjaman` (
  `id_jenis_pembayaran` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pembayaran` varchar(30) NOT NULL,
  PRIMARY KEY (`id_jenis_pembayaran`),
  UNIQUE KEY `nama_pembayaran` (`nama_pembayaran`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `jenis_pembayaran_pinjaman`
--

INSERT INTO `jenis_pembayaran_pinjaman` (`id_jenis_pembayaran`, `nama_pembayaran`) VALUES
(1, 'Pokok'),
(2, 'Jasa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_tabungan`
--

CREATE TABLE IF NOT EXISTS `jenis_tabungan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_tabungan` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jenis_tabungan` (`jenis_tabungan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `jenis_tabungan`
--

INSERT INTO `jenis_tabungan` (`id`, `jenis_tabungan`) VALUES
(1, 'Sukarela'),
(2, 'Wajib'),
(3, 'Pokok');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran_pinjaman`
--

CREATE TABLE IF NOT EXISTS `pembayaran_pinjaman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pinjaman` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `ip_input` varchar(50) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `jumlah_pembayaran` decimal(10,0) NOT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `jenis_pembayaran` int(11) NOT NULL DEFAULT '1' COMMENT 'pokok atau jasa',
  PRIMARY KEY (`id`),
  KEY `id_pinjaman` (`id_pinjaman`,`id_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data untuk tabel `pembayaran_pinjaman`
--

INSERT INTO `pembayaran_pinjaman` (`id`, `id_pinjaman`, `id_user`, `tgl_transaksi`, `ip_input`, `tgl_input`, `jumlah_pembayaran`, `keterangan`, `jenis_pembayaran`) VALUES
(1, 1, 1, '2010-10-06', '127.0.0.1', '2010-10-06 09:33:09', 100000, 'Pembayaran Jasa', 2),
(2, 1, 0, '2010-10-07', '', '0000-00-00 00:00:00', 100000, 'test', 1),
(3, 1, 0, '2010-10-08', '', '0000-00-00 00:00:00', 500000, 'test', 1),
(4, 1, 0, '2010-10-09', '', '0000-00-00 00:00:00', 50000, 'test', 1),
(5, 1, 0, '2010-10-07', '', '0000-00-00 00:00:00', 35000, 'Dibayar Oleh Dedi', 1),
(6, 11, 0, '2010-10-07', '', '0000-00-00 00:00:00', 50000, 'Bayar', 1),
(7, 12, 0, '2010-10-11', '', '0000-00-00 00:00:00', 1000000, 'test', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE IF NOT EXISTS `pengeluaran` (
  `id` int(11) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `jumlah` decimal(10,0) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `id_user` int(11) NOT NULL,
  `ip_input` varchar(30) NOT NULL DEFAULT '',
  `tgl_input` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengeluaran`
--

INSERT INTO `pengeluaran` (`id`, `tgl_transaksi`, `jumlah`, `keterangan`, `id_user`, `ip_input`, `tgl_input`) VALUES
(0, '2010-10-12', 15000, '', 1, 'localhost', '2010-10-12 10:01:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pinjaman`
--

CREATE TABLE IF NOT EXISTS `pinjaman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_anggota` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `ip_input` varchar(50) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `jumlah_pinjaman` decimal(10,0) NOT NULL,
  `catatan` varchar(100) DEFAULT NULL,
  `saldo` decimal(10,0) NOT NULL COMMENT 'saldo = jumlah_pinjaman + jasa',
  `jumlah_jasa` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_anggota` (`id_anggota`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=13 ;

--
-- Dumping data untuk tabel `pinjaman`
--

INSERT INTO `pinjaman` (`id`, `id_anggota`, `id_user`, `tgl_transaksi`, `ip_input`, `tgl_input`, `jumlah_pinjaman`, `catatan`, `saldo`, `jumlah_jasa`) VALUES
(1, 1, 1, '2010-10-01', '127.0.0.1', '2010-10-01 08:59:46', 1000000, NULL, 315000, 100000),
(12, 1, 1, '2010-10-11', 'localhost', '2010-10-11 13:19:32', 1200000, NULL, 320000, 120000),
(11, 2, 0, '2010-10-07', 'localhost', '2010-10-07 13:17:13', 1000000, NULL, 1050000, 100000);

-- --------------------------------------------------------

--
-- Stand-in structure for view `summary_tabungan`
--
CREATE TABLE IF NOT EXISTS `summary_tabungan` (
`j_in` decimal(32,0)
,`j_out` decimal(32,0)
,`saldo` decimal(33,0)
,`id_anggota` int(11)
,`nama` varchar(50)
,`id_jenis_tabungan` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `summary_tabungan_total`
--
CREATE TABLE IF NOT EXISTS `summary_tabungan_total` (
`j_in` decimal(32,0)
,`j_out` decimal(32,0)
,`saldo` decimal(33,0)
,`id_anggota` int(11)
,`nama` varchar(50)
,`id_jenis_tabungan` int(11)
);
-- --------------------------------------------------------

--
-- Struktur dari tabel `tabungan`
--

CREATE TABLE IF NOT EXISTS `tabungan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_anggota` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `jumlah_in` decimal(10,0) NOT NULL,
  `jumlah_out` decimal(10,0) NOT NULL,
  `catatan` varchar(100) DEFAULT NULL,
  `ip_input` varchar(50) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `id_jenis_tabungan` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_anggota` (`id_anggota`),
  KEY `id_user` (`id_user`),
  KEY `tgl_transaksi` (`tgl_transaksi`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data untuk tabel `tabungan`
--

INSERT INTO `tabungan` (`id`, `id_anggota`, `id_user`, `tgl_transaksi`, `jumlah_in`, `jumlah_out`, `catatan`, `ip_input`, `tgl_input`, `id_jenis_tabungan`) VALUES
(1, 1, 1, '2010-09-27', 10000, 0, NULL, '127.0.0.1', '2010-09-27 12:36:41', 1),
(2, 1, 1, '2010-09-28', 10000, 0, NULL, '127.0.0.1', '2010-09-02 12:22:25', 2),
(3, 1, 1, '2010-09-28', 10000, 0, NULL, '127.0.0.1', '2010-09-02 12:22:25', 3),
(4, 2, 1, '2010-09-28', 10000, 0, NULL, '127.0.0.1', '2010-09-28 15:43:32', 1),
(5, 2, 1, '2010-09-28', 10000, 0, NULL, '127.0.0.1', '2010-09-28 15:43:32', 1),
(6, 2, 1, '2010-09-28', 10000, 0, NULL, '127.0.0.1', '2010-09-28 15:43:32', 1),
(7, 2, 1, '2010-09-28', 10000, 0, NULL, '127.0.0.1', '2010-09-28 15:43:32', 1),
(8, 2, 1, '2010-09-28', 10000, 0, NULL, '127.0.0.1', '2010-09-28 15:43:32', 1),
(9, 2, 1, '2010-09-28', 10000, 0, NULL, '127.0.0.1', '2010-09-28 15:43:32', 1),
(10, 2, 1, '2010-09-28', 10000, 0, NULL, '127.0.0.1', '2010-09-28 15:43:32', 1),
(11, 2, 1, '2010-09-28', 10000, 0, NULL, '127.0.0.1', '2010-09-28 15:43:32', 1),
(12, 2, 1, '2010-09-28', 10000, 0, NULL, '127.0.0.1', '2010-09-28 15:43:32', 1),
(13, 1, 0, '2010-01-02', 13500, 0, NULL, 'localhost', '2010-09-28 18:19:43', 1),
(14, 1, 0, '2010-01-02', 13500, 0, NULL, 'localhost', '2010-09-28 18:22:09', 1),
(15, 2, 0, '2010-01-02', 14500, 0, NULL, 'localhost', '2010-09-28 18:22:31', 1),
(16, 1, 0, '0000-00-00', 12000, 0, NULL, 'localhost', '2010-10-04 11:12:47', 1),
(17, 2, 0, '0000-00-00', 15000, 0, NULL, 'localhost', '2010-10-04 11:13:27', 1),
(18, 2, 0, '2010-10-04', 1000, 0, NULL, 'localhost', '2010-10-04 11:15:24', 1),
(19, 1, 1, '2010-10-08', 13500, 0, NULL, 'localhost', '2010-10-08 18:01:54', 1),
(20, 1, 1, '2010-10-08', 11000, 0, NULL, 'localhost', '2010-10-08 18:37:21', 1),
(21, 1, 1, '2010-10-08', 13000, 0, NULL, 'localhost', '2010-10-08 18:41:26', 1),
(22, 1, 1, '2010-10-08', 13000, 0, NULL, 'localhost', '2010-10-08 18:42:17', 1),
(23, 1, 1, '2010-10-08', 13000, 0, NULL, 'localhost', '2010-10-08 18:42:44', 1),
(24, 1, 1, '2010-10-08', 13000, 0, NULL, 'localhost', '2010-10-08 18:42:50', 1),
(25, 1, 1, '2010-10-08', 13000, 0, NULL, 'localhost', '2010-10-08 18:42:57', 1),
(26, 1, 1, '2010-10-08', 5666, 0, NULL, 'localhost', '2010-10-08 18:43:43', 1),
(27, 1, 1, '2010-10-08', 5666, 0, NULL, 'localhost', '2010-10-08 18:48:17', 1),
(28, 1, 1, '2010-10-08', 5666, 0, NULL, 'localhost', '2010-10-08 18:48:43', 1),
(29, 1, 1, '2010-10-08', 5666, 0, NULL, 'localhost', '2010-10-08 18:49:57', 1),
(30, 1, 1, '2010-10-08', 5666, 0, NULL, 'localhost', '2010-10-08 18:50:37', 1),
(31, 1, 1, '2010-10-08', 5666, 0, NULL, 'localhost', '2010-10-08 18:51:24', 1),
(32, 1, 1, '2010-10-08', 5666, 0, NULL, 'localhost', '2010-10-08 18:51:53', 1),
(33, 1, 1, '2010-10-08', 5666, 0, NULL, 'localhost', '2010-10-08 18:52:13', 1),
(34, 1, 1, '2010-10-08', 5666, 0, NULL, 'localhost', '2010-10-08 18:52:32', 1),
(35, 1, 1, '2010-10-08', 5666, 0, NULL, 'localhost', '2010-10-08 18:52:35', 1),
(36, 1, 1, '2010-10-08', 5666, 0, NULL, 'localhost', '2010-10-08 18:52:36', 1),
(37, 1, 1, '2010-10-08', 5666, 0, NULL, 'localhost', '2010-10-08 18:52:56', 1),
(38, 1, 1, '2010-10-08', 5666, 0, NULL, 'localhost', '2010-10-08 18:53:13', 1),
(39, 1, 1, '2010-10-08', 5666, 0, NULL, 'localhost', '2010-10-08 18:54:02', 1),
(40, 1, 1, '2010-10-08', 5666, 0, NULL, 'localhost', '2010-10-08 18:54:24', 1),
(41, 1, 1, '2010-10-08', 5666, 0, NULL, 'localhost', '2010-10-08 19:18:21', 1),
(42, 1, 1, '2010-10-08', 14000, 0, NULL, 'localhost', '2010-10-08 19:19:25', 1),
(43, 1, 1, '2010-10-08', 14000, 0, NULL, 'localhost', '2010-10-08 19:19:40', 1),
(44, 1, 1, '2010-10-11', 15000, 0, NULL, 'localhost', '2010-10-11 09:44:26', 1),
(45, 1, 1, '2010-10-11', 15000, 0, NULL, 'localhost', '2010-10-11 10:04:16', 1),
(46, 1, 1, '2010-10-11', 12500, 0, NULL, 'localhost', '2010-10-11 10:04:33', 1),
(47, 1, 1, '2010-10-11', 1250, 0, NULL, 'localhost', '2010-10-11 13:54:36', 1),
(48, 1, 1, '2010-10-11', 1260, 0, NULL, 'localhost', '2010-10-11 13:55:14', 1),
(49, 1, 1, '2010-10-11', 1260, 0, NULL, 'localhost', '2010-10-11 13:56:01', 1),
(50, 1, 1, '2011-07-20', 15000, 0, NULL, 'localhost', '2011-07-20 12:32:31', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `id_anggota` int(11) DEFAULT NULL,
  `tgl_input` datetime NOT NULL,
  `ip_input` varchar(30) NOT NULL,
  `user_level` int(11) NOT NULL DEFAULT '1' COMMENT 'level user. 99 admin, 1. user biasa',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`,`email`),
  KEY `password` (`password`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `user_name`, `password`, `email`, `id_anggota`, `tgl_input`, `ip_input`, `user_level`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'satiri.a@gmail.com', NULL, '0000-00-00 00:00:00', '', 1);

-- --------------------------------------------------------

--
-- Structure for view `summary_tabungan`
--
DROP TABLE IF EXISTS `summary_tabungan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `summary_tabungan` AS select sum(`tabungan`.`jumlah_in`) AS `j_in`,sum(`tabungan`.`jumlah_out`) AS `j_out`,sum((`tabungan`.`jumlah_in` - `tabungan`.`jumlah_out`)) AS `saldo`,`tabungan`.`id_anggota` AS `id_anggota`,`anggota`.`nama` AS `nama`,`tabungan`.`id_jenis_tabungan` AS `id_jenis_tabungan` from ((`tabungan` join `anggota` on((`tabungan`.`id_anggota` = `anggota`.`id`))) join `jenis_tabungan` on((`tabungan`.`id_jenis_tabungan` = `jenis_tabungan`.`id`))) group by `anggota`.`id`,`tabungan`.`id_jenis_tabungan` order by `anggota`.`nama`;

-- --------------------------------------------------------

--
-- Structure for view `summary_tabungan_total`
--
DROP TABLE IF EXISTS `summary_tabungan_total`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `summary_tabungan_total` AS select sum(`tabungan`.`jumlah_in`) AS `j_in`,sum(`tabungan`.`jumlah_out`) AS `j_out`,sum((`tabungan`.`jumlah_in` - `tabungan`.`jumlah_out`)) AS `saldo`,`tabungan`.`id_anggota` AS `id_anggota`,`anggota`.`nama` AS `nama`,`tabungan`.`id_jenis_tabungan` AS `id_jenis_tabungan` from ((`tabungan` join `anggota` on((`tabungan`.`id_anggota` = `anggota`.`id`))) join `jenis_tabungan` on((`tabungan`.`id_jenis_tabungan` = `jenis_tabungan`.`id`))) group by `anggota`.`id` order by `anggota`.`nama`;
