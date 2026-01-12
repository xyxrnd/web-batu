<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModels;

class UserControllers extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = new UserModels();
    }

    // =========================
    // READ
    // =========================
    public function index()
    {
        $data['users'] = $this->user->findAll();
        return view('PanitiaUser', $data);
    }

    // =========================
    // CREATE (Form)
    // =========================
    public function create()
    {
        return view('TambahUser');
    }

    // =========================
    // CREATE (Simpan)
    // =========================
    public function store()
    {
        $rules = [
            'nama'     => 'required|min_length[3]',
            'no_hp'    => 'required|numeric|min_length[10]',
            'password' => 'required|min_length[6]',
            'role'     => 'required'
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
            'role'     => $this->request->getPost('role')
        ]);

        return redirect()->to('/user')
            ->with('success', 'Data user berhasil ditambahkan');
    }

    // =========================
    // UPDATE (Form)
    // =========================
    public function edit($id_user)
    {
        $data['user'] = $this->user->find($id_user);
        return view('EditUser', $data);
    }

    // =========================
    // UPDATE (Proses)
    // =========================
    public function update($id_user)
    {
        $rules = [
            'nama'  => 'required|min_length[3]',
            'no_hp' => 'required|numeric|min_length[10]',
            'role'  => 'required'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama'  => $this->request->getPost('nama'),
            'no_hp' => $this->request->getPost('no_hp'),
            'role'  => $this->request->getPost('role')
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
        }

        $this->user->update($id_user, $data);

        return redirect()->to('/user')
            ->with('success', 'Data user berhasil diupdate');
    }

    // =========================
    // DELETE (POST ONLY)
    // =========================
    public function delete($id_user)
    {
        $this->user->delete($id_user);

        return redirect()->to('/user')
            ->with('success', 'Data user berhasil dihapus');
    }
}
