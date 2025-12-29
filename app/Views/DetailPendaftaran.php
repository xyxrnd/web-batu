<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Detail Pendaftaran<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pendaftaran</h1>
        <a href="/pendaftaran" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Nama -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <strong>Nama Pendaftar:</strong> <?= esc($nama) ?>
        </div>
    </div>

    <!-- Detail Batu -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <strong>Daftar Batu Akik</strong>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Batu</th>
                        <th>Nomor Batu</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pendaftaran)): ?>
                        <tr>
                            <td colspan="6" class="text-center">
                                Data belum tersedia
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php $no = 1;
                    foreach ($pendaftaran as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($row['jenis_batu']) ?></td>
                            <td>
                                <?= $row['nomor_batu'] ?? '-' ?>
                            </td>
                            <td>
                                <span class="badge text-white
                                    <?= $row['status_pendaftaran'] == 'Diterima' ? 'bg-success' : ($row['status_pendaftaran'] == 'Ditolak' ? 'bg-danger' : 'bg-warning') ?>">
                                    <?= esc($row['status_pendaftaran']) ?>
                                </span>
                            </td>
                            <td><?= esc($row['catatan'] ?? '-') ?></td>
                            <td class="text-center">
                                <?php if ($row['status_pendaftaran'] === 'Pengecekan'): ?>
                                    <a href="/pendaftaran/terima/<?= $row['id_detail_pendaftaran'] ?>"
                                        class="btn btn-success btn-sm">
                                        Terima
                                    </a>

                                    <button class="btn btn-danger btn-sm"
                                        onclick="openTolakModal(
                                            <?= $row['id_detail_pendaftaran'] ?>,
                                            '<?= esc($row['jenis_batu']) ?>',
                                            '<?= esc($row['nomor_batu'] ?? '-') ?>'
                                        )">
                                        Tolak
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- ================= MODAL TOLAK ================= -->
            <div class="modal fade" id="modalTolak" tabindex="-1">
                <div class="modal-dialog">
                    <form method="post" action="/pendaftaran/tolak">
                        <?= csrf_field() ?>

                        <input type="hidden" name="id_detail" id="id_detail">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tolak Batu</h5>
                                <button type="button" class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <div class="mb-2">
                                    <strong>Nama Batu:</strong>
                                    <span id="jenis_batu"></span>
                                </div>

                                <div class="mb-3">
                                    <strong>Nomor Batu:</strong>
                                    <span id="nomor_batu"></span>
                                </div>

                                <div class="mb-3">
                                    <label>Catatan Penolakan</label>
                                    <textarea name="catatan"
                                        class="form-control"
                                        rows="3"
                                        required
                                        placeholder="Masukkan alasan penolakan"></textarea>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-danger">Tolak Batu</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
    function openTolakModal(id, jenisBatu, nomorBatu) {
        document.getElementById('id_detail').value = id;
        document.getElementById('jenis_batu').innerText = jenisBatu;
        document.getElementById('nomor_batu').innerText = nomorBatu;

        new bootstrap.Modal(
            document.getElementById('modalTolak')
        ).show();
    }
</script>


<?= $this->endSection() ?>