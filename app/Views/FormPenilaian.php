<?= $this->extend('layouts/base') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="h4 mb-4">Form Penilaian Batu</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif ?>

    <form action="<?= base_url('penilaian/simpan') ?>" method="post">
        <input type="hidden" name="id_detail_pendaftaran" value="<?= $id_detail_pendaftaran ?>">

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Sub Kriteria</th>
                    <th width="200">Nilai (1 - 9)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subs as $s): ?>
                    <tr>
                        <td><?= esc($s['nama_sub']) ?></td>
                        <td>
                            <input type="hidden" name="id_sub" value="<?= $s['id_sub'] ?>">
                            <input type="number"
                                name="nilai"
                                class="form-control"
                                min="1"
                                max="9"
                                step="0.1"
                                required>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <button class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan Penilaian
        </button>
    </form>
</div>

<?= $this->endSection() ?>