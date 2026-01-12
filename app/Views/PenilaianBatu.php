<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>
Data Penilaian
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Data Penilaian</h1>

    <?php if (!empty($dataKelas)): ?>
        <?php $i = 1; ?>
        <?php foreach ($dataKelas as $idKelas => $batuList): ?>

            <!-- Card per Kelas -->
            <div class="card shadow mb-4">

                <!-- Card Header -->
                <a href="#collapseKelas<?= $i ?>"
                    class="d-block card-header py-3"
                    data-toggle="collapse"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseKelas<?= $i ?>">

                    <h6 class="m-0 font-weight-bold text-primary">
                        Nama Kelas : <?= esc($batuList['nama_kelas']) ?>
                    </h6>
                </a>

                <!-- Card Body (Collapse) -->
                <div class="collapse" id="collapseKelas<?= $i ?>">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Jenis Batu</th>
                                        <th width="15%">Total Batu</th>
                                        <th width="20%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($batuList['batu'])): ?>
                                        <?php $no = 1; ?>
                                        <?php foreach ($batuList['batu'] as $batu): ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= esc($batu['jenis_batu']) ?></td>
                                                <td class="text-center"><?= $batu['total_batu'] ?></td>
                                                <td class="text-center">
                                                    <a href="<?= base_url('penilaian/batu/' . $batu['id_batu']) ?>"
                                                        class="btn btn-info btn-sm">
                                                        Nilai
                                                    </a>
                                                    <a href="<?= base_url('penilaian/ranking/' . $idKelas) ?>"
                                                        class="btn btn-primary btn-sm">
                                                        Lihat Ranking
                                                    </a>

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                Data batu belum tersedia
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

            <?php $i++; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-warning">
            Data penilaian belum tersedia.
        </div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>