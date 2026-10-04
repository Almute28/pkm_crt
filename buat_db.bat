@echo off
title Setup Database UPT Puskesmas Carita
color 0a

echo =====================================================================
echo           SETUP DATABASE XAMPP - UPT PUSKESMAS CARITA
echo                 Motto: "Carita Wisata Sehat"
echo =====================================================================
echo.

cd /d "c:\xampp\htdocs\Puskesmasweb"

REM 1. Salin Gambar Resmi
echo [1/3] Menyiapkan gambar dan aset grafis...
if not exist "assets\img" mkdir "assets\img"
copy /y "C:\Users\ASUS\.gemini\antigravity-ide\brain\62648548-f6c6-4f72-a184-66b811a2b96a\hero_puskesmas_carita_1791101476500.jpg" "assets\img\hero-puskesmas.jpg" >nul 2>&1
copy /y "C:\Users\ASUS\.gemini\antigravity-ide\brain\62648548-f6c6-4f72-a184-66b811a2b96a\kepala_puskesmas_carita_1791101534568.jpg" "assets\img\kepala-puskesmas.jpg" >nul 2>&1
copy /y "C:\Users\ASUS\.gemini\antigravity-ide\brain\62648548-f6c6-4f72-a184-66b811a2b96a\inovasi_kajedak_1791101566573.jpg" "assets\img\inovasi-kajedak.jpg" >nul 2>&1
echo [OK] Gambar berhasil disinkronkan.
echo.

REM 2. Eksekusi MySQL
echo [2/3] Membuat database dan mengimpor skema tabel ke MySQL XAMPP...
if exist "C:\xampp\mysql\bin\mysql.exe" (
    "C:\xampp\mysql\bin\mysql.exe" -u root -e "CREATE DATABASE IF NOT EXISTS puskesmas_carita CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    "C:\xampp\mysql\bin\mysql.exe" -u root puskesmas_carita < "database.sql"
    if %ERRORLEVEL% EQU 0 (
        echo [OK] Database 'puskesmas_carita' berhasil dibuat dan data telah diisi!
    ) else (
        echo [PERINGATAN] Gagal terhubung ke MySQL.
        echo Pastikan modul MySQL pada XAMPP Control Panel sudah dalam status START.
    )
) else (
    echo [PERINGATAN] File C:\xampp\mysql\bin\mysql.exe tidak ditemukan.
)
echo.

REM 3. Eksekusi instalasi PHP alternatif
echo [3/3] Memeriksa status PHP...
if exist "C:\xampp\php\php.exe" (
    "C:\xampp\php\php.exe" install.php >nul 2>&1
)
echo.

echo =====================================================================
echo                     INSTALASI SELESAI!
echo =====================================================================
echo.
echo Sekarang buka browser Anda di alamat:
echo 1. Website Utama:  http://localhost/Puskesmasweb/
echo 2. Login Admin:    http://localhost/Puskesmasweb/admin/login.php
echo    - Username:     admin
echo    - Password:     adminpuskesmas2026
echo.
echo =====================================================================
pause
