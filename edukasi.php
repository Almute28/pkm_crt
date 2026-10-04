<?php
/**
 * UPT PUSKESMAS CARITA - KABUPATEN PANDEGLANG
 * Artikel Edukasi Kesehatan Masyarakat
 */

require_once __DIR__ . '/config/helper.php';

$page_title = 'Edukasi Kesehatan';
$page_desc = 'Pojok artikel dan panduan edukasi kesehatan masyarakat dari tim medis UPT Puskesmas Carita. Stunting, DBD, TBC, Hipertensi, dan PHBS.';

$db = getDBConnection();

$topic = sanitize($_GET['topik'] ?? 'all');
$singleSlug = sanitize($_GET['slug'] ?? '');

// If viewing a specific article
$singleArticle = null;
if (!empty($singleSlug)) {
    $stmt = $db->prepare("SELECT * FROM articles WHERE slug = ? AND status = 'published'");
    $stmt->execute([$singleSlug]);
    $singleArticle = $stmt->fetch();
    if ($singleArticle) {
        $db->prepare("UPDATE articles SET views = views + 1 WHERE id = ?")->execute([$singleArticle['id']]);
        $page_title = $singleArticle['title'];
    }
}

// Fetch list of articles
$where = "WHERE status = 'published'";
$params = [];
if ($topic !== 'all' && !empty($topic)) {
    $where .= " AND topic = ?";
    $params[] = $topic;
}

$stmt = $db->prepare("SELECT * FROM articles $where ORDER BY published_at DESC");
$stmt->execute($params);
$articles = $stmt->fetchAll();

$topics = ['Cek Kesehatan Gratis', 'TBC', 'DBD', 'Hipertensi', 'Stunting', 'PHBS', 'Imunisasi'];

include __DIR__ . '/includes/header.php';
?>

<!-- Header Banner -->
<div style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #ffffff; padding: 4.5rem 0 3.5rem 0; text-align: center;">
  <div class="container">
    <span class="badge-pill" style="background: rgba(255,255,255,0.15); color: #bae6fd; margin-bottom: 0.75rem;">
      <i class="fas fa-book-medical"></i> Promosi & Pencegahan
    </span>
    <h1 style="font-size: clamp(2rem, 3.5vw, 2.8rem); color: #ffffff; margin-bottom: 0.75rem;">Edukasi Kesehatan Masyarakat</h1>
    <p style="color: #e0f2fe; font-size: 1.1rem; max-width: 650px; margin: 0 auto;">Informasi ilmiah terpercaya untuk mewujudkan masyarakat Kecamatan Carita yang sadar, mandiri, dan berdaya hidup sehat.</p>
  </div>
</div>

<!-- Breadcrumb -->
<div style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 0.75rem 0; font-size: 0.85rem;">
  <div class="container" style="display: flex; gap: 0.5rem; align-items: center; color: #64748b;">
    <a href="<?= base_url(); ?>"><i class="fas fa-home"></i> Beranda</a>
    <span>/</span>
    <a href="<?= base_url('edukasi.php'); ?>">Edukasi Kesehatan</a>
    <?php if ($singleArticle): ?>
      <span>/</span>
      <span style="color: #0284c7; font-weight: 600;"><?= htmlspecialchars(substr($singleArticle['title'], 0, 35)) . '...'; ?></span>
    <?php endif; ?>
  </div>
</div>

<main class="section">
  <div class="container">
    
    <?php if ($singleArticle): ?>
      <!-- Single Article Reader -->
      <article style="max-width: 860px; margin: 0 auto; background: #ffffff; border-radius: var(--radius-xl); border: 1px solid var(--pkm-border); padding: 3rem; box-shadow: var(--shadow-sm);">
        <span class="badge-pill badge-blue" style="margin-bottom: 1rem;">
          <i class="fas fa-heartbeat"></i> Topik: <?= htmlspecialchars($singleArticle['topic']); ?>
        </span>
        <h1 style="font-size: 2.2rem; color: #064e3b; margin-bottom: 1rem; line-height: 1.3;">
          <?= htmlspecialchars($singleArticle['title']); ?>
        </h1>
        <div style="display: flex; gap: 1.5rem; font-size: 0.85rem; color: #64748b; padding-bottom: 1.25rem; margin-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0;">
          <span><i class="far fa-calendar-alt"></i> <?= format_date_id($singleArticle['published_at']); ?></span>
          <span><i class="far fa-user"></i> Penulis: <?= htmlspecialchars($singleArticle['author']); ?></span>
          <span><i class="far fa-eye"></i> <?= htmlspecialchars($singleArticle['views'] + 1); ?> kali dibaca</span>
        </div>

        <img src="<?= base_url($singleArticle['thumbnail']); ?>" alt="" style="width: 100%; border-radius: var(--radius-lg); margin-bottom: 2rem;">

        <div style="font-size: 1.05rem; line-height: 1.85; color: #334155; margin-bottom: 2.5rem;">
          <?= nl2br(htmlspecialchars($singleArticle['content'])); ?>
        </div>

        <div style="text-align: center; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
          <a href="<?= base_url('edukasi.php'); ?>" class="btn btn-secondary">
            &larr; Kembali ke Semua Artikel Edukasi
          </a>
        </div>
      </article>

    <?php else: ?>
      <!-- Filter Topics -->
      <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 0.5rem; margin-bottom: 3rem;">
        <a href="<?= base_url('edukasi.php'); ?>" class="btn <?= $topic === 'all' ? 'btn-primary' : 'btn-secondary'; ?>" style="padding: 0.45rem 1rem; font-size: 0.85rem;">
          Semua Topik
        </a>
        <?php foreach ($topics as $top): ?>
          <a href="<?= base_url('edukasi.php?topik=' . urlencode($top)); ?>" class="btn <?= $topic === $top ? 'btn-primary' : 'btn-secondary'; ?>" style="padding: 0.45rem 1rem; font-size: 0.85rem;">
            <?= $top; ?>
          </a>
        <?php endforeach; ?>
      </div>

      <!-- Articles Grid -->
      <div class="news-grid">
        <?php foreach ($articles as $art): ?>
          <article class="news-card" style="border-top: 4px solid #0284c7;">
            <div class="news-thumb-wrap">
              <img src="<?= base_url($art['thumbnail']); ?>" alt="<?= htmlspecialchars($art['title']); ?>" class="news-thumb">
              <span class="badge-pill badge-blue news-cat-badge">
                <?= htmlspecialchars($art['topic']); ?>
              </span>
            </div>
            <div class="news-body">
              <div class="news-meta">
                <span><i class="far fa-calendar-alt"></i> <?= format_date_id($art['published_at']); ?></span>
                <span><i class="far fa-eye"></i> <?= htmlspecialchars($art['views']); ?>x</span>
              </div>
              <h3>
                <a href="<?= base_url('edukasi.php?slug=' . urlencode($art['slug'])); ?>">
                  <?= htmlspecialchars($art['title']); ?>
                </a>
              </h3>
              <p><?= htmlspecialchars($art['excerpt']); ?></p>
              <a href="<?= base_url('edukasi.php?slug=' . urlencode($art['slug'])); ?>" class="news-readmore" style="color: #0284c7;">
                Baca Lengkap <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
