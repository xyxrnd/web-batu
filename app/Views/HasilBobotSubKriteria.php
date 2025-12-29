<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Hasil Bobot Sub Kriteria AHP<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    ```
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Hasil Bobot Sub Kriteria (Group AHP)</h1>
        <a href="/ahp" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <strong>Kriteria :</strong> <?= esc($kriteria['kriteria']) ?>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:5%">No</th>
                            <th>Sub Kriteria</th>
                            <th style="width:20%">Bobot</th>
                            <th style="width:30%">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($hasil)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    <em>Sub kriteria belum ada</em>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1;
                            foreach ($hasil as $h): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($h['nama_sub']) ?></td>
                                    <td><?= number_format($h['bobot'], 4) ?></td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-success"
                                                role="progressbar"
                                                style="width: <?= $h['persen'] ?>%">
                                                <?= $h['persen'] ?>%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

            <div class="alert alert-info mt-4">
                <strong>Catatan:</strong><br>
                Bobot kriteria dihitung menggunakan <b>Group AHP</b> dengan pendekatan <i>geometric mean</i>
                dari seluruh penilai. Nilai persentase menunjukkan tingkat kepentingan relatif tiap kriteria.
            </div>

        </div>
    </div>
    ```

</div>

<?= $this->endSection() ?>