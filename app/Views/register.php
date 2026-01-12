<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6">
                <div class="card shadow-lg my-5">
                    <div class="card-body p-4">

                        <h4 class="text-center mb-4">Registrasi Akun</h4>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success text-center">
                                <?= esc(session()->getFlashdata('success')) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="/register/simpan">
                            <?= csrf_field() ?>

                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text"
                                    name="nama"
                                    class="form-control"
                                    value="<?= old('nama') ?>"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>No HP</label>
                                <input type="text"
                                    name="no_hp"
                                    class="form-control"
                                    value="<?= old('no_hp') ?>"
                                    placeholder="08xxxxxxxxxx"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password"
                                    name="password"
                                    class="form-control"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Konfirmasi Password</label>
                                <input type="password"
                                    name="password_confirm"
                                    class="form-control"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                Daftar
                            </button>
                        </form>

                        <hr>

                        <div class="text-center">
                            <a href="<?= base_url('login') ?>">
                                Sudah punya akun? Login
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>