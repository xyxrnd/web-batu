<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Tambah Kriteria<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Kriteria</h1>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">

                <form action="/kriteria/simpan" method="post">
                    <?= csrf_field() ?>

                    <div class="card-body">

                        <!-- Error Validasi -->
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

                        <div class="form-group">
                            <label for="kriteria">Nama Kriteria</label>
                            <input
                                type="text"
                                class="form-control"
                                id="kriteria"
                                name="kriteria"
                                value="<?= old('kriteria') ?>"
                                placeholder="Masukkan nama kriteria"
                                required>
                        </div>

                    </div>

                    <div class="card-footer text-left">
                        <button type="button" class="btn btn-primary" id="btnSubmit">
                            <i class="fa fa-save mr-2"></i>Simpan
                        </button>
                        <a href="/kriteria" class="btn btn-secondary">
                            <i class="fa fa-arrow-left fa-sm"></i> Kembali
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