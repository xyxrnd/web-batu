<?= $this->extend('layouts/base') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h3 class="mb-4 fw-bold">Kelola Data Penilaian</h3>

    <div class="card">
        <div class="card-body">

            <h6 class="text-primary mb-3">Data Penilaian</h6>

            <table class="table table-bordered table-striped" id="tablePenilaian">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Batu</th>
                        <th>Total Batu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($dataPenilaian as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($row['jenis_batu']) ?></td>
                            <td><?= esc($row['total_batu']) ?></td>
                            <td>
                                <a href="<?= site_url('penilaian/batu/' . $row['id_batu']) ?>"
                                    class="btn btn-sm btn-info">
                                    Nilai
                                </a>
                                <a href="<?= site_url('penilaian/upload/' . $row['id_batu']) ?>"
                                    class="btn btn-sm btn-success">
                                    Upload
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?= $this->endSection() ?>