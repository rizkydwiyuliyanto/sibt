<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TamuModel;
use App\Models\KunjunganModel;
use App\Models\TujuanModel;
use CodeIgniter\HTTP\ResponseInterface;

class Masyarakat extends BaseController
{
    protected $tamuModel;
    protected $kunjunganModel;
    protected $tujuanModel;

    public function __construct()
    {
        $this->tamuModel = new TamuModel();
        $this->kunjunganModel = new KunjunganModel();
        $this->tujuanModel = new TujuanModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $user_id = session()->get('user_id');
        $tamu = $this->tamuModel->where('user_id', $user_id)->first();

        $jumlahKunjunganTerakhir = 0;
        if ($tamu) {
            $jumlahKunjunganTerakhir = $this->kunjunganModel
                ->where('id_tamu', $tamu['id_tamu'])
                ->where('tanggal_kunjungan >=', date('Y-m-d', strtotime('-7 days')))
                ->countAllResults();
        }

        $data = [
            'title' => 'Dashboard Masyarakat',
            'nama_pengguna' => session()->get('nama_lengkap') ?? 'Masyarakat',
            'jumlahKunjunganTerakhir' => $jumlahKunjunganTerakhir,
        ];
        return view('masyarakat/dashboard', $data);
    }

    public function inputKunjungan()
    {
        $daftarTujuan = $this->tujuanModel->findAll();
        $user_id = session()->get('user_id');
        $tamuInfo = $this->tamuModel->where('user_id', $user_id)->first();

        if (!$tamuInfo) {
            return redirect()->to('/masyarakat')->with('error', 'Profil tamu Anda tidak ditemukan. Harap hubungi admin.');
        }

        $daftarInstansi = $this->tamuModel->distinct()
                                          ->select('asal_instansi')
                                          ->where('asal_instansi IS NOT NULL')
                                          ->where('asal_instansi !=', '')
                                          ->orderBy('asal_instansi', 'ASC')
                                          ->findAll();
        $instansiList = array_column($daftarInstansi, 'asal_instansi');


        $data = [
            'title' => 'Input Kunjungan Baru',
            'daftarTujuan' => $daftarTujuan,
            'tamuInfo' => $tamuInfo,
            'currentDate' => date('Y-m-d'),
            'currentTime' => date('H:i'),
            'instansiList' => json_encode($instansiList),
        ];
        return view('masyarakat/input_kunjungan', $data);
    }

    public function submitKunjungan()
    {
        $user_id = session()->get('user_id');
        $tamu = $this->tamuModel->where('user_id', $user_id)->first();

        if (!$tamu) {
            return redirect()->back()->with('error', 'Data tamu Anda tidak ditemukan. Harap hubungi admin.');
        }

        $rules = [
            'asal_instansi_input' => 'permit_empty|max_length[255]',
            'id_tujuan'           => 'permit_empty|is_natural_no_zero',
            'keperluan'           => 'required|min_length[10]|max_length[500]',
            'catatan'             => 'permit_empty|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $new_asal_instansi = $this->request->getPost('asal_instansi_input');
        if ($new_asal_instansi !== ($tamu['asal_instansi'] ?? null)) {
            $this->tamuModel->update($tamu['id_tamu'], ['asal_instansi' => $new_asal_instansi]);
        }

        $data = [
            'id_tamu'           => $tamu['id_tamu'],
            'id_tujuan'         => $this->request->getPost('id_tujuan') ? $this->request->getPost('id_tujuan') : null,
            'tanggal_kunjungan' => date('Y-m-d'),
            'waktu_masuk'       => date('H:i:s'),
            'keperluan'         => $this->request->getPost('keperluan'),
            'waktu_keluar'      => null,
            'catatan'           => $this->request->getPost('catatan'),
            'status_persetujuan' => 'menunggu', // <-- TAMBAHAN BARU: Default status
        ];

        if ($this->kunjunganModel->insert($data)) {
            return redirect()->to('/masyarakat/riwayat-kunjungan-saya')->with('success', 'Kunjungan Anda berhasil dicatat dan akan segera diproses.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mencatat kunjungan. ' . implode(', ', $this->kunjunganModel->errors()));
        }
    }

    public function riwayatKunjunganSaya()
    {
        $user_id = session()->get('user_id');
        $tamu = $this->tamuModel->where('user_id', $user_id)->first();

        if (!$tamu) {
            return redirect()->to('/masyarakat')->with('error', 'Data tamu Anda tidak ditemukan.');
        }

        $riwayatKunjungan = $this->kunjunganModel->getKunjunganWithDetails(['id_tamu' => $tamu['id_tamu']]);

        $data = [
            'title' => 'Riwayat Kunjungan Saya',
            'riwayatKunjungan' => $riwayatKunjungan,
        ];
        return view('masyarakat/riwayat_kunjungan_saya', $data);
    }
}