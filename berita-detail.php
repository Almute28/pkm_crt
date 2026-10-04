<?php
/**
 * UPT PUSKESMAS CARITA - KABUPATEN PANDEGLANG
 * Detail Berita & Kegiatan
 */

require_once __DIR__ . '/config/helper.php';

$slug = sanitize($_GET['slug'] ?? '');
if (empty($slug)) {
    header('Location: ' . base_url('berita.php'));
    exit;
}

$db = getDBConnection();

$stmt = $db->prepare("SELECT * FROM news WHERE slug = ? AND status = 'published'");
$stmt->execute([$slug]);
$news = $stmt->fetch();

if (!$news) {
    header('Location: ' . base_url('berita.php'));
    exit;
}

// Increment views
$db->prepare("UPDATE news SET views = views + 1 WHERE id = ?")->execute([$news['id']]);

$page_title = $news['title'];
$page_desc = $news['excerpt'];

// Fetch related news
$relatedStmt = $db->prepare("SELECT * FROM news WHERE category = ? AND id != ? AND status = 'published' ORDER BY published_at DESC LIMIT 3");
$relatedStmt->execute([$news['category'], $news['id']]);
$related = $relatedStmt->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<!-- Breadcrumb -->
<div style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 0.75rem 0; font-size: 0.85rem;">
  <div class="container" style="display: flex; gap: 0.5rem; align-items: center; color: #64748b;">
    <a href="<?= base_url(); ?>"><i class="fas fa-home"></i> Beranda</a>
    <span>/</span>
    <a href="<?= base_url('berita.php'); ?>">Berita & Kegiatan</a>
    <span>/</span>
    <span style="color: #059669; font-weight: 600;"><?= htmlspecialchars(substr($news['title'], 0, 40)) . '...'; ?></span>
  </div>
</div>

<main class="section">
  <div class="container">
    <div style="display: grid; grid-template-columns: 2.2fr 1fr; gap: 3.5rem; align-items: start;">
      
      <!-- Article Content -->
      <article style="background: #ffffff; border-radius: var(--radius-xl); border: 1px solid var(--pkm-border); padding: 2.5rem; box-shadow: var(--shadow-sm);">
        <span class="badge-pill badge-mint" style="margin-bottom: 1rem;">
          <i class="fas fa-tag"></i> <?= htmlspecialchars($news['category']); ?>
        </span>

        <h1 style="font-size: clamp(1.8rem, 3vw, 2.4rem); color: #064e3b; margin-bottom: 1rem; line-height: 1.3;">
          <?= htmlspecialchars($news['title']); ?>
        </h1>

        <div style="display: flex; flex-wrap: wrap; gap: 1.25rem; font-size: 0.85rem; color: #64748b; padding-bottom: 1.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0;">
          <span><i class="far fa-calendar-alt" style="color: #059669;"></i> <?= format_date_id($news['published_at'], true); ?></span>
          <span><i class="far fa-user" style="color: #059669;"></i> Oleh: <?= htmlspecialchars($news['author']); ?></span>
          <span><i class="far fa-eye" style="color: #059669;"></i> <?= htmlspecialchars($news['views'] + 1); ?> kali dibaca</span>
        </div>

        <div style="margin-bottom: 2rem;">
          <img src="<?= base_url($news['thumbnail']); ?>" alt="<?= htmlspecialchars($news['title']); ?>" style="width: 100%; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
        </div>

        <div style="font-size: 1.05rem; line-height: 1.85; color: #334155; margin-bottom: 2.5rem;">
          <?= nl2br(htmlspecialchars($news['content'])); ?>
        </div>

        <!-- Share Buttons -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: var(--radius-lg); padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
          <span style="font-weight: 700; color: #064e3b; font-size: 0.9rem;">
            <i class="fas fa-share-alt"></i> Bagikan Berita Ini:
          </span>
          <div style="display: flex; gap: 0.5rem;">
            <?php 
              $currentUrl = urlencode(base_url('berita-detail.php?slug=' . $news['slug']));
              $titleEnc = urlencode($news['title']);
            ?>
            <a href="https://api.whatsapp.com/send?text=<?= $titleEnc . '%20' . $currentUrl; ?>" target="_blank" rel="noopener" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem; background: #25d366; color: #ffffff; border-color: #25d366;">
              <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $currentUrl; ?>" target="_blank" rel="noopener" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem; background: #1877f2; color: #ffffff; border-color: #1877f2;">
              <i class="fab fa-facebook-f"></i> Facebook
            </a>
            <a href="https://twitter.com/intent/tweet?text=<?= $titleEnc; ?>&url=<?= $currentUrl; ?>" target="_blank" rel="noopener" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem; background: #0f172a; color: #ffffff; border-color: #0f172a;">
              <i class="fab fa-x-twitter"></i> X
            </a>
          </div>
        </div>
      </article>

      <!-- Sidebar -->
      <aside style="position: sticky; top: 100px;">
        <div style="background: #ffffff; border: 1px solid var(--pkm-border); border-radius: var(--radius-xl); padding: 1.75rem; box-shadow: var(--shadow-sm); margin-bottom: 2rem;">
          <h4 style="font-size: 1.15rem; color: #064e3b; margin-bottom: 1.25rem; border-bottom: 2px solid #ecfdf5; padding-bottom: 0.5rem;">
            Berita Terkait
          </h4>

          <?php if (empty($related)): ?>
            <p style="color: #94a3b8; font-size: 0.85rem;">Belum ada berita terkait lainnya.</p>
          <?php else: ?>
            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
              <?php foreach ($related as $rel): ?>
                <div style="display: flex; gap: 1rem; align-items: center;">
                  <img src="<?= base_url($rel['thumbnail']); ?>" alt="" style="width: 70px; height: 70px; object-fit: cover; border-radius: var(--radius-md); flex-shrink: 0;">
                  <div>
                    <h5 style="font-size: 0.875rem; line-height: 1.4; margin-bottom: 0.25rem;">
                      <a href="<?= base_url('berita-detail.php?slug=' . urlencode($rel['slug'])); ?>" style="color: #1e293b;">
                        <?= htmlspecialchars(substr($rel['title'], 0, 50)) . '...'; ?>
                      </a>
                    </h5>
                    <span style="font-size: 0.75rem; color: #94a3b8;"><i class="far fa-calendar-alt"></i> <?= format_date_id($rel['published_at']); ?></span>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>

        <!-- Floating Emergency Helpline -->
        <div style="background: linear-gradient(135deg, #064e3b, #047857); border-radius: var(--radius-xl); padding: 2rem; color: #ffffff; text-align: center;">
          <i class="fas fa-stethoscope" style="font-size: 2rem; color: #34d399; margin-bottom: 0.75rem;"></i>
          <h4 style="color: #ffffff; margin-bottom: 0.5rem;">Punya Pertanyaan Medis?</h4>
          <p style="color: #cbd5e1; font-size: 0.85rem; margin-bottom: 1.25rem;">Petugas piket dan admin layanan Puskesmas Carita siap membantu Anda.</p>
          <a href="https://wa.me/62<?= ltrim(preg_replace('/[^0-9]/', '', get_setting('whatsapp')), '0'); ?>" target="_blank" rel="noopener" class="btn btn-outline-white" style="width: 100%; border-radius: var(--radius-md);">
            <i class="fab fa-whatsapp"></i> Chat Petugas
          </a>
        </div>
      </aside>

    </div>
  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
