<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Kelola User<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-center">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Data User</h1>
        <a href="/user/tambah" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm"></i> Tambah User
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Role</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if ($users): ?>
                            <?php $no = 1;
                            foreach ($users as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($row['nama']) ?></td>
                                    <td><?= esc($row['no_hp']) ?></td>
                                    <td>
                                        <span class="badge badge-info">
                                            <?= esc($row['role']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">

                                        <a href="/user/edit/<?= $row['id_user'] ?>"
                                            class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>

                                        <form action="/user/hapus/<?= $row['id_user'] ?>"
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
                                <td colspan="5" class="text-center text-muted">
                                    Data user belum tersedia
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
            text: 'Data user yang dihapus tidak dapat dikembalikan!',
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