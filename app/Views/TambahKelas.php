<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Tambah Kelas<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="mb-3">
        <div class="row">
            <div class="col-md-6">
                <h1 class="h3 mb-0 text-gray-800">Tambah Data Kelas</h1>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">

                <form action="/kelas/simpan" method="post">
                    <?= csrf_field() ?>

                    <div class="card-body">

                        <!-- Error validasi -->
                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger">
                                <i class="fa fa-exclamation-circle"></i>
                                Ada kesalahan dalam pengisian form:
                                <ul class="mt-2">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Error umum -->
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <i class="fa fa-exclamation-circle"></i>
                                <?= esc(session()->getFlashdata('error')) ?>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="kelas">Nama Kelas</label>
                            <input type="text"
                                class="form-control"
                                id="kelas"
                                name="kelas"
                                placeholder="Masukkan nama kelas"
                                value="<?= old('kelas') ?>">
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <button type="button" class="btn btn-primary" id="btnSubmit">
                            Simpan
                        </button>
                        <a href="/kelas" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('btnSubmit').addEventListener('click', function() {
        Swal.fire({
            title: 'Apakah Anda yakin akan menyimpan data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector('form').submit();
            }
        });
    });
</script>

<?= $this->endSection() ?>