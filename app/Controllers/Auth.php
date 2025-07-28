<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\TamuModel; // Pastikan TamuModel sudah di-use
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    protected $userModel;
    protected $tamuModel; // Pastikan ini diinisialisasi

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->tamuModel = new TamuModel(); // Inisialisasi TamuModel
        helper(['form', 'url']);
    }

    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
            'role'     => 'required|in_list[1,2,3]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $role = $this->request->getPost('role');

        $user = $this->userModel->where('username', $username)->where('role', $role)->first();

        if ($user && password_verify($password, $user['password'])) {
            $userData = [
                'user_id'    => $user['id'],
                'username'   => $user['username'],
                'nama_lengkap' => $user['nama_lengkap'],
                'role'       => $user['role'],
                'isLoggedIn' => true,
            ];
            session()->set($userData);

            if ($user['role'] == 2) { // Admin
                return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang Admin!');
            } elseif ($user['role'] == 3) { // Kepala Bagian
                return redirect()->to('/kepala-bagian')->with('success', 'Selamat datang Kepala Bagian!');
            } elseif ($user['role'] == 1) { // Masyarakat
                return redirect()->to('/masyarakat')->with('success', 'Selamat datang!');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Username, password, atau peran salah.');
        }
    }

    public function registerMasyarakat()
    {
        $rules = [
            'nama_lengkap'        => 'required|min_length[3]|max_length[255]',
            'username'            => 'required|min_length[5]|is_unique[users.username]',
            'password'            => 'required|min_length[8]',
            'konfirmasi_password' => 'required_with[password]|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors())
                             ->with('openRegisterModal', true);
        }

        // Data untuk tabel `users`
        $userData = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'         => 1, // Role 1 untuk Masyarakat
        ];

        // --- Perbaikan di sini: Pastikan insert ke users berhasil sebelum ke t_tamu ---
        if ($this->userModel->insert($userData)) {
            $user_id = $this->userModel->getInsertID(); // Dapatkan ID user yang baru dibuat

            // Data untuk tabel `t_tamu`
            $tamuData = [
                'user_id'       => $user_id, // Gunakan user_id yang baru didapat
                'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
                'email'         => null, // Email bisa null atau ambil dari form jika ada
                'asal_instansi' => null, // Instansi bisa null atau ambil dari form jika ada
                'no_telepon'    => null, // Telepon bisa null atau ambil dari form jika ada
                'alamat'        => null, // Alamat bisa null atau ambil dari form jika ada
            ];

            // Coba masukkan data ke t_tamu. Tangani jika ada error.
            if ($this->tamuModel->insert($tamuData)) {
                return redirect()->to('/auth')->with('success', 'Registrasi berhasil! Silakan login dengan username dan password Anda.');
            } else {
                // Jika gagal membuat entri tamu, hapus user yang sudah dibuat
                $this->userModel->delete($user_id);
                return redirect()->back()->withInput()
                                 ->with('error', 'Gagal membuat profil tamu. Silakan coba lagi atau hubungi admin.')
                                 ->with('errors', $this->tamuModel->errors()) // Tambahkan error model tamu
                                 ->with('openRegisterModal', true);
            }
        } else {
            return redirect()->back()->withInput()
                             ->with('error', 'Gagal mendaftar. Silakan coba lagi.')
                             ->with('errors', $this->userModel->errors()) // Tambahkan error model user
                             ->with('openRegisterModal', true);
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('info', 'Anda telah logout.');
    }
}