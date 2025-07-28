<?php

namespace App\Models;

use CodeIgniter\Model;

class TujuanModel extends Model
{
    protected $table = 't_tujuan';
    protected $primaryKey = 'id_tujuan';
    protected $allowedFields = [
        'nama_tujuan',
        'deskripsi',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Optional: Add validation rules
    protected $validationRules = [
        'nama_tujuan' => 'required|min_length[3]|is_unique[t_tujuan.nama_tujuan,id_tujuan,{id_tujuan}]',
        'deskripsi'   => 'permit_empty|max_length[500]',
    ];
    protected $validationMessages = [
        'nama_tujuan' => [
            'is_unique' => 'Nama tujuan ini sudah ada.'
        ],
    ];
    protected $skipValidation = false;
}