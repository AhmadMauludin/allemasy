-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: learning_management_system
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tb_buku`
--

DROP TABLE IF EXISTS `tb_buku`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_buku` (
  `id_buku` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(150) NOT NULL,
  `pengarang` varchar(100) DEFAULT NULL,
  `penerbit` varchar(100) DEFAULT NULL,
  `keilmuan` varchar(100) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `ket` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_buku`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_buku`
--

LOCK TABLES `tb_buku` WRITE;
/*!40000 ALTER TABLE `tb_buku` DISABLE KEYS */;
INSERT INTO `tb_buku` VALUES (1,'Aplikasi Seminar Prakerin Berbasis Web','Ahmad Mauludin','almapedia','Teknologi Informasi',2025,'aktif','tidak ada keterangan','1760060074_26cb6f988d2f85ac19e0.jpg');
/*!40000 ALTER TABLE `tb_buku` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_guru`
--

DROP TABLE IF EXISTS `tb_guru`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_guru` (
  `id_guru` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `telp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` enum('aktif','cuti','nonaktif') DEFAULT 'aktif',
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_guru`),
  UNIQUE KEY `nip` (`nip`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `tb_guru_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_guru`
--

LOCK TABLES `tb_guru` WRITE;
/*!40000 ALTER TABLE `tb_guru` DISABLE KEYS */;
INSERT INTO `tb_guru` VALUES (2,8,'Ahmad Mauludin','1990081720200410','Gelembung Cisarua Sumedang','1999-07-01','08118881111','ahmad.mauludin247@guru.smk.belajar.id','aktif','1760024679_2ca16627c3592d0af1eb.jpg');
/*!40000 ALTER TABLE `tb_guru` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_jabatan`
--

DROP TABLE IF EXISTS `tb_jabatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_jabatan` (
  `id_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  PRIMARY KEY (`id_jabatan`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `tb_jabatan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_jabatan`
--

LOCK TABLES `tb_jabatan` WRITE;
/*!40000 ALTER TABLE `tb_jabatan` DISABLE KEYS */;
INSERT INTO `tb_jabatan` VALUES (3,8,'Wakasek Kesiswaan','aktif'),(4,7,'Ketua OSIS','aktif');
/*!40000 ALTER TABLE `tb_jabatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_jadwal`
--

DROP TABLE IF EXISTS `tb_jadwal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_jadwal` (
  `id_jadwal` int(11) NOT NULL AUTO_INCREMENT,
  `id_kontrak_jadwal` int(11) NOT NULL,
  `hari` enum('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jampel` varchar(20) NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `id_ruangan` int(11) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `ket` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_jadwal`),
  KEY `id_kontrak_jadwal` (`id_kontrak_jadwal`),
  KEY `id_ruangan` (`id_ruangan`),
  CONSTRAINT `tb_jadwal_ibfk_1` FOREIGN KEY (`id_kontrak_jadwal`) REFERENCES `tb_kontrak_jadwal` (`id_kontrak_jadwal`) ON DELETE CASCADE,
  CONSTRAINT `tb_jadwal_ibfk_2` FOREIGN KEY (`id_ruangan`) REFERENCES `tb_ruangan` (`id_ruangan`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_jadwal`
--

LOCK TABLES `tb_jadwal` WRITE;
/*!40000 ALTER TABLE `tb_jadwal` DISABLE KEYS */;
INSERT INTO `tb_jadwal` VALUES (1,3,'Selasa','1 - 5','07:00:00','21:54:00',1,'aktif','baik baik','1760079303_2a04561c73d4ef768ef2.jpg');
/*!40000 ALTER TABLE `tb_jadwal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_kelas`
--

DROP TABLE IF EXISTS `tb_kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_kelas` (
  `id_kelas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(100) NOT NULL,
  `tingkat` enum('1','2','3','4','5','6') NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_ruangan` int(11) DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_kelas`),
  KEY `id_user` (`id_user`),
  KEY `id_ruangan` (`id_ruangan`) USING BTREE,
  CONSTRAINT `tb_kelas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE SET NULL,
  CONSTRAINT `tb_kelas_ibfk_2` FOREIGN KEY (`id_ruangan`) REFERENCES `tb_ruangan` (`id_ruangan`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_kelas`
--

LOCK TABLES `tb_kelas` WRITE;
/*!40000 ALTER TABLE `tb_kelas` DISABLE KEYS */;
INSERT INTO `tb_kelas` VALUES (1,'XI A','5',8,1,'Kelas XI A','aktif','1760023025_2536b5b99833530e5ef9.jpg');
/*!40000 ALTER TABLE `tb_kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_kontrak_jadwal`
--

DROP TABLE IF EXISTS `tb_kontrak_jadwal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_kontrak_jadwal` (
  `id_kontrak_jadwal` int(11) NOT NULL AUTO_INCREMENT,
  `id_mapel` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_tahun_ajaran` int(11) DEFAULT NULL,
  `jumlah_jam` int(11) DEFAULT 0,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `ket` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_kontrak_jadwal`),
  KEY `id_mapel` (`id_mapel`),
  KEY `id_user` (`id_user`),
  KEY `id_kelas` (`id_kelas`),
  KEY `id_tahun_ajaran` (`id_tahun_ajaran`),
  CONSTRAINT `tb_kontrak_jadwal_ibfk_1` FOREIGN KEY (`id_mapel`) REFERENCES `tb_mapel` (`id_mapel`) ON DELETE CASCADE,
  CONSTRAINT `tb_kontrak_jadwal_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE,
  CONSTRAINT `tb_kontrak_jadwal_ibfk_3` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE CASCADE,
  CONSTRAINT `tb_kontrak_jadwal_ibfk_4` FOREIGN KEY (`id_tahun_ajaran`) REFERENCES `tb_tahun_ajaran` (`id_tahun_ajaran`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_kontrak_jadwal`
--

LOCK TABLES `tb_kontrak_jadwal` WRITE;
/*!40000 ALTER TABLE `tb_kontrak_jadwal` DISABLE KEYS */;
INSERT INTO `tb_kontrak_jadwal` VALUES (3,1,8,1,1,5,'aktif','','1760077140_ee4a6c748651807d8071.jpg');
/*!40000 ALTER TABLE `tb_kontrak_jadwal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_log_aktivitas`
--

DROP TABLE IF EXISTS `tb_log_aktivitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_log_aktivitas` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `aksi` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `waktu` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_log`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `tb_log_aktivitas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_log_aktivitas`
--

LOCK TABLES `tb_log_aktivitas` WRITE;
/*!40000 ALTER TABLE `tb_log_aktivitas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_log_aktivitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_mapel`
--

DROP TABLE IF EXISTS `tb_mapel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_mapel` (
  `id_mapel` int(11) NOT NULL AUTO_INCREMENT,
  `kode_mapel` varchar(50) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  `golongan` enum('produktif','muatan nasional','muatan lokal') NOT NULL,
  `tingkat` enum('1','2','3','4','5','6') NOT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `ket` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mapel`),
  UNIQUE KEY `kode_mapel` (`kode_mapel`),
  KEY `id_buku` (`id_buku`),
  CONSTRAINT `tb_mapel_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `tb_buku` (`id_buku`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_mapel`
--

LOCK TABLES `tb_mapel` WRITE;
/*!40000 ALTER TABLE `tb_mapel` DISABLE KEYS */;
INSERT INTO `tb_mapel` VALUES (1,'PR-01','Pemrograman Web','produktif','5',1,'aktif','','1760075847_586c967d171737f5291e.jpg');
/*!40000 ALTER TABLE `tb_mapel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_materi`
--

DROP TABLE IF EXISTS `tb_materi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_materi` (
  `id_materi` int(11) NOT NULL AUTO_INCREMENT,
  `id_pertemuan` int(11) DEFAULT NULL,
  `judul` varchar(150) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `link_video` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  PRIMARY KEY (`id_materi`),
  KEY `id_pertemuan` (`id_pertemuan`),
  CONSTRAINT `tb_materi_ibfk_1` FOREIGN KEY (`id_pertemuan`) REFERENCES `tb_pertemuan` (`id_pertemuan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_materi`
--

LOCK TABLES `tb_materi` WRITE;
/*!40000 ALTER TABLE `tb_materi` DISABLE KEYS */;
INSERT INTO `tb_materi` VALUES (1,2,'Aplikasi Seminar Prakerin Berbasis Web','ghfx','1760263731_d5a3ebfa30d017187ef5.docx','https://gfxfgfxg.com','aktif');
/*!40000 ALTER TABLE `tb_materi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_nilai`
--

DROP TABLE IF EXISTS `tb_nilai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_nilai` (
  `id_nilai` int(11) NOT NULL AUTO_INCREMENT,
  `id_pesdik` int(11) NOT NULL,
  `id_tugas` int(11) DEFAULT NULL,
  `id_mapel` int(11) DEFAULT NULL,
  `nilai` decimal(5,2) DEFAULT NULL,
  `kategori` enum('tugas','ulangan','ujian','praktik') DEFAULT 'tugas',
  `komentar` text DEFAULT NULL,
  PRIMARY KEY (`id_nilai`),
  KEY `id_pesdik` (`id_pesdik`),
  KEY `id_tugas` (`id_tugas`),
  KEY `id_mapel` (`id_mapel`),
  CONSTRAINT `tb_nilai_ibfk_1` FOREIGN KEY (`id_pesdik`) REFERENCES `tb_pesdik` (`id_pesdik`) ON DELETE CASCADE,
  CONSTRAINT `tb_nilai_ibfk_2` FOREIGN KEY (`id_tugas`) REFERENCES `tb_tugas` (`id_tugas`) ON DELETE SET NULL,
  CONSTRAINT `tb_nilai_ibfk_3` FOREIGN KEY (`id_mapel`) REFERENCES `tb_mapel` (`id_mapel`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_nilai`
--

LOCK TABLES `tb_nilai` WRITE;
/*!40000 ALTER TABLE `tb_nilai` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_nilai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_pengumpulan_tugas`
--

DROP TABLE IF EXISTS `tb_pengumpulan_tugas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_pengumpulan_tugas` (
  `id_pengumpulan_tugas` int(11) NOT NULL AUTO_INCREMENT,
  `id_tugas` int(11) NOT NULL,
  `id_pesdik` int(11) NOT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `nilai` varchar(10) DEFAULT NULL,
  `status` enum('dikirim','diterima','ditolak','selesai') DEFAULT 'dikirim',
  `intruksi` text DEFAULT NULL,
  PRIMARY KEY (`id_pengumpulan_tugas`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_pengumpulan_tugas`
--

LOCK TABLES `tb_pengumpulan_tugas` WRITE;
/*!40000 ALTER TABLE `tb_pengumpulan_tugas` DISABLE KEYS */;
INSERT INTO `tb_pengumpulan_tugas` VALUES (3,2,3,'1760341809_7377ed105cc2d306b4c2.docx','90','diterima','Baik');
/*!40000 ALTER TABLE `tb_pengumpulan_tugas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_pengumuman`
--

DROP TABLE IF EXISTS `tb_pengumuman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_pengumuman` (
  `id_pengumuman` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(150) DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `tanggal` date DEFAULT curdate(),
  `target` enum('semua','guru','pesdik','staf','kelas') DEFAULT 'semua',
  `id_kelas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pengumuman`),
  KEY `id_kelas` (`id_kelas`),
  CONSTRAINT `tb_pengumuman_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_pengumuman`
--

LOCK TABLES `tb_pengumuman` WRITE;
/*!40000 ALTER TABLE `tb_pengumuman` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_pengumuman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_pertemuan`
--

DROP TABLE IF EXISTS `tb_pertemuan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_pertemuan` (
  `id_pertemuan` int(11) NOT NULL AUTO_INCREMENT,
  `id_jadwal` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Dijadwalkan','Hadir','Tugas','Alfa') DEFAULT 'Dijadwalkan',
  `ket` text DEFAULT NULL,
  `materi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pertemuan`),
  KEY `id_jadwal` (`id_jadwal`),
  CONSTRAINT `tb_pertemuan_ibfk_1` FOREIGN KEY (`id_jadwal`) REFERENCES `tb_jadwal` (`id_jadwal`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_pertemuan`
--

LOCK TABLES `tb_pertemuan` WRITE;
/*!40000 ALTER TABLE `tb_pertemuan` DISABLE KEYS */;
INSERT INTO `tb_pertemuan` VALUES (2,1,'2025-10-14','Hadir','Mantap','Pengenalan CSS','1760253714_9005743e8dd1af8761d9.jpg'),(4,1,'2025-10-20','Dijadwalkan','Siap','Framework CI','');
/*!40000 ALTER TABLE `tb_pertemuan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_pesdik`
--

DROP TABLE IF EXISTS `tb_pesdik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_pesdik` (
  `id_pesdik` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jk` enum('l','p') NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `telp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pesdik`),
  UNIQUE KEY `nisn` (`nisn`),
  UNIQUE KEY `nis` (`nis`),
  KEY `id_kelas` (`id_kelas`),
  CONSTRAINT `tb_pesdik_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE,
  CONSTRAINT `tb_pesdik_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_pesdik`
--

LOCK TABLES `tb_pesdik` WRITE;
/*!40000 ALTER TABLE `tb_pesdik` DISABLE KEYS */;
INSERT INTO `tb_pesdik` VALUES (3,7,'Saheela Meera','p',1,'0031759504','1809599101','2025-10-09','08118881111','emailsiswa@gmail.com','Cisitu Sumedang','aktif','1760023465_38d02643611e0d4cb31d.jpg'),(4,9,'Siti Fadhilah Kamelia','p',1,'0031759505','1809599102','2025-10-07','08118881111','emailsiswa@gmail.com','Rancakalong Sumedang','aktif','1760023937_c8bf45f3cda97fb53767.jpg');
/*!40000 ALTER TABLE `tb_pesdik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_presensi`
--

DROP TABLE IF EXISTS `tb_presensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_presensi` (
  `id_presensi` int(11) NOT NULL AUTO_INCREMENT,
  `id_pertemuan` int(11) NOT NULL,
  `id_pesdik` int(11) NOT NULL,
  `status` enum('hadir','sakit','ijin','alfa','pending') DEFAULT 'pending',
  `ket` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_presensi`),
  KEY `id_pertemuan` (`id_pertemuan`),
  KEY `id_pesdik` (`id_pesdik`),
  CONSTRAINT `tb_presensi_ibfk_1` FOREIGN KEY (`id_pertemuan`) REFERENCES `tb_pertemuan` (`id_pertemuan`) ON DELETE CASCADE,
  CONSTRAINT `tb_presensi_ibfk_2` FOREIGN KEY (`id_pesdik`) REFERENCES `tb_pesdik` (`id_pesdik`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_presensi`
--

LOCK TABLES `tb_presensi` WRITE;
/*!40000 ALTER TABLE `tb_presensi` DISABLE KEYS */;
INSERT INTO `tb_presensi` VALUES (1,2,3,'hadir','Telat',NULL),(2,2,4,'sakit','Demam','1760258047_0455cd67f6aadc26451b.pdf'),(5,4,3,'pending',NULL,NULL),(6,4,4,'pending',NULL,NULL);
/*!40000 ALTER TABLE `tb_presensi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_ruangan`
--

DROP TABLE IF EXISTS `tb_ruangan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_ruangan` (
  `id_ruangan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `nama_ruangan` varchar(100) NOT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `ket` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_ruangan`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `tb_ruangan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_ruangan`
--

LOCK TABLES `tb_ruangan` WRITE;
/*!40000 ALTER TABLE `tb_ruangan` DISABLE KEYS */;
INSERT INTO `tb_ruangan` VALUES (1,8,'Ruang Kelas A','-6.808366144866421','107.8896429','aktif','Ruang kelas kondisi baik namun pintunya rusak','1760022957_7caa177ca2bb8a4f4451.png');
/*!40000 ALTER TABLE `tb_ruangan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_tahun_ajaran`
--

DROP TABLE IF EXISTS `tb_tahun_ajaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_tahun_ajaran` (
  `id_tahun_ajaran` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` varchar(9) NOT NULL,
  `semester` enum('ganjil','genap') NOT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  PRIMARY KEY (`id_tahun_ajaran`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_tahun_ajaran`
--

LOCK TABLES `tb_tahun_ajaran` WRITE;
/*!40000 ALTER TABLE `tb_tahun_ajaran` DISABLE KEYS */;
INSERT INTO `tb_tahun_ajaran` VALUES (1,'2025/2026','ganjil','aktif'),(2,'2025/2026','genap','aktif');
/*!40000 ALTER TABLE `tb_tahun_ajaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_tugas`
--

DROP TABLE IF EXISTS `tb_tugas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_tugas` (
  `id_tugas` int(11) NOT NULL AUTO_INCREMENT,
  `id_pertemuan` int(11) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `instruksi` text DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `status` enum('ditugaskan','selesai') DEFAULT 'ditugaskan',
  `file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_tugas`),
  KEY `id_pertemuan` (`id_pertemuan`),
  CONSTRAINT `tb_tugas_ibfk_1` FOREIGN KEY (`id_pertemuan`) REFERENCES `tb_pertemuan` (`id_pertemuan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_tugas`
--

LOCK TABLES `tb_tugas` WRITE;
/*!40000 ALTER TABLE `tb_tugas` DISABLE KEYS */;
INSERT INTO `tb_tugas` VALUES (2,2,'Sistem Manajemen Pelayanan Informasi Pegawai','hd','2025-10-12 17:13:00','ditugaskan','1760264001_f47f1d5bfd67f0ff42e3.docx');
/*!40000 ALTER TABLE `tb_tugas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_user`
--

DROP TABLE IF EXISTS `tb_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','guru','staf','pesdik') NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_user`
--

LOCK TABLES `tb_user` WRITE;
/*!40000 ALTER TABLE `tb_user` DISABLE KEYS */;
INSERT INTO `tb_user` VALUES (1,'admin','$2y$10$iCFf0dZ4itSOzGM1MwuQZuTUnfwTBS/VCwpo75zcdb2Gncdy3mkda','aktif','1760027633_204d62d3fd1b9d5df663.png','2025-10-07 11:00:45','admin'),(7,'saheela','$2y$10$7BZQTMHwhB2M8CsdBbOQnOTp81M1HCO9zPdZz/hItKOdnHwMIXnnu','aktif','1760027595_1f14fcb718a26f7409c2.jpg','2025-10-08 17:00:57','pesdik'),(8,'ahmad','$2y$10$Tb7.GRrubXh3R46gICC1JOKvHkTDCp47c3iRtJKm5ESwqdxGkydhe','aktif','1760027586_ac121121db5d86d87508.jpg','2025-10-08 17:02:02','guru'),(9,'sitifadhilah','$2y$10$5LA/17uMPEN3Sg8.qBWwJeU9Rn89R3ubgFM.K83E69uy6aXEHv/9W','aktif','1760023894_9d94cae2029363ef0a29.jpg','2025-10-09 15:31:34','pesdik');
/*!40000 ALTER TABLE `tb_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-13 23:21:13
