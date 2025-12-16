<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class BatuControllers extends BaseController
{
    public function DaftarBatu()
    {
        return view('PanitiaBatu');
    }

    public function TambahBatu()
    {
        return view('TambahBatu');
    }
}
