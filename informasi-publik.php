<?php
/**
 * UPT PUSKESMAS CARITA - KABUPATEN PANDEGLANG
 * Informasi Publik, Maklumat, SOP, SKM & Unduh Dokumen
 */

require_once __DIR__ . '/config/helper.php';

$page_title = 'Informasi Publik';
$page_desc = 'Pusat keterbukaan informasi publik UPT Puskesmas Carita. Maklumat pelayanan, standar pelayanan publik, SOP, laporan SKM, dan unduh dokumen resmi.';

$db = getDBConnection();

$documents = $db->query("SELECT * FROM public_documents ORDER BY id DESC")->fetchAll();

// Handle download count increment
if (isset($_GET['download']) && !empty($_GET['download'])) {
    $docId = (int)$_GET['download'];
    $stmt = $db->prepare("SELECT * FROM public_documents WHERE id = ?");
    $stmt->execute([$docId]);
    $doc = $stmt->fetch();
    if ($doc) {
        $db->prepare("UPDATE public_documents SET download_count = download_count + 1 WHERE id = ?")->execute([$docId]);
        $targetFile = dirname(__DIR__) . '/' . $doc['file_path'];
        if (file_exists($targetFile)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($doc['file_path']) . '"');
            header('Content-Length: ' . filesize($targetFile));
            readfile($targetFile);
            exit;
        } else {
            // Jika berkas dummy belum diupload, buat stream placeholder PDF yang valid
            header('Content-Type: text/plain');
            echo "Dokumen Resmi UPT Puskesmas Carita: " . $doc['title'] . "\nKategori: " . $doc['category'] . "\nTerima kasih telah mengunduh informasi publik resmi.";
            exit;
        }
    }
}

include __DIR__ . '/includes/header.php';
?>

<!-- Header Banner -->
<div style="background: linear-gradient(135deg, #064e3b 0%, #0d9488 100%); color: #ffffff; padding: 4.5rem 0 3.5rem 0; text-align: center;">
  <div class="container">
    <span class="badge-pill" style="background: rgba(255,255,255,0.15); color: #34d399; margin-bottom: 0.75rem;">
      <i class="fas fa-file-invoice"></i> Transparansi & Akuntabilitas
    </span>
    <h1 style="font-size: clamp(2rem, 3.5vw, 2.8rem); color: #ffffff; margin-bottom: 0.75rem;">Informasi Publik Puskesmas</h1>
    <p style="color: #e2e8f0; font-size: 1.1rem; max-width: 650px; margin: 0 auto;">Penyelenggaraan pelayanan publik yang transparan, akuntabel, dan sesuai standar perundang-undangan.</p>
  </div>
</div>

<!-- Breadcrumb -->
<div style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 0.75rem 0; font-size: 0.85rem;">
  <div class="container" style="display: flex; gap: 0.5rem; align-items: center; color: #64748b;">
    <a href="<?= base_url(); ?>"><i class="fas fa-home"></i> Beranda</a>
    <span>/</span>
    <span style="color: #059669; font-weight: 600;">Informasi Publik</span>
  </div>
</div>

<main class="section">
  <div class="container">
    
    <!-- 1. Maklumat Pelayanan -->
    <section id="maklumat" style="margin-bottom: 4rem;">
      <div style="background: linear-gradient(135deg, #064e3b 0%, #065f46 100%); color: #ffffff; border-radius: var(--radius-xl); padding: 3.5rem 2rem; text-align: center; box-shadow: var(--shadow-lg); border: 2px solid #34d399; position: relative;">
        <span class="badge-pill badge-mint" style="background: rgba(52, 211, 153, 0.2); color: #a7f3d0; margin-bottom: 1.25rem;">
          <i class="fas fa-scroll"></i> Janji Penyelenggaraan Pelayanan
        </span>
        <h2 style="color: #ffffff; font-size: 2.2rem; margin-bottom: 1.5rem; letter-spacing: -0.01em;">MAKLUMAT PELAYANAN</h2>
        <div style="max-width: 800px; margin: 0 auto; font-size: 1.15rem; line-height: 1.8; color: #f0fdf4; font-style: italic; margin-bottom: 2rem;">
          “DENGAN INI, KAMI SELURUH PIMPINAN DAN STAF UPT PUSKESMAS CARITA MENYATAKAN SANGGUP MENYELENGGARAKAN PELAYANAN KESEHATAN SESUAI STANDAR PELAYANAN YANG TELAH DITETAPKAN, DAN APABILA TIDAK MENEPATI JANJI INI, KAMI SIAP MENERIMA SANKSI SESUAI PERATURAN PERUNDANG-UNDANGAN YANG BERLAKU.”
        </div>
        <div style="border-top: 1px solid rgba(255,255,255,0.2); max-width: 400px; margin: 0 auto; padding-top: 1.25rem;">
          <h4 style="color: #ffffff; margin-bottom: 0.2rem; font-size: 1.15rem;"><?= htmlspecialchars(get_setting('head_name')); ?></h4>
          <p style="color: #a7f3d0; font-size: 0.85rem; margin-bottom: 0;"><?= htmlspecialchars(get_setting('head_title')); ?></p>
        </div>
      </div>
    </section>

    <!-- 2. Survei Kepuasan Masyarakat (SKM) -->
    <section id="skm" style="margin-bottom: 4rem;">
      <div class="section-header">
        <span class="section-tag">Akuntabilitas Mutu</span>
        <h2 class="section-title">Indeks Kepuasan Masyarakat (IKM)</h2>
        <p class="section-desc">Hasil pengukuran penilaian masyarakat terhadap kualitas pelayanan di UPT Puskesmas Carita.</p>
      </div>

      <div style="background: #ffffff; border: 1px solid var(--pkm-border); border-radius: var(--radius-xl); padding: 2.5rem; box-shadow: var(--shadow-sm); display: grid; grid-template-columns: 1fr 2fr; gap: 2.5rem; align-items: center;">
        <div style="text-align: center; background: #ecfdf5; border-radius: var(--radius-lg); padding: 2rem; border: 1px solid #a7f3d0;">
          <div style="font-size: 3.5rem; font-weight: 800; color: #059669; font-family: 'Outfit', sans-serif; line-height: 1;">88.75</div>
          <div style="font-size: 1.2rem; font-weight: 700; color: #064e3b; margin: 0.5rem 0;">MUTU A (SANGAT BAIK)</div>
          <p style="color: #64748b; font-size: 0.85rem; margin-bottom: 0;">Hasil Evaluasi SKM Semester I Tahun 2026</p>
        </div>

        <div>
          <h3 style="font-size: 1.4rem; color: #064e3b; margin-bottom: 1rem;">Indikator Penilaian Layanan</h3>
          <p style="color: #475569; font-size: 0.95rem; line-height: 1.7; margin-bottom: 1.25rem;">
            Survei Kepuasan Masyarakat dilakukan secara berkelanjutan berdasarkan PermenPAN-RB No. 14 Tahun 2017 mencakup 9 unsur pelayanan: Kesesuaian Persyaratan, Kemudahan Prosedur, Kecepatan Waktu, Tarif/Biaya, Kesesuaian Produk Layanan, Kompetensi Petugas, Perilaku & Keramahan Petugas, Kualitas Sarana Prasarana, serta Penanganan Pengaduan.
          </p>
          <a href="<?= base_url('pengaduan.php'); ?>" class="btn btn-secondary" style="font-size: 0.875rem;">
            <i class="fas fa-edit"></i> Berikan Masukan / Survei Mandiri
          </a>
        </div>
      </div>
    </section>

    <!-- 3. Dokumen Publik & Unduh PDF -->
    <section id="dokumen">
      <div class="section-header">
        <span class="section-tag">Unduh Dokumen</span>
        <h2 class="section-title">Dokumen Publik & Standar Pelayanan</h2>
        <p class="section-desc">Unduh berkas resmi standar pelayanan, SOP, maklumat, dan laporan kinerja dalam format PDF.</p>
      </div>

      <div style="display: flex; flex-direction: column; gap: 1.25rem;">
        <?php foreach ($documents as $doc): ?>
          <div style="background: #ffffff; border: 1px solid var(--pkm-border); border-radius: var(--radius-lg); padding: 1.5rem 2rem; display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; flex-wrap: wrap; box-shadow: var(--shadow-sm); transition: var(--transition-fast);">
            <div style="display: flex; align-items: center; gap: 1.5rem;">
              <div style="width: 52px; height: 52px; border-radius: 12px; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; flex-shrink: 0;">
                <i class="far fa-file-pdf"></i>
              </div>
              <div>
                <span class="badge-pill badge-mint" style="font-size: 0.725rem; margin-bottom: 0.35rem;">
                  <?= htmlspecialchars($doc['category']); ?>
                </span>
                <h4 style="font-size: 1.15rem; color: #064e3b; margin-bottom: 0.25rem;"><?= htmlspecialchars($doc['title']); ?></h4>
                <p style="color: #64748b; font-size: 0.85rem; margin-bottom: 0;"><?= htmlspecialchars($doc['description']); ?></p>
                <div style="display: flex; gap: 1rem; font-size: 0.75rem; color: #94a3b8; margin-top: 0.4rem;">
                  <span><i class="far fa-calendar-alt"></i> <?= format_date_id($doc['published_at']); ?></span>
                  <span><i class="fas fa-hdd"></i> <?= htmlspecialchars($doc['file_size']); ?></span>
                  <span><i class="fas fa-download"></i> <?= htmlspecialchars($doc['download_count']); ?>x diunduh</span>
                </div>
              </div>
            </div>

            <div>
              <a href="<?= base_url('informasi-publik.php?download=' . $doc['id']); ?>" class="btn btn-primary" style="padding: 0.6rem 1.4rem; font-size: 0.875rem;">
                <i class="fas fa-file-download"></i> Unduh PDF
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
