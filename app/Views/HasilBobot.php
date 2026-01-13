<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Hasil Bobot AHP<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Bobot Kriteria</h1>
        <a href="/batu" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <strong>Jenis Batu:</strong> <?= esc($batu['jenis_batu']) ?>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:5%">No</th>
                            <th style="width:20%">Kriteria</th>
                            <th style="width:40%">Persentase</th>
                            <th style="width:15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($hasil)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    <em>kriteria belum ada</em>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1;
                            foreach ($hasil as $h): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($h['kriteria']) ?></td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-success"
                                                role="progressbar"
                                                style="width: <?= $h['persen'] ?>%">
                                                <?= $h['persen'] ?>%
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('ahp-sub/hasil/' . $batu['id_batu'] . '/' . $h['id_kriteria']) ?>"
                                            class="btn btn-info btn-sm">
                                            Lihat Sub Kriteria
                                        </a>
                                        <a href="<?= base_url('ahp/detail/' . $id_batu . '/' . $h['id_kriteria']) ?>"
                                            class="btn btn-primary btn-sm">
                                            Detail Bobot
                                        </a>


                                    </td>


                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>