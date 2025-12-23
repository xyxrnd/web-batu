<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Kelola Sub Kriteria<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- FLASH MESSAGE -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-center">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-0">Kelola Sub Kriteria</h1>
            <small class="text-muted">
                Batu: <b><?= esc($batu['jenis_batu']) ?></b>
            </small>
        </div>

        <a href="/batu" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- LOOP PER KRITERIA -->
    <?php foreach ($kriteria as $k): ?>
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Kriteria: <?= esc($k['kriteria']) ?></strong>

                <div>
                    <button class="btn btn-sm btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalTambah<?= $k['id_kriteria'] ?>">
                        <i class="fa fa-plus"></i> Sub Kriteria
                    </button>

                    <a href="/ahp/sub/<?= $batu['id_batu'] ?>/<?= $k['id_kriteria'] ?>"
                        class="btn btn-sm btn-info">
                        <i class="fa fa-balance-scale"></i> Berikan Bobot
                    </a>
                </div>
            </div>

            <div class="card-body">
                <?php if (!empty($sub_kriteria[$k['id_kriteria']])): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Sub Kriteria</th>
                                <th width="15%">Nilai</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($sub_kriteria[$k['id_kriteria']] as $s): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($s['nama_sub_kriteria']) ?></td>
                                    <td><?= esc($s['nilai']) ?></td>
                                    <td class="text-center">
                                        <a href="/batu/<?= $batu['id_batu'] ?>/sub-kriteria/edit/<?= $s['id_sub_kriteria'] ?>"
                                            class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <a href="/batu/<?= $batu['id_batu'] ?>/sub-kriteria/hapus/<?= $s['id_sub_kriteria'] ?>"
                                            onclick="return confirm('Hapus data ini?')"
                                            class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="text-muted text-center">
                        Sub kriteria belum tersedia
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

</div>

<?= $this->endSection() ?>