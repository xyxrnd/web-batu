<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Tambah Sub Kriteria<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Sub Kriteria</h1>
    </div>

    <div class="mb-3">
        <div class="row">
            <div class="col-md-6">
                <h1 class="h3 d-inline align-middle">Data Sub Kriteria</h1>
            </div>
            <div class="col-md-6 text-right">
                <a href="<?= site_url('sub-kriteria') ?>" class="btn btn-primary">
                    <i class="fa fa-arrow-left fa-sm"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">

                <form action="<?= site_url('sub-kriteria/store') ?>" method="post">
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
                            <label for="nama_sub">Nama Sub Kriteria</label>
                            <input type="text"
                                class="form-control"
                                id="nama_sub"
                                name="nama_sub"
                                placeholder="Masukkan nama sub kriteria"
                                value="<?= old('nama_sub') ?>">
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <button type="button" class="btn btn-primary" id="btnSubmit">
                            <i class="fa fa-save mr-2"></i> Simpan
                        </button>
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