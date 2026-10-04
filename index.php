<?php
/**
 * UPT PUSKESMAS CARITA - KABUPATEN PANDEGLANG
 * Official Homepage (Beranda)
 * Motto: "Carita Wisata Sehat"
 */

require_once __DIR__ . '/config/helper.php';

$page_title = 'Beranda Resmi';
$page_desc = 'Selamat Datang di Portal Resmi UPT Puskesmas Carita Kabupaten Pandeglang. Melayani dengan ramah, cepat, tepat, dan profesional menuju Carita Wisata Sehat.';

$db = getDBConnection();

// Handle form submission pengaduan dari homepage
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_complaint') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!verify_csrf_token($csrf)) {
        set_flash('danger', 'Sesi keamanan tidak valid. Silakan coba kembali.');
        header('Location: ' . base_url('#pengaduan'));
        exit;
    }

    $captcha_answer = trim($_POST['captcha_answer'] ?? '');
    $captcha_expected = $_SESSION['captcha_expected'] ?? null;

    if ($captcha_answer === '' || (int)$captcha_answer !== (int)$captcha_expected) {
        set_flash('danger', 'Jawaban verifikasi keamanan (captcha) salah. Silakan coba lagi.');
        header('Location: ' . base_url('#pengaduan'));
        exit;
    }

    $name = sanitize($_POST['name'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $category = sanitize($_POST['category'] ?? 'Pelayanan Medis');
    $message = sanitize($_POST['message'] ?? '');

    if (empty($name) || empty($phone) || empty($message)) {
        set_flash('danger', 'Nama, Nomor Telepon/WhatsApp, dan Isi Pengaduan wajib diisi.');
        header('Location: ' . base_url('#pengaduan'));
        exit;
    }

    // Upload lampiran jika ada
    $attachmentPath = null;
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $upload = upload_file($_FILES['attachment'], 'uploads/complaints', ['image/jpeg', 'image/png', 'application/pdf'], 3145728);
        if ($upload['success']) {
            $attachmentPath = $upload['filepath'];
        }
    }

    $ticketNumber = 'PKM-' . date('Y') . '-' . strtoupper(substr(uniqid(), -5));

    try {
        $stmt = $db->prepare("INSERT INTO complaints (ticket_number, name, phone, email, category, message, attachment, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'Menunggu')");
        $stmt->execute([$ticketNumber, $name, $phone, $email, $category, $message, $attachmentPath]);

        set_flash('success', "Pengaduan Anda berhasil dikirim dengan Nomor Tiket: <strong>{$ticketNumber}</strong>. Simpan nomor tiket ini untuk memantau status respon petugas.");
        header('Location: ' . base_url('pengaduan.php?ticket=' . urlencode($ticketNumber)));
        exit;
    } catch (Exception $e) {
        set_flash('danger', 'Terjadi kesalahan sistem saat menyimpan pengaduan: ' . $e->getMessage());
        header('Location: ' . base_url('#pengaduan'));
        exit;
    }
}

// Generate simple math captcha
$num1 = rand(2, 8);
$num2 = rand(1, 7);
$_SESSION['captcha_expected'] = $num1 + $num2;

// Load Data from Database
$hero_headline = get_setting('hero_headline', 'Selamat Datang di UPT Puskesmas Carita');
$hero_subheadline = get_setting('hero_subheadline', 'Memberikan pelayanan kesehatan yang mudah, cepat, ramah, dan berkualitas bagi masyarakat Carita dan sekitarnya.');
$hero_img = get_setting('hero_image', 'assets/img/hero-puskesmas.jpg');
$head_name = get_setting('head_name', 'Mahmudi, S.Kep., Ners');
$head_title = get_setting('head_title', 'Kepala UPT Puskesmas Carita');
$head_speech = get_setting('head_speech', '');
$head_photo = get_setting('head_photo', 'assets/img/kepala-puskesmas.jpg');

$stats_nakes = get_setting('stats_nakes', '42');
$stats_services = get_setting('stats_services', '18');
$stats_programs = get_setting('stats_programs', '14');
$stats_villages = get_setting('stats_villages', '10');

// Query Services
$services = $db->query("SELECT * FROM services WHERE is_active = 1 ORDER BY order_num ASC LIMIT 8")->fetchAll();

// Query Schedules
$schedules = $db->query("SELECT * FROM service_schedules WHERE is_active = 1 ORDER BY id ASC")->fetchAll();

// Query Programs
$programs = $db->query("SELECT * FROM programs ORDER BY is_featured DESC, id ASC LIMIT 6")->fetchAll();

// Query Innovations (Spotlight KAJEDAK)
$kajedak = $db->query("SELECT * FROM innovations WHERE slug = 'inovasi-kajedak-carita' OR name LIKE '%KAJEDAK%' LIMIT 1")->fetch();
$other_innovations = $db->query("SELECT * FROM innovations WHERE slug != 'inovasi-kajedak-carita' AND is_active = 1 LIMIT 2")->fetchAll();

// Query Latest News
$news_list = $db->query("SELECT * FROM news WHERE status = 'published' ORDER BY published_at DESC LIMIT 3")->fetchAll();

// Query Articles Edukasi
$articles_list = $db->query("SELECT * FROM articles WHERE status = 'published' ORDER BY published_at DESC LIMIT 3")->fetchAll();

// Query Gallery
$galleries = $db->query("SELECT * FROM galleries ORDER BY id DESC LIMIT 6")->fetchAll();

// Query Videos
$video = $db->query("SELECT * FROM videos ORDER BY id ASC LIMIT 1")->fetch();

// Announcements
$urgent_announcement = $db->query("SELECT * FROM announcements WHERE is_active = 1 AND priority = 'urgent' AND (end_date IS NULL OR end_date >= CURRENT_DATE) ORDER BY id DESC LIMIT 1")->fetch();

include __DIR__ . '/includes/header.php';
?>

<!-- ==========================================================================
     URUTAN 1: NAVBAR (Loaded via includes/header.php)
     ========================================================================== -->

<!-- Pengumuman Darurat Banner (Jika ada) -->
<?php if ($urgent_announcement): ?>
  <div style="background: #ef4444; color: #ffffff; padding: 0.75rem 0; font-size: 0.9rem; font-weight: 600;">
    <div class="container" style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
      <div style="display: flex; align-items: center; gap: 0.75rem;">
        <i class="fas fa-bullhorn" style="font-size: 1.1rem; animation: pulse-red 1.5s infinite;"></i>
        <span><strong>PENGUMUMAN PENTING:</strong> <?= htmlspecialchars($urgent_announcement['title']); ?> - <?= htmlspecialchars($urgent_announcement['content']); ?></span>
      </div>
      <a href="<?= base_url('informasi-publik.php'); ?>" style="color: #ffffff; text-decoration: underline; font-size: 0.85rem;">Selengkapnya &rarr;</a>
    </div>
  </div>
<?php endif; ?>

<!-- ==========================================================================
     URUTAN 2: HERO SECTION
     ========================================================================== -->
<section class="hero-section">
  <div class="hero-bg-wrapper">
    <img src="<?= base_url($hero_img); ?>" alt="UPT Puskesmas Carita Pandeglang" class="hero-bg-img">
  </div>
  <div class="hero-overlay"></div>

  <div class="container">
    <div class="hero-content">
      <div class="hero-motto-badge">
        <i class="fas fa-heartbeat"></i> Motto: “<?= htmlspecialchars($motto); ?>”
      </div>
      <h1 class="hero-title">
        <?= htmlspecialchars($hero_headline); ?><br>
        <span>Kabupaten Pandeglang</span>
      </h1>
      <p class="hero-subtitle">
        <?= htmlspecialchars($hero_subheadline); ?>
      </p>

      <div class="hero-btns">
        <a href="#pelayanan" class="btn btn-primary">
          <i class="fas fa-stethoscope"></i> Lihat Pelayanan
        </a>
        <a href="#profil" class="btn btn-outline-white">
          <i class="fas fa-info-circle"></i> Tentang Kami
        </a>
        <a href="https://wa.me/62<?= ltrim(preg_replace('/[^0-9]/', '', $whatsapp), '0'); ?>?text=Halo%20Admin%20Puskesmas%20Carita" target="_blank" rel="noopener" class="btn btn-outline-white" style="border-color: #34d399; color: #34d399;">
          <i class="fab fa-whatsapp"></i> Chat WhatsApp
        </a>
      </div>

      <!-- Quick Floating Stats on Hero -->
      <div class="hero-stats-banner">
        <div class="hero-stat-item">
          <i class="fas fa-user-md"></i>
          <div>
            <h4><?= htmlspecialchars($stats_nakes); ?>+</h4>
            <p>Tenaga Medis</p>
          </div>
        </div>
        <div class="hero-stat-item">
          <i class="fas fa-clinic-medical"></i>
          <div>
            <h4><?= htmlspecialchars($stats_services); ?></h4>
            <p>Poli & Layanan</p>
          </div>
        </div>
        <div class="hero-stat-item">
          <i class="fas fa-map-marked-alt"></i>
          <div>
            <h4><?= htmlspecialchars($stats_villages); ?></h4>
            <p>Desa Wilayah Kerja</p>
          </div>
        </div>
        <div class="hero-stat-item">
          <i class="fas fa-clock"></i>
          <div>
            <h4 style="color: #f87171;">24 Jam</h4>
            <p>UGD & PONED Siaga</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ==========================================================================
     URUTAN 3: QUICK ACCESS (MENU AKSES CEPAT)
     ========================================================================== -->
<section class="quick-access-section">
  <div class="container">
    <div class="quick-grid">
      <!-- 1. Jadwal Pelayanan -->
      <a href="#jadwal" class="quick-card">
        <div class="quick-icon-wrap">
          <i class="fas fa-calendar-alt"></i>
        </div>
        <h3>Jadwal Pelayanan</h3>
        <p>Jadwal poli rawat jalan & jam buka</p>
      </a>

      <!-- 2. Pendaftaran Online -->
      <a href="https://wa.me/62<?= ltrim(preg_replace('/[^0-9]/', '', $whatsapp), '0'); ?>?text=Halo%20Puskesmas%20Carita%2C%20saya%20ingin%20mendaftar%20pelayanan%20kesehatan" target="_blank" rel="noopener" class="quick-card">
        <div class="quick-icon-wrap">
          <i class="fas fa-id-card"></i>
        </div>
        <h3>Pendaftaran</h3>
        <p>Booking antrean via WhatsApp</p>
      </a>

      <!-- 3. Cek Kesehatan Gratis -->
      <a href="<?= base_url('edukasi.php'); ?>" class="quick-card">
        <div class="quick-icon-wrap">
          <i class="fas fa-heartbeat"></i>
        </div>
        <h3>Cek Kesehatan</h3>
        <p>Skrining PTM & kesehatan berkala</p>
      </a>

      <!-- 4. Informasi Obat -->
      <a href="<?= base_url('pelayanan.php#pelayanan-farmasi'); ?>" class="quick-card">
        <div class="quick-icon-wrap">
          <i class="fas fa-pills"></i>
        </div>
        <h3>Informasi Obat</h3>
        <p>Layanan farmasi & resep obat</p>
      </a>

      <!-- 5. Pengaduan Masyarakat -->
      <a href="#pengaduan" class="quick-card">
        <div class="quick-icon-wrap">
          <i class="fas fa-comments"></i>
        </div>
        <h3>Pengaduan</h3>
        <p>Kanal aspirasi & masukan warga</p>
      </a>

      <!-- 6. Informasi Publik -->
      <a href="<?= base_url('informasi-publik.php'); ?>" class="quick-card">
        <div class="quick-icon-wrap">
          <i class="fas fa-file-alt"></i>
        </div>
        <h3>Informasi Publik</h3>
        <p>Maklumat, SOP & SKM Puskesmas</p>
      </a>
    </div>
  </div>
</section>

<!-- ==========================================================================
     URUTAN 4: PROFIL PUSKESMAS (TENTANG & STATISTIK)
     ========================================================================== -->
<section class="section section-alt" id="profil">
  <div class="container">
    <div class="profile-grid">
      <!-- Visual Column -->
      <div class="profile-visual">
        <img src="<?= base_url($hero_img); ?>" alt="Gedung UPT Puskesmas Carita" class="profile-img-main">
        <div class="profile-badge-float">
          <i class="fas fa-award"></i>
          <div>
            <h4 style="font-size: 1.1rem; margin-bottom: 0.1rem; color: #064e3b;">Pelayanan Terakreditasi</h4>
            <p style="font-size: 0.8rem; color: #64748b; margin-bottom: 0;">Mutu Layanan Primer Paripurna</p>
          </div>
        </div>
      </div>

      <!-- Content Column -->
      <div class="profile-content">
        <span class="badge-pill badge-mint" style="margin-bottom: 1rem;">
          <i class="fas fa-hospital-alt"></i> Profil Fasilitas Kesehatan
        </span>
        <h2>Tentang UPT Puskesmas Carita</h2>
        <p>
          <?= htmlspecialchars(get_setting('about_summary')); ?>
        </p>
        <p>
          Dengan visi mewujudkan <strong>“Carita Wisata Sehat”</strong>, kami mengedepankan pelayanan promotif dan preventif tanpa mengesampingkan pengobatan kuratif dan rehabilitatif, menjamin keselamatan pasien, serta mendukung kawasan wisata Carita yang bersih, aman, dan sehat bagi semua.
        </p>

        <!-- Dynamic Statistics -->
        <div class="stats-grid">
          <div class="stat-box">
            <div class="stat-num"><?= htmlspecialchars($stats_nakes); ?></div>
            <div class="stat-label">Tenaga Kesehatan Profesional</div>
          </div>
          <div class="stat-box">
            <div class="stat-num"><?= htmlspecialchars($stats_services); ?></div>
            <div class="stat-label">Jenis Pelayanan & Poli Medis</div>
          </div>
          <div class="stat-box">
            <div class="stat-num"><?= htmlspecialchars($stats_programs); ?></div>
            <div class="stat-label">Program Kesehatan Unggulan</div>
          </div>
          <div class="stat-box">
            <div class="stat-num"><?= htmlspecialchars($stats_villages); ?></div>
            <div class="stat-label">Desa Wilayah Kerja Binaan</div>
          </div>
        </div>

        <a href="<?= base_url('profil.php'); ?>" class="btn btn-secondary">
          <i class="fas fa-arrow-right"></i> Selengkapnya Tentang Profil
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ==========================================================================
     URUTAN 5: SAMBUTAN KEPALA PUSKESMAS
     ========================================================================== -->
<section class="section" style="background: #f1f5f9;">
  <div class="container">
    <div class="speech-card">
      <div class="speech-grid">
        <!-- Photo Column -->
        <div class="speech-photo-col">
          <img src="<?= base_url($head_photo); ?>" alt="Foto <?= htmlspecialchars($head_name); ?>" class="speech-photo">
        </div>

        <!-- Speech Text Column -->
        <div class="speech-body">
          <i class="fas fa-quote-right speech-quote-icon"></i>
          <span class="speech-badge"><i class="fas fa-user-tie"></i> Sambutan Pemimpin</span>
          <h3>Sambutan Kepala UPT Puskesmas Carita</h3>
          <div class="speech-text">
            <?= nl2br(htmlspecialchars($head_speech)); ?>
          </div>
          <div class="speech-author">
            <h4><?= htmlspecialchars($head_name); ?></h4>
            <p><?= htmlspecialchars($head_title); ?> - Kabupaten Pandeglang</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ==========================================================================
     URUTAN 6: INFORMASI PELAYANAN
     ========================================================================== -->
<section class="section section-alt" id="pelayanan">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Pelayanan Medis</span>
      <h2 class="section-title">Pelayanan UPT Puskesmas Carita</h2>
      <p class="section-desc">Pilihan layanan kesehatan komprehensif, berkualitas, dan didukung oleh dokter serta tenaga medis berpengalaman.</p>
    </div>

    <div class="services-grid">
      <?php foreach ($services as $srv): ?>
        <div class="service-card">
          <div class="service-icon-box">
            <i class="<?= htmlspecialchars($srv['icon']); ?>"></i>
          </div>
          <span class="badge-pill badge-mint" style="align-self: flex-start; margin-bottom: 0.75rem; font-size: 0.75rem;">
            <?= htmlspecialchars($srv['category']); ?>
          </span>
          <h3><?= htmlspecialchars($srv['name']); ?></h3>
          <p><?= htmlspecialchars($srv['description']); ?></p>
          
          <div class="service-meta">
            <span><i class="far fa-clock" style="color: #059669;"></i> <?= htmlspecialchars($srv['schedule_info']); ?></span>
            <span><i class="fas fa-map-marker-alt" style="color: #059669;"></i> <?= htmlspecialchars($srv['location']); ?></span>
          </div>

          <a href="<?= base_url('pelayanan.php#' . $srv['slug']); ?>" class="news-readmore" style="margin-top: auto;">
            Lihat Detail <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      <?php endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: 3rem;">
      <a href="<?= base_url('pelayanan.php'); ?>" class="btn btn-primary">
        <i class="fas fa-list-ul"></i> Lihat Seluruh 18+ Jenis Pelayanan
      </a>
    </div>
  </div>
</section>

<!-- ==========================================================================
     URUTAN 7: JADWAL PELAYANAN (DENGAN FILTER & SEARCH LIVE)
     ========================================================================== -->
<section class="section" id="jadwal" style="background: #f8fafc;">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Jadwal Operasional</span>
      <h2 class="section-title">Jadwal Pelayanan Terpadu</h2>
      <p class="section-desc">Ketahui jam operasional loket dan poli untuk mempermudah kunjungan Anda ke UPT Puskesmas Carita.</p>
    </div>

    <!-- Filter & Live Search Bar -->
    <div class="table-filter-bar">
      <div class="filter-controls">
        <div class="search-input-wrap">
          <i class="fas fa-search"></i>
          <input type="text" id="scheduleSearch" placeholder="Cari nama poli, hari, atau unit..." autocomplete="off">
        </div>

        <select id="scheduleDayFilter" class="filter-select">
          <option value="all">Semua Hari Pelayanan</option>
          <option value="senin">Senin</option>
          <option value="selasa">Selasa</option>
          <option value="rabu">Rabu</option>
          <option value="kamis">Kamis</option>
          <option value="jumat">Jumat</option>
          <option value="sabtu">Sabtu</option>
          <option value="minggu">Minggu / 24 Jam</option>
        </select>
      </div>

      <div style="font-size: 0.85rem; color: #64748b;">
        <i class="fas fa-check-circle" style="color: #059669;"></i> Data Terverifikasi Dinas Kesehatan
      </div>
    </div>

    <!-- Schedule Responsive Table -->
    <div class="table-responsive">
      <table class="schedule-table">
        <thead>
          <tr>
            <th>Jenis Pelayanan / Poli</th>
            <th>Hari Pelayanan</th>
            <th>Jam Buka</th>
            <th>Loket / Unit Ruang</th>
            <th>Keterangan / Persyaratan</th>
          </tr>
        </thead>
        <tbody id="scheduleTableBody">
          <?php foreach ($schedules as $sch): ?>
            <?php 
              $is24Hours = (strpos($sch['open_time'], '00.00') !== false || strpos($sch['day'], 'Setiap Hari') !== false);
            ?>
            <tr class="schedule-row" 
                data-service="<?= htmlspecialchars($sch['service_name']); ?>" 
                data-day="<?= htmlspecialchars($sch['day']); ?>" 
                data-room="<?= htmlspecialchars($sch['room_unit']); ?>">
              <td style="font-weight: 700; color: #064e3b;">
                <i class="fas <?= $is24Hours ? 'fa-ambulance' : 'fa-stethoscope'; ?>" style="color: <?= $is24Hours ? '#dc2626' : '#059669'; ?>; margin-right: 8px;"></i>
                <?= htmlspecialchars($sch['service_name']); ?>
              </td>
              <td>
                <span class="badge-pill badge-mint"><?= htmlspecialchars($sch['day']); ?></span>
              </td>
              <td>
                <span class="time-badge <?= $is24Hours ? 'time-24' : ''; ?>">
                  <?= htmlspecialchars($sch['open_time']); ?> - <?= htmlspecialchars($sch['close_time']); ?> WIB
                </span>
              </td>
              <td><?= htmlspecialchars($sch['room_unit']); ?></td>
              <td style="color: #64748b; font-size: 0.85rem;"><?= htmlspecialchars($sch['notes']); ?></td>
            </tr>
          <?php endforeach; ?>
          <tr id="scheduleEmptyRow" style="display: none;">
            <td colspan="5" style="text-align: center; padding: 2rem; color: #94a3b8;">
              <i class="fas fa-search" style="font-size: 1.5rem; margin-bottom: 0.5rem; display: block;"></i>
              Tidak ada jadwal pelayanan yang sesuai dengan kata kunci pencarian Anda.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="table-disclaimer">
      <i class="fas fa-info-circle" style="color: #0284c7;"></i>
      <span><strong>Catatan:</strong> Jam pelayanan dapat berubah sesuai kebijakan, situasi darurat, dan kondisi pelayanan. Untuk kondisi darurat, UGD & Bersalin (PONED) melayani 24 Jam Nonstop.</span>
    </div>
  </div>
</section>

<!-- ==========================================================================
     URUTAN 8: PROGRAM KESEHATAN
     ========================================================================== -->
<section class="section section-alt" id="program">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Program Unggulan</span>
      <h2 class="section-title">Program Kesehatan Puskesmas</h2>
      <p class="section-desc">Upaya Kesehatan Masyarakat (UKM) terpadu untuk meningkatkan derajat kesehatan warga Carita dari hulu ke hilir.</p>
    </div>

    <div class="services-grid">
      <?php foreach ($programs as $prog): ?>
        <div class="service-card" style="border-top: 4px solid var(--pkm-primary);">
          <span class="badge-pill badge-blue" style="align-self: flex-start; margin-bottom: 0.75rem; font-size: 0.75rem;">
            <?= htmlspecialchars($prog['category']); ?>
          </span>
          <h3><?= htmlspecialchars($prog['title']); ?></h3>
          <p><?= htmlspecialchars($prog['short_desc']); ?></p>
          
          <div class="service-meta" style="margin-top: auto;">
            <span><i class="fas fa-users" style="color: #0284c7;"></i> Sasaran: <?= htmlspecialchars($prog['target_group']); ?></span>
            <span><i class="fas fa-user-check" style="color: #0284c7;"></i> Pengelola: <?= htmlspecialchars($prog['pic_officer']); ?></span>
          </div>

          <a href="<?= base_url('program.php#' . $prog['slug']); ?>" class="news-readmore">
            Pelajari Program <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      <?php endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: 3rem;">
      <a href="<?= base_url('program.php'); ?>" class="btn btn-secondary">
        <i class="fas fa-heartbeat"></i> Selengkapnya Program Kesehatan
      </a>
    </div>
  </div>
</section>

<!-- ==========================================================================
     URUTAN 9: INOVASI PUSKESMAS (KAJEDAK SPOTLIGHT)
     ========================================================================== -->
<section class="section" id="inovasi" style="background: linear-gradient(180deg, #ecfdf5 0%, #f8fafc 100%);">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Karya Inovasi</span>
      <h2 class="section-title">Inovasi UPT Puskesmas Carita</h2>
      <p class="section-desc">Terobosan layanan proaktif untuk menjawab tantangan kesehatan masyarakat pesisir dan pariwisata.</p>
    </div>

    <!-- Spotlight Inovasi Utama: KAJEDAK -->
    <?php if ($kajedak): ?>
      <div class="featured-innovation">
        <div class="innovation-spotlight-grid">
          <img src="<?= base_url($kajedak['image'] ?? 'assets/img/inovasi-kajedak.jpg'); ?>" alt="Inovasi KAJEDAK Puskesmas Carita" class="innovation-spotlight-img">
          
          <div class="innovation-spotlight-body">
            <span class="badge-pill badge-urgent" style="margin-bottom: 0.75rem; background: #dcfce7; color: #047857; border-color: #86efac;">
              <i class="fas fa-star"></i> Inovasi Unggulan Daerah
            </span>
            <h3><?= htmlspecialchars($kajedak['name']); ?></h3>
            <div class="innovation-tagline"><?= htmlspecialchars($kajedak['tagline']); ?></div>
            <p style="color: #475569; font-size: 0.95rem; line-height: 1.65;">
              <?= htmlspecialchars($kajedak['short_desc']); ?>
            </p>

            <div class="innovation-keypoints">
              <div class="keypoint-item">
                <i class="fas fa-check-circle"></i>
                <div><strong>Tujuan:</strong> <?= nl2br(htmlspecialchars($kajedak['objectives'])); ?></div>
              </div>
              <div class="keypoint-item">
                <i class="fas fa-shield-alt"></i>
                <div><strong>Manfaat:</strong> <?= nl2br(htmlspecialchars($kajedak['benefits'])); ?></div>
              </div>
            </div>

            <div style="margin-top: 1.5rem;">
              <a href="<?= base_url('inovasi.php'); ?>" class="btn btn-primary">
                <i class="fas fa-info-circle"></i> Baca Dokumentasi KAJEDAK
              </a>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- Inovasi Tambahan Cards -->
    <div class="innovations-grid">
      <?php foreach ($other_innovations as $inov): ?>
        <div class="innovation-subcard">
          <span class="badge-pill badge-mint" style="font-size: 0.75rem; margin-bottom: 0.75rem;">Inovasi Pelayanan</span>
          <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;"><?= htmlspecialchars($inov['name']); ?></h3>
          <p style="font-size: 0.85rem; color: #059669; font-weight: 600; margin-bottom: 0.75rem;"><?= htmlspecialchars($inov['tagline']); ?></p>
          <p style="font-size: 0.875rem; color: #475569; line-height: 1.6; margin-bottom: 1.25rem;"><?= htmlspecialchars($inov['short_desc']); ?></p>
          <a href="<?= base_url('inovasi.php#' . $inov['slug']); ?>" class="news-readmore">Selengkapnya <i class="fas fa-arrow-right"></i></a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ==========================================================================
     URUTAN 10: BERITA DAN KEGIATAN
     ========================================================================== -->
<section class="section section-alt" id="berita">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Warta Puskesmas</span>
      <h2 class="section-title">Berita & Kegiatan Terkini</h2>
      <p class="section-desc">Publikasi aktivitas, program lapangan, dan pengumuman resmi UPT Puskesmas Carita.</p>
    </div>

    <div class="news-grid">
      <?php foreach ($news_list as $item): ?>
        <article class="news-card">
          <div class="news-thumb-wrap">
            <img src="<?= base_url($item['thumbnail']); ?>" alt="<?= htmlspecialchars($item['title']); ?>" class="news-thumb">
            <span class="badge-pill badge-mint news-cat-badge">
              <?= htmlspecialchars($item['category']); ?>
            </span>
          </div>
          <div class="news-body">
            <div class="news-meta">
              <span><i class="far fa-calendar-alt"></i> <?= format_date_id($item['published_at']); ?></span>
              <span><i class="far fa-user"></i> <?= htmlspecialchars($item['author']); ?></span>
            </div>
            <h3>
              <a href="<?= base_url('berita-detail.php?slug=' . urlencode($item['slug'])); ?>">
                <?= htmlspecialchars($item['title']); ?>
              </a>
            </h3>
            <p><?= htmlspecialchars($item['excerpt']); ?></p>
            <a href="<?= base_url('berita-detail.php?slug=' . urlencode($item['slug'])); ?>" class="news-readmore">
              Baca Selengkapnya <i class="fas fa-arrow-right"></i>
            </a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: 3rem;">
      <a href="<?= base_url('berita.php'); ?>" class="btn btn-secondary">
        <i class="far fa-newspaper"></i> Lihat Semua Berita & Kegiatan
      </a>
    </div>
  </div>
</section>

<!-- ==========================================================================
     URUTAN 11: ARTIKEL EDUKASI KESEHATAN
     ========================================================================== -->
<section class="section" id="edukasi" style="background: #f8fafc;">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Pojok Sehat</span>
      <h2 class="section-title">Edukasi Kesehatan Masyarakat</h2>
      <p class="section-desc">Artikel ilmiah populer dan tips kesehatan praktis untuk mewujudkan keluarga sehat dan bebas penyakit.</p>
    </div>

    <div class="news-grid">
      <?php foreach ($articles_list as $art): ?>
        <article class="news-card" style="border-top: 4px solid #0284c7;">
          <div class="news-thumb-wrap">
            <img src="<?= base_url($art['thumbnail']); ?>" alt="<?= htmlspecialchars($art['title']); ?>" class="news-thumb">
            <span class="badge-pill badge-blue news-cat-badge">
              <i class="fas fa-tag"></i> <?= htmlspecialchars($art['topic']); ?>
            </span>
          </div>
          <div class="news-body">
            <div class="news-meta">
              <span><i class="far fa-calendar-alt"></i> <?= format_date_id($art['published_at']); ?></span>
              <span><i class="far fa-eye"></i> <?= htmlspecialchars($art['views']); ?>x dilihat</span>
            </div>
            <h3>
              <a href="<?= base_url('edukasi.php?slug=' . urlencode($art['slug'])); ?>">
                <?= htmlspecialchars($art['title']); ?>
              </a>
            </h3>
            <p><?= htmlspecialchars($art['excerpt']); ?></p>
            <a href="<?= base_url('edukasi.php?slug=' . urlencode($art['slug'])); ?>" class="news-readmore" style="color: #0284c7;">
              Baca Artikel Lengkap <i class="fas fa-arrow-right"></i>
            </a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: 3rem;">
      <a href="<?= base_url('edukasi.php'); ?>" class="btn btn-primary" style="background: linear-gradient(135deg, #0284c7, #0369a1);">
        <i class="fas fa-book-medical"></i> Jelajahi Seluruh Artikel Edukasi
      </a>
    </div>
  </div>
</section>

<!-- ==========================================================================
     URUTAN 12: VIDEO PROFIL PUSKESMAS
     ========================================================================== -->
<section class="section section-alt" id="video">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Multimedia</span>
      <h2 class="section-title">Video Profil UPT Puskesmas Carita</h2>
      <p class="section-desc">Kenali sarana prasarana, ruang pelayanan, dan dedikasi tim medis Puskesmas Carita dalam tayangan video.</p>
    </div>

    <div style="max-width: 900px; margin: 0 auto; background: #0f172a; border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--shadow-lg);">
      <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
        <iframe 
          style="position: absolute; top:0; left: 0; width: 100%; height: 100%; border: 0;"
          src="https://www.youtube-nocookie.com/embed/<?= htmlspecialchars($video['youtube_id'] ?? 'dQw4w9WgXcQ'); ?>?rel=0" 
          title="Video Profil UPT Puskesmas Carita" 
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
          allowfullscreen>
        </iframe>
      </div>
      <div style="padding: 1.5rem 2rem; color: #ffffff; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
          <h4 style="color: #ffffff; font-size: 1.15rem; margin-bottom: 0.25rem;"><?= htmlspecialchars($video['title'] ?? 'Profil Puskesmas Carita'); ?></h4>
          <p style="color: #94a3b8; font-size: 0.85rem; margin-bottom: 0;"><?= htmlspecialchars($video['description'] ?? 'Puskesmas Carita Kabupaten Pandeglang'); ?></p>
        </div>
        <a href="https://youtube.com/@puskesmascarita" target="_blank" rel="noopener" class="btn btn-primary" style="padding: 0.5rem 1.25rem; font-size: 0.85rem; background: #dc2626;">
          <i class="fab fa-youtube"></i> Subscribe YouTube
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ==========================================================================
     URUTAN 13: GALERI KEGIATAN (DENGAN LIGHTBOX)
     ========================================================================== -->
<section class="section" id="galeri" style="background: #f8fafc;">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Dokumentasi</span>
      <h2 class="section-title">Galeri Foto Kegiatan</h2>
      <p class="section-desc">Dokumentasi potret pelayanan medis, posyandu desa, dan aksi sosial tenaga kesehatan di wilayah Carita.</p>
    </div>

    <div class="gallery-grid">
      <?php foreach ($galleries as $gal): ?>
        <div class="gallery-item" data-img="<?= base_url($gal['file_path']); ?>" data-caption="<?= htmlspecialchars($gal['title'] . ' - ' . $gal['caption']); ?>">
          <img src="<?= base_url($gal['file_path']); ?>" alt="<?= htmlspecialchars($gal['title']); ?>" loading="lazy">
          <div class="gallery-overlay">
            <h4><?= htmlspecialchars($gal['title']); ?></h4>
            <span><i class="fas fa-tag"></i> <?= htmlspecialchars($gal['category']); ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: 2.5rem;">
      <a href="<?= base_url('galeri.php'); ?>" class="btn btn-secondary">
        <i class="far fa-images"></i> Lihat Galeri Selengkapnya
      </a>
    </div>
  </div>
</section>

<!-- ==========================================================================
     URUTAN 14: MEDIA SOSIAL
     ========================================================================== -->
<section class="section section-alt" style="padding: 3.5rem 0;">
  <div class="container">
    <div class="section-header" style="margin-bottom: 2rem;">
      <span class="section-tag">Kanal Informasi Resmi</span>
      <h2 class="section-title">Ikuti Media Sosial Kami</h2>
      <p class="section-desc">Dapatkan update informasi kesehatan berkala, jadwal vaksinasi, dan kegiatan Puskesmas Carita.</p>
    </div>

    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1.25rem;">
      <a href="https://instagram.com/puskesmas_carita" target="_blank" rel="noopener" class="btn btn-secondary" style="border-radius: var(--radius-lg); padding: 0.9rem 1.6rem;">
        <i class="fab fa-instagram" style="color: #e1306c; font-size: 1.3rem;"></i> Instagram @puskesmas_carita
      </a>
      <a href="https://facebook.com/puskesmascarita" target="_blank" rel="noopener" class="btn btn-secondary" style="border-radius: var(--radius-lg); padding: 0.9rem 1.6rem;">
        <i class="fab fa-facebook-f" style="color: #1877f2; font-size: 1.3rem;"></i> Facebook UPT Puskesmas Carita
      </a>
      <a href="https://youtube.com/@puskesmascarita" target="_blank" rel="noopener" class="btn btn-secondary" style="border-radius: var(--radius-lg); padding: 0.9rem 1.6rem;">
        <i class="fab fa-youtube" style="color: #ff0000; font-size: 1.3rem;"></i> YouTube Channel
      </a>
      <a href="https://tiktok.com/@puskesmascarita" target="_blank" rel="noopener" class="btn btn-secondary" style="border-radius: var(--radius-lg); padding: 0.9rem 1.6rem;">
        <i class="fab fa-tiktok" style="color: #000000; font-size: 1.3rem;"></i> TikTok Official
      </a>
      <a href="https://wa.me/62<?= ltrim(preg_replace('/[^0-9]/', '', $whatsapp), '0'); ?>" target="_blank" rel="noopener" class="btn btn-secondary" style="border-radius: var(--radius-lg); padding: 0.9rem 1.6rem;">
        <i class="fab fa-whatsapp" style="color: #25d366; font-size: 1.3rem;"></i> WhatsApp Layanan
      </a>
    </div>
  </div>
</section>

<!-- ==========================================================================
     URUTAN 15: PENGADUAN MASYARAKAT
     ========================================================================== -->
<section class="section" id="pengaduan" style="background: #f1f5f9;">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Layanan Aspirasi</span>
      <h2 class="section-title">Pengaduan & Saran Masyarakat</h2>
      <p class="section-desc">Kritik, saran, dan aspirasi Anda sangat berharga bagi peningkatan mutu dan kualitas pelayanan kami.</p>
    </div>

    <div style="max-width: 820px; margin: 0 auto;">
      <div class="complaint-box">
        <form action="<?= base_url('index.php#pengaduan'); ?>" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="action" value="submit_complaint">
          <input type="hidden" name="csrf_token" value="<?= generate_csrf_token(); ?>">

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
            <div class="form-group">
              <label class="form-label" for="comp_name">Nama Lengkap <span style="color: #ef4444;">*</span></label>
              <input type="text" id="comp_name" name="name" class="form-control" placeholder="Masukkan nama Anda" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="comp_phone">Nomor HP / WhatsApp <span style="color: #ef4444;">*</span></label>
              <input type="text" id="comp_phone" name="phone" class="form-control" placeholder="Contoh: 081234567890" required>
            </div>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
            <div class="form-group">
              <label class="form-label" for="comp_email">Alamat Email (Opsional)</label>
              <input type="email" id="comp_email" name="email" class="form-control" placeholder="nama@email.com">
            </div>

            <div class="form-group">
              <label class="form-label" for="comp_category">Kategori Pengaduan</label>
              <select id="comp_category" name="category" class="form-control">
                <option value="Pelayanan Medis">Pelayanan Medis & Dokter</option>
                <option value="Petugas & Sikap">Sikap Petugas & Komunikasi</option>
                <option value="Fasilitas & Kebersihan">Sarana, Fasilitas & Kebersihan</option>
                <option value="Farmasi & Obat">Farmasi, Resep & Ketersediaan Obat</option>
                <option value="Administrasi & Pendaftaran">Administrasi, Antrean & Loket</option>
                <option value="Lainnya">Saran & Pertanyaan Lainnya</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label" for="comp_message">Uraian Pengaduan / Masukan <span style="color: #ef4444;">*</span></label>
            <textarea id="comp_message" name="message" class="form-control" rows="4" placeholder="Jelaskan secara jelas kronologi, unit layanan terkait, atau saran perbaikan Anda..." required></textarea>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
            <div class="form-group">
              <label class="form-label" for="comp_attachment">Lampiran Bukti / Foto (Opsional, Maks 3MB)</label>
              <input type="file" id="comp_attachment" name="attachment" class="form-control" accept="image/jpeg,image/png,application/pdf">
            </div>

            <div class="form-group">
              <label class="form-label" for="captcha_answer">Verifikasi Keamanan: Berapa hasil <strong><?= $num1; ?> + <?= $num2; ?></strong>? <span style="color: #ef4444;">*</span></label>
              <input type="number" id="captcha_answer" name="captcha_answer" class="form-control" placeholder="Jawaban angka" required>
            </div>
          </div>

          <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-top: 1rem;">
            <button type="submit" class="btn btn-primary" style="padding: 0.85rem 2rem;">
              <i class="fas fa-paper-plane"></i> Kirim Pengaduan Sekarang
            </button>
            <a href="<?= base_url('pengaduan.php'); ?>" style="font-size: 0.9rem; color: #0284c7; font-weight: 600;">
              <i class="fas fa-search"></i> Cek Status Tiket Pengaduan &rarr;
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ==========================================================================
     URUTAN 16: KONTAK & GOOGLE MAPS
     ========================================================================== -->
<section class="section section-alt" id="kontak">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Lokasi & Akses</span>
      <h2 class="section-title">Kontak & Lokasi Puskesmas</h2>
      <p class="section-desc">Kunjungi kami di jalur utama wisata pantai Carita atau hubungi kami untuk layanan medis dan rujukan darurat.</p>
    </div>

    <div class="contact-grid">
      <!-- Contact Info Card -->
      <div class="contact-card">
        <span class="badge-pill badge-mint" style="margin-bottom: 1rem;">
          <i class="fas fa-building"></i> Fasilitas Pelayanan Kesehatan
        </span>
        <h3 style="font-size: 1.6rem; margin-bottom: 0.5rem; color: #064e3b;"><?= htmlspecialchars($site_title); ?></h3>
        <p style="color: #64748b;"><?= htmlspecialchars($site_sub); ?> - Banten</p>

        <div class="contact-list">
          <div class="contact-item">
            <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div class="contact-text">
              <h4>Alamat Resmi</h4>
              <p><?= htmlspecialchars(get_setting('address')); ?></p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
            <div class="contact-text">
              <h4>Telepon Pelayanan</h4>
              <p><a href="tel:<?= preg_replace('/[^0-9]/', '', $phone); ?>"><?= htmlspecialchars($phone); ?></a></p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon" style="background: #fee2e2; color: #dc2626;"><i class="fas fa-ambulance"></i></div>
            <div class="contact-text">
              <h4>Hotline Darurat & UGD 24 Jam</h4>
              <p style="color: #dc2626; font-weight: 700;"><?= htmlspecialchars($emergency_phone); ?></p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon"><i class="far fa-envelope"></i></div>
            <div class="contact-text">
              <h4>Email Resmi</h4>
              <p><a href="mailto:<?= htmlspecialchars($email); ?>"><?= htmlspecialchars($email); ?></a></p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon"><i class="far fa-clock"></i></div>
            <div class="contact-text">
              <h4>Jam Operasional</h4>
              <p><?= htmlspecialchars(get_setting('working_hours')); ?></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Google Maps Embed -->
      <div class="map-card">
        <iframe 
          src="<?= htmlspecialchars(get_setting('maps_embed')); ?>" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade" 
          title="Lokasi UPT Puskesmas Carita">
        </iframe>
      </div>
    </div>
  </div>
</section>

<!-- ==========================================================================
     URUTAN 17: FOOTER (Loaded via includes/footer.php)
     ========================================================================== -->
<?php include __DIR__ . '/includes/footer.php'; ?>
