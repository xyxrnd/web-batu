<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Detail Bobot Sub Kriteria<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Detail Bobot Sub Kriteria</h1>
        <a href="<?= base_url('ahp-sub/hasil/' . $batu['id_batu']) ?>"
            class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <strong>Jenis Batu:</strong> <?= esc($batu['jenis_batu']) ?><br>
            <strong>Sub Kriteria:</strong> <?= esc($sub['nama_sub']) ?>
        </div>

        <div class="card-body">

            <?php if (empty($detail)): ?>
                <div class="alert alert-warning text-center">
                    <em>Belum ada penilaian.</em>
                </div>
            <?php else: ?>

                <table class="table table-bordered">
                    <thead>
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
                                    <?= esc($d['sub1']) ?>
                                    <strong>vs</strong>
                                    <?= esc($d['sub2']) ?>
                                </td>
                                <td class="text-center">
                                    <?= $d['nilai'] ?>
                                </td>
                                <td>
                                    <?php if ($d['id_sub1'] == $sub['id_sub']): ?>
                                        Sub Kriteria <strong><?= esc($d['sub1']) ?></strong>
                                        dinilai <strong>lebih penting</strong>
                                        dibanding <?= esc($d['sub2']) ?>
                                    <?php else: ?>
                                        Sub Kriteria <strong><?= esc($d['sub2']) ?></strong>
                                        dinilai <strong>kurang penting</strong>
                                        dibanding <?= esc($d['sub1']) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="alert alert-info mt-3">
                    <strong>Kesimpulan:</strong><br>
                    Bobot sub kriteria <strong><?= esc($sub['nama_sub']) ?></strong>
                    terbentuk karena sebagian besar penilai memberikan nilai tinggi.
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>

<?= $this->endSection() ?>