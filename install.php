<?php
/**
 * UPT PUSKESMAS CARITA - KABUPATEN PANDEGLANG
 * One-Click Database & Asset Auto-Installer
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/helper.php';

$message = '';
$status = 'info';

try {
    // 1. Koneksi ke MySQL Root Server
    $pdo = new PDO("mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // 2. Buat Database jika belum ada
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

    // 3. Sambungkan ke Database puskesmas_carita
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // 4. Eksekusi Skema Tabel & Data Awal dari database.sql
    $sqlFile = __DIR__ . '/database.sql';
    if (file_exists($sqlFile)) {
        $sql = file_get_contents($sqlFile);
        $db->exec($sql);
    }

    // 5. Salin Asset Gambar Awal
    sync_initial_assets();

    $status = 'success';
    $message = "Database <strong>" . DB_NAME . "</strong> dan seluruh data awal berhasil diinstalasi dengan sempurna!";
} catch (Exception $e) {
    $status = 'danger';
    $message = "Terjadi kendala saat instalasi: " . $e->getMessage() . "<br><small>Pastikan service MySQL di XAMPP Control Panel sudah AKTIF (Start).</small>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Instalasi Database - UPT Puskesmas Carita</title>
  <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/img/logo.svg'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <style>
    body {
      background: #f8fafc;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
    }
    .install-card {
      background: #ffffff;
      max-width: 580px;
      width: 100%;
      border-radius: 20px;
      padding: 3rem;
      border: 1px solid #e2e8f0;
      box-shadow: 0 20px 40px rgba(0,0,0,0.06);
      text-align: center;
    }
  </style>
</head>
<body>

  <div class="install-card">
    <img src="<?= base_url('assets/img/logo.svg'); ?>" alt="Logo Puskesmas Carita" style="height: 64px; margin: 0 auto 1.5rem auto;">
    
    <h2 style="color: #064e3b; margin-bottom: 0.5rem;">Instalasi Database & Sistem</h2>
    <p style="color: #64748b; font-size: 0.95rem; margin-bottom: 2rem;">UPT Puskesmas Carita Kabupaten Pandeglang &bull; “Carita Wisata Sehat”</p>

    <div style="padding: 1.25rem; border-radius: 12px; margin-bottom: 2rem; background: <?= $status === 'success' ? '#ecfdf5' : '#fee2e2'; ?>; border: 1px solid <?= $status === 'success' ? '#a7f3d0' : '#fecaca'; ?>; color: <?= $status === 'success' ? '#065f46' : '#991b1b'; ?>;">
      <i class="fas <?= $status === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?>" style="font-size: 2rem; margin-bottom: 0.5rem; display: block;"></i>
      <div><?= $message; ?></div>
    </div>

    <?php if ($status === 'success'): ?>
      <div style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; padding: 1.25rem; text-align: left; font-size: 0.875rem; margin-bottom: 2rem;">
        <strong style="color: #064e3b; display: block; margin-bottom: 0.5rem;"><i class="fas fa-key"></i> Kredensial Administrator Default:</strong>
        <div>URL Admin: <code><?= base_url('admin/login.php'); ?></code></div>
        <div>Username: <strong>admin</strong></div>
        <div>Password: <strong>adminpuskesmas2026</strong></div>
      </div>

      <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
        <a href="<?= base_url(); ?>" class="btn btn-primary" style="padding: 0.75rem 1.75rem;">
          <i class="fas fa-home"></i> Buka Website Publik
        </a>
        <a href="<?= base_url('admin/login.php'); ?>" class="btn btn-secondary" style="padding: 0.75rem 1.75rem;">
          <i class="fas fa-lock"></i> Masuk Dashboard Admin
        </a>
      </div>
    <?php else: ?>
      <a href="<?= base_url('install.php'); ?>" class="btn btn-primary">
        <i class="fas fa-sync-alt"></i> Coba Instalasi Ulang
      </a>
    <?php endif; ?>
  </div>

</body>
</html>
