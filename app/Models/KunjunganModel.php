<?php

namespace App\Models;

use CodeIgniter\Model;

class KunjunganModel extends Model
{
    protected $table = 't_kunjungan';
    protected $primaryKey = 'id_kunjungan';
    protected $allowedFields = [
        'id_tamu',
        'id_tujuan',
        'tanggal_kunjungan',
        'waktu_masuk',
        'waktu_keluar',
        'keperluan',
        'catatan',
        'status_persetujuan',        // <-- TAMBAHAN BARU
        'catatan_persetujuan',       // <-- TAMBAHAN BARU
        'disetujui_oleh_user_id',    // <-- TAMBAHAN BARU
        'tanggal_persetujuan',       // <-- TAMBAHAN BARU
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'id_tamu'           => 'required|is_natural_no_zero',
        'id_tujuan'         => 'permit_empty|is_natural_no_zero',
        'tanggal_kunjungan' => 'required|valid_date',
        'waktu_masuk'       => 'required',
        'keperluan'         => 'required|min_length[10]',
        'status_persetujuan' => 'required|in_list[menunggu,disetujui,ditolak]', // <-- TAMBAHAN BARU
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function getKunjunganWithDetails($filters = [])
    {
        $builder = $this->db->table('t_kunjungan');
        // Tambahkan select nama user yang menyetujui
        $builder->select('t_kunjungan.*, t_tamu.*,t_tujuan.*, users.nama_lengkap as nama_penyetuju');
        $builder->join('t_tamu', 't_tamu.id_tamu = t_kunjungan.id_tamu');
        $builder->join('t_tujuan', 't_tujuan.id_tujuan = t_kunjungan.id_tujuan', 'left');
        $builder->join('users', 'users.id = t_kunjungan.disetujui_oleh_user_id', 'left'); // <-- JOIN BARU

        if (!empty($filters['id_tamu'])) {
            $builder->where('t_kunjungan.id_tamu', $filters['id_tamu']);
        }
        if (!empty($filters['date'])) {
            $builder->where('DATE(tanggal_kunjungan)', $filters['date']);
        }
        if (!empty($filters['month']) && !empty($filters['year'])) {
            $builder->where('MONTH(tanggal_kunjungan)', $filters['month']);
            $builder->where('YEAR(tanggal_kunjungan)', $filters['year']);
        }
        if (!empty($filters['year_only'])) {
            $builder->where('YEAR(tanggal_kunjungan)', $filters['year_only']);
        }
        if (!empty($filters['status_persetujuan'])) { // <-- FILTER BARU
            $builder->where('status_persetujuan', $filters['status_persetujuan']);
        }

        $builder->orderBy('tanggal_kunjungan', 'DESC');
        $builder->orderBy('waktu_masuk', 'DESC');
        // dd($builder->get()->getResultArray());
        return $builder->get()->getResultArray();
    }
}