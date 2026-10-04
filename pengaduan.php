<?php
/**
 * UPT PUSKESMAS CARITA - KABUPATEN PANDEGLANG
 * Pengaduan & Saran Masyarakat serta Lacak Status Tiket
 */

require_once __DIR__ . '/config/helper.php';

$page_title = 'Pengaduan & Saran Masyarakat';
$page_desc = 'Sampaikan kritik, saran, dan pengaduan layanan kesehatan UPT Puskesmas Carita. Lacak status penanganan tiket aduan Anda secara online.';

$db = getDBConnection();

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_complaint') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!verify_csrf_token($csrf)) {
        set_flash('danger', 'Sesi keamanan tidak valid. Silakan coba kembali.');
        header('Location: ' . base_url('pengaduan.php'));
        exit;
    }

    $captcha_answer = trim($_POST['captcha_answer'] ?? '');
    $captcha_expected = $_SESSION['captcha_expected'] ?? null;

    if ($captcha_answer === '' || (int)$captcha_answer !== (int)$captcha_expected) {
        set_flash('danger', 'Jawaban verifikasi keamanan (captcha) salah. Silakan coba lagi.');
        header('Location: ' . base_url('pengaduan.php'));
        exit;
    }

    $name = sanitize($_POST['name'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $category = sanitize($_POST['category'] ?? 'Pelayanan Medis');
    $message = sanitize($_POST['message'] ?? '');

    if (empty($name) || empty($phone) || empty($message)) {
        set_flash('danger', 'Nama, Nomor Telepon/WhatsApp, dan Isi Pengaduan wajib diisi.');
        header('Location: ' . base_url('pengaduan.php'));
        exit;
    }

    $attachmentPath = null;
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $upload = upload_file($_FILES['attachment'], 'uploads/complaints', ['image/jpeg', 'image/png', 'application/pdf'], 3145728);
        if ($upload['success']) {
            $attachmentPath = $upload['filepath'];
        }
    }

    $ticketNumber = 'PKM-' . date('Y') . '-' . strtoupper(substr(uniqid(), -5));

    try {
        $stmt = $db->prepare("INSERT INTO complaints (ticket_number, name, phone, email, category, message, attachment, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'Menunggu')");
        $stmt->execute([$ticketNumber, $name, $phone, $email, $category, $message, $attachmentPath]);

        set_flash('success', "Pengaduan Anda telah tercatat dengan Nomor Tiket: <strong>{$ticketNumber}</strong>. Simpan nomor tiket ini untuk melacak tindak lanjut petugas.");
        header('Location: ' . base_url('pengaduan.php?ticket=' . urlencode($ticketNumber)));
        exit;
    } catch (Exception $e) {
        set_flash('danger', 'Terjadi kesalahan sistem saat menyimpan pengaduan: ' . $e->getMessage());
        header('Location: ' . base_url('pengaduan.php'));
        exit;
    }
}

// Generate captcha
$n1 = rand(2, 8);
$n2 = rand(1, 7);
$_SESSION['captcha_expected'] = $n1 + $n2;

// Check ticket tracking query
$searchTicket = sanitize($_GET['ticket'] ?? '');
$trackedComplaint = null;
if (!empty($searchTicket)) {
    $stmt = $db->prepare("SELECT * FROM complaints WHERE ticket_number = ?");
    $stmt->execute([$searchTicket]);
    $trackedComplaint = $stmt->fetch();
}

include __DIR__ . '/includes/header.php';
?>

<!-- Header Banner -->
<div style="background: linear-gradient(135deg, #064e3b 0%, #059669 100%); color: #ffffff; padding: 4.5rem 0 3.5rem 0; text-align: center;">
  <div class="container">
    <span class="badge-pill" style="background: rgba(255,255,255,0.15); color: #34d399; margin-bottom: 0.75rem;">
      <i class="fas fa-bullhorn"></i> Kanal Aspirasi Warga
    </span>
    <h1 style="font-size: clamp(2rem, 3.5vw, 2.8rem); color: #ffffff; margin-bottom: 0.75rem;">Pengaduan & Saran Masyarakat</h1>
    <p style="color: #e2e8f0; font-size: 1.1rem; max-width: 650px; margin: 0 auto;">Kami mendengar dan siap menindaklanjuti setiap aspirasi, saran, dan pengaduan demi perbaikan mutu pelayanan.</p>
  </div>
</div>

<!-- Breadcrumb -->
<div style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 0.75rem 0; font-size: 0.85rem;">
  <div class="container" style="display: flex; gap: 0.5rem; align-items: center; color: #64748b;">
    <a href="<?= base_url(); ?>"><i class="fas fa-home"></i> Beranda</a>
    <span>/</span>
    <span style="color: #059669; font-weight: 600;">Pengaduan Masyarakat</span>
  </div>
</div>

<main class="section">
  <div class="container">
    
    <!-- Tracking Box -->
    <div style="background: #ffffff; border-radius: var(--radius-xl); border: 1px solid var(--pkm-border); padding: 2.25rem; box-shadow: var(--shadow-sm); margin-bottom: 3.5rem;">
      <h3 style="font-size: 1.35rem; color: #064e3b; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
        <i class="fas fa-search" style="color: #059669;"></i> Lacak Status Tiket Pengaduan
      </h3>
      <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1.25rem;">Sudah pernah mengirim pengaduan? Masukkan nomor tiket Anda (contoh: <code>PKM-2026-001</code>) untuk melihat respon resmi petugas.</p>

      <form action="<?= base_url('pengaduan.php'); ?>" method="GET" style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <input type="text" name="ticket" value="<?= htmlspecialchars($searchTicket); ?>" class="form-control" style="flex: 1; min-width: 250px;" placeholder="Masukkan Nomor Tiket Pengaduan..." required>
        <button type="submit" class="btn btn-primary" style="padding: 0.75rem 1.75rem;">
          <i class="fas fa-search"></i> Cek Status
        </button>
      </form>

      <?php if (!empty($searchTicket)): ?>
        <div style="margin-top: 1.5rem; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
          <?php if ($trackedComplaint): ?>
            <div style="background: #f8fafc; border-radius: var(--radius-lg); border: 1px solid #cbd5e1; padding: 1.5rem;">
              <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1rem;">
                <h4 style="margin-bottom: 0; color: #064e3b; font-size: 1.15rem;">
                  Tiket: <strong><?= htmlspecialchars($trackedComplaint['ticket_number']); ?></strong>
                </h4>
                <?php 
                  $status = $trackedComplaint['status'];
                  $badgeClass = 'badge-mint';
                  if ($status === 'Menunggu') $badgeClass = 'badge-urgent';
                  if ($status === 'Diproses') $badgeClass = 'badge-blue';
                  if ($status === 'Selesai') $badgeClass = 'badge-mint';
                ?>
                <span class="badge-pill <?= $badgeClass; ?>">
                  Status: <?= htmlspecialchars($status); ?>
                </span>
              </div>

              <div style="font-size: 0.875rem; color: #475569; display: flex; flex-direction: column; gap: 0.4rem; margin-bottom: 1rem;">
                <div><strong>Pelapor:</strong> <?= htmlspecialchars($trackedComplaint['name']); ?> (Kategori: <?= htmlspecialchars($trackedComplaint['category']); ?>)</div>
                <div><strong>Tanggal Pengaduan:</strong> <?= format_date_id($trackedComplaint['created_at'], true); ?></div>
                <div><strong>Uraian Aduan:</strong> <em>"<?= htmlspecialchars($trackedComplaint['message']); ?>"</em></div>
              </div>

              <?php if (!empty($trackedComplaint['response'])): ?>
                <div style="background: #ecfdf5; border-left: 4px solid #059669; padding: 1rem; border-radius: 4px; margin-top: 1rem;">
                  <strong style="color: #064e3b; display: block; margin-bottom: 0.35rem;">
                    <i class="fas fa-reply"></i> Respon Tindak Lanjut dari UPT Puskesmas Carita:
                  </strong>
                  <div style="color: #1e293b; font-size: 0.9rem; line-height: 1.6;">
                    <?= nl2br(htmlspecialchars($trackedComplaint['response'])); ?>
                  </div>
                  <small style="color: #64748b; display: block; margin-top: 0.5rem;">
                    Direspon pada: <?= format_date_id($trackedComplaint['responded_at'], true); ?>
                  </small>
                </div>
              <?php else: ?>
                <div style="background: #fef3c7; border: 1px solid #fde68a; border-radius: var(--radius-sm); padding: 0.85rem; color: #92400e; font-size: 0.875rem;">
                  <i class="fas fa-hourglass-half"></i> Pengaduan Anda sedang dalam proses verifikasi dan telaah tim manajemen UPT Puskesmas Carita. Mohon cek kembali secara berkala.
                </div>
              <?php endif; ?>
            </div>
          <?php else: ?>
            <div style="background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; padding: 1rem; border-radius: var(--radius-md); font-size: 0.9rem;">
              <i class="fas fa-exclamation-triangle"></i> Nomor tiket <strong><?= htmlspecialchars($searchTicket); ?></strong> tidak ditemukan dalam sistem kami. Pastikan nomor tiket ditulis dengan benar.
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Form Pengaduan Baru -->
    <div style="max-width: 820px; margin: 0 auto;">
      <div class="complaint-box">
        <h3 style="font-size: 1.5rem; color: #064e3b; margin-bottom: 0.5rem;">Formulir Pengaduan / Aspirasi Baru</h3>
        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 2rem;">Isi formulir berikut dengan data yang valid. Identitas pelapor dilindungi dan dijaga kerahasiaannya.</p>

        <form action="<?= base_url('pengaduan.php'); ?>" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="action" value="submit_complaint">
          <input type="hidden" name="csrf_token" value="<?= generate_csrf_token(); ?>">

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
            <div class="form-group">
              <label class="form-label" for="name">Nama Lengkap <span style="color: #ef4444;">*</span></label>
              <input type="text" id="name" name="name" class="form-control" placeholder="Nama Anda" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="phone">Nomor Telepon / WhatsApp <span style="color: #ef4444;">*</span></label>
              <input type="text" id="phone" name="phone" class="form-control" placeholder="Contoh: 081234567890" required>
            </div>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
            <div class="form-group">
              <label class="form-label" for="email">Alamat Email (Opsional)</label>
              <input type="email" id="email" name="email" class="form-control" placeholder="nama@email.com">
            </div>

            <div class="form-group">
              <label class="form-label" for="category">Kategori Pengaduan</label>
              <select id="category" name="category" class="form-control">
                <option value="Pelayanan Medis">Pelayanan Medis & Dokter</option>
                <option value="Petugas & Sikap">Sikap Petugas & Komunikasi</option>
                <option value="Fasilitas & Kebersihan">Sarana, Fasilitas & Kebersihan</option>
                <option value="Farmasi & Obat">Farmasi, Resep & Ketersediaan Obat</option>
                <option value="Administrasi & Pendaftaran">Administrasi, Antrean & Loket</option>
                <option value="Lainnya">Saran & Masukan Lainnya</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label" for="message">Uraian Pengaduan / Masukan <span style="color: #ef4444;">*</span></label>
            <textarea id="message" name="message" class="form-control" rows="5" placeholder="Jelaskan secara runtut kronologi, waktu kejadian, ruang pelayanan, atau saran perbaikan Anda..." required></textarea>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
            <div class="form-group">
              <label class="form-label" for="attachment">Lampirkan Bukti / Foto (Maks 3MB, PDF/JPG)</label>
              <input type="file" id="attachment" name="attachment" class="form-control" accept="image/jpeg,image/png,application/pdf">
            </div>

            <div class="form-group">
              <label class="form-label" for="captcha_answer">Verifikasi Keamanan: Berapa <strong><?= $n1; ?> + <?= $n2; ?></strong>? <span style="color: #ef4444;">*</span></label>
              <input type="number" id="captcha_answer" name="captcha_answer" class="form-control" placeholder="Tulis hasil angka" required>
            </div>
          </div>

          <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.9rem; font-size: 1rem; margin-top: 1rem;">
            <i class="fas fa-paper-plane"></i> Kirim Pengaduan Sekarang
          </button>
        </form>
      </div>
    </div>

  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
