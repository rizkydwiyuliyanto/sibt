<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class KepalaBagianFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }
        // Periksa role: 3 untuk Kepala Bagian
        if (session()->get('role') != 3) {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki akses sebagai Kepala Bagian.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}