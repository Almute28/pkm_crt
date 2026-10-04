<?php
/**
 * UPT PUSKESMAS CARITA - KABUPATEN PANDEGLANG
 * Portal Berita & Kegiatan
 */

require_once __DIR__ . '/config/helper.php';

$page_title = 'Berita & Kegiatan';
$page_desc = 'Warta resmi, kegiatan pelayanan lapangan, pengumuman, dan artikel kesehatan UPT Puskesmas Carita Kabupaten Pandeglang.';

$db = getDBConnection();

$category = sanitize($_GET['kategori'] ?? 'all');
$search = sanitize($_GET['q'] ?? '');
$page = max(1, (int)($_GET['p'] ?? 1));
$perPage = 6;
$offset = ($page - 1) * $perPage;

$whereClause = "WHERE status = 'published'";
$params = [];

if ($category !== 'all' && !empty($category)) {
    $whereClause .= " AND category = ?";
    $params[] = $category;
}

if (!empty($search)) {
    $whereClause .= " AND (title LIKE ? OR content LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

// Count total
$countStmt = $db->prepare("SELECT COUNT(*) FROM news $whereClause");
$countStmt->execute($params);
$totalRows = $countStmt->fetchColumn();
$totalPages = ceil($totalRows / $perPage);

// Fetch news items
$stmt = $db->prepare("SELECT * FROM news $whereClause ORDER BY published_at DESC LIMIT $perPage OFFSET $offset");
$stmt->execute($params);
$news_items = $stmt->fetchAll();

$categories = ['Berita', 'Kegiatan', 'Pengumuman', 'Program', 'Pelayanan'];

include __DIR__ . '/includes/header.php';
?>

<!-- Header Banner -->
<div style="background: linear-gradient(135deg, #064e3b 0%, #059669 100%); color: #ffffff; padding: 4.5rem 0 3.5rem 0; text-align: center;">
  <div class="container">
    <span class="badge-pill" style="background: rgba(255,255,255,0.15); color: #34d399; margin-bottom: 0.75rem;">
      <i class="far fa-newspaper"></i> Publikasi Terkini
    </span>
    <h1 style="font-size: clamp(2rem, 3.5vw, 2.8rem); color: #ffffff; margin-bottom: 0.75rem;">Berita & Kegiatan Puskesmas</h1>
    <p style="color: #e2e8f0; font-size: 1.1rem; max-width: 650px; margin: 0 auto;">Pusat informasi kegiatan medis, program posyandu desa, dan pengumuman resmi UPT Puskesmas Carita.</p>
  </div>
</div>

<!-- Breadcrumb -->
<div style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 0.75rem 0; font-size: 0.85rem;">
  <div class="container" style="display: flex; gap: 0.5rem; align-items: center; color: #64748b;">
    <a href="<?= base_url(); ?>"><i class="fas fa-home"></i> Beranda</a>
    <span>/</span>
    <span style="color: #059669; font-weight: 600;">Berita & Kegiatan</span>
  </div>
</div>

<main class="section">
  <div class="container">
    <!-- Filter & Search Bar -->
    <div class="table-filter-bar" style="margin-bottom: 2.5rem;">
      <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center;">
        <a href="<?= base_url('berita.php'); ?>" class="btn <?= $category === 'all' ? 'btn-primary' : 'btn-secondary'; ?>" style="padding: 0.45rem 1rem; font-size: 0.85rem;">
          Semua (<?= $totalRows; ?>)
        </a>
        <?php foreach ($categories as $cat): ?>
          <a href="<?= base_url('berita.php?kategori=' . urlencode($cat)); ?>" class="btn <?= $category === $cat ? 'btn-primary' : 'btn-secondary'; ?>" style="padding: 0.45rem 1rem; font-size: 0.85rem;">
            <?= $cat; ?>
          </a>
        <?php endforeach; ?>
      </div>

      <!-- Search Form -->
      <form action="<?= base_url('berita.php'); ?>" method="GET" style="display: flex; gap: 0.5rem;">
        <?php if ($category !== 'all'): ?>
          <input type="hidden" name="kategori" value="<?= htmlspecialchars($category); ?>">
        <?php endif; ?>
        <div class="search-input-wrap" style="min-width: 220px;">
          <i class="fas fa-search"></i>
          <input type="text" name="q" value="<?= htmlspecialchars($search); ?>" placeholder="Cari judul berita...">
        </div>
        <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
          Cari
        </button>
      </form>
    </div>

    <!-- News Grid -->
    <?php if (empty($news_items)): ?>
      <div style="text-align: center; padding: 4rem 1rem; background: #ffffff; border-radius: var(--radius-xl); border: 1px solid var(--pkm-border);">
        <i class="far fa-newspaper" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem; display: block;"></i>
        <h3 style="color: #64748b; margin-bottom: 0.5rem;">Tidak Ada Berita Ditemukan</h3>
        <p style="color: #94a3b8; font-size: 0.9rem;">Coba ganti kata kunci pencarian atau pilih kategori lain.</p>
        <a href="<?= base_url('berita.php'); ?>" class="btn btn-secondary" style="margin-top: 1rem;">Lihat Semua Berita</a>
      </div>
    <?php else: ?>
      <div class="news-grid">
        <?php foreach ($news_items as $item): ?>
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
                <span><i class="far fa-eye"></i> <?= htmlspecialchars($item['views']); ?>x</span>
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

      <!-- Pagination -->
      <?php if ($totalPages > 1): ?>
        <div style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 3.5rem;">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= base_url('berita.php?p=' . $i . ($category !== 'all' ? '&kategori=' . urlencode($category) : '') . (!empty($search) ? '&q=' . urlencode($search) : '')); ?>" 
               class="btn <?= $page === $i ? 'btn-primary' : 'btn-secondary'; ?>" 
               style="width: 42px; height: 42px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: var(--radius-md);">
              <?= $i; ?>
            </a>
          <?php endfor; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>

  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
