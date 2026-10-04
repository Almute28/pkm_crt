-- ==========================================================
-- UPT PUSKESMAS CARITA - KABUPATEN PANDEGLANG
-- Database Schema & Comprehensive Seed Data
-- Motto: "Carita Wisata Sehat"
-- ==========================================================

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `contacts`;
DROP TABLE IF EXISTS `settings`;
DROP TABLE IF EXISTS `social_media`;
DROP TABLE IF EXISTS `complaints`;
DROP TABLE IF EXISTS `announcements`;
DROP TABLE IF EXISTS `public_documents`;
DROP TABLE IF EXISTS `videos`;
DROP TABLE IF EXISTS `galleries`;
DROP TABLE IF EXISTS `articles`;
DROP TABLE IF EXISTS `news`;
DROP TABLE IF EXISTS `innovations`;
DROP TABLE IF EXISTS `programs`;
DROP TABLE IF EXISTS `service_schedules`;
DROP TABLE IF EXISTS `services`;
DROP TABLE IF EXISTS `pages`;
DROP TABLE IF EXISTS `users`;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. USERS TABLE
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `role` ENUM('admin', 'operator') DEFAULT 'admin',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admin credentials: username=admin, password=adminpuskesmas2026
-- Hash generated using PASSWORD_BCRYPT
INSERT INTO `users` (`username`, `password`, `full_name`, `email`, `role`) VALUES
('admin', '$2y$10$w8u3uS1fNl9jS3tXzP2KjOzR07nN9x4o6i5vY07u4Z1e8V2J1F6yO', 'Administrator Puskesmas Carita', 'admin.carita@pandeglangkab.go.id', 'admin');

-- 2. SETTINGS TABLE
CREATE TABLE `settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(50) NOT NULL UNIQUE,
  `setting_value` TEXT,
  `setting_group` VARCHAR(30) DEFAULT 'general'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
('site_title', 'UPT Puskesmas Carita', 'general'),
('site_sub', 'Puskesmas Carita Kabupaten Pandeglang', 'general'),
('motto', 'Carita Wisata Sehat', 'general'),
('head_name', 'Mahmudi, S.Kep., Ners', 'head'),
('head_title', 'Kepala UPT Puskesmas Carita', 'head'),
('head_photo', 'assets/img/kepala-puskesmas.jpg', 'head'),
('head_speech', 'Puji dan syukur kita panjatkan ke hadirat Allah SWT atas rahmat dan karunia-Nya, website resmi UPT Puskesmas Carita dapat hadir sebagai wujud transparansi, keterbukaan informasi, dan kemudahan akses layanan kesehatan bagi seluruh masyarakat Kecamatan Carita dan para wisatawan yang berkunjung ke kawasan pesisir Carita, Kabupaten Pandeglang.\n\nSesuai dengan motto kami “Carita Wisata Sehat”, kami berkomitmen untuk terus meningkatkan mutu pelayanan kesehatan primer yang ramah, cepat, tepat, dan berorientasi pada keselamatan pasien serta pencegahan penyakit promotif dan preventif. Melalui portal ini, masyarakat dapat dengan mudah memperoleh informasi mengenai jadwal dokter, jenis layanan medis, program unggulan ILP, inovasi KAJEDAK, serta kanal pengaduan langsung.\n\nMari bersama-sama kita wujudkan masyarakat Carita yang sehat, mandiri, dan berdaya saing.', 'head'),
('hero_headline', 'Selamat Datang di UPT Puskesmas Carita', 'hero'),
('hero_subheadline', 'Memberikan pelayanan kesehatan yang mudah, cepat, ramah, dan berkualitas bagi masyarakat Carita dan sekitarnya.', 'hero'),
('hero_image', 'assets/img/hero-puskesmas.jpg', 'hero'),
('about_summary', 'UPT Puskesmas Carita merupakan fasilitas pelayanan kesehatan tingkat pertama (FKTP) yang berada di bawah naungan Dinas Kesehatan Kabupaten Pandeglang, Provinsi Banten. Kami melayani masyarakat di 10 desa wilayah kerja Kecamatan Carita serta menjadi rujukan pertama layanan kesehatan wisata di kawasan pesisir Selat Sunda.', 'about'),
('stats_nakes', '42', 'stats'),
('stats_services', '18', 'stats'),
('stats_programs', '14', 'stats'),
('stats_villages', '10', 'stats'),
('phone', '(0253) 802100', 'contact'),
('emergency_phone', '0812-8899-7722', 'contact'),
('whatsapp', '081288997722', 'contact'),
('email', 'pkmcarita@pandeglangkab.go.id', 'contact'),
('address', 'Jl. Raya Labuan - Carita KM. 9, Desa Carita, Kecamatan Carita, Kabupaten Pandeglang, Banten 42264', 'contact'),
('working_hours', 'Senin - Sabtu: 08.00 - 14.00 WIB | UGD & PONED 24 Jam', 'contact'),
('maps_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15865.73359569722!2d105.8458!3d-6.3117!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e423f03b2907fc9%3A0x7d6f51cb3229b12e!2sPuskesmas%20Carita!5e0!3m2!1sid!2sid!4v1700000000000', 'contact');

-- 3. SOCIAL MEDIA
CREATE TABLE `social_media` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `platform` VARCHAR(50) NOT NULL,
  `account_name` VARCHAR(100) NOT NULL,
  `url` VARCHAR(255) NOT NULL,
  `icon` VARCHAR(50) NOT NULL,
  `is_active` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `social_media` (`platform`, `account_name`, `url`, `icon`, `is_active`) VALUES
('Instagram', '@puskesmas_carita', 'https://instagram.com/puskesmas_carita', 'fab fa-instagram', 1),
('Facebook', 'UPT Puskesmas Carita Pandeglang', 'https://facebook.com/puskesmascarita', 'fab fa-facebook-f', 1),
('YouTube', 'Puskesmas Carita Official', 'https://youtube.com/@puskesmascarita', 'fab fa-youtube', 1),
('TikTok', '@puskesmascarita', 'https://tiktok.com/@puskesmascarita', 'fab fa-tiktok', 1),
('WhatsApp', 'Layanan Informasi & Antrean', 'https://wa.me/6281288997722?text=Halo%20Admin%20Puskesmas%20Carita%2C%20saya%20ingin%20bertanya%20informasi%20layanan', 'fab fa-whatsapp', 1);

-- 4. SERVICES TABLE
CREATE TABLE `services` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(120) NOT NULL UNIQUE,
  `category` VARCHAR(50) NOT NULL,
  `description` TEXT,
  `schedule_info` VARCHAR(200),
  `location` VARCHAR(100),
  `officer` VARCHAR(100),
  `icon` VARCHAR(50) DEFAULT 'fas fa-stethoscope',
  `image` VARCHAR(255),
  `is_active` TINYINT(1) DEFAULT 1,
  `order_num` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `services` (`name`, `slug`, `category`, `description`, `schedule_info`, `location`, `officer`, `icon`, `order_num`) VALUES
('Pelayanan Pemeriksaan Umum', 'pelayanan-umum', 'Rawat Jalan', 'Melayani pemeriksaan klinis awal, diagnosa, dan penanganan penyakit umum oleh dokter umum dan perawat berpengalaman dengan standar medis terpadu.', 'Senin - Sabtu (08.00 - 13.30 WIB)', 'Lantai 1 - Ruang Poli Umum', 'Dokter Umum & Tim Perawat', 'fas fa-stethoscope', 1),
('Pelayanan Kesehatan Gigi & Mulut', 'pelayanan-gigi', 'Rawat Jalan', 'Pemeriksaan kesehatan gigi, penambalan, pencabutan gigi sulung dan tetap, pembersihan karang gigi (scaling), serta edukasi kesehatan mulut.', 'Senin - Kamis (08.00 - 13.00 WIB)', 'Lantai 1 - Poli Gigi', 'Dokter Gigi & Perawat Gigi', 'fas fa-tooth', 2),
('Kesehatan Ibu dan Anak (KIA)', 'pelayanan-kia', 'Kesehatan Ibu & Anak', 'Pemeriksaan kehamilan (ANC terpadu), USG dasar oleh dokter terlatih, pemeriksaan nifas, deteksi dini risiko tinggi kehamilan, dan kesehatan bayi.', 'Senin - Sabtu (08.00 - 13.30 WIB)', 'Ruang KIA / Kebidanan', 'Bidan Koordinator & Bidan Desa', 'fas fa-female', 3),
('Pelayanan Keluarga Berencana (KB)', 'pelayanan-kb', 'Kesehatan Ibu & Anak', 'Konseling dan pelayanan kontrasepsi lengkap seperti Suntik KB, Pil KB, Implan, IUD (Spiral), dan rujukan MOW/MOP.', 'Selasa & Kamis (08.30 - 13.00 WIB)', 'Ruang KB / KIA', 'Bidan Terlatih KB', 'fas fa-heart', 4),
('Pelayanan Imunisasi', 'pelayanan-imunisasi', 'Pencegahan Penyakit', 'Pemberian vaksin dasar lengkap bagi bayi dan balita (BCG, Polio, DPT-HB-Hib, Campak/MR, PCV, Rotavirus) dan calon pengantin.', 'Rabu & Jumat (08.30 - 12.00 WIB)', 'Ruang Imunisasi', 'Petugas Imunisasi / Bidan', 'fas fa-syringe', 5),
('Pelayanan Laboratorium', 'pelayanan-laboratorium', 'Penunjang Medis', 'Pemeriksaan hematologi lengkap, kimia darah (gula darah, kolesterol, asam urat), golongan darah, tes kehamilan, malaria, BTA TB, HIV, dan tes urine.', 'Senin - Sabtu (08.00 - 13.00 WIB)', 'Instalasi Laboratorium', 'Ahli Teknologi Laboratorium Medis (ATLM)', 'fas fa-vial', 6),
('Pelayanan Konsultasi Gizi', 'pelayanan-gizi', 'Konseling & Pencegahan', 'Konseling gizi klinis untuk pasien hipertensi, diabetes, anemia bumil, penanganan balita gizi kurang serta pencegahan stunting terintegrasi.', 'Senin - Kamis (08.30 - 13.00 WIB)', 'Poli Konseling Gizi', 'Nutrisionis Puskesmas', 'fas fa-apple-alt', 7),
('Promosi Kesehatan (Promkes)', 'promosi-kesehatan', 'Upaya Kesehatan Masyarakat', 'Penyuluhan kesehatan di dalam dan luar gedung, pembinaan Posyandu, edukasi PHBS bagi sekolah dan pengelola wisata pantai Carita.', 'Senin - Jumat (Fleksibel & Lapangan)', 'Ruang Promkes & Wilayah Desa', 'Tenaga Promosi Kesehatan', 'fas fa-bullhorn', 8),
('Pelayanan MTBS / Kesehatan Anak', 'kesehatan-anak-mtbs', 'Rawat Jalan', 'Manajemen Terpadu Balita Sakit (MTBS) dan skrining tumbuh kembang anak (SDIDTK) untuk memastikan tumbuh kembang optimal anak.', 'Senin - Sabtu (08.00 - 13.30 WIB)', 'Poli Anak & MTBS', 'Dokter & Bidan Anak', 'fas fa-baby', 9),
('Kesehatan Remaja & PKPR', 'kesehatan-remaja-pkpr', 'Konseling & Pencegahan', 'Pelayanan Kesehatan Peduli Remaja mencakup konseling anemia, kesehatan reproduksi, bimbingan gizi remaja, dan edukasi bahaya napza.', 'Rabu & Sabtu (09.00 - 13.00 WIB)', 'Ruang Konseling PKPR', 'Tim Pembina PKPR Remaja', 'fas fa-users', 10),
('Pelayanan PTM (Penyakit Tidak Menular)', 'pelayanan-ptm', 'Pencegahan Penyakit', 'Skrining faktor risiko, pengelolaan hipertensi, diabetes melitus, penyakit jantung, serta program rujukan balik (PRB) BPJS Kesehatan.', 'Senin, Rabu, Jumat (08.00 - 13.00 WIB)', 'Klinik Terpadu PTM', 'Dokter Penanggung Jawab PTM', 'fas fa-heartbeat', 11),
('Pelayanan Lansia (Geriatri Santun)', 'pelayanan-lansia', 'Rawat Jalan', 'Layanan ramah usia lanjut dengan jalur prioritas (antrean ramah lansia), pemeriksaan kesehatan menyeluruh, dan senam kebugaran lansia.', 'Selasa & Kamis (08.00 - 12.30 WIB)', 'Loket Prioritas & Poli Lansia', 'Dokter & Perawat Geriatri', 'fas fa-blind', 12),
('Klinik TB / DOTS', 'pelayanan-tb-dots', 'Pencegahan Penyakit', 'Pelayanan deteksi dini dahak BTA / TCM, pengobatan tuberkulosis dengan pendampingan minum obat (PMO), dan investigasi kontak erat serumah.', 'Senin - Jumat (08.30 - 12.30 WIB)', 'Gedung TB Paru Terpisah', 'Petugas TB & Perawat Terlatih', 'fas fa-lungs', 13),
('Konseling Kesehatan Lingkungan', 'kesehatan-lingkungan', 'Konseling & Pencegahan', 'Konseling sanitasi dasar (jamban sehat, air bersih, pengelolaan sampah, inspeksi hygiene sanitasi tempat pengolahan pangan dan hotel/homestay wisata).', 'Senin - Kamis (08.30 - 12.30 WIB)', 'Ruang Sanitarian', 'Sanitarian Puskesmas', 'fas fa-recycle', 14),
('Pelayanan Farmasi & Obat', 'pelayanan-farmasi', 'Penunjang Medis', 'Pengelolaan perbekalan obat, peracikan resep obat rawat jalan, konseling penggunaan obat (PIO), dan pemantauan kepatuhan minum obat.', 'Senin - Sabtu (08.00 - 14.00 WIB)', 'Instalasi Farmasi', 'Apoteker & Tenaga Teknis Kefarmasian', 'fas fa-pills', 15),
('Pelayanan Persalinan 24 Jam (PONED)', 'pelayanan-poned', 'Gawat Darurat & Rawat Inap', 'Pertolongan persalinan normal dan penanganan awal kegawatdaruratan obstetri neonatal oleh tim bidan dan dokter jaga selama 24 jam.', '24 Jam Setiap Hari', 'Ruang Bersalin PONED', 'Bidan Jaga 24 Jam & Dokter Siaga', 'fas fa-hospital-user', 16),
('Unit Gawat Darurat (UGD 24 Jam)', 'pelayanan-ugd-24-jam', 'Gawat Darurat & Rawat Inap', 'Layanan pertolongan pertama pada kasus kecelakaan lalu lintas, cedera wisata pantai, syok, trauma medis akut, dan observasi gawat darurat.', '24 Jam Nonstop', 'Gedung UGD Depan', 'Dokter Jaga & Tim Perawat Gawat Darurat', 'fas fa-ambulance', 17),
('Pelayanan Ambulans Siaga & Rujukan', 'ambulans-rujukan', 'Penunjang Medis', 'Armada ambulans siaga 24 jam dilengkapi peralatan medis darurat untuk rujukan pasien ke RSUD Berkah Pandeglang atau RS rujukan lain.', '24 Jam Siaga Call Center', 'Parkir Ambulans UGD', 'Driver Khusus & Paramedis Pendamping', 'fas fa-shuttle-van', 18);

-- 5. SERVICE SCHEDULES TABLE
CREATE TABLE `service_schedules` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `service_id` INT DEFAULT NULL,
  `service_name` VARCHAR(100) NOT NULL,
  `day` VARCHAR(50) NOT NULL,
  `open_time` VARCHAR(20) NOT NULL,
  `close_time` VARCHAR(20) NOT NULL,
  `room_unit` VARCHAR(100) NOT NULL,
  `notes` VARCHAR(255) DEFAULT 'Bawa KTP/KK dan Kartu BPJS jika ada',
  `is_active` TINYINT(1) DEFAULT 1,
  FOREIGN KEY (`service_id`) REFERENCES `services`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `service_schedules` (`service_id`, `service_name`, `day`, `open_time`, `close_time`, `room_unit`, `notes`) VALUES
(1, 'Pemeriksaan Umum', 'Senin - Kamis', '08.00', '13.30', 'Poli Umum', 'Pendaftaran buka mulai 07.45 WIB'),
(1, 'Pemeriksaan Umum', 'Jumat', '08.00', '11.00', 'Poli Umum', 'Istirahat sholat Jumat'),
(1, 'Pemeriksaan Umum', 'Sabtu', '08.00', '12.30', 'Poli Umum', 'Pelayanan rawat jalan akhir pekan'),
(2, 'Pemeriksaan Gigi & Mulut', 'Senin - Kamis', '08.00', '13.00', 'Poli Gigi', 'Maksimal 20 nomor antrean per hari untuk tindakan'),
(3, 'Kesehatan Ibu & Anak (KIA)', 'Senin - Sabtu', '08.00', '13.00', 'Ruang KIA', 'Pemeriksaan USG dasar terjadwal setiap Rabu'),
(4, 'Pelayanan KB (Suntik, Pil, Implan, IUD)', 'Selasa & Kamis', '08.30', '12.30', 'Ruang KIA/KB', 'Konseling reproduksi & pemasangan alat kontrasepsi'),
(5, 'Imunisasi Bayi & Balita', 'Rabu', '08.30', '11.30', 'Poli Imunisasi', 'Membawa buku KIA/KMS balita'),
(6, 'Pemeriksaan Laboratorium', 'Senin - Sabtu', '08.00', '13.00', 'Instalasi Lab', 'Pemeriksaan darah puasa datang sebelum jam 09.00'),
(7, 'Konsultasi Gizi & Stunting', 'Senin & Kamis', '08.30', '12.30', 'Poli Gizi', 'Konseling khusus balita resiko stunting dan bumil KEK'),
(10, 'Kesehatan Remaja (PKPR)', 'Rabu & Sabtu', '09.00', '12.30', 'Ruang PKPR', 'Konseling privat dan pemeriksaan Hb remaja putri'),
(11, 'Klinik Penyakit Tidak Menular (PTM)', 'Senin & Rabu', '08.00', '12.30', 'Poli PTM', 'Skrining tensi, gula darah, dan edukasi pola hidup'),
(12, 'Pelayanan Lansia Santun', 'Selasa & Kamis', '08.00', '12.30', 'Poli Lansia', 'Jalur prioritas tanpa perlu antre tangga'),
(13, 'Klinik TB / Paru (DOTS)', 'Senin - Jumat', '08.30', '12.00', 'Poli TB DOTS', 'Pengambilan obat OAT & pemeriksaan dahak berkala'),
(14, 'Konseling Sanitasi Lingkungan', 'Senin - Kamis', '09.00', '12.00', 'Klinik Sanitarian', 'Konsultasi kualitas air dan higienitas sanitasi'),
(15, 'Pelayanan Farmasi & Obat', 'Senin - Sabtu', '08.00', '14.00', 'Loket Obat', 'Menyerahkan resep dari dokter pemeriksa Puskesmas'),
(16, 'Persalinan 24 Jam (PONED)', 'Setiap Hari (Senin - Minggu)', '00.00', '24.00', 'Ruang Bersalin PONED', 'Pelayanan 24 Jam Bidan & Dokter Jaga Siaga'),
(17, 'Unit Gawat Darurat (UGD)', 'Setiap Hari (Senin - Minggu)', '00.00', '24.00', 'Ruang UGD', 'Layanan darurat medis 24 Jam Nonstop');

-- 6. PROGRAMS TABLE
CREATE TABLE `programs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(180) NOT NULL UNIQUE,
  `category` VARCHAR(50) NOT NULL,
  `short_desc` TEXT,
  `content` LONGTEXT,
  `target_group` VARCHAR(150),
  `pic_officer` VARCHAR(100),
  `image` VARCHAR(255),
  `is_featured` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `programs` (`title`, `slug`, `category`, `short_desc`, `content`, `target_group`, `pic_officer`, `is_featured`) VALUES
('Integrasi Layanan Primer (ILP)', 'integrasi-layanan-primer-ilp', 'Transformasi Layanan', 'Penerapan siklus hidup terintegrasi dari ibu hamil, bayi balita, anak remaja, usia produktif hingga lansia dengan penguatan Pustu dan Posyandu.', 'Program Transformasi Pelayanan Kesehatan Primer di Puskesmas Carita diselenggarakan berdasarkan klaster siklus hidup: Klaster 1 (Manajemen), Klaster 2 (Ibu dan Anak), Klaster 3 (Usia Dewasa dan Lansia), serta Klaster 4 (Penanggulangan Penyakit Menular dan Kesling). Integrasi ini memastikan tidak ada masyarakat di pelosok desa Carita yang luput dari pemantauan kesehatan berkala.', 'Seluruh Warga Kecamatan Carita', 'Tim ILP Puskesmas Carita', 1),
('Gerakan Cegah Stunting (GENTING)', 'gerakan-cegah-stunting-genting', 'Kesehatan Ibu & Anak', 'Aksi terpadu pemantauan berat dan tinggi badan balita, pemberian makanan tambahan (PMT) lokal bernutrisi tinggi, dan edukasi gizi bagi ibu hamil.', 'Melalui program Gerakan Cegah Stunting, UPT Puskesmas Carita secara intensif melakukan pendampingan kepada keluarga yang memiliki balita berisiko stunting di seluruh desa di Kecamatan Carita. Bekerja sama dengan kader posyandu desa, kami membagikan asupan gizi seimbang berbahan pangan lokal ikan laut Carita yang kaya omega-3 dan protein berkualitas tinggi.', 'Ibu Hamil, Baduta, & Balita', 'Koordinator Program Gizi', 1),
('Promosi Kesehatan & Desa Ber-PHBS', 'promosi-kesehatan-dan-phbs', 'Promkes', 'Pemberdayaan masyarakat dalam mewujudkan Perilaku Hidup Bersih dan Sehat (PHBS) di tatanan rumah tangga, sekolah, tempat ibadah, dan kawasan wisata.', 'Kegiatan mencakup senam sehat mingguan bersama masyarakat Carita, penyuluhan bebas jentik nyamuk DBD, edukasi cuci tangan pakai sabun (CTPS), kawasan tanpa rokok (KTR), dan sertifikasi sanitasi higienis bagi warung wisata pesisir pantai Carita.', 'Masyarakat Desa & Pelaku Usaha Wisata', 'PJ Promosi Kesehatan', 1),
('Program P2P & Eliminasi Tuberkulosis (TBC)', 'eliminasi-tuberkulosis-tbc', 'Pencegahan & Pengendalian Penyakit', 'Skrining aktif penemuan kasus TBC melalui investigasi kontak serumah dan pendampingan minum obat hingga tuntas sembuh.', 'Puskesmas Carita menyediakan akses tes cepat molekuler (TCM) dan pendampingan konselor obat. Setiap pasien TB mendapatkan pemantauan ketat agar patuh mengonsumsi obat selama 6 bulan penuh hingga dinyatakan sembuh total tanpa putus obat.', 'Masyarakat Umum & Kontak Erat TB', 'Pemegang Program TB', 1),
('Kesehatan Usia Lanjut & Posyandu Lansia', 'kesehatan-lansia-dan-santun', 'Pelayanan Lansia', 'Pendampingan kesehatan berkala untuk para lansia di tiap posyandu desa meliputi cek tekanan darah, gula darah, senam lansia, dan konseling gizi.', 'Menghadirkan pelayanan kesehatan yang ramah dan penuh kasih sayang bagi kaum lansia agar tetap bugar, produktif, mandiri, dan bahagia di usia senja melalui jejaring Posyandu Lansia terpadu di 10 desa.', 'Masyarakat Usia 60 Tahun ke Atas', 'PJ Kesehatan Lansia', 0),
('Program Usaha Kesehatan Sekolah (UKS) & Remaja (PKPR)', 'program-uks-dan-remaja-pkpr', 'Kesehatan Anak & Remaja', 'Pemeriksaan berkala kesehatan siswa, penjaringan kesehatan gigi, pembagian tablet tambah darah (TTD) pencegah anemia bagi siswi SMP & SMA.', 'Pembinaan sekolah sehat dari tingkat SD, SMP, hingga SMA di kawasan Carita demi mencetak generasi muda yang cerdas, sehat fisik jasmani, dan bebas anemia serta edukasi bahaya pergaulan berisiko.', 'Pelajar SD, SMP, SMA di Kec. Carita', 'Koordinator UKS & Bidan PKPR', 0);

-- 7. INNOVATIONS TABLE
CREATE TABLE `innovations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(180) NOT NULL UNIQUE,
  `tagline` VARCHAR(255),
  `short_desc` TEXT,
  `objectives` TEXT,
  `benefits` TEXT,
  `documentation` TEXT,
  `image` VARCHAR(255) DEFAULT 'assets/img/inovasi-kajedak.jpg',
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `innovations` (`name`, `slug`, `tagline`, `short_desc`, `objectives`, `benefits`, `documentation`, `image`, `is_active`) VALUES
('KAJEDAK (Kampung Jaga Edukasi dan Deteksi Aksi Kesehatan)', 'inovasi-kajedak-carita', 'Inovasi Jemput Bola Pelayanan Kesehatan Terpadu Masyarakat Pesisir & Desa Carita', 'KAJEDAK merupakan inovasi unggulan UPT Puskesmas Carita yang mengintegrasikan layanan skrining penyakit tidak menular, pemeriksaan ibu hamil, balita, dan edukasi sanitasi langsung ke kantong-kantong pemukiman masyarakat nelayan dan pelaku wisata pantai.', '1. Memperluas jangkauan deteksi dini penyakit degeneratif dan stunting bagi warga yang tinggal jauh dari fasilitas utama.\n2. Mengedukasi masyarakat pesisir Carita tentang gaya hidup sehat berkesinambungan.\n3. Memberikan kemudahan akses konsultasi kesehatan gratis tanpa harus mengeluarkan ongkos transportasi ke Puskesmas.\n4. Mendukung citra Carita sebagai destinasi wisata bahari yang aman, sehat, dan nyaman bagi wisatawan.', 'Bagi Masyarakat: Mendapatkan skrining kesehatan gratis dan konsultasi medis rutin di balai desa terdekat.\nBagi Puskesmas: Meningkatkan capaian standar pelayanan minimal (SPM) dan mempercepat penanganan kasus medis sejak fase awal.\nBagi Wilayah Wisata: Mewujudkan kawasan Carita yang higienis, bersih, dan bebas wabah penyakit menular.', 'Dilaksanakan secara berkala setiap bulan berpindah antar desa di Kecamatan Carita dengan melibatkan tim dokter, bidan desa, perawat, analis lab, dan kader kesehatan setempat.', 'assets/img/inovasi-kajedak.jpg', 1),
('SI-PINTAR BUMIL (Sistem Pantau Intensif Ibu Hamil Risiko Tinggi)', 'si-pintar-bumil-carita', 'Pendampingan Digital & Sambang Desa Bidan untuk Keselamatan Ibu dan Anak', 'Inovasi pelacakan dan pendampingan khusus bagi ibu hamil berisiko tinggi (anemia, hipertensi kehamilan, riwayat komplikasi) melalui koordinasi intensif Bidan Desa dan kader terpadu.', 'Menurunkan angka kematian ibu (AKI) dan angka kematian bayi (AKB) di wilayah kerja Puskesmas Carita hingga 0 kasus.', 'Pemantauan tanda bahaya kehamilan secara real-time dan respon rujukan PONED siaga yang lebih cepat.', 'Tercatat lebih dari 120 ibu hamil terpantau aktif dan mendapatkan intervensi nutrisi serta kontrol USG berkala.', 'assets/img/inovasi-kajedak.jpg', 1),
('WISATA SEHAT CARITA (Mitra Higiene Sanitasi Sentra Kuliner Pesisir)', 'wisata-sehat-carita', 'Pemberdayaan Higiene Pangan & Keselamatan Wisata Bahari', 'Program pendampingan sanitarian puskesmas kepada para pedagang kuliner pantai, homestay, dan pengelola wahana wisata air mengenai standar higiene sanitasi pangan dan pertolongan pertama kecelakaan air.', 'Menjamin kesehatan wisatawan dan kebersihan sentra kuliner pantai agar bebas kontaminasi bakteri.', 'Sertifikasi laik higiene bagi warung kuliner pesisir dan tersedianya titik pertolongan pertama di pantai utama Carita.', 'Pelatihan rutin sanitasi makanan dan simulasi P3K gawat darurat air bersama tim SAR dan penjaga pantai Carita.', 'assets/img/hero-puskesmas.jpg', 1);

-- 8. NEWS TABLE
CREATE TABLE `news` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `category` ENUM('Berita', 'Kegiatan', 'Pengumuman', 'Program', 'Pelayanan') DEFAULT 'Berita',
  `content` LONGTEXT NOT NULL,
  `excerpt` TEXT,
  `author` VARCHAR(100) DEFAULT 'Humas Puskesmas Carita',
  `thumbnail` VARCHAR(255) DEFAULT 'assets/img/hero-puskesmas.jpg',
  `views` INT DEFAULT 0,
  `status` ENUM('published', 'draft') DEFAULT 'published',
  `published_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `news` (`title`, `slug`, `category`, `content`, `excerpt`, `author`, `thumbnail`, `views`, `published_at`) VALUES
('Pelaksanaan Inovasi KAJEDAK di Desa Sukarame Tingkatkan Skrining Kesehatan Nelayan', 'pelaksanaan-inovasi-kajedak-sukarame', 'Kegiatan', 'Tim Tenaga Kesehatan UPT Puskesmas Carita kembali menggelar program inovasi KAJEDAK (Kampung Jaga Edukasi dan Deteksi Aksi Kesehatan) yang bertempat di Balai Desa Sukarame, Kecamatan Carita.\n\nKegiatan ini dihadiri puluhan warga, mayoritas nelayan dan pedagang pantai yang mendapatkan layanan pemeriksaan tekanan darah, cek kadar gula darah, kolesterol, asam urat, serta konsultasi langsung dengan dokter. Kepala UPT Puskesmas Carita, Mahmudi, S.Kep., Ners, menyampaikan apresiasi atas antusiasme warga yang sadar pentingnya deteksi dini kesehatan sejak dini.', 'Kegiatan inovasi KAJEDAK menyasar puluhan masyarakat nelayan dan pelaku wisata di Desa Sukarame untuk skrining kesehatan terpadu.', 'Tim Humas Carita', 'assets/img/inovasi-kajedak.jpg', 245, '2026-09-28 09:30:00'),
('UPT Puskesmas Carita Tingkatkan Kesiapsiagaan Pos Kesehatan Wisata Jelang Libur Akhir Pekan', 'kesiapsiagaan-pos-kesehatan-wisata-carita', 'Pelayanan', 'Mengingat tingginya kunjungan wisatawan ke pantai Carita, UPT Puskesmas Carita menyiagakan pos layanan kesehatan gawat darurat dan ambulans siaga 24 jam. Kesiapan ini bertujuan memberikan rasa aman bagi para wisatawan dan warga lokal terhadap potensi gangguan kesehatan dan insiden darurat di kawasan wisata bahari.', 'Puskesmas Carita memastikan tim medis dan ambulans siaga 24 jam siap melayani lonjakan pengunjung di kawasan wisata Carita.', 'Redaksi Puskesmas', 'assets/img/hero-puskesmas.jpg', 188, '2026-09-20 14:00:00'),
('Sosialisasi Integrasi Layanan Primer (ILP) Bersama Kader Posyandu Se-Kecamatan Carita', 'sosialisasi-integrasi-layanan-primer-kader-carita', 'Program', 'Bertempat di Aula UPT Puskesmas Carita, diselenggarakan sosialisasi transformasi Integrasi Layanan Primer (ILP). Seluruh perwakilan kader posyandu dari 10 desa di Kecamatan Carita hadir mendengarkan arahan teknis penataan klaster layanan kesehatan dari siklus balita hingga lanjut usia.', 'Penyelarasan pemahaman kader posyandu se-Kecamatan Carita dalam mendukung implementasi Integrasi Layanan Primer (ILP).', 'Humas Carita', 'assets/img/hero-puskesmas.jpg', 132, '2026-09-12 10:15:00'),
('Pemberian Makanan Tambahan (PMT) Berbasis Pangan Lokal Sukseskan Penurunan Stunting di Carita', 'pmt-pangan-lokal-turunkan-stunting-carita', 'Berita', 'Puskesmas Carita bersama Dinas Kesehatan Kabupaten Pandeglang terus menggencarkan pemberian makanan tambahan (PMT) bergizi berbahan dasar ikan segar dan sayur mayur lokal untuk balita berat badan kurang (underweight) dan ibu hamil risiko tinggi. Program ini terbukti nyata membantu menaikkan kurva berat badan anak secara konsisten.', 'Pemanfaatan kekayaan laut Carita sebagai olahan PMT bergizi tinggi bagi pencegahan dan pemulihan stunting.', 'Bidang Gizi', 'assets/img/inovasi-kajedak.jpg', 310, '2026-08-30 11:00:00');

-- 9. ARTICLES TABLE (Edukasi Kesehatan)
CREATE TABLE `articles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `topic` VARCHAR(100) NOT NULL,
  `content` LONGTEXT NOT NULL,
  `excerpt` TEXT,
  `author` VARCHAR(100) DEFAULT 'Tim Promkes Puskesmas Carita',
  `thumbnail` VARCHAR(255) DEFAULT 'assets/img/hero-puskesmas.jpg',
  `views` INT DEFAULT 0,
  `status` ENUM('published', 'draft') DEFAULT 'published',
  `published_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `articles` (`title`, `slug`, `topic`, `content`, `excerpt`, `author`, `thumbnail`, `views`, `published_at`) VALUES
('Pentingnya Skrining Cek Kesehatan Berkala Gratis di Puskesmas Carita', 'pentingnya-skrining-cek-kesehatan-berkala', 'Cek Kesehatan Gratis', 'Banyak orang merasa tubuhnya sehat tanpa keluhan, padahal penyakit tidak menular (PTM) seperti hipertensi, diabetes melitus, dan kolesterol tinggi seringkali tidak menunjukkan gejala awal (silent killer). UPT Puskesmas Carita membuka layanan skrining berkala gratis bagi seluruh warga pemegang KTP/BPJS. Melalui pengecekan teratur minimal 6 bulan sekali, kita dapat mencegah komplikasi fatal sedini mungkin.', 'Kenali kondisi tubuh Anda sejak dini dengan memanfaatkan skrining kesehatan gratis dan terpadu di Puskesmas Carita.', 'dr. Poli Umum', 'assets/img/hero-puskesmas.jpg', 420, '2026-09-25 08:00:00'),
('Mengenal Gejala TBC dan Cara Tuntas Pengobatannya di Fasilitas Kesehatan', 'mengenal-gejala-tbc-dan-pengobatan-tuntas', 'TBC', 'Tuberkulosis (TBC) adalah penyakit menular yang disebabkan oleh kuman Mycobacterium tuberculosis. Gejala utamanya adalah batuk berdahak terus menerus selama lebih dari 2 minggu, demam sumeng, berkeringat di malam hari tanpa aktivitas, nafsu makan turun, dan penurunan berat badan secara drastis.\n\nJangan khawatir, TBC BISA DISEMBUHKAN sampai tuntas! UPT Puskesmas Carita menyediakan pemeriksaan TCM gratis dan paket obat anti-tuberkulosis (OAT) secara cuma-cuma didampingi oleh petugas.', 'Ketahui tanda-tanda batuk TBC dan pentingnya meminum obat secara teratur selama 6 bulan tanpa putus.', 'Pemegang Program TB', 'assets/img/hero-puskesmas.jpg', 385, '2026-09-18 09:00:00'),
('Waspada Demam Berdarah Dengue (DBD) di Musim Pancaroba: Terapkan 3M Plus', 'waspada-dbd-musim-pancaroba-terapkan-3m-plus', 'DBD', 'Penyakit DBD ditularkan melalui gigitan nyamuk Aedes aegypti yang berkembang biak pada genangan air bersih di sekitar rumah. Langkah terbaik bukanlah pengasapan (fogging) semata, melainkan pemberantasan sarang nyamuk (PSN) dengan gerakan 3M Plus: Menguras tempat penampungan air, Menutup rapat wadah air, Memanfaatkan/mendaur ulang barang bekas, plus memelihara ikan pemakan jentik dan memakai kelambu.', 'Cegah gigitan nyamuk Aedes aegypti dengan konsisten menjalankan gerakan 3M Plus di lingkungan pemukiman Anda.', 'Sanitarian Carita', 'assets/img/inovasi-kajedak.jpg', 290, '2026-09-10 10:00:00'),
('Kendalikan Hipertensi dengan Pola Hidup CERDIK', 'kendalikan-hipertensi-dengan-pola-hidup-cerdik', 'Hipertensi', 'Hipertensi dijuluki the silent killer karena dapat memicu stroke, serangan jantung, dan gagal ginjal tanpa disadari. Puskesmas Carita mengajak masyarakat menerapkan rumus CERDIK: Cek kesehatan berkala, Enyahkan asap rokok, Rajin berolahraga, Diet sehat dan seimbang (kurangi garam berlebih), Istirahat cukup, dan Kelola stres dengan baik.', 'Tips praktis mengontrol tekanan darah agar tetap stabil dan terhindar dari komplikasi kardiovaskular.', 'Dokter Puskesmas', 'assets/img/hero-puskesmas.jpg', 270, '2026-08-25 10:30:00'),
('1000 Hari Pertama Kehidupan: Kunci Emas Mencegah Stunting Pada Anak', '1000-hari-pertama-kehidupan-cegah-stunting', 'Stunting', 'Periode 1000 Hari Pertama Kehidupan (HPK) yang dimulai sejak saat terjadinya pembuahan di dalam kandungan hingga anak berusia 2 tahun merupakan masa emas pertumbuhan otak dan fisik anak. Pastikan ibu hamil mengonsumsi makanan bergizi lengkap, meminum tablet tambah darah, memberikan ASI eksklusif 6 bulan, dan meneruskan MP-ASI bergizi seimbang.', 'Panduan penting bagi para orang tua untuk memastikan nutrisi optimal selama masa kehamilan hingga balita 2 tahun.', 'Nutrisionis Carita', 'assets/img/inovasi-kajedak.jpg', 510, '2026-08-15 08:45:00');

-- 10. GALLERIES TABLE
CREATE TABLE `galleries` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(150) NOT NULL,
  `category` ENUM('Kegiatan Posyandu', 'Kegiatan Masyarakat', 'Internal Puskesmas', 'Pelayanan Medis') DEFAULT 'Kegiatan Posyandu',
  `media_type` ENUM('photo', 'video') DEFAULT 'photo',
  `file_path` VARCHAR(255) NOT NULL,
  `caption` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `galleries` (`title`, `category`, `media_type`, `file_path`, `caption`) VALUES
('Pelayanan Inovasi KAJEDAK di Wilayah Pesisir', 'Kegiatan Masyarakat', 'photo', 'assets/img/inovasi-kajedak.jpg', 'Pemeriksaan kesehatan gratis dan skrining tensi darah bagi warga nelayan Carita.'),
('Gedung dan Fasilitas Utama UPT Puskesmas Carita', 'Internal Puskesmas', 'photo', 'assets/img/hero-puskesmas.jpg', 'Tampak depan gedung utama dan armada ambulans siaga UPT Puskesmas Carita.'),
('Arahan dan Koordinasi Kepala UPT Puskesmas Carita', 'Internal Puskesmas', 'photo', 'assets/img/kepala-puskesmas.jpg', 'Mahmudi, S.Kep., Ners memimpin koordinasi peningkatan mutu layanan rawat jalan.'),
('Pelayanan Imunisasi Balita Posyandu Melati', 'Kegiatan Posyandu', 'photo', 'assets/img/inovasi-kajedak.jpg', 'Pemberian vaksin dasar lengkap bagi balita di wilayah Desa Carita.'),
('Pemeriksaan Kehamilan dan Konseling Gizi Ibu Hamil', 'Pelayanan Medis', 'photo', 'assets/img/hero-puskesmas.jpg', 'Bidan Puskesmas melakukan pemeriksaan antenatal care (ANC) terpadu.');

-- 11. VIDEOS TABLE
CREATE TABLE `videos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(150) NOT NULL,
  `youtube_id` VARCHAR(50) NOT NULL,
  `youtube_url` VARCHAR(255) NOT NULL,
  `category` VARCHAR(50) DEFAULT 'Profil Puskesmas',
  `description` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `videos` (`title`, `youtube_id`, `youtube_url`, `category`, `description`) VALUES
('Video Profil UPT Puskesmas Carita - Carita Wisata Sehat', 'dQw4w9WgXcQ', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'Profil Puskesmas', 'Mengenal lebih dekat fasilitas, sarana prasarana, tenaga medis, dan layanan unggulan UPT Puskesmas Carita Kabupaten Pandeglang.'),
('Sosialisasi Inovasi KAJEDAK Menuju Masyarakat Sehat', 'dQw4w9WgXcQ', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'Inovasi', 'Dokumentasi kegiatan jemput bola skrining kesehatan di sentra pemukiman nelayan dan desa wisata Carita.'),
('Edukasi Gerakan Hidup Sehat & Pencegahan Stunting', 'dQw4w9WgXcQ', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'Edukasi Kesehatan', 'Tips pemenuhan gizi seimbang dengan pangan lokal bagi ibu hamil dan anak balita.');

-- 12. PUBLIC DOCUMENTS TABLE
CREATE TABLE `public_documents` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `category` ENUM('Maklumat Pelayanan', 'Standar Pelayanan', 'SOP', 'Survei Kepuasan Masyarakat', 'Kinerja', 'Program', 'Pengumuman') NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `file_size` VARCHAR(50) DEFAULT '1.2 MB',
  `download_count` INT DEFAULT 0,
  `description` TEXT,
  `published_at` DATE DEFAULT (CURRENT_DATE)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `public_documents` (`title`, `category`, `file_path`, `file_size`, `download_count`, `description`) VALUES
('Maklumat Pelayanan UPT Puskesmas Carita Tahun 2026', 'Maklumat Pelayanan', 'assets/uploads/maklumat-pelayanan-carita.pdf', '850 KB', 145, 'Komitmen resmi seluruh pegawai UPT Puskesmas Carita dalam menyelenggarakan pelayanan prima sesuai standar.'),
('Standar Pelayanan Publik Rawat Jalan & PONED UPT Puskesmas Carita', 'Standar Pelayanan', 'assets/uploads/standar-pelayanan-carita.pdf', '2.4 MB', 230, 'Dokumen resmi persyaratan, prosedur, waktu pelayanan, dan tarif retribusi sesuai Perda Kab. Pandeglang.'),
('Laporan Hasil Survei Kepuasan Masyarakat (SKM) Semester I 2026', 'Survei Kepuasan Masyarakat', 'assets/uploads/laporan-skm-puskesmas-carita.pdf', '1.8 MB', 98, 'Hasil pengukuran indeks kepuasan masyarakat terhadap mutu layanan kesehatan UPT Puskesmas Carita (Predikat: Sangat Baik / 88.75).'),
('Standar Operasional Prosedur (SOP) Penanganan Gawat Darurat UGD & Ambulans', 'SOP', 'assets/uploads/sop-ugd-puskesmas-carita.pdf', '3.1 MB', 112, 'Prosedur tetap alur penanganan kegawatdaruratan medis bagi warga dan wisatawan pesisir Carita.'),
('Rencana Aksi Program Penurunan Stunting Terpadu Kecamatan Carita', 'Program', 'assets/uploads/rencana-aksi-stunting-carita.pdf', '1.5 MB', 76, 'Strategi intervensi spesifik dan sensitif penanganan gagal tumbuh balita di 10 desa.');

-- 13. ANNOUNCEMENTS TABLE
CREATE TABLE `announcements` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `content` TEXT NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE DEFAULT NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `priority` ENUM('normal', 'urgent') DEFAULT 'normal',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `announcements` (`title`, `content`, `start_date`, `end_date`, `is_active`, `priority`) VALUES
('Layanan UGD dan Bersalin (PONED) 24 Jam Tetap Buka Selama Hari Libur Nasional', 'UPT Puskesmas Carita memberitahukan bahwa seluruh layanan kegawatdaruratan (UGD) dan persalinan 24 jam tetap melayani masyarakat tanpa libur. Untuk konsultasi darurat hubungi 0812-8899-7722.', '2026-09-01', '2026-12-31', 1, 'urgent'),
('Jadwal Pelaksanaan Pekan Imunisasi Tambahan (PIN) di Seluruh Posyandu Desa Carita', 'Dihimbau kepada seluruh orang tua yang memiliki anak balita usia 0-59 bulan untuk hadir di posyandu desa terdekat sesuai jadwal giliran untuk mendapatkan imunisasi tambahan gratis.', '2026-10-01', '2026-10-31', 1, 'normal');

-- 14. COMPLAINTS TABLE
CREATE TABLE `complaints` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `ticket_number` VARCHAR(30) NOT NULL UNIQUE,
  `name` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `category` ENUM('Pelayanan Medis', 'Petugas & Sikap', 'Fasilitas & Kebersihan', 'Farmasi & Obat', 'Administrasi & Pendaftaran', 'Lainnya') DEFAULT 'Pelayanan Medis',
  `message` TEXT NOT NULL,
  `attachment` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('Menunggu', 'Diproses', 'Selesai', 'Ditolak') DEFAULT 'Menunggu',
  `response` TEXT DEFAULT NULL,
  `responded_at` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `complaints` (`ticket_number`, `name`, `phone`, `email`, `category`, `message`, `status`, `response`, `responded_at`) VALUES
('PKM-2026-001', 'Bambang Supriyadi', '081388771122', 'bambang.s@gmail.com', 'Fasilitas & Kebersihan', 'Mohon penambahan kipas angin atau pendingin ruangan di ruang tunggu poli umum saat jam ramai di hari Senin pagi.', 'Selesai', 'Terima kasih atas saran Bapak Bambang. Tim sarana prasarana kami telah menambahkan unit exhaust fan dan kipas tambahan di area tunggu rawat jalan demi kenyamanan pasien.', '2026-09-24 14:20:00'),
('PKM-2026-002', 'Siti Rahmawati', '085712349988', 'sitirahma@yahoo.com', 'Administrasi & Pendaftaran', 'Apakah untuk pendaftaran pemeriksaan ibu hamil bisa booking nomor antrean lewat WhatsApp sebelum datang?', 'Selesai', 'Halo Ibu Siti, pendaftaran nomor antrean sudah dapat dilakukan secara online melalui WhatsApp Layanan Puskesmas di nomor 0812-8899-7722 dengan mengirimkan foto KTP/BPJS pada H-1 pelayanan.', '2026-09-27 10:15:00');

-- 15. PAGES TABLE
CREATE TABLE `pages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `title` VARCHAR(150) NOT NULL,
  `content` LONGTEXT NOT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pages` (`slug`, `title`, `content`) VALUES
('profil', 'Profil UPT Puskesmas Carita', '<h2>Visi & Misi UPT Puskesmas Carita</h2><p><strong>Visi:</strong> Terwujudnya Masyarakat Kecamatan Carita yang Mandiri untuk Hidup Sehat Menuju Carita Wisata Sehat yang Berkualitas dan Berdaya Saing.</p><p><strong>Misi:</strong></p><ol><li>Memberikan pelayanan kesehatan tingkat pertama yang bermutu, merata, terjangkau, dan profesional.</li><li>Meningkatkan derajat kesehatan masyarakat melalui penguatan upaya promotif dan preventif.</li><li>Mengembangkan inovasi layanan kesehatan berbasis kearifan lokal pesisir dan ramah wisatawan.</li><li>Meningkatkan tata kelola manajemen puskesmas yang transparan, akuntabel, dan berorientasi kepuasan masyarakat.</li><li>Menggalang kemitraan lintas sektor dan pemberdayaan masyarakat dalam mewujudkan kemandirian hidup sehat.</li></ol><h3>Tata Nilai Puskesmas: C-A-R-I-T-A</h3><ul><li><strong>C (Cepat):</strong> Memberikan respon pelayanan secara tanggap tanpa penundaan.</li><li><strong>A (Akuntabel):</strong> Bekerja sesuai regulasi dan standar prosedur operasional.</li><li><strong>R (Ramah):</strong> Senyum, sapa, salam, sopan, dan santun dalam setiap interaksi.</li><li><strong>I (Inovatif):</strong> Terus mengembangkan ide kreatif peningkatan pelayanan.</li><li><strong>T (Transparan):</strong> Keterbukaan informasi publik dan akuntabilitas kerja.</li><li><strong>A (Amanah):</strong> Menjaga kepercayaan masyarakat dan rahasia medis pasien.</li></ul>'),
('maklumat', 'Maklumat Pelayanan', '<div class="maklumat-box text-center p-4"><h3>MAKLUMAT PELAYANAN</h3><p class="lead">“Dengan Ini, Kami Seluruh Pimpinan dan Staf UPT Puskesmas Carita Menyatakan Sanggup Menyelenggarakan Pelayanan Kesehatan Sesuai Standar Pelayanan yang Telah Ditetapkan, dan Apabila Tidak Menepati Janji Ini, Kami Siap Menerima Sanksi Sesuai Peraturan Perundang-undangan yang Berlaku.”</p><p class="mt-4 font-weight-bold">Kepala UPT Puskesmas Carita<br><strong>Mahmudi, S.Kep., Ners</strong></p></div>'),
('wilayah-kerja', 'Wilayah Kerja Puskesmas Carita', '<p>Wilayah kerja UPT Puskesmas Carita mencakup seluruh wilayah administratif Kecamatan Carita, Kabupaten Pandeglang, Provinsi Banten dengan luas wilayah sekitar 71,97 km² yang terdiri atas 10 desa:</p><ul><li>Desa Carita (Sentra Pemerintahan & Wisata Pantai)</li><li>Desa Sukarame</li><li>Desa Banjarmasin</li><li>Desa Pejamben</li><li>Desa Kaungcaang</li><li>Desa Sukanagara</li><li>Desa Sindang Laut</li><li>Desa Tembong</li><li>Desa Matabalat</li><li>Desa Sukajadi</li></ul><p>Karakteristik wilayah meliputi daerah pesisir pantai Selat Sunda, permukiman nelayan, sentra pariwisata bahari, serta kawasan perbukitan agraris.</p>');
