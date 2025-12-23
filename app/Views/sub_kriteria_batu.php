<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Sub Kriteria Batu<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Sub Kriteria Batu</h1>
        <a href="/batu" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <strong>Jenis Batu:</strong> <?= esc($batu['jenis_batu']) ?>
        </div>

        <div class="card-body">

            <!-- ACTION BUTTON -->
            <div class="mb-3 d-flex justify-content-between">
                <a href="/sub-kriteria/batu/<?= $batu['id_batu'] ?>/tambah"
                    class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Tambah Sub Kriteria
                </a>

                <a href="/sub-kriteria/batu/<?= $batu['id_batu'] ?>/bobot"
                    class="btn btn-success btn-sm">
                    <i class="fa fa-balance-scale"></i> Berikan Bobot
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Sub Kriteria</th>
                            <th width="20%">Bobot</th>
                            <th width="30%">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($sub_kriteria)): ?>
                            <?php $no = 1;
                            foreach ($sub_kriteria as $sk): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($sk['nama_sub_kriteria']) ?></td>
                                    <td><?= number_format($sk['bobot'], 4) ?></td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-success"
                                                style="width: <?= $sk['persen'] ?>%">
                                                <?= $sk['persen'] ?>%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Sub kriteria belum tersedia
                                </td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>

            <div class="alert alert-info mt-4">
                <strong>Catatan:</strong><br>
                Bobot sub kriteria dihitung menggunakan <b>AHP</b> melalui
                perbandingan berpasangan.
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>