<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Detail Pendaftaran<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pendaftaran</h1>
        <a href="/pendaftaran" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
    </div>

    <!-- Card Nama -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="mb-0">
                <strong>Nama Pendaftar:</strong> <?= esc($nama) ?>
            </h5>
        </div>
    </div>

    <!-- Card Detail Batu -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Batu Akik yang Didaftarkan
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Batu</th>
                            <th>Jumlah Batu</th>
                            <th>Total Bayar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        $grandTotal = 0;
                        foreach ($pendaftaran as $row):
                            $grandTotal += $row['total_bayar'];
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($row['jenis_batu']) ?></td>
                                <td><?= esc($row['jumlah_batu']) ?></td>
                                <td>Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-right">Total Keseluruhan</th>
                            <th>Rp <?= number_format($grandTotal, 0, ',', '.') ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>