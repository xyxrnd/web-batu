<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Kelola Pendaftaran<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-center">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <!-- Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Data Pendaftaran</h1>
        <a href="/pendaftaran/create" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-500"></i> Tambah
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pendaftaran</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pendaftar</th>
                            <th>Tanggal</th>
                            <th>Total Bayar</th>
                            <th>Status Bayar</th>
                            <th width="25%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1;
                        foreach ($pendaftaran as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($row['nama']) ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                                <td>Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
                                <td><?= esc($row['status_pembayaran']) ?></td>
                                <td class="text-center">
                                    <a href="/pendaftaran/detail/<?= $row['id_user'] ?>" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i> Detail
                                    </a>


                                    <a href="/pendaftaran/keuangan/<?= $row['id_user'] ?>"
                                        class="btn btn-success btn-sm">
                                        <i class="fa fa-money-bill"></i> Keuangan
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
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
            text: 'Data pendaftaran yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/pendaftaran/delete/" + id;
            }
        });
    }
</script>

<?= $this->endSection() ?>