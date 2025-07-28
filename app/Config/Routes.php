<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute Default
// $routes->get('/(:any)', 'Disabled::index/$1');
$routes->get('/', 'Auth::index'); // Halaman login sebagai halaman utama
$routes->get('/login', 'Auth::index');
$routes->post('/auth', 'Auth::login');
$routes->get('/logout', 'Auth::logout');

// Rute untuk Pendaftaran Masyarakat (jika ada)
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::processRegister');

// --- Route Group untuk Admin (Role 1) ---
$routes->group('admin', ['namespace' => 'App\Controllers', 'filter' => 'admin'], function($routes) {
    $routes->get('/', 'Admin::index'); // Dashboard Admin
    $routes->get('dashboard', 'Admin::index');

    // Manajemen Tamu
    $routes->get('data-tamu', 'Admin::dataTamu');
    $routes->post('data-tamu/tambah', 'Admin::tambahTamu');
    $routes->post('data-tamu/edit', 'Admin::editTamu');
    $routes->get('data-tamu/hapus/(:num)', 'Admin::hapusTamu/$1');

    // Manajemen Tujuan Kunjungan
    $routes->get('tujuan-kunjungan', 'Admin::tujuanKunjungan');
    $routes->post('tujuan-kunjungan/tambah', 'Admin::tambahTujuan');
    $routes->post('tujuan-kunjungan/edit', 'Admin::editTujuan');
    $routes->get('tujuan-kunjungan/hapus/(:num)', 'Admin::hapusTujuan/$1');

    // Riwayat Kunjungan (Admin)
    $routes->get('riwayat-kunjungan', 'Admin::riwayatKunjungan');
    $routes->post('riwayat-kunjungan/tambah', 'Admin::tambahKunjungan');
    $routes->post('riwayat-kunjungan/edit', 'Admin::editKunjungan');
    $routes->get('riwayat-kunjungan/hapus/(:num)', 'Admin::hapusKunjungan/$1');
    $routes->get('riwayat-kunjungan/update-waktu-keluar/(:num)', 'Admin::updateWaktuKeluar/$1');

    // Manajemen Pengguna (User Management)
    $routes->get('manajemen-pengguna', 'Admin::manajemenPengguna');
    $routes->post('manajemen-pengguna/tambah', 'Admin::tambahPengguna');
    $routes->post('manajemen-pengguna/edit', 'Admin::editPengguna');
    $routes->get('manajemen-pengguna/reset-password/(:num)', 'Admin::resetPassword/$1');
    $routes->get('manajemen-pengguna/hapus/(:num)', 'Admin::hapusPengguna/$1');

    // Laporan (Admin)
    $routes->get('laporan-harian', 'Admin::laporanHarian');
    $routes->get('laporan-bulanan', 'Admin::laporanBulanan');
    $routes->get('laporan-tahunan', 'Admin::laporanTahunan');
    $routes->get('laporan/export-pdf', 'Admin::exportPdfLaporan');

    // Pengaturan Akun
    $routes->get('pengaturan-akun', 'Admin::pengaturanAkun');
    $routes->post('pengaturan-akun/tambah', 'Admin::tambahUser');  
    $routes->post('pengaturan-akun/edit', 'Admin::editUser');  
    $routes->post('pengaturan-akun/hapus', 'Admin::hapusUser');  
});

// --- Route Group untuk Kepala Bagian (Role 3) ---
$routes->group('kepala-bagian', ['namespace' => 'App\Controllers', 'filter' => 'kepalaBagian'], function($routes) {
    $routes->get('/', 'KepalaBagian::index'); // Dashboard Kepala Bagian
    $routes->get('dashboard', 'KepalaBagian::index');

    // Fitur Persetujuan Kunjungan BARU
    $routes->get('persetujuan-kunjungan', 'KepalaBagian::persetujuanKunjungan');
    $routes->post('proses-persetujuan', 'KepalaBagian::prosesPersetujuan');

    // Riwayat Kunjungan (Kepala Bagian)
    $routes->get('riwayat-kunjungan', 'KepalaBagian::riwayatKunjungan');

    // Laporan (Kepala Bagian) - Memanggil method dari Admin Controller
    $routes->get('laporan-harian', 'KepalaBagian::laporanHarian');
    $routes->get('laporan-bulanan', 'KepalaBagian::laporanBulanan');
    $routes->get('laporan-tahunan', 'KepalaBagian::laporanTahunan');
    $routes->get('laporan/export-pdf', 'KepalaBagian::exportPdfLaporan');
});

// --- Route Group untuk Masyarakat (Role 2) ---
$routes->group('masyarakat', ['namespace' => 'App\Controllers', 'filter' => 'masyarakat'], function($routes) {
    $routes->get('/', 'Masyarakat::index'); // Dashboard Masyarakat
    $routes->get('dashboard', 'Masyarakat::index');

    // Input Kunjungan Baru oleh Masyarakat
    $routes->get('input-kunjungan', 'Masyarakat::inputKunjungan');
    $routes->post('submit-kunjungan', 'Masyarakat::submitKunjungan');

    // Riwayat Kunjungan Masyarakat
    $routes->get('riwayat-kunjungan-saya', 'Masyarakat::riwayatKunjunganSaya');
});