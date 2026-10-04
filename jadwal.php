<?php
/**
 * UPT PUSKESMAS CARITA - KABUPATEN PANDEGLANG
 * Halaman Khusus: Jadwal Pelayanan Terpadu
 */

require_once __DIR__ . '/config/helper.php';

$page_title = 'Jadwal Pelayanan Terpadu';
$page_desc = 'Jadwal resmi pelayanan kesehatan UPT Puskesmas Carita. Informasi jam operasional loket pendaftaran, poli umum, gigi, KIA, KB, laboratorium, dan layanan 24 jam.';

$db = getDBConnection();

$schedules = $db->query("SELECT * FROM service_schedules WHERE is_active = 1 ORDER BY id ASC")->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<!-- Header Banner -->
<div style="background: linear-gradient(135deg, #064e3b 0%, #047857 100%); color: #ffffff; padding: 4.5rem 0 3.5rem 0; text-align: center;">
  <div class="container">
    <span class="badge-pill" style="background: rgba(255,255,255,0.15); color: #34d399; margin-bottom: 0.75rem;">
      <i class="fas fa-clock"></i> Informasi Operasional
    </span>
    <h1 style="font-size: clamp(2rem, 3.5vw, 2.8rem); color: #ffffff; margin-bottom: 0.75rem;">Jadwal Pelayanan Puskesmas</h1>
    <p style="color: #e2e8f0; font-size: 1.1rem; max-width: 650px; margin: 0 auto;">Puskesmas Carita Kabupaten Pandeglang &bull; Motto: “Carita Wisata Sehat”</p>
  </div>
</div>

<!-- Breadcrumb -->
<div style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 0.75rem 0; font-size: 0.85rem;">
  <div class="container" style="display: flex; gap: 0.5rem; align-items: center; color: #64748b;">
    <a href="<?= base_url(); ?>"><i class="fas fa-home"></i> Beranda</a>
    <span>/</span>
    <a href="<?= base_url('pelayanan.php'); ?>">Pelayanan</a>
    <span>/</span>
    <span style="color: #059669; font-weight: 600;">Jadwal Pelayanan</span>
  </div>
</div>

<main class="section">
  <div class="container">
    <!-- Notice Card -->
    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: var(--radius-lg); padding: 1.25rem 1.5rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; color: #1e40af;">
      <i class="fas fa-info-circle" style="font-size: 1.5rem; color: #2563eb; flex-shrink: 0;"></i>
      <div style="font-size: 0.925rem; line-height: 1.6;">
        <strong>Informasi Penting:</strong> Jam pelayanan dapat berubah sewaktu-waktu sesuai dengan kebijakan teknis kedaruratan dan kondisi pelayanan. Untuk kondisi darurat medis dan persalinan, <strong>UGD & PONED tetap buka 24 Jam Nonstop</strong>.
      </div>
    </div>

    <!-- Filter & Search Controls -->
    <div class="table-filter-bar">
      <div class="filter-controls">
        <div class="search-input-wrap">
          <i class="fas fa-search"></i>
          <input type="text" id="scheduleSearch" placeholder="Cari nama poli, unit, atau keterangan..." autocomplete="off">
        </div>

        <select id="scheduleDayFilter" class="filter-select">
          <option value="all">Semua Hari</option>
          <option value="senin">Senin</option>
          <option value="selasa">Selasa</option>
          <option value="rabu">Rabu</option>
          <option value="kamis">Kamis</option>
          <option value="jumat">Jumat</option>
          <option value="sabtu">Sabtu</option>
          <option value="setiap hari">24 Jam / Setiap Hari</option>
        </select>
      </div>

      <div style="display: flex; gap: 0.75rem; align-items: center;">
        <button onclick="window.print()" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
          <i class="fas fa-print"></i> Cetak Jadwal
        </button>
      </div>
    </div>

    <!-- Responsive Table -->
    <div class="table-responsive">
      <table class="schedule-table">
        <thead>
          <tr>
            <th style="width: 18%;">Hari Pelayanan</th>
            <th style="width: 20%;">Jam Pelayanan</th>
            <th style="width: 24%;">Jenis Pelayanan</th>
            <th style="width: 18%;">Loket / Unit Ruang</th>
            <th style="width: 20%;">Keterangan & Persyaratan</th>
          </tr>
        </thead>
        <tbody id="scheduleTableBody">
          <?php foreach ($schedules as $sch): ?>
            <?php 
              $is24 = (strpos($sch['open_time'], '00.00') !== false || strpos($sch['day'], 'Setiap Hari') !== false);
            ?>
            <tr class="schedule-row" 
                data-service="<?= htmlspecialchars($sch['service_name']); ?>" 
                data-day="<?= htmlspecialchars($sch['day']); ?>" 
                data-room="<?= htmlspecialchars($sch['room_unit']); ?>">
              <td style="font-weight: 700; color: #0f172a;">
                <span class="badge-pill badge-mint"><?= htmlspecialchars($sch['day']); ?></span>
              </td>
              <td>
                <span class="time-badge <?= $is24 ? 'time-24' : ''; ?>">
                  <i class="far fa-clock"></i> <?= htmlspecialchars($sch['open_time']); ?> - <?= htmlspecialchars($sch['close_time']); ?> WIB
                </span>
              </td>
              <td style="font-weight: 700; color: #064e3b; font-size: 0.95rem;">
                <?= htmlspecialchars($sch['service_name']); ?>
              </td>
              <td>
                <span style="display: inline-flex; align-items: center; gap: 0.4rem; color: #334155;">
                  <i class="fas fa-door-open" style="color: #059669;"></i> <?= htmlspecialchars($sch['room_unit']); ?>
                </span>
              </td>
              <td style="color: #64748b; font-size: 0.85rem;">
                <?= htmlspecialchars($sch['notes']); ?>
              </td>
            </tr>
          <?php endforeach; ?>
          <tr id="scheduleEmptyRow" style="display: none;">
            <td colspan="5" style="text-align: center; padding: 2.5rem; color: #94a3b8;">
              <i class="fas fa-search" style="font-size: 2rem; margin-bottom: 0.75rem; display: block;"></i>
              Tidak ditemukan data jadwal pelayanan yang cocok dengan filter atau kata kunci Anda.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Requirements Card -->
    <div style="margin-top: 3rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
      <div style="background: #ffffff; border: 1px solid var(--pkm-border); border-radius: var(--radius-lg); padding: 1.5rem; box-shadow: var(--shadow-sm);">
        <h4 style="font-size: 1.1rem; color: #064e3b; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
          <i class="fas fa-file-medical-alt" style="color: #059669;"></i> Persyaratan Pasien BPJS
        </h4>
        <ul style="color: #475569; font-size: 0.875rem; padding-left: 1.25rem; line-height: 1.7;">
          <li>Kartu Indonesia Sehat (KIS) / BPJS Kesehatan aktif (Faskes Tingkat 1 Puskesmas Carita).</li>
          <li>Kartu Tanda Penduduk (KTP) / Kartu Keluarga (KK) asli atau fotokopi.</li>
          <li>Buku KIA (khusus ibu hamil, bayi, dan balita).</li>
        </ul>
      </div>

      <div style="background: #ffffff; border: 1px solid var(--pkm-border); border-radius: var(--radius-lg); padding: 1.5rem; box-shadow: var(--shadow-sm);">
        <h4 style="font-size: 1.1rem; color: #064e3b; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
          <i class="fas fa-user-check" style="color: #0284c7;"></i> Persyaratan Pasien Umum
        </h4>
        <ul style="color: #475569; font-size: 0.875rem; padding-left: 1.25rem; line-height: 1.7;">
          <li>Kartu Tanda Penduduk (KTP) / Kartu Identitas Anak (KIA) / KK.</li>
          <li>Kartu Berobat Puskesmas Carita (bagi pasien lama).</li>
          <li>Retribusi pelayanan kesehatan sesuai Peraturan Daerah Kabupaten Pandeglang.</li>
        </ul>
      </div>

      <div style="background: #ffffff; border: 1px solid var(--pkm-border); border-radius: var(--radius-lg); padding: 1.5rem; box-shadow: var(--shadow-sm);">
        <h4 style="font-size: 1.1rem; color: #dc2626; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
          <i class="fas fa-ambulance"></i> Pasien Gawat Darurat (UGD)
        </h4>
        <ul style="color: #475569; font-size: 0.875rem; padding-left: 1.25rem; line-height: 1.7;">
          <li>Pelayanan darurat langsung ditangani tanpa menunggu kelengkapan administrasi awal.</li>
          <li>Keluarga atau pengantar dapat melengkapi berkas administrasi setelah kondisi pasien stabil.</li>
          <li>Hotline Darurat: <strong><?= htmlspecialchars(get_setting('emergency_phone')); ?></strong> (24 Jam).</li>
        </ul>
      </div>
    </div>
  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
