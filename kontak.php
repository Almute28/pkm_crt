<?php
/**
 * UPT PUSKESMAS CARITA - KABUPATEN PANDEGLANG
 * Kontak Resmi & Peta Lokasi
 */

require_once __DIR__ . '/config/helper.php';

$page_title = 'Kontak & Lokasi';
$page_desc = 'Hubungi kami dan temukan lokasi UPT Puskesmas Carita Kabupaten Pandeglang. Alamat, nomor telepon, WhatsApp, dan Google Maps.';

$site_title = get_setting('site_title', 'UPT Puskesmas Carita');
$site_sub = get_setting('site_sub', 'Puskesmas Carita Kabupaten Pandeglang');
$phone = get_setting('phone', '(0253) 802100');
$emergency_phone = get_setting('emergency_phone', '0812-8899-7722');
$whatsapp = get_setting('whatsapp', '081288997722');
$email = get_setting('email', 'pkmcarita@pandeglangkab.go.id');
$address = get_setting('address', 'Jl. Raya Labuan - Carita KM. 9, Desa Carita, Kecamatan Carita, Kabupaten Pandeglang, Banten 42264');
$working_hours = get_setting('working_hours');
$maps_embed = get_setting('maps_embed');

include __DIR__ . '/includes/header.php';
?>

<!-- Header Banner -->
<div style="background: linear-gradient(135deg, #064e3b 0%, #059669 100%); color: #ffffff; padding: 4.5rem 0 3.5rem 0; text-align: center;">
  <div class="container">
    <span class="badge-pill" style="background: rgba(255,255,255,0.15); color: #34d399; margin-bottom: 0.75rem;">
      <i class="fas fa-map-marked-alt"></i> Pusat Komunikasi
    </span>
    <h1 style="font-size: clamp(2rem, 3.5vw, 2.8rem); color: #ffffff; margin-bottom: 0.75rem;">Hubungi Kami</h1>
    <p style="color: #e2e8f0; font-size: 1.1rem; max-width: 650px; margin: 0 auto;">Kami siap melayani kebutuhan informasi dan pelayanan kesehatan Anda dengan ramah dan cepat.</p>
  </div>
</div>

<!-- Breadcrumb -->
<div style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 0.75rem 0; font-size: 0.85rem;">
  <div class="container" style="display: flex; gap: 0.5rem; align-items: center; color: #64748b;">
    <a href="<?= base_url(); ?>"><i class="fas fa-home"></i> Beranda</a>
    <span>/</span>
    <span style="color: #059669; font-weight: 600;">Kontak & Lokasi</span>
  </div>
</div>

<main class="section">
  <div class="container">
    <div class="contact-grid" style="margin-bottom: 3.5rem;">
      
      <!-- Contact Details -->
      <div class="contact-card">
        <span class="badge-pill badge-mint" style="margin-bottom: 1rem;">
          <i class="fas fa-hospital"></i> Kantor Pelayanan
        </span>
        <h2 style="font-size: 1.85rem; color: #064e3b; margin-bottom: 0.5rem;"><?= htmlspecialchars($site_title); ?></h2>
        <p style="color: #64748b; margin-bottom: 1.5rem;"><?= htmlspecialchars($site_sub); ?> - Banten</p>

        <div class="contact-list">
          <div class="contact-item">
            <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div class="contact-text">
              <h4>Alamat Lengkap</h4>
              <p><?= htmlspecialchars($address); ?></p>
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
              <h4>UGD & Ambulans 24 Jam Nonstop</h4>
              <p style="color: #dc2626; font-weight: 700;"><?= htmlspecialchars($emergency_phone); ?></p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon"><i class="fab fa-whatsapp"></i></div>
            <div class="contact-text">
              <h4>WhatsApp Resmi</h4>
              <p><a href="https://wa.me/62<?= ltrim(preg_replace('/[^0-9]/', '', $whatsapp), '0'); ?>" target="_blank" rel="noopener"><?= htmlspecialchars($whatsapp); ?> (Layanan Informasi & Antrean)</a></p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon"><i class="far fa-envelope"></i></div>
            <div class="contact-text">
              <h4>Email Kedinasan</h4>
              <p><a href="mailto:<?= htmlspecialchars($email); ?>"><?= htmlspecialchars($email); ?></a></p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon"><i class="far fa-clock"></i></div>
            <div class="contact-text">
              <h4>Waktu Pelayanan</h4>
              <p><?= htmlspecialchars($working_hours); ?></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Google Maps -->
      <div class="map-card">
        <iframe 
          src="<?= htmlspecialchars($maps_embed); ?>" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade" 
          title="Lokasi Puskesmas Carita">
        </iframe>
      </div>

    </div>
  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
