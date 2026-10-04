<?php
/**
 * UPT PUSKESMAS CARITA - KABUPATEN PANDEGLANG
 * Galeri Kegiatan Foto & Video
 */

require_once __DIR__ . '/config/helper.php';

$page_title = 'Galeri Kegiatan';
$page_desc = 'Dokumentasi visual potret pelayanan medis, posyandu desa, dan penyuluhan kesehatan UPT Puskesmas Carita Kabupaten Pandeglang.';

$db = getDBConnection();

$category = sanitize($_GET['kategori'] ?? 'all');

$where = "";
$params = [];
if ($category !== 'all' && !empty($category)) {
    $where = "WHERE category = ?";
    $params[] = $category;
}

$stmt = $db->prepare("SELECT * FROM galleries $where ORDER BY id DESC");
$stmt->execute($params);
$galleries = $stmt->fetchAll();

// Videos
$videos = $db->query("SELECT * FROM videos ORDER BY id DESC")->fetchAll();

$categories = ['Kegiatan Posyandu', 'Kegiatan Masyarakat', 'Internal Puskesmas', 'Pelayanan Medis'];

include __DIR__ . '/includes/header.php';
?>

<!-- Header Banner -->
<div style="background: linear-gradient(135deg, #064e3b 0%, #059669 100%); color: #ffffff; padding: 4.5rem 0 3.5rem 0; text-align: center;">
  <div class="container">
    <span class="badge-pill" style="background: rgba(255,255,255,0.15); color: #34d399; margin-bottom: 0.75rem;">
      <i class="far fa-images"></i> Dokumentasi Visual
    </span>
    <h1 style="font-size: clamp(2rem, 3.5vw, 2.8rem); color: #ffffff; margin-bottom: 0.75rem;">Galeri Foto & Video</h1>
    <p style="color: #e2e8f0; font-size: 1.1rem; max-width: 650px; margin: 0 auto;">Potret pelayanan kesehatan, aksi sosial masyarakat, dan kegiatan Posyandu di Kecamatan Carita.</p>
  </div>
</div>

<!-- Breadcrumb -->
<div style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 0.75rem 0; font-size: 0.85rem;">
  <div class="container" style="display: flex; gap: 0.5rem; align-items: center; color: #64748b;">
    <a href="<?= base_url(); ?>"><i class="fas fa-home"></i> Beranda</a>
    <span>/</span>
    <span style="color: #059669; font-weight: 600;">Galeri Kegiatan</span>
  </div>
</div>

<main class="section">
  <div class="container">
    <!-- Filter Tabs -->
    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 0.5rem; margin-bottom: 3rem;">
      <a href="<?= base_url('galeri.php'); ?>" class="btn <?= $category === 'all' ? 'btn-primary' : 'btn-secondary'; ?>" style="padding: 0.5rem 1.25rem; font-size: 0.875rem;">
        Semua Foto
      </a>
      <?php foreach ($categories as $cat): ?>
        <a href="<?= base_url('galeri.php?kategori=' . urlencode($cat)); ?>" class="btn <?= $category === $cat ? 'btn-primary' : 'btn-secondary'; ?>" style="padding: 0.5rem 1.25rem; font-size: 0.875rem;">
          <?= $cat; ?>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Gallery Grid with Lightbox Data Attributes -->
    <div class="gallery-grid" style="margin-bottom: 4rem;">
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

    <!-- Video Section -->
    <div class="section-header">
      <span class="section-tag">Multimedia</span>
      <h2 class="section-title">Dokumentasi Video</h2>
      <p class="section-desc">Tayangan video edukasi, profil pelayanan, dan sosialisasi program kesehatan Puskesmas Carita.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.75rem;">
      <?php foreach ($videos as $vid): ?>
        <div style="background: #ffffff; border-radius: var(--radius-lg); border: 1px solid var(--pkm-border); overflow: hidden; box-shadow: var(--shadow-sm);">
          <div style="position: relative; padding-bottom: 56.25%; height: 0;">
            <iframe 
              style="position: absolute; top:0; left: 0; width: 100%; height: 100%; border:0;"
              src="https://www.youtube-nocookie.com/embed/<?= htmlspecialchars($vid['youtube_id']); ?>?rel=0" 
              title="<?= htmlspecialchars($vid['title']); ?>" 
              allowfullscreen>
            </iframe>
          </div>
          <div style="padding: 1.25rem;">
            <span class="badge-pill badge-mint" style="font-size: 0.75rem; margin-bottom: 0.4rem;">
              <?= htmlspecialchars($vid['category']); ?>
            </span>
            <h4 style="font-size: 1.05rem; margin-bottom: 0.4rem; color: #064e3b;"><?= htmlspecialchars($vid['title']); ?></h4>
            <p style="color: #64748b; font-size: 0.85rem; margin-bottom: 0;"><?= htmlspecialchars($vid['description']); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
