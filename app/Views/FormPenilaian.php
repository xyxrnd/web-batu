<?= $this->extend('layouts/base') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-4 fw-bold">
        Penilaian Jenis Batu <?= esc($nama_batu) ?>
    </h4>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-center">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger text-center">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>


    <!-- FORM SIMPAN NILAI -->
    <form action="<?= site_url('penilaian/simpan') ?>" method="post">
        <?= csrf_field() ?>

        <input type="hidden" name="id_batu" value="<?= esc($id_batu) ?>">

        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-primary">

                <!-- HEADER BARIS 1 -->
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nama Peserta</th>
                    <th rowspan="2">Nomor Urut</th>

                    <?php foreach ($kriteria as $k): ?>
                        <th colspan="<?= count($k['sub']) ?>">
                            <?= esc($k['kriteria']) ?><br>
                            <small>(Bobot: <?= esc($k['persen']) ?>%)</small>
                        </th>
                    <?php endforeach ?>

                    <th rowspan="2">Aksi</th>
                </tr>

                <!-- HEADER BARIS 2 -->
                <tr>
                    <?php foreach ($kriteria as $k): ?>
                        <?php foreach ($k['sub'] as $s): ?>
                            <th>
                                <?= esc($s['nama_sub']) ?><br>
                                <small>
                                    <?= number_format($s['persen_global'], 2) ?>%
                                </small>


                            </th>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </tr>

            </thead>

            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($detail as $p): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($p['nama']) ?></td>
                        <td><?= esc($p['nomor_batu'] ?? '-') ?></td>

                        <?php foreach ($kriteria as $k): ?>
                            <?php foreach ($k['sub'] as $s): ?>
                                <td>
                                    <input type="text"
                                        name="nilai[<?= $p['id_detail_pendaftaran'] ?>][<?= $k['id_kriteria'] ?>][<?= $s['id_sub'] ?>]"
                                        value="<?= $nilai[$p['id_detail_pendaftaran']][$k['id_kriteria']][$s['id_sub']] ?? '' ?>"
                                        class="form-control text-center"
                                        step="0.01"
                                        min="0"
                                        max="100">

                                </td>
                            <?php endforeach ?>
                        <?php endforeach ?>

                        <!-- SIMPAN PER BARIS -->
                        <td>
                            <button type="submit"
                                name="simpanId"
                                value="<?= $p['id_detail_pendaftaran'] ?>"
                                class="btn btn-sm btn-success">
                                Simpan
                            </button>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </form>

    <!-- FORM PUBLISH (TERPISAH, VALID HTML) -->
    <div class="d-flex justify-content-end mt-3">
        <form action="<?= site_url('penilaian/publish') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id_batu" value="<?= esc($id_batu) ?>">

            <button type="submit"
                class="btn btn-danger"
                onclick="return confirm('Publish nilai akhir? Nilai tidak dapat diubah!')">
                Publish Nilai Akhir
            </button>
        </form>
    </div>

</div>

<?= $this->endSection() ?>