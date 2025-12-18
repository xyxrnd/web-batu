<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Tambah User<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Error Validasi -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah User</h6>
        </div>

        <div class="card-body">

            <form action="/user/simpan" method="post">
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
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="Panitia" <?= old('role') == 'Panitia' ? 'selected' : '' ?>>Panitia</option>
                        <option value="Peserta" <?= old('role') == 'Peserta' ? 'selected' : '' ?>>Peserta</option>
                        <option value="Juri" <?= old('role') == 'Juri' ? 'selected' : '' ?>>Juri</option>
                    </select>
                </div>

                <div class="text-right">
                    <a href="/user" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>