<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KunjunganModel;
use App\Models\TamuModel;
use App\Models\TujuanModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Controllers\Admin;

class KepalaBagian extends BaseController
{
    protected $kunjunganModel;
    protected $tamuModel;
    protected $tujuanModel;

    public function __construct()
    {
        $this->kunjunganModel = new KunjunganModel();
        $this->tamuModel = new TamuModel();
        $this->tujuanModel = new TujuanModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        // Statistik untuk dashboard Kepala Bagian
        $jumlahKunjunganHariIni = $this->kunjunganModel->where('DATE(tanggal_kunjungan)', date('Y-m-d'))->countAllResults();
        $totalKunjunganBulanIni = $this->kunjunganModel->where('YEAR(tanggal_kunjungan)', date('Y'))
                                                  ->where('MONTH(tanggal_kunjungan)', date('m'))
                                                  ->countAllResults();
        // Kunjungan menunggu persetujuan
        $kunjunganMenunggu = $this->kunjunganModel->where('status_persetujuan', 'menunggu')->countAllResults();

        // Data untuk Grafik (Contoh: Kunjungan 7 hari terakhir)
        $labelsGrafikKunjungan = [];
        $dataGrafikKunjungan = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $labelsGrafikKunjungan[] = date('D, d M', strtotime($date));
            $dataGrafikKunjungan[] = $this->kunjunganModel->where('DATE(tanggal_kunjungan)', $date)->countAllResults();
        }

        $data = [
            'title' => 'Dashboard Kepala Bagian',
            'jumlahKunjunganHariIni' => $jumlahKunjunganHariIni,
            'totalKunjunganBulanIni' => $totalKunjunganBulanIni,
            'kunjunganMenunggu' => $kunjunganMenunggu, // Tambahkan ini
            'labelsGrafikKunjungan' => json_encode($labelsGrafikKunjungan),
            'dataGrafikKunjungan' => json_encode($dataGrafikKunjungan),
        ];
        return view('kepala_bagian/dashboard', $data);
    }

    /**
     * Menampilkan daftar kunjungan yang menunggu persetujuan.
     */
    public function persetujuanKunjungan()
    {
        $kunjunganMenunggu = $this->kunjunganModel->getKunjunganWithDetails(['status_persetujuan' => 'menunggu']);

        $data = [
            'title' => 'Persetujuan Kunjungan',
            'kunjunganMenunggu' => $kunjunganMenunggu,
        ];
        return view('kepala_bagian/persetujuan_kunjungan', $data);
    }

    /**
     * Memproses persetujuan atau penolakan kunjungan.
     */
    public function prosesPersetujuan()
    {
        $id_kunjungan = $this->request->getPost('id_kunjungan');
        $status = $this->request->getPost('status_persetujuan'); // 'disetujui' atau 'ditolak'
        $catatan_persetujuan = $this->request->getPost('catatan_persetujuan');

        $kunjungan = $this->kunjunganModel->find($id_kunjungan);

        if (!$kunjungan) {
            return redirect()->back()->with('error', 'Kunjungan tidak ditemukan.');
        }

        if ($kunjungan['status_persetujuan'] !== 'menunggu') {
            return redirect()->back()->with('info', 'Kunjungan ini sudah diproses sebelumnya.');
        }

        $dataUpdate = [
            'status_persetujuan' => $status,
            'catatan_persetujuan' => $catatan_persetujuan,
            'disetujui_oleh_user_id' => session()->get('user_id'), // User yang sedang login
            'tanggal_persetujuan' => date('Y-m-d H:i:s'),
        ];

        if ($this->kunjunganModel->update($id_kunjungan, $dataUpdate)) {
            $message = ($status === 'disetujui') ? 'Kunjungan berhasil disetujui.' : 'Kunjungan berhasil ditolak.';
            return redirect()->to('/kepala-bagian/persetujuan-kunjungan')->with('success', $message);
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memproses persetujuan/penolakan.');
        }
    }

     /**
     * Menampilkan riwayat kunjungan umum untuk Kepala Bagian.
     */
    public function riwayatKunjungan()
    {
        $riwayatKunjungan = $this->kunjunganModel->getKunjunganWithDetails(); // Menggunakan getKunjunganWithDetails dari KunjunganModel
        $data = [
            'title' => 'Riwayat Kunjungan (Kepala Bagian)',
            'riwayatKunjungan' => $riwayatKunjungan,
        ];
        return view('kepala_bagian/riwayat_kunjungan', $data);
    }

    /**
     * Memanggil laporan harian dari Admin Controller.
     */
    public function laporanHarian() {
        $adminController = new \App\Controllers\Admin();
        // --- FIX: Pass the current request object ---
        $adminController->request = $this->request; // Inject the request object
        return $adminController->laporanHarian();
    }

    /**
     * Memanggil laporan bulanan dari Admin Controller.
     */
    public function laporanBulanan() {
        $adminController = new \App\Controllers\Admin();
        // --- FIX: Pass the current request object ---
        $adminController->request = $this->request; // Inject the request object
        return $adminController->laporanBulanan();
    }

    /**
     * Memanggil laporan tahunan dari Admin Controller.
     */
    public function laporanTahunan() {
        $adminController = new \App\Controllers\Admin();
        // --- FIX: Pass the current request object ---
        $adminController->request = $this->request; // Inject the request object
        return $adminController->laporanTahunan();
    }

    /**
     * Memanggil export PDF laporan dari Admin Controller.
     */
    public function exportPdfLaporan() {
        $adminController = new \App\Controllers\Admin();
        // --- FIX: Pass the current request object ---
        $adminController->request = $this->request; // Inject the request object
        return $adminController->exportPdfLaporan();
    }
}