<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Kelola Pendaftaran<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-center">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <h1 class="h3 mb-4 text-gray-800">Kelola Data Pendaftaran</h1>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Total Bayar</th>
                        <th>Status Bayar</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($pendaftaran as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($row['nama']) ?></td>
                            <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                            <td>Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
                            <td><?= esc($row['status_pembayaran']) ?></td>

                            <td class="text-center">

                                <a href="/pendaftaran/detail/<?= $row['id_user'] ?>"
                                    class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i> Detail
                                </a>

                                <button type="button"
                                    class="btn btn-success btn-sm"
                                    onclick="openKeuangan(
                                    <?= $row['id_pendaftaran'] ?>,
                                    '<?= esc($row['nama']) ?>'
                                )">
                                    <i class="fa fa-money-bill"></i> Keuangan
                                </button>

                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= MODAL KEUANGAN ================= -->
<div class="modal fade" id="modalKeuangan" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="/pendaftaran/prosesKeuangan">
            <?= csrf_field() ?>
            <input type="hidden" name="id_pendaftaran" id="id_pendaftaran">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pembayaran Pendaftaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Nama Pendaftar</label>
                        <input type="text" id="nama_pendaftar" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Status Pembayaran</label>
                        <select name="status_pembayaran" id="status_pembayaran"
                            class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Lunas">Lunas</option>
                            <option value="DP">DP</option>
                        </select>
                    </div>

                    <div class="mb-3 d-none" id="form-dp">
                        <label>Nominal DP</label>
                        <input type="number" name="dp" class="form-control"
                            placeholder="Masukkan nominal DP">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ================= SCRIPT ================= -->
<script>
    function openKeuangan(id, nama) {
        document.getElementById('id_pendaftaran').value = id;
        document.getElementById('nama_pendaftar').value = nama;

        new bootstrap.Modal(
            document.getElementById('modalKeuangan')
        ).show();
    }

    document.getElementById('status_pembayaran')
        .addEventListener('change', function() {
            document.getElementById('form-dp')
                .classList.toggle('d-none', this.value !== 'DP');
        });
</script>

<?= $this->endSection() ?>