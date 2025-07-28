<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class MasyarakatFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }
        // Periksa role: 1 untuk Masyarakat
        if (session()->get('role') != 1) {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki akses sebagai Masyarakat.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}