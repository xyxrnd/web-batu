<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Kelola Sub Kriteria<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-center">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger text-center">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Sub Kriteria</h1>
        <a href="<?= site_url('sub-kriteria/tambah') ?>" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm"></i> Tambah Sub Kriteria
        </a>
        <a href="/ahp-sub"
            class="btn btn-info btn-sm">
            <i class="fa fa-balance-scale"></i> Kelola Bobot
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Sub Kriteria</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Sub Kriteria</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($sub)): ?>
                            <?php $no = 1;
                            foreach ($sub as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($row['nama_sub']) ?></td>
                                    <td class="text-center">

                                        <a href="<?= site_url('sub-kriteria/edit/' . $row['id_sub']) ?>"
                                            class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>

                                        <form action="<?= site_url('sub-kriteria/delete/' . $row['id_sub']) ?>"
                                            method="post"
                                            class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="button"
                                                onclick="confirmHapus(this.form)"
                                                class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    Data sub kriteria belum tersedia
                                </td>
                            </tr>
                        <?php endif ?>
                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>

<script>
    function confirmHapus(form) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data sub kriteria yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>

<?= $this->endSection() ?>