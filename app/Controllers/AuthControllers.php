<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModels;

class AuthControllers extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = new UserModels();
    }

    // =====================
    // FORM LOGIN
    // =====================
    public function Login()
    {
        // Kalau sudah login, jangan balik ke login
        if (session()->get('isLogin')) {
            return redirect()->to('/');
        }

        return view('login');
    }

    // =====================
    // PROSES LOGIN
    // =====================
    public function ProsesLogin()
    {
        $rules = [
            'nama'     => 'required',
            'password' => 'required'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nama dan password wajib diisi');
        }

        $nama     = $this->request->getPost('nama');
        $password = $this->request->getPost('password');

        $user = $this->user->getUserByNama($nama);

        // User tidak ditemukan
        if (! $user) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nama tidak ditemukan');
        }

        // Password salah
        if (! password_verify($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Password salah');
        }

        // 🔐 Regenerate session (anti session fixation)
        session()->regenerate();

        // Simpan session (WAJIB isLogin)
        session()->set([
            'id_user' => $user['id_user'],
            'nama'    => $user['nama'],
            'role'    => $user['role'],
            'isLogin' => true
        ]);

        session()->setFlashdata('welcome', 'Selamat datang, ' . $user['nama']);

        // Redirect sesuai role
        switch ($user['role']) {
            case 'admin':
                return redirect()->to('/');

            case 'pelanggan':
                return redirect()->to('/');

            default:
                return redirect()->to('/');
        }
    }

    // =====================
    // LOGOUT
    // =====================
    public function Logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
