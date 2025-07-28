<?php

namespace App\Models;

use CodeIgniter\Model;

class TamuModel extends Model
{
    protected $table = 't_tamu';
    protected $primaryKey = 'id_tamu';
    protected $allowedFields = [
        'user_id',
        'nama_lengkap',
        'asal_instansi',
        'no_telepon',
        'email',
        'alamat',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Optional: Add validation rules
    protected $validationRules = [
        'nama_lengkap'  => 'required|min_length[3]',
        'asal_instansi' => 'permit_empty|max_length[255]',
        'no_telepon'    => 'permit_empty|max_length[20]',
        'email'         => 'permit_empty|valid_email|is_unique[t_tamu.email,id_tamu,{id_tamu}]',
        'alamat'        => 'permit_empty',
    ];
    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Email ini sudah terdaftar sebagai tamu lain.'
        ],
    ];
    protected $skipValidation = false;
}