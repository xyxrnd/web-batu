<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6">
                <div class="card shadow-lg my-5">
                    <div class="card-body p-4">

                        <h4 class="text-center mb-4">Sigertengah <br>Gemstone</h4>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger text-center">
                                <?= esc(session()->getFlashdata('error')) ?>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="/login">
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
                                <label>Password</label>
                                <input type="password"
                                    name="password"
                                    class="form-control"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                Login
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a href="/register">
                                Belum punya akun? Daftar
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>