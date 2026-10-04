<?php
/**
 * UPT PUSKESMAS CARITA - KABUPATEN PANDEGLANG
 * Inovasi Pelayanan Kesehatan & Spotlight KAJEDAK
 */

require_once __DIR__ . '/config/helper.php';

$page_title = 'Inovasi Pelayanan Puskesmas';
$page_desc = 'Inovasi unggulan UPT Puskesmas Carita Kabupaten Pandeglang. Inovasi KAJEDAK, SI-PINTAR BUMIL, dan Pelayanan Kesehatan Wisata Pesisir.';

$db = getDBConnection();

$innovations = $db->query("SELECT * FROM innovations WHERE is_active = 1 ORDER BY id ASC")->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<!-- Header Banner -->
<div style="background: linear-gradient(135deg, #064e3b 0%, #059669 100%); color: #ffffff; padding: 4.5rem 0 3.5rem 0; text-align: center;">
  <div class="container">
    <span class="badge-pill" style="background: rgba(255,255,255,0.15); color: #34d399; margin-bottom: 0.75rem;">
      <i class="fas fa-lightbulb"></i> Terobosan Pelayanan Publik
    </span>
    <h1 style="font-size: clamp(2rem, 3.5vw, 2.8rem); color: #ffffff; margin-bottom: 0.75rem;">Inovasi UPT Puskesmas Carita</h1>
    <p style="color: #e2e8f0; font-size: 1.1rem; max-width: 650px; margin: 0 auto;">Menghadirkan pelayanan kesehatan proaktif, adaptif terhadap masyarakat pesisir dan pariwisata bahari.</p>
  </div>
</div>

<!-- Breadcrumb -->
<div style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 0.75rem 0; font-size: 0.85rem;">
  <div class="container" style="display: flex; gap: 0.5rem; align-items: center; color: #64748b;">
    <a href="<?= base_url(); ?>"><i class="fas fa-home"></i> Beranda</a>
    <span>/</span>
    <span style="color: #059669; font-weight: 600;">Inovasi Puskesmas</span>
  </div>
</div>

<main class="section">
  <div class="container">
    <?php foreach ($innovations as $index => $inov): ?>
      <?php 
        $isKajedak = (stripos($inov['name'], 'KAJEDAK') !== false);
      ?>
      <article class="featured-innovation" id="<?= htmlspecialchars($inov['slug']); ?>" style="<?= $isKajedak ? 'border: 2px solid #059669; box-shadow: var(--shadow-lg);' : 'margin-bottom: 2.5rem;'; ?>">
        <div class="innovation-spotlight-grid" style="<?= ($index % 2 === 1) ? 'direction: rtl;' : ''; ?>">
          <div style="direction: ltr;">
            <img src="<?= base_url($inov['image']); ?>" alt="<?= htmlspecialchars($inov['name']); ?>" class="innovation-spotlight-img">
          </div>
          
          <div class="innovation-spotlight-body" style="direction: ltr;">
            <?php if ($isKajedak): ?>
              <span class="badge-pill badge-urgent" style="background: #ecfdf5; color: #047857; border-color: #86efac; margin-bottom: 0.75rem;">
                <i class="fas fa-crown"></i> Inovasi Unggulan Puskesmas Carita
              </span>
            <?php else: ?>
              <span class="badge-pill badge-blue" style="margin-bottom: 0.75rem;">
                <i class="fas fa-certificate"></i> Inovasi Pelayanan Terpadu
              </span>
            <?php endif; ?>

            <h2 style="font-size: 1.85rem; margin-bottom: 0.5rem; color: #064e3b;"><?= htmlspecialchars($inov['name']); ?></h2>
            <div class="innovation-tagline" style="margin-bottom: 1rem;"><?= htmlspecialchars($inov['tagline']); ?></div>

            <p style="color: #475569; font-size: 0.95rem; line-height: 1.7; margin-bottom: 1.5rem;">
              <?= htmlspecialchars($inov['short_desc']); ?>
            </p>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: var(--radius-md); padding: 1.25rem; margin-bottom: 1.25rem;">
              <h4 style="font-size: 0.95rem; color: #064e3b; margin-bottom: 0.4rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-bullseye" style="color: #059669;"></i> Tujuan Inovasi:
              </h4>
              <p style="color: #475569; font-size: 0.875rem; margin-bottom: 0; line-height: 1.6;">
                <?= nl2br(htmlspecialchars($inov['objectives'])); ?>
              </p>
            </div>

            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: var(--radius-md); padding: 1.25rem; margin-bottom: 1.5rem;">
              <h4 style="font-size: 0.95rem; color: #064e3b; margin-bottom: 0.4rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-check-double" style="color: #059669;"></i> Manfaat yang Dirasakan:
              </h4>
              <p style="color: #475569; font-size: 0.875rem; margin-bottom: 0; line-height: 1.6;">
                <?= nl2br(htmlspecialchars($inov['benefits'])); ?>
              </p>
            </div>

            <?php if (!empty($inov['documentation'])): ?>
              <div style="color: #64748b; font-size: 0.85rem; margin-bottom: 1.5rem;">
                <i class="far fa-clipboard" style="color: #059669;"></i> <strong>Dokumentasi Pelaksanaan:</strong> <?= htmlspecialchars($inov['documentation']); ?>
              </div>
            <?php endif; ?>

            <a href="https://wa.me/62<?= ltrim(preg_replace('/[^0-9]/', '', get_setting('whatsapp')), '0'); ?>?text=Halo%20Admin%2C%20saya%20tertarik%20mengenai%20Inovasi%20<?= urlencode($inov['name']); ?>" target="_blank" rel="noopener" class="btn btn-primary" style="font-size: 0.875rem;">
              <i class="fab fa-whatsapp"></i> Konsultasi & Jadwal KAJEDAK
            </a>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
