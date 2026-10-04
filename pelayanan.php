<?php
/**
 * UPT PUSKESMAS CARITA - KABUPATEN PANDEGLANG
 * Informasi Jenis Pelayanan Kesehatan
 */

require_once __DIR__ . '/config/helper.php';

$page_title = 'Informasi Pelayanan';
$page_desc = 'Daftar lengkap jenis pelayanan kesehatan rawat jalan, gawat darurat 24 jam, persalinan PONED, dan penunjang medis di UPT Puskesmas Carita.';

$db = getDBConnection();

$services = $db->query("SELECT * FROM services WHERE is_active = 1 ORDER BY order_num ASC")->fetchAll();

// Group categories
$categories = array_unique(array_column($services, 'category'));

include __DIR__ . '/includes/header.php';
?>

<!-- Page Header Banner -->
<div style="background: linear-gradient(135deg, #064e3b 0%, #059669 100%); color: #ffffff; padding: 4.5rem 0 3.5rem 0; text-align: center;">
  <div class="container">
    <span class="badge-pill" style="background: rgba(255,255,255,0.15); color: #34d399; margin-bottom: 0.75rem;">
      <i class="fas fa-stethoscope"></i> Layanan Komprehensif
    </span>
    <h1 style="font-size: clamp(2rem, 3.5vw, 2.8rem); color: #ffffff; margin-bottom: 0.75rem;">Pelayanan UPT Puskesmas Carita</h1>
    <p style="color: #e2e8f0; font-size: 1.1rem; max-width: 650px; margin: 0 auto;">Layanan kesehatan primer yang ramah, bermutu, terjangkau, dan berorientasi pada keselamatan pasien.</p>
  </div>
</div>

<!-- Breadcrumb -->
<div style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 0.75rem 0; font-size: 0.85rem;">
  <div class="container" style="display: flex; gap: 0.5rem; align-items: center; color: #64748b;">
    <a href="<?= base_url(); ?>"><i class="fas fa-home"></i> Beranda</a>
    <span>/</span>
    <span style="color: #059669; font-weight: 600;">Pelayanan</span>
  </div>
</div>

<main class="section">
  <div class="container">
    <!-- Filter Tabs -->
    <div class="filter-tabs-wrapper" style="text-align: center; margin-bottom: 3rem;">
      <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 0.5rem;">
        <button class="btn btn-secondary filter-tab-btn active" data-category="all" data-target="#servicesGrid" style="padding: 0.5rem 1.25rem; font-size: 0.875rem;">
          Semua Pelayanan (<?= count($services); ?>)
        </button>
        <?php foreach ($categories as $cat): ?>
          <button class="btn btn-secondary filter-tab-btn" data-category="<?= htmlspecialchars($cat); ?>" data-target="#servicesGrid" style="padding: 0.5rem 1.25rem; font-size: 0.875rem;">
            <?= htmlspecialchars($cat); ?>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Services Grid -->
    <div class="services-grid" id="servicesGrid">
      <?php foreach ($services as $srv): ?>
        <div class="service-card filterable-item" id="<?= htmlspecialchars($srv['slug']); ?>" data-category="<?= htmlspecialchars($srv['category']); ?>">
          <div class="service-icon-box">
            <i class="<?= htmlspecialchars($srv['icon']); ?>"></i>
          </div>
          <span class="badge-pill badge-mint" style="align-self: flex-start; margin-bottom: 0.75rem; font-size: 0.75rem;">
            <?= htmlspecialchars($srv['category']); ?>
          </span>
          <h3><?= htmlspecialchars($srv['name']); ?></h3>
          <p><?= htmlspecialchars($srv['description']); ?></p>

          <div class="service-meta">
            <span><i class="far fa-clock" style="color: #059669;"></i> <strong>Jadwal:</strong> <?= htmlspecialchars($srv['schedule_info']); ?></span>
            <span><i class="fas fa-map-marker-alt" style="color: #059669;"></i> <strong>Ruang:</strong> <?= htmlspecialchars($srv['location']); ?></span>
            <?php if (!empty($srv['officer'])): ?>
              <span><i class="fas fa-user-md" style="color: #059669;"></i> <strong>Tenaga:</strong> <?= htmlspecialchars($srv['officer']); ?></span>
            <?php endif; ?>
          </div>

          <div style="margin-top: auto; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 1rem;">
            <a href="https://wa.me/62<?= ltrim(preg_replace('/[^0-9]/', '', get_setting('whatsapp')), '0'); ?>?text=Halo%20Admin%2C%20saya%20ingin%20konsultasi%20layanan%20<?= urlencode($srv['name']); ?>" target="_blank" rel="noopener" class="btn btn-secondary" style="padding: 0.4rem 0.85rem; font-size: 0.775rem;">
              <i class="fab fa-whatsapp"></i> Tanya Petugas
            </a>
            <a href="<?= base_url('jadwal.php'); ?>" class="news-readmore" style="font-size: 0.825rem;">
              Cek Jam <i class="fas fa-arrow-right"></i>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Quick CTA Banner -->
    <div style="margin-top: 4rem; background: linear-gradient(135deg, #064e3b, #047857); border-radius: var(--radius-xl); padding: 3rem; color: #ffffff; text-align: center;">
      <h3 style="color: #ffffff; font-size: 1.8rem; margin-bottom: 0.75rem;">Butuh Jadwal Lengkap Berdasarkan Hari?</h3>
      <p style="color: #e2e8f0; max-width: 600px; margin: 0 auto 1.75rem auto;">Lihat tabel jadwal pelayanan terpadu lengkap dengan nama ruang unit dan persyaratan administrasi BPJS / Umum.</p>
      <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
        <a href="<?= base_url('jadwal.php'); ?>" class="btn btn-primary" style="background: #ffffff; color: #064e3b;">
          <i class="fas fa-calendar-alt"></i> Buka Jadwal Pelayanan Lengkap
        </a>
        <a href="https://wa.me/62<?= ltrim(preg_replace('/[^0-9]/', '', get_setting('whatsapp')), '0'); ?>" target="_blank" rel="noopener" class="btn btn-outline-white">
          <i class="fab fa-whatsapp"></i> Pendaftaran Antrean Online
        </a>
      </div>
    </div>
  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
