<?php
/**
 * UPT PUSKESMAS CARITA - KABUPATEN PANDEGLANG
 * Program Kesehatan & Integrasi Layanan Primer (ILP)
 */

require_once __DIR__ . '/config/helper.php';

$page_title = 'Program Kesehatan & ILP';
$page_desc = 'Program kesehatan unggulan dan penerapan Integrasi Layanan Primer (ILP) di UPT Puskesmas Carita Kabupaten Pandeglang.';

$db = getDBConnection();

$programs = $db->query("SELECT * FROM programs ORDER BY is_featured DESC, id ASC")->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<!-- Header Banner -->
<div style="background: linear-gradient(135deg, #064e3b 0%, #0d9488 100%); color: #ffffff; padding: 4.5rem 0 3.5rem 0; text-align: center;">
  <div class="container">
    <span class="badge-pill" style="background: rgba(255,255,255,0.15); color: #34d399; margin-bottom: 0.75rem;">
      <i class="fas fa-heartbeat"></i> Upaya Kesehatan Masyarakat
    </span>
    <h1 style="font-size: clamp(2rem, 3.5vw, 2.8rem); color: #ffffff; margin-bottom: 0.75rem;">Program Kesehatan Puskesmas</h1>
    <p style="color: #e2e8f0; font-size: 1.1rem; max-width: 650px; margin: 0 auto;">Penerapan Transformasi Layanan Primer (ILP) dan program prioritas nasional di Kecamatan Carita.</p>
  </div>
</div>

<!-- Breadcrumb -->
<div style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 0.75rem 0; font-size: 0.85rem;">
  <div class="container" style="display: flex; gap: 0.5rem; align-items: center; color: #64748b;">
    <a href="<?= base_url(); ?>"><i class="fas fa-home"></i> Beranda</a>
    <span>/</span>
    <span style="color: #059669; font-weight: 600;">Program Kesehatan</span>
  </div>
</div>

<main class="section">
  <div class="container">
    <!-- ILP Spotlight Card -->
    <div style="background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%); border: 1px solid #a7f3d0; border-radius: var(--radius-xl); padding: 3rem; margin-bottom: 3.5rem; box-shadow: var(--shadow-sm);">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; align-items: center;">
        <div>
          <span class="badge-pill badge-mint" style="margin-bottom: 1rem;">
            <i class="fas fa-sync-alt"></i> Transformasi Kesehatan
          </span>
          <h2 style="font-size: 2rem; margin-bottom: 1rem; color: #064e3b;">Integrasi Layanan Primer (ILP)</h2>
          <p style="color: #475569; font-size: 1rem; line-height: 1.7; margin-bottom: 1.25rem;">
            UPT Puskesmas Carita menerapkan integrasi pelayanan kesehatan primer berbasis siklus hidup yang mengoordinasikan faskes tingkat pertama, Pustu desa, dan Posyandu terpadu untuk memastikan pencegahan penyakit sedini mungkin bagi seluruh warga.
          </p>
          <div style="display: flex; flex-direction: column; gap: 0.6rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem; color: #064e3b; font-weight: 600; font-size: 0.9rem;">
              <i class="fas fa-check-circle" style="color: #059669;"></i> Klaster 1: Manajemen Puskesmas & Ketatausahaan
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem; color: #064e3b; font-weight: 600; font-size: 0.9rem;">
              <i class="fas fa-check-circle" style="color: #059669;"></i> Klaster 2: Ibu, Anak, Remaja & Siklus Hidup Awal
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem; color: #064e3b; font-weight: 600; font-size: 0.9rem;">
              <i class="fas fa-check-circle" style="color: #059669;"></i> Klaster 3: Usia Dewasa, Usia Lanjut & PTM
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem; color: #064e3b; font-weight: 600; font-size: 0.9rem;">
              <i class="fas fa-check-circle" style="color: #059669;"></i> Klaster 4: Penanggulangan Penyakit Menular & Sanitasi
            </div>
          </div>
        </div>

        <div style="background: #ffffff; border: 1px solid var(--pkm-border); border-radius: var(--radius-lg); padding: 2rem; box-shadow: var(--shadow-md);">
          <h4 style="color: #064e3b; margin-bottom: 1rem; font-size: 1.15rem;">Jejaring Layanan ILP di 10 Desa</h4>
          <p style="color: #64748b; font-size: 0.875rem; line-height: 1.6; margin-bottom: 1rem;">
            Pemberdayaan kader posyandu terlatih 25 kompetensi dasar di setiap posyandu desa wilayah kerja Puskesmas Carita untuk menjangkau keluarga sehat langsung ke rumah-rumah warga (home visit).
          </p>
          <div class="stat-box" style="padding: 1rem; background: #f0fdf4;">
            <div class="stat-num" style="font-size: 1.8rem; color: #059669;">10 Desa</div>
            <div class="stat-label">Terhubung Jejaring ILP & Posyandu Terintegrasi</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Programs Grid -->
    <div class="section-header" style="text-align: left; margin-bottom: 2rem;">
      <span class="section-tag">Rincian Program</span>
      <h2 class="section-title">Program Kesehatan Masyarakat Prioritas</h2>
    </div>

    <div style="display: flex; flex-direction: column; gap: 2rem;">
      <?php foreach ($programs as $prog): ?>
        <article class="service-card" id="<?= htmlspecialchars($prog['slug']); ?>" style="padding: 2.2rem; border-left: 5px solid var(--pkm-primary);">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
            <div>
              <span class="badge-pill badge-blue" style="font-size: 0.775rem; margin-bottom: 0.5rem;">
                <?= htmlspecialchars($prog['category']); ?>
              </span>
              <h3 style="font-size: 1.5rem; margin-bottom: 0.35rem; color: #064e3b;"><?= htmlspecialchars($prog['title']); ?></h3>
              <p style="color: #059669; font-weight: 600; font-size: 0.9rem;"><?= htmlspecialchars($prog['short_desc']); ?></p>
            </div>
            <div style="text-align: right;">
              <span class="badge-pill badge-mint" style="font-size: 0.8rem;">
                <i class="fas fa-user-tie"></i> Pengelola: <?= htmlspecialchars($prog['pic_officer']); ?>
              </span>
            </div>
          </div>

          <div style="color: #475569; font-size: 0.95rem; line-height: 1.8; margin-bottom: 1.5rem;">
            <?= nl2br(htmlspecialchars($prog['content'])); ?>
          </div>

          <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: var(--radius-md); padding: 0.85rem 1.25rem; display: flex; align-items: center; gap: 1rem; font-size: 0.85rem; color: #334155;">
            <i class="fas fa-users" style="color: #0284c7; font-size: 1.1rem;"></i>
            <span><strong>Kelompok Sasaran:</strong> <?= htmlspecialchars($prog['target_group']); ?></span>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
