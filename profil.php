<?php
/**
 * UPT PUSKESMAS CARITA - KABUPATEN PANDEGLANG
 * Halaman Profil Lengkap
 */

require_once __DIR__ . '/config/helper.php';

$page_title = 'Profil Puskesmas';
$page_desc = 'Profil resmi UPT Puskesmas Carita Kabupaten Pandeglang. Visi, misi, tata nilai, struktur organisasi, dan wilayah kerja binaan.';

$db = getDBConnection();

$head_name = get_setting('head_name', 'Mahmudi, S.Kep., Ners');
$head_title = get_setting('head_title', 'Kepala UPT Puskesmas Carita');
$head_speech = get_setting('head_speech');
$head_photo = get_setting('head_photo', 'assets/img/kepala-puskesmas.jpg');
$hero_img = get_setting('hero_image', 'assets/img/hero-puskesmas.jpg');

$stats_nakes = get_setting('stats_nakes', '42');
$stats_services = get_setting('stats_services', '18');
$stats_programs = get_setting('stats_programs', '14');
$stats_villages = get_setting('stats_villages', '10');

// Page content from database
$stmt = $db->prepare("SELECT * FROM pages WHERE slug = 'profil'");
$stmt->execute();
$pageData = $stmt->fetch();

include __DIR__ . '/includes/header.php';
?>

<!-- Page Header Banner -->
<div style="background: linear-gradient(135deg, #064e3b 0%, #0d9488 100%); color: #ffffff; padding: 4.5rem 0 3.5rem 0; text-align: center; position: relative;">
  <div class="container">
    <span class="badge-pill" style="background: rgba(255,255,255,0.15); color: #34d399; margin-bottom: 0.75rem;">
      <i class="fas fa-landmark"></i> Tentang Instansi
    </span>
    <h1 style="font-size: clamp(2rem, 3.5vw, 2.8rem); color: #ffffff; margin-bottom: 0.75rem;">Profil UPT Puskesmas Carita</h1>
    <p style="color: #e2e8f0; font-size: 1.1rem; max-width: 650px; margin: 0 auto;">Puskesmas Carita Kabupaten Pandeglang &bull; Motto: “Carita Wisata Sehat”</p>
  </div>
</div>

<!-- Breadcrumb -->
<div style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 0.75rem 0; font-size: 0.85rem;">
  <div class="container" style="display: flex; gap: 0.5rem; align-items: center; color: #64748b;">
    <a href="<?= base_url(); ?>"><i class="fas fa-home"></i> Beranda</a>
    <span>/</span>
    <span style="color: #059669; font-weight: 600;">Profil Puskesmas</span>
  </div>
</div>

<main class="section">
  <div class="container">
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 3rem; align-items: start;">
      <!-- Main Content -->
      <div>
        <!-- 1. Tentang -->
        <section id="tentang" style="margin-bottom: 3.5rem;">
          <span class="section-tag">Gambaran Umum</span>
          <h2 style="font-size: 2rem; margin-bottom: 1rem;">Mengenal UPT Puskesmas Carita</h2>
          <p style="font-size: 1.05rem; line-height: 1.8; color: #475569; margin-bottom: 1.5rem;">
            <?= htmlspecialchars(get_setting('about_summary')); ?>
          </p>
          <img src="<?= base_url($hero_img); ?>" alt="UPT Puskesmas Carita" style="border-radius: var(--radius-lg); width: 100%; box-shadow: var(--shadow-md); margin-bottom: 1.5rem;">
          <p style="font-size: 1rem; line-height: 1.8; color: #475569;">
            Sebagai puskesmas yang berada di sentra destinasi pariwisata bahari Selat Sunda, Puskesmas Carita memiliki peran ganda yang strategis: menyelenggarakan pelayanan kesehatan tingkat pertama bagi warga pemukiman di 10 desa binaan, sekaligus menjadi rujukan utama kesiapsiagaan medis bagi ribuan wisatawan nusantara dan mancanegara yang berkunjung ke kawasan pantai Carita.
          </p>
        </section>

        <!-- 2. Visi & Misi & Tata Nilai -->
        <section id="visi-misi" style="margin-bottom: 3.5rem; background: #ffffff; padding: 2.5rem; border-radius: var(--radius-xl); border: 1px solid var(--pkm-border); box-shadow: var(--shadow-sm);">
          <?php if ($pageData && !empty($pageData['content'])): ?>
            <?= $pageData['content']; ?>
          <?php else: ?>
            <h2 style="color: #064e3b; margin-bottom: 1rem;">Visi & Misi Puskesmas</h2>
            <p><strong>Visi:</strong> Terwujudnya Masyarakat Kecamatan Carita yang Mandiri untuk Hidup Sehat Menuju Carita Wisata Sehat yang Berkualitas dan Berdaya Saing.</p>
          <?php endif; ?>
        </section>

        <!-- 3. Sambutan Kepala -->
        <section id="sambutan" style="margin-bottom: 3.5rem;">
          <span class="section-tag">Kepemimpinan</span>
          <h2 style="font-size: 2rem; margin-bottom: 1.5rem;">Sambutan Kepala UPT Puskesmas Carita</h2>
          <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: var(--radius-xl); padding: 2.5rem; display: flex; gap: 2rem; align-items: center; flex-wrap: wrap;">
            <img src="<?= base_url($head_photo); ?>" alt="Kepala Puskesmas" style="width: 140px; height: 180px; object-fit: cover; border-radius: var(--radius-md); box-shadow: var(--shadow-md);">
            <div style="flex: 1; min-width: 260px;">
              <h3 style="margin-bottom: 0.25rem;"><?= htmlspecialchars($head_name); ?></h3>
              <p style="color: #059669; font-weight: 600; font-size: 0.9rem; margin-bottom: 1rem;"><?= htmlspecialchars($head_title); ?></p>
              <div style="color: #334155; font-size: 0.95rem; line-height: 1.7; font-style: italic;">
                "<?= nl2br(htmlspecialchars($head_speech)); ?>"
              </div>
            </div>
          </div>
        </section>

        <!-- 4. Wilayah Kerja 10 Desa -->
        <section id="wilayah-kerja" style="margin-bottom: 3.5rem;">
          <span class="section-tag">Cakupan Layanan</span>
          <h2 style="font-size: 2rem; margin-bottom: 1rem;">Wilayah Kerja 10 Desa</h2>
          <p style="color: #475569; margin-bottom: 1.5rem;">Puskesmas Carita mengampu 10 desa di wilayah administratif Kecamatan Carita dengan karakteristik geografis pesisir dan dataran:</p>
          
          <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1rem;">
            <?php 
              $desaList = [
                ['Desa Carita', 'Sentra Pemerintahan & Kawasan Pantai Utama'],
                ['Desa Sukarame', 'Kawasan Pemukiman Nelayan & Pesisir'],
                ['Desa Banjarmasin', 'Pemukiman Masyarakat & Sentra Kerajinan'],
                ['Desa Pejamben', 'Wilayah Agraris & Perkebunan'],
                ['Desa Cinoyong', 'Kawasan Perbukitan & Pertanian'],
                ['Desa Sindang Laut', 'Area Pesisir & Konservasi Bahari'],
                ['Desa Sukanagara', 'Pemukiman Warga & Sentra Pertanian'],
                ['Desa Tembong', 'Kawasan Dataran & Perbukitan Sejuk'],
                ['Desa Kawoyang', 'Wilayah Binaan Posyandu Terpadu'],
                ['Desa Sukajadi', 'Wilayah Perbatasan & Perkebunan'],
              ];
              foreach ($desaList as $d):
            ?>
              <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: var(--radius-md); padding: 1.2rem; border-left: 4px solid var(--pkm-primary); box-shadow: var(--shadow-sm);">
                <h4 style="font-size: 1rem; margin-bottom: 0.2rem;"><?= $d[0]; ?></h4>
                <p style="font-size: 0.8rem; color: #64748b; margin-bottom: 0;"><?= $d[1]; ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        </section>

        <!-- 5. Struktur Organisasi -->
        <section id="struktur">
          <span class="section-tag">Tata Kelola</span>
          <h2 style="font-size: 2rem; margin-bottom: 1rem;">Struktur Organisasi</h2>
          <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: var(--radius-xl); padding: 2rem; text-align: center; box-shadow: var(--shadow-sm);">
            <div style="background: #ecfdf5; border: 2px solid #059669; border-radius: var(--radius-md); padding: 1rem; max-width: 320px; margin: 0 auto 1.5rem auto;">
              <h4 style="margin-bottom: 0.2rem; color: #064e3b;">Kepala UPT Puskesmas</h4>
              <p style="margin-bottom: 0; font-weight: 700; color: #059669;"><?= htmlspecialchars($head_name); ?></p>
            </div>

            <div style="width: 2px; height: 24px; background: #059669; margin: 0 auto 1.5rem auto;"></div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
              <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: var(--radius-md); padding: 0.85rem;">
                <h5 style="font-size: 0.9rem; margin-bottom: 0.2rem;">Kasubag Tata Usaha</h5>
                <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 0;">Administrasi & Kepegawaian</p>
              </div>
              <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: var(--radius-md); padding: 0.85rem;">
                <h5 style="font-size: 0.9rem; margin-bottom: 0.2rem;">PJ UKM Essensial</h5>
                <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 0;">Promkes, KIA, Gizi, Kesling, P2P</p>
              </div>
              <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: var(--radius-md); padding: 0.85rem;">
                <h5 style="font-size: 0.9rem; margin-bottom: 0.2rem;">PJ UKP, Farmasi & Lab</h5>
                <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 0;">Rawat Jalan, UGD, PONED</p>
              </div>
              <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: var(--radius-md); padding: 0.85rem;">
                <h5 style="font-size: 0.9rem; margin-bottom: 0.2rem;">PJ Jejaring Pelayanan</h5>
                <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 0;">Pustu & Posyandu 10 Desa</p>
              </div>
            </div>
          </div>
        </section>
      </div>

      <!-- Sidebar Quick Links -->
      <aside style="position: sticky; top: 100px;">
        <div style="background: #ffffff; border: 1px solid var(--pkm-border); border-radius: var(--radius-xl); padding: 1.75rem; box-shadow: var(--shadow-sm); margin-bottom: 1.5rem;">
          <h4 style="margin-bottom: 1rem; font-size: 1.15rem; color: #064e3b; border-bottom: 2px solid #ecfdf5; padding-bottom: 0.5rem;">Navigasi Profil</h4>
          <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.6rem;">
            <li><a href="#tentang" style="display: flex; align-items: center; gap: 0.5rem; color: #475569; font-weight: 500;"><i class="fas fa-chevron-right" style="color: #059669; font-size: 0.75rem;"></i> Gambaran Umum</a></li>
            <li><a href="#visi-misi" style="display: flex; align-items: center; gap: 0.5rem; color: #475569; font-weight: 500;"><i class="fas fa-chevron-right" style="color: #059669; font-size: 0.75rem;"></i> Visi & Misi & Nilai</a></li>
            <li><a href="#sambutan" style="display: flex; align-items: center; gap: 0.5rem; color: #475569; font-weight: 500;"><i class="fas fa-chevron-right" style="color: #059669; font-size: 0.75rem;"></i> Sambutan Kepala</a></li>
            <li><a href="#wilayah-kerja" style="display: flex; align-items: center; gap: 0.5rem; color: #475569; font-weight: 500;"><i class="fas fa-chevron-right" style="color: #059669; font-size: 0.75rem;"></i> Wilayah Kerja 10 Desa</a></li>
            <li><a href="#struktur" style="display: flex; align-items: center; gap: 0.5rem; color: #475569; font-weight: 500;"><i class="fas fa-chevron-right" style="color: #059669; font-size: 0.75rem;"></i> Struktur Organisasi</a></li>
          </ul>
        </div>

        <!-- Quick Contacts Card -->
        <div style="background: linear-gradient(135deg, #064e3b, #047857); color: #ffffff; border-radius: var(--radius-xl); padding: 2rem; text-align: center;">
          <i class="fas fa-phone-volume" style="font-size: 2.2rem; color: #34d399; margin-bottom: 0.75rem;"></i>
          <h4 style="color: #ffffff; margin-bottom: 0.5rem;">Layanan Gawat Darurat</h4>
          <p style="color: #cbd5e1; font-size: 0.85rem; margin-bottom: 1.25rem;">UGD & PONED Puskesmas Carita melayani 24 Jam Nonstop.</p>
          <a href="tel:<?= preg_replace('/[^0-9]/', '', get_setting('emergency_phone')); ?>" class="btn btn-outline-white" style="width: 100%; border-radius: var(--radius-md);">
            <i class="fas fa-ambulance"></i> <?= htmlspecialchars(get_setting('emergency_phone')); ?>
          </a>
        </div>
      </aside>
    </div>
  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
