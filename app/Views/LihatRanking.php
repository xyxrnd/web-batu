<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Lihat Ranking<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Ranking Batu Akik</h1>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama Peserta</th>
                            <th>Nomor Batu</th>
                            <th>Jenis Batu</th>
                            <th width="15%">Total Nilai</th>
                            <th width="5%">Peringkat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($ranking)): ?>
                            <?php foreach ($ranking as $row): ?>
                                <tr>
                                    <td><?= esc($row['nama']) ?></td>
                                    <td><?= esc($row['nomor_batu']) ?></td>
                                    <td><?= esc($row['jenis_batu']) ?></td>
                                    <td class="text-center"><?= $row['total_nilai'] ?></td>
                                    <td class="text-center"><?= $row['peringkat'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Data ranking belum tersedia
                                </td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>

            <a href="/penilaian" class="btn btn-secondary mt-3">
                Kembali
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>