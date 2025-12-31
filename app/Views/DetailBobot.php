<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Detail Bobot AHP<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Detail Bobot Kriteria</h1>
        <a href="<?= base_url('ahp/hasil/' . $batu['id_batu']) ?>" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- INFO BATU & KRITERIA -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <strong>Jenis Batu:</strong> <?= esc($batu['jenis_batu']) ?><br>
            <strong>Kriteria:</strong> <?= esc($kriteria['kriteria']) ?>
        </div>

        <div class="card-body">

            <?php if (empty($detail)): ?>
                <div class="alert alert-warning text-center">
                    <em>Belum ada data penilaian untuk kriteria ini.</em>
                </div>
            <?php else: ?>

                <!-- TABEL DETAIL -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:5%">No</th>
                                <th style="width:20%">User</th>
                                <th style="width:30%">Perbandingan</th>
                                <th style="width:15%">Nilai</th>
                                <th style="width:30%">Penjelasan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($detail as $d): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($d['nama_user']) ?></td>
                                    <td>
                                        <?= esc($d['kriteria_1']) ?>
                                        <strong>vs</strong>
                                        <?= esc($d['kriteria_2']) ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $d['nilai'] ?>
                                    </td>
                                    <td>
                                        <?php if ($d['id_kriteria_1'] == $kriteria['id_kriteria']): ?>
                                            Kriteria <strong><?= esc($kriteria['kriteria']) ?></strong>
                                            dinilai <strong>lebih penting</strong>
                                            dibanding <?= esc($d['kriteria_2']) ?>
                                        <?php else: ?>
                                            Kriteria <strong><?= esc($kriteria['kriteria']) ?></strong>
                                            dinilai <strong>kurang penting</strong>
                                            dibanding <?= esc($d['kriteria_1']) ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- KESIMPULAN -->
                <div class="alert alert-info mt-3">
                    <strong>Kesimpulan:</strong><br>
                    Bobot kriteria <strong><?= esc($kriteria['kriteria']) ?></strong>
                    menjadi besar karena pada sebagian besar perbandingan,
                    kriteria ini dinilai lebih penting oleh para penilai.
                </div>

            <?php endif; ?>

        </div>
    </div>

</div>

<?= $this->endSection() ?>