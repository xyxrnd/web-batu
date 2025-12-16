<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class KriteriaControllers extends BaseController
{
    public function DaftarKriteria()
    {
        return view('PanitiaKriteria');
    }

    public function TambahKriteria()
    {
        return view('TambahKriteria');
    }
}
