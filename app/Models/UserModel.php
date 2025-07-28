<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_lengkap',
        'username',
        'password',
        'role',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true; // Akan mengisi created_at dan updated_at secara otomatis
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Optional: Add validation rules
    protected $validationRules = [
        'nama_lengkap' => 'required|min_length[3]',
        'username'     => 'required|min_length[5]|is_unique[users.username]',
        'password'     => 'required|min_length[8]',
        'role'         => 'required|in_list[1,2,3]', // Validate role values
    ];
    protected $validationMessages = [
        'username' => [
            'is_unique' => 'Username ini sudah digunakan.'
        ],
        'password' => [
            'min_length' => 'Password minimal 8 karakter.'
        ],
        'role' => [
            'in_list' => 'Peran yang dipilih tidak valid.'
        ]
    ];
    protected $skipValidation = false;
}