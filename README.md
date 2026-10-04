# Website Resmi UPT Puskesmas Carita - Kabupaten Pandeglang
### *"Carita Wisata Sehat"*

Website resmi yang modern, profesional, responsif, berkeamanan tinggi, dan mudah dikelola untuk **UPT PUSKESMAS CARITA**, Kecamatan Carita, Kabupaten Pandeglang, Provinsi Banten.

---

## 🌟 Identitas Resmi Instansi
- **Nama Faskes:** UPT Puskesmas Carita
- **Subjudul:** Puskesmas Carita Kabupaten Pandeglang
- **Motto Pelayanan:** *“Carita Wisata Sehat”*
- **Kepala UPT Puskesmas:** Mahmudi, S.Kep., Ners
- **Alamat:** Jl. Raya Labuan - Carita KM. 9, Desa Carita, Kecamatan Carita, Kabupaten Pandeglang, Banten 42264
- **Wilayah Kerja:** 10 Desa Binaan (Desa Carita, Sukarame, Banjarmasin, Pejamben, Kaungcaang, Sindang Laut, Sukanagara, Tembong, Matabalat, Sukajadi)
- **Pelayanan Darurat:** UGD 24 Jam Nonstop & PONED (Persalinan 24 Jam)
- **Inovasi Unggulan:** **KAJEDAK** (*Kampung Jaga Edukasi dan Deteksi Aksi Kesehatan*)

---

## 🚀 Petunjuk Menjalankan di XAMPP (Localhost)

Aplikasi ini dirancang khusus kompatibel 100% dengan lingkungan server **XAMPP** (Apache, PHP, MySQL) tanpa memerlukan setup dependensi rumit.

### Langkah-langkah:
1. Buka **XAMPP Control Panel**.
2. Klik tombol **Start** pada modul **Apache** dan **MySQL**.
3. Pastikan folder proyek berada di:
   ```
   C:\xampp\htdocs\Puskesmasweb
3. **Cara Cepat Buat Database (Pilih salah satu):**

   - **Opsi 1 (Paling Praktis):** Klik ganda (double-click) file:
     ```
     C:\xampp\htdocs\Puskesmasweb\buat_db.bat
     ```
     *Script otomatis membuat database `puskesmas_carita`, mengisi 16 tabel berserta data awal, dan menyalin aset gambar.*

   - **Opsi 2 (Lewat Browser):** Buka link auto-installer:
     ```
     http://localhost/Puskesmasweb/install.php
     ```

   - **Opsi 3 (Lewat phpMyAdmin):** Buka `http://localhost/phpmyadmin/`, klik tab **Import**, pilih berkas `database.sql`, lalu klik **Import**.

4. Buka Website Utama:
   ```
   http://localhost/Puskesmasweb/
   ```

---

## 🔐 Kredensial Administrator CMS

- **Halaman Login Admin:** `http://localhost/Puskesmasweb/admin/login.php`
- **Username:** `admin`
- **Password:** `adminpuskesmas2026`

---

## 📂 Struktur Direktori & File

```
Puskesmasweb/
├── config/
│   ├── database.php          # Koneksi PDO & Auto-Database Engine
│   └── helper.php            # Security, CSRF, Date Format, File Uploads
├── database.sql              # Skema 16 Tabel MySQL & Data Seed Lengkap
├── install.php               # One-click installer & migrator
├── assets/
│   ├── css/
│   │   ├── style.css         # Desain Modern, Typography, Responsif
│   │   └── admin.css         # Desain Dashboard CMS & Dark Sidebar
│   ├── js/
│   │   └── main.js           # Live Table Filter, Lightbox, Mobile Nav
│   └── img/
│       ├── logo.svg          # Logo Vektor Resmi UPT Puskesmas Carita
│       ├── hero-puskesmas.jpg
│       ├── kepala-puskesmas.jpg
│       └── inovasi-kajedak.jpg
├── includes/
│   ├── header.php            # Topbar Hotline, Sticky Navbar, SEO Meta
│   └── footer.php            # Footer Lengkap, Floating WhatsApp & Top
├── admin/
│   ├── auth_check.php        # Guard Autentikasi Sesi Admin
│   ├── header.php            # Sidebar CMS & Profil Petugas
│   ├── footer.php
│   ├── index.php             # 8 Counter Ringkasan KPI & Quick Actions
│   ├── login.php             # Form Login Aman BCrypt
│   ├── logout.php
│   ├── berita.php            # CRUD Berita & Kegiatan
│   ├── artikel.php           # CRUD Artikel Edukasi Kesehatan
│   ├── pelayanan.php         # CRUD 18 Jenis Pelayanan
│   ├── jadwal.php            # CRUD Jadwal Pelayanan Terpadu
│   ├── program.php           # CRUD Program Kesehatan & ILP
│   ├── inovasi.php           # CRUD Inovasi (KAJEDAK)
│   ├── dokumen.php           # CRUD Dokumen Publik PDF Download
│   ├── galeri.php            # CRUD Galeri Foto & Lightbox
│   ├── video.php             # CRUD Video Multimedia YouTube
│   ├── pengumuman.php        # CRUD Pengumuman & Urgent Alert
│   ├── pengaduan.php         # Kelola & Respon Pengaduan Warga
│   ├── sambutan.php          # Edit Sambutan Kepala Puskesmas
│   └── pengaturan.php        # Edit Kontak, Motto, Peta & Ganti Sandi
├── index.php                 # Homepage 17 Seksi Lengkap
├── profil.php                # Profil, Visi-Misi, Struktur & 10 Desa
├── pelayanan.php             # Direktori Layanan Medis
├── jadwal.php                # Tabel Jadwal Interaktif & Filter Hari
├── program.php               # Program Transformasi ILP
├── inovasi.php               # Dokumentasi KAJEDAK & Inovasi
├── informasi-publik.php      # Maklumat, SOP, SKM & Unduh PDF
├── berita.php                # Portal Berita & Filter Kategori
├── berita-detail.php         # Baca Berita, Share & Rekomendasi
├── edukasi.php               # Pojok Edukasi Kesehatan
├── galeri.php                # Galeri Foto & Video
├── pengaduan.php             # Form Aduan & Cek Status Tiket Online
└── kontak.php                # Hubungi Kami & Google Maps Iframe
```

---

## ✨ Fitur & Keunggulan Utama

1. **Urutan 17 Seksi Homepage Sesuai Spesifikasi:**
   - Navbar Sticky & Topbar Darurat
   - Hero Section dengan Motto *“Carita Wisata Sehat”*
   - Quick Access (6 Tombol Pintas Interaktif)
   - Profil Singkat & Counter Statistik
   - Sambutan Kepala UPT Puskesmas Carita (Mahmudi, S.Kep., Ners)
   - Informasi Pelayanan Medis
   - Jadwal Pelayanan Terpadu
   - Program Kesehatan & Transformasi ILP
   - Inovasi Puskesmas (KAJEDAK)
   - Berita & Kegiatan Terkini
   - Edukasi Kesehatan Masyarakat
   - Video Profil Multimedia
   - Galeri Foto Dokumentasi (dengan Lightbox Popup)
   - Media Sosial Resmi
   - Pengaduan & Saran Masyarakat
   - Kontak Resmi & Google Maps
   - Footer Modern Lengkap
2. **Kanal Pengaduan & Tracking Tiket Mandiri:**
   - Warga mendapatkan nomor tiket unik (contoh: `PKM-2026-XXXX`).
   - Fitur pencarian tiket untuk melihat langsung status penanganan dan jawaban resmi dari pihak manajemen Puskesmas.
3. **Pusat Unduhan Dokumen Publik:**
   - Maklumat Pelayanan, Standar Pelayanan, SOP, dan Laporan Hasil Survei Kepuasan Masyarakat (SKM) dengan penghitung jumlah unduhan.
4. **Keamanan Berlapis:**
   - Proteksi CSRF (`verify_csrf_token`) pada seluruh formulir.
   - Proteksi SQL Injection dengan PDO Prepared Statements.
   - Proteksi XSS (`htmlspecialchars` sanitization).
   - Enkripsi kata sandi menggunakan `password_hash` (`PASSWORD_BCRYPT`).
   - Validasi ketat format berkas unggahan dan pembatasan kapasitas ukuran file.
