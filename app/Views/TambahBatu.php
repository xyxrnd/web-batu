<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Tambah Batu<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Batu</h1>
    </div>

    <div class="mb-3">
        <div class="row">
            <div class="col-md-6">
                <h1 class="h3 d-inline align-middle">Data Batu</h1>
            </div>
            <div class="col-md-6 text-right">
                <a href="/batu" class="btn btn-primary">
                    <i class="fa fa-arrow-left fa-sm"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">

                <form action="/batu/simpan" method="post">
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

                        <!-- Jenis Batu -->
                        <div class="form-group">
                            <label for="jenis_batu">Jenis Batu</label>
                            <input
                                type="text"
                                class="form-control"
                                id="jenis_batu"
                                name="jenis_batu"
                                value="<?= old('jenis_batu') ?>"
                                placeholder="Masukkan jenis batu"
                                required>
                        </div>

                        <!-- Kelas Batu -->
                        <div class="form-group">
                            <label for="id_kelas">Kelas</label>
                            <select
                                name="id_kelas"
                                id="id_kelas"
                                class="form-control"
                                required>
                                <option value="">-- Pilih Kelas --</option>

                                <?php foreach ($kelas as $k): ?>
                                    <option
                                        value="<?= $k['id_kelas'] ?>"
                                        <?= old('id_kelas') == $k['id_kelas'] ? 'selected' : '' ?>>
                                        <?= esc($k['kelas']) ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <button type="button" class="btn btn-primary" id="btnSubmit">
                            <i class="fa fa-save mr-2"></i>Simpan
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