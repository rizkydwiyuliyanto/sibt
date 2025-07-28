<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use Dompdf\Dompdf;

use App\Models\TamuModel;
use App\Models\KunjunganModel;
use App\Models\TujuanModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    protected $tamuModel;
    protected $kunjunganModel;
    protected $tujuanModel;
    protected $userModel;

    public function __construct()
    {
        $this->tamuModel = new TamuModel();
        $this->kunjunganModel = new KunjunganModel();
        $this->tujuanModel = new TujuanModel();
        $this->userModel = new UserModel();
        helper(['form', 'url', 'number']);
    }

    public function index()
    {
        // Data untuk Card Statistik Dashboard
        $jumlahTamuTerdaftar = $this->tamuModel->countAllResults();
        $jumlahKunjunganHariIni = $this->kunjunganModel->where('DATE(tanggal_kunjungan)', date('Y-m-d'))->countAllResults();
        $totalKunjunganBulanIni = $this->kunjunganModel->where('YEAR(tanggal_kunjungan)', date('Y'))
                                                  ->where('MONTH(tanggal_kunjungan)', date('m'))
                                                  ->countAllResults();

        // Data untuk Grafik (Contoh: Kunjungan 7 hari terakhir)
        $labelsGrafikKunjungan = [];
        $dataGrafikKunjungan = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $labelsGrafikKunjungan[] = date('D, d M', strtotime($date));
            $dataGrafikKunjungan[] = $this->kunjunganModel->where('DATE(tanggal_kunjungan)', $date)->countAllResults();
        }

        $data = [
            'title' => 'Dashboard Admin',
            'jumlahTamuTerdaftar' => $jumlahTamuTerdaftar,
            'jumlahKunjunganHariIni' => $jumlahKunjunganHariIni,
            'totalKunjunganBulanIni' => $totalKunjunganBulanIni,
            'labelsGrafikKunjungan' => json_encode($labelsGrafikKunjungan),
            'dataGrafikKunjungan' => json_encode($dataGrafikKunjungan),
        ];

        return view('admin/dashboard', $data);
    }

    
   // --- Manajemen Data Tamu ---
     public function dataTamu()
    {
        // Ambil ID user dari tabel 'users' yang memiliki role 1 (Masyarakat)
        $userMasyarakatIds = $this->userModel->select('id')
                                             ->where('role', 1) // Role 1 untuk Masyarakat
                                             ->findAll();
        $userIds = array_column($userMasyarakatIds, 'id');

        // Ambil data tamu yang user_id-nya ada di $userIds
        $dataTamu = [];
        if (!empty($userIds)) {
            $dataTamu = $this->tamuModel->whereIn('user_id', $userIds)->findAll();
        }
        // Jika Anda juga ingin menampilkan tamu yang diinput manual oleh admin dan tidak punya user_id:
        $dataTamuManual = $this->tamuModel->where('user_id IS NULL')->findAll();
        $dataTamu = array_merge($dataTamu, $dataTamuManual);


        // --- PERBAIKAN PENEMPATAN KODE DI SINI ---
        // Ambil user Masyarakat yang belum punya entri di t_tamu
        $existingTamuUserIds = $this->tamuModel->select('user_id')
                                               ->where('user_id IS NOT NULL')
                                               ->findAll();
        $existingTamuUserIds = array_column($existingTamuUserIds, 'user_id');

        $usersNotYetTamu = $this->userModel->select('id, nama_lengkap, username')
                                           ->where('role', 1) // Hanya user Masyarakat
                                           ->whereNotIn('id', $existingTamuUserIds) // Yang belum ada di t_tamu
                                           ->findAll();

        // Ambil daftar unik asal instansi untuk autocomplete di form Admin
        $daftarInstansiUntukAutocomplete = $this->tamuModel->distinct()
                                                          ->select('asal_instansi')
                                                          ->where('asal_instansi IS NOT NULL')
                                                          ->where('asal_instansi !=', '')
                                                          ->orderBy('asal_instansi', 'ASC')
                                                          ->findAll();
        $instansiListForAdmin = array_column($daftarInstansiUntukAutocomplete, 'asal_instansi');
        // --- AKHIR PERBAIKAN PENEMPATAN KODE ---

        $data = [
            'title' => 'Data Tamu',
            'dataTamu' => $dataTamu,
            'usersNotYetTamu' => $usersNotYetTamu,
            'instansiListForAdmin' => json_encode($instansiListForAdmin), // Kirimkan ini ke view
        ];
        return view('admin/data_tamu', $data);
    }


    public function tambahTamu()
    {
        // --- Perbaikan di sini untuk menangani pilihan user_id dari dropdown ---
        $selectedUserId = $this->request->getPost('user_id_from_account'); // Ambil dari dropdown
        $inputNamaLengkap = $this->request->getPost('nama_lengkap');

        // Validasi
        $rules = [
            'asal_instansi' => 'permit_empty|max_length[255]',
            'no_telepon'    => 'permit_empty|max_length[20]',
            'email'         => 'permit_empty|valid_email|is_unique[t_tamu.email]',
            'alamat'        => 'permit_empty',
        ];

        if (empty($selectedUserId)) { // Jika tidak ada user_id yang dipilih, maka ini input manual
            $rules['nama_lengkap'] = 'required|min_length[3]|max_length[255]';
        } else { // Jika user_id dipilih, nama_lengkap akan diambil dari user account
            $rules['user_id_from_account'] = 'required|is_natural_no_zero';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'asal_instansi' => $this->request->getPost('asal_instansi'),
            'no_telepon'    => $this->request->getPost('no_telepon'),
            'email'         => $this->request->getPost('email'),
            'alamat'        => $this->request->getPost('alamat'),
        ];

        if (!empty($selectedUserId)) {
            // Jika user_id dipilih, ambil nama lengkap dari tabel users
            $user = $this->userModel->find($selectedUserId);
            if ($user) {
                $data['user_id'] = $selectedUserId;
                $data['nama_lengkap'] = $user['nama_lengkap'];
            } else {
                return redirect()->back()->withInput()->with('error', 'User yang dipilih tidak valid.');
            }
        } else {
            // Jika user_id tidak dipilih, gunakan nama lengkap dari input form
            $data['user_id'] = null;
            $data['nama_lengkap'] = $inputNamaLengkap;
        }


        if ($this->tamuModel->insert($data)) {
            return redirect()->to('/admin/data-tamu')->with('success', 'Data tamu berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data tamu. ' . implode(', ', $this->tamuModel->errors()));
        }
    }


     public function editTamu()
    {
        $id = $this->request->getPost('id_tamu');
        $rules = [
            'id_tamu'       => 'required|is_natural_no_zero',
            'nama_lengkap'  => 'required|min_length[3]|max_length[255]',
            'asal_instansi' => 'permit_empty|max_length[255]',
            'no_telepon'    => 'permit_empty|max_length[20]',
            'email'         => 'permit_empty|valid_email|is_unique[t_tamu.email,id_tamu,{id_tamu}]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'asal_instansi' => $this->request->getPost('asal_instansi'),
            'no_telepon'    => $this->request->getPost('no_telepon'),
            'email'         => $this->request->getPost('email'),
            'alamat'        => $this->request->getPost('alamat'),
        ];

        if ($this->tamuModel->update($id, $data)) {
            return redirect()->to('/admin/data-tamu')->with('success', 'Data tamu berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data tamu. ' . implode(', ', $this->tamuModel->errors()));
        }
    }

    public function hapusTamu($id)
    {
        try {
            $tamu = $this->tamuModel->find($id);
            if ($tamu) {
                // Jika tamu ini terhubung dengan user_id, pastikan user_id tersebut juga dihapus jika perlu
                // Atau set user_id di t_tamu menjadi NULL jika user_id dihapus dari tabel users
                // Namun, kita asumsikan Foreign Key ON DELETE CASCADE pada users->t_tamu sudah ada

                // Hapus semua riwayat kunjungan terkait tamu ini terlebih dahulu
                $this->kunjunganModel->where('id_tamu', $id)->delete();
                // Kemudian hapus data tamunya
                $this->tamuModel->delete($id);
            }
            return redirect()->to('/admin/data-tamu')->with('success', 'Data tamu dan riwayat kunjungannya berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->to('/admin/data-tamu')->with('error', 'Gagal menghapus data tamu: ' . $e->getMessage());
        }
    }

    // --- Manajemen Riwayat Kunjungan ---
    public function riwayatKunjungan()
    {
        $riwayatKunjungan = $this->kunjunganModel->getKunjunganWithDetails();
        $daftarTamu = $this->tamuModel->findAll(); // Ini untuk dropdown di form
        $daftarTujuan = $this->tujuanModel->findAll();

        $data = [
            'title' => 'Riwayat Kunjungan',
            'riwayatKunjungan' => $riwayatKunjungan,
            'daftarTamu' => $daftarTamu,
            'daftarTujuan' => $daftarTujuan,
        ];
        // dd($data);
        return view('admin/riwayat_kunjungan', $data);
    }

    public function tambahKunjungan()
    {
        $rules = [
            'id_tamu'     => 'required|is_natural_no_zero',
            'id_tujuan'   => 'permit_empty|is_natural_no_zero',
            'keperluan'   => 'required|min_length[10]',
            'tanggal_kunjungan' => 'required|valid_date',
            'waktu_masuk' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id_tamu'           => $this->request->getPost('id_tamu'),
            'id_tujuan'         => $this->request->getPost('id_tujuan') ? $this->request->getPost('id_tujuan') : null,
            'tanggal_kunjungan' => $this->request->getPost('tanggal_kunjungan') ?? date('Y-m-d'),
            'waktu_masuk'       => $this->request->getPost('waktu_masuk') ?? date('H:i:s'),
            'keperluan'         => $this->request->getPost('keperluan'),
            'waktu_keluar'      => null,
            'catatan'           => $this->request->getPost('catatan'),
            'status_persetujuan'  => "menunggu",
        ];

        if ($this->kunjunganModel->insert($data)) {
            return redirect()->to('/admin/riwayat-kunjungan')->with('success', 'Kunjungan berhasil dicatat.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mencatat kunjungan. ' . implode(', ', $this->kunjunganModel->errors()));
        }
    }

    public function updateWaktuKeluar($id_kunjungan)
    {
        $kunjungan = $this->kunjunganModel->find($id_kunjungan);

        if (!$kunjungan) {
            return redirect()->back()->with('error', 'Kunjungan tidak ditemukan.');
        }

        if (empty($kunjungan['waktu_keluar'])) {
            $data = [
                'waktu_keluar' => date('H:i:s'),
            ];
            if ($this->kunjunganModel->update($id_kunjungan, $data)) {
                return redirect()->back()->with('success', 'Waktu keluar berhasil dicatat.');
            } else {
                return redirect()->back()->with('error', 'Gagal mencatat waktu keluar.');
            }
        } else {
            return redirect()->back()->with('info', 'Waktu keluar sudah dicatat sebelumnya.');
        }
    }

    public function editKunjungan()
    {
        $id = $this->request->getPost('id_kunjungan');
        $rules = [
            'id_kunjungan'      => 'required|is_natural_no_zero',
            'id_tamu'           => 'required|is_natural_no_zero',
            'id_tujuan'         => 'permit_empty|is_natural_no_zero',
            'tanggal_kunjungan' => 'required|valid_date',
            'waktu_masuk'       => 'required',
            'keperluan'         => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id_tamu'           => $this->request->getPost('id_tamu'),
            'id_tujuan'         => $this->request->getPost('id_tujuan') ? $this->request->getPost('id_tujuan') : null,
            'tanggal_kunjungan' => $this->request->getPost('tanggal_kunjungan'),
            'waktu_masuk'       => $this->request->getPost('waktu_masuk'),
            'waktu_keluar'      => $this->request->getPost('waktu_keluar') ? $this->request->getPost('waktu_keluar') : null,
            'keperluan'         => $this->request->getPost('keperluan'),
            'catatan'           => $this->request->getPost('catatan'),
        ];

        if ($this->kunjunganModel->update($id, $data)) {
            return redirect()->to('/admin/riwayat-kunjungan')->with('success', 'Data kunjungan berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data kunjungan. ' . implode(', ', $this->kunjunganModel->errors()));
        }
    }

    public function hapusKunjungan($id)
    {
        try {
            $this->kunjunganModel->delete($id);
            return redirect()->to('/admin/riwayat-kunjungan')->with('success', 'Kunjungan berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->to('/admin/riwayat-kunjungan')->with('error', 'Gagal menghapus kunjungan: ' . $e->getMessage());
        }
    }

    // --- Manajemen Tujuan Kunjungan ---
    public function tujuanKunjungan()
    {
        $dataTujuan = $this->tujuanModel->findAll();

        $data = [
            'title' => 'Manajemen Tujuan Kunjungan',
            'dataTujuan' => $dataTujuan,
        ];
        return view('admin/tujuan_kunjungan', $data);
    }

    public function tambahTujuan()
    {
        $rules = [
            'nama_tujuan' => 'required|min_length[3]|is_unique[t_tujuan.nama_tujuan]',
            'deskripsi'   => 'permit_empty|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_tujuan' => $this->request->getPost('nama_tujuan'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
        ];
        if ($this->tujuanModel->insert($data)) {
            return redirect()->to('/admin/tujuan-kunjungan')->with('success', 'Tujuan kunjungan berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan tujuan kunjungan.');
        }
    }

    public function editTujuan()
    {
        $id = $this->request->getPost('id_tujuan');
        $rules = [
            'id_tujuan'   => 'required|is_natural_no_zero',
            'nama_tujuan' => 'required|min_length[3]|is_unique[t_tujuan.nama_tujuan,id_tujuan,{id_tujuan}]',
            'deskripsi'   => 'permit_empty|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_tujuan' => $this->request->getPost('nama_tujuan'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
        ];
        if ($this->tujuanModel->update($id, $data)) {
            return redirect()->to('/admin/tujuan-kunjungan')->with('success', 'Tujuan kunjungan berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui tujuan kunjungan.');
        }
    }

    public function hapusTujuan($id)
    {
        try {
            // Set id_tujuan di t_kunjungan menjadi NULL sebelum menghapus tujuan
            $this->kunjunganModel->where('id_tujuan', $id)->set(['id_tujuan' => null])->update();
            $this->tujuanModel->delete($id);
            return redirect()->to('/admin/tujuan-kunjungan')->with('success', 'Tujuan kunjungan berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->to('/admin/tujuan-kunjungan')->with('error', 'Gagal menghapus tujuan kunjungan: ' . $e->getMessage());
        }
    }

    // --- Laporan ---
    public function laporanHarian()
    {
        $tanggal = $this->request->getVar('tanggal') ?? date('Y-m-d');
        $laporan = $this->kunjunganModel->getKunjunganWithDetails(['date' => $tanggal]);

        $data = [
            'title' => 'Laporan Kunjungan Harian',
            'laporan' => $laporan,
            'tanggal' => $tanggal,
        ];
        return view('admin/laporan_harian', $data);
    }

    public function laporanBulanan()
    {
        $tahun = $this->request->getVar('tahun') ?? date('Y');
        $bulan = $this->request->getVar('bulan') ?? date('m');
        $laporan = $this->kunjunganModel->getKunjunganWithDetails(['month' => $bulan, 'year' => $tahun]);

        $data = [
            'title' => 'Laporan Kunjungan Bulanan',
            'laporan' => $laporan,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ];
        return view('admin/laporan_bulanan', $data);
    }

    public function laporanTahunan()
    {
        $tahun = $this->request->getVar('tahun') ?? date('Y');
        $laporanSummary = $this->kunjunganModel
            ->select('MONTH(tanggal_kunjungan) as bulan, COUNT(id_kunjungan) as total_kunjungan')
            ->where('YEAR(tanggal_kunjungan)', $tahun)
            ->groupBy('MONTH(tanggal_kunjungan)')
            ->orderBy('bulan', 'ASC')
            ->findAll();

        $data = [
            'title' => 'Laporan Kunjungan Tahunan',
            'laporanSummary' => $laporanSummary,
            'tahun' => $tahun,
        ];
        return view('admin/laporan_tahunan', $data);
    }

    public function exportPdfLaporan()
    {
        $filterType = $this->request->getVar('filter_type');
        $dataLaporan = [];
        $title = "Laporan Kunjungan";
        $filterInfo = "";
        $laporanSummary = [];

        if ($filterType === 'harian') {
            $tanggal = $this->request->getVar('tanggal') ?? date('Y-m-d');
            $dataLaporan = $this->kunjunganModel->getKunjunganWithDetails(['date' => $tanggal]);
            $title .= " Harian";
            $filterInfo = "Tanggal: " . date('d M Y', strtotime($tanggal));
        } elseif ($filterType === 'bulanan') {
            $tahun = $this->request->getVar('tahun') ?? date('Y');
            $bulan = $this->request->getVar('bulan') ?? date('m');
            $dataLaporan = $this->kunjunganModel->getKunjunganWithDetails(['month' => $bulan, 'year' => $tahun]);
            $title .= " Bulanan";
            $filterInfo = "Bulan: " . date('F', mktime(0, 0, 0, $bulan, 10)) . " " . $tahun;
        } elseif ($filterType === 'tahunan') {
            $tahun = $this->request->getVar('tahun') ?? date('Y');
            $dataLaporan = $this->kunjunganModel->getKunjunganWithDetails(['year_only' => $tahun]);
            $title .= " Tahunan";
            $filterInfo = "Tahun: " . $tahun;
        } else {
            $dataLaporan = $this->kunjunganModel->getKunjunganWithDetails();
            $title = "Laporan Semua Kunjungan";
        }

        $dompdf = new Dompdf();
        $html = view('admin/print_laporan', [
            'title' => $title,
            'filterInfo' => $filterInfo,
            'laporan' => $dataLaporan,
            'filterType' => $filterType,
            'laporanSummary' => $laporanSummary
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream(str_replace(" ", "_", $title) . '_' . date('Ymd_His') . '.pdf', ['Attachment' => true]);
    }

    // --- Pengaturan Akun (untuk admin) ---
    public function pengaturanAkun()
    {
        // Ambil semua user (Admin, Kepala Bagian, Masyarakat)
        $users = $this->userModel->findAll();

        $data = [
            'title' => 'Pengaturan Akun',
            'users' => $users,
        ];
        return view('admin/pengaturan_akun', $data);
    }
    public function tambahUser()
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[3]|max_length[255]',
            'username'     => 'required|min_length[5]|is_unique[users.username]',
            'password'     => 'required|min_length[8]',
            'role'         => 'required|in_list[1,2,3]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'         => $this->request->getPost('role'),
        ];

        if ($this->userModel->insert($data)) {
            $user_id = $this->userModel->getInsertID(); // Dapatkan ID user yang baru dibuat

            // --- Perbaikan di sini: Jika role adalah masyarakat (1), buat juga entri di t_tamu ---
            if ($this->request->getPost('role') == 1) {
                $tamuData = [
                    'user_id'       => $user_id,
                    'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
                    'email'         => null, // Ambil dari input jika ada
                    'asal_instansi' => null, // Ambil dari input jika ada
                    'no_telepon'    => null,
                    'alamat'        => null,
                ];
                // Coba insert ke t_tamu, tangani error jika ada
                if (!$this->tamuModel->insert($tamuData)) {
                    // Jika gagal membuat tamu, Anda bisa log error atau tampilkan pesan lain
                    // Tapi user sudah terbuat, jadi mungkin tidak perlu di-rollback otomatis
                    log_message('error', 'Gagal membuat entri tamu untuk user_id: ' . $user_id . '. Errors: ' . implode(', ', $this->tamuModel->errors()));
                }
            }
            // --------------------------------------------------------------------------------------
            return redirect()->to('/admin/pengaturan-akun')->with('success', 'Pengguna berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan pengguna. ' . implode(', ', $this->userModel->errors()));
        }
    }

    public function editUser()
    {
        $id = $this->request->getPost('id_user');
        $rules = [
            'id_user'      => 'required|is_natural_no_zero',
            'nama_lengkap' => 'required|min_length[3]|max_length[255]',
            'username'     => 'required|min_length[5]|is_unique[users.username,id,{id_user}]',
            'role'         => 'required|in_list[1,2,3]',
        ];

        if ($this->request->getPost('password_new')) {
            $rules['password_new'] = 'min_length[8]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'role'         => $this->request->getPost('role'),
        ];

        if ($this->request->getPost('password_new')) {
            $data['password'] = password_hash($this->request->getPost('password_new'), PASSWORD_DEFAULT);
        }

        if ($this->userModel->update($id, $data)) {
            // --- Perbaikan di sini: Logika penanganan tamu saat edit user ---
            $newRole = $this->request->getPost('role');
            $tamu = $this->tamuModel->where('user_id', $id)->first(); // Cek apakah sudah ada entri tamu

            if ($newRole == 1) { // Jika role BARU adalah Masyarakat
                if (!$tamu) { // Jika belum punya entri tamu, buat yang baru
                    $tamuData = [
                        'user_id'       => $id,
                        'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
                        'email'         => null, // Ambil dari form jika ada
                        'asal_instansi' => null, // Ambil dari form jika ada
                        'no_telepon'    => null,
                        'alamat'        => null,
                    ];
                    $this->tamuModel->insert($tamuData);
                } else { // Jika sudah punya, update nama lengkap jika berubah
                    $this->tamuModel->update($tamu['id_tamu'], ['nama_lengkap' => $data['nama_lengkap']]);
                }
            } else { // Jika role BARU BUKAN Masyarakat (Admin/Kepala Bagian)
                if ($tamu) { // Jika sebelumnya adalah masyarakat dan punya entri tamu
                    // Hapus semua kunjungan terkait tamu ini
                    $this->kunjunganModel->where('id_tamu', $tamu['id_tamu'])->delete();
                    // Hapus entri tamu
                    $this->tamuModel->delete($tamu['id_tamu']);
                }
            }
            // --------------------------------------------------------------------
            return redirect()->to('/admin/pengaturan-akun')->with('success', 'Pengguna berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui pengguna. ' . implode(', ', $this->userModel->errors()));
        }
    }

    public function hapusUser($id)
    {
        try {
            $user = $this->userModel->find($id);
            if ($user) {
                // Jika user adalah masyarakat (role 1)
                if ($user['role'] == 1) {
                    $tamu = $this->tamuModel->where('user_id', $id)->first();
                    if ($tamu) {
                        $this->kunjunganModel->where('id_tamu', $tamu['id_tamu'])->delete();
                        $this->tamuModel->delete($tamu['id_tamu']);
                    }
                }
                $this->userModel->delete($id);
            }
            return redirect()->to('/admin/pengaturan-akun')->with('success', 'Pengguna berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->to('/admin/pengaturan-akun')->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }
}