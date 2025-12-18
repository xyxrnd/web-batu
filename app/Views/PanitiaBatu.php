<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Kelola Batu<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-center">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <!-- Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Data Batu</h1>
        <a href="/batu/tambah" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-500"></i> Tambah
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Batu</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Jenis Batu</th>
                            <th>Kelas</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($batu)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($batu as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($row['jenis_batu']) ?></td>
                                    <td><?= esc($row['kelas']) ?></td>
                                    <td class="text-center">
                                        <a href="/ahp/hasil/<?= $row['id_batu'] ?>"
                                            class="btn btn-info btn-sm">
                                            <i class="fa fa-balance-scale"></i> Hasil Bobot
                                        </a>
                                        <a href="/batu/edit/<?= $row['id_batu'] ?>"
                                            class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>

                                        <button onclick="hapus(<?= $row['id_batu'] ?>)"
                                            class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Data batu belum tersedia
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>

<script>
    function hapus(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/batu/hapus/" + id;
            }
        });
    }
</script>

<?= $this->endSection() ?>