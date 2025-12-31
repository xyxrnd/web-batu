<?= $this->extend('layouts/base') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-4 fw-bold">
        Penilaian Jenis Batu
    </h4>

    <form action="<?= site_url('penilaian/simpan') ?>" method="post">

        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-primary">

                <!-- HEADER BARIS 1 -->
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nama Peserta</th>
                    <th rowspan="2">Nomor Urut</th>

                    <?php foreach ($kriteria as $k): ?>
                        <?php $jumlahSub = max(1, count($k['sub'])); ?>
                        <th colspan="<?= $jumlahSub ?>">
                            <?= esc($k['kriteria']) ?>
                            <br>
                            <small>(Bobot: <?= $k['persen'] ?>%)</small>
                        </th>
                    <?php endforeach ?>
                </tr>

                <!-- HEADER BARIS 2 -->
                <tr>
                    <?php foreach ($kriteria as $k): ?>
                        <?php if (!empty($k['sub'])): ?>
                            <?php foreach ($k['sub'] as $s): ?>
                                <th>
                                    <?= esc($s['nama_sub']) ?>
                                    <br><small>(<?= $s['persen'] ?>%)</small>
                                </th>
                            <?php endforeach ?>
                        <?php else: ?>
                            <th>Belum ada sub kriteria atau belum input sub kriteria</th>
                        <?php endif ?>
                    <?php endforeach ?>
                </tr>


            </thead>

            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($peserta as $p): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($p['nama']) ?></td>
                        <td><?= esc($p['nomor_batu'] ?? '-') ?></td>

                        <?php foreach ($kriteria as $k): ?>
                            <?php if (!empty($k['sub'])): ?>
                                <?php foreach ($k['sub'] as $s): ?>
                                    <td>
                                        <input type="number" class="form-control text-center" required>
                                    </td>
                                <?php endforeach ?>
                            <?php else: ?>
                                <td>
                                    <input type="number" class="form-control text-center" required>
                                </td>
                            <?php endif ?>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <div class="text-end mt-3">
            <button type="submit" class="btn btn-success">
                Simpan Penilaian
            </button>
        </div>

    </form>
</div>

<?= $this->endSection() ?>