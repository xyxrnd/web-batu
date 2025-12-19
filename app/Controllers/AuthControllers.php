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
    // FORM REGISTER
    // =====================
    public function Register()
    {
        // Jika sudah login, tidak boleh register
        if (session()->get('isLogin')) {
            return redirect()->to('/');
        }

        return view('register');
    }

    // =====================
    // PROSES REGISTER
    // =====================
    public function ProsesRegister()
    {
        $rules = [
            'nama' => [
                'rules'  => 'required|is_unique[t_user.nama]',
                'errors' => [
                    'required'  => 'Nama wajib diisi',
                    'is_unique' => 'Nama sudah digunakan'
                ]
            ],
            'no_hp' => [
                'rules'  => 'required|numeric|min_length[10]|max_length[13]|is_unique[t_user.no_hp]',
                'errors' => [
                    'required'   => 'No HP wajib diisi',
                    'numeric'    => 'No HP harus angka',
                    'min_length' => 'No HP minimal 10 digit',
                    'max_length' => 'No HP maksimal 13 digit',
                    'is_unique'  => 'No HP sudah terdaftar'
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[6]',
                'errors' => [
                    'required'   => 'Password wajib diisi',
                    'min_length' => 'Password minimal 6 karakter'
                ]
            ],
            'password_confirm' => [
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password wajib diisi',
                    'matches'  => 'Password tidak sama'
                ]
            ]
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->user->insert([
            'nama'     => $this->request->getPost('nama'),
            'no_hp'    => $this->request->getPost('no_hp'),
            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'role'     => 'peserta'
        ]);

        return redirect()->to('/login')
            ->with('success', 'Registrasi berhasil, silakan login');
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
