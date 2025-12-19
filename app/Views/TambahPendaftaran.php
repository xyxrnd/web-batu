<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Tambah Pendaftaran<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h1 class="h3 text-gray-800">Tambah Pendaftaran</h1>
        <a href="/pendaftaran" class="btn btn-primary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <form action="/pendaftaran/store" method="post">
            <?= csrf_field() ?>

            <div class="card-body">

                <!-- NAMA USER -->
                <div class="form-group">
                    <label>Nama Pendaftar</label>
                    <input type="text" class="form-control"
                        value="<?= esc(session()->get('nama')) ?>" readonly>
                </div>

                <!-- PILIH BATU -->
                <div class="form-group">
                    <label>Pilih Batu</label>
                    <div class="d-flex gap-2">
                        <select id="select_batu" class="form-control">
                            <option value="">-- Pilih Batu --</option>
                            <?php foreach ($batu as $b): ?>
                                <option value="<?= $b['id_batu'] ?>"
                                    data-jenis="<?= $b['jenis_batu'] ?>">
                                    <?= esc($b['jenis_batu']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>

                        <button type="button" id="btnTambah"
                            class="btn btn-success ml-2">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>

                <hr>

                <!-- PREVIEW BATU -->
                <h5 class="mb-3">Detail Batu</h5>

                <div id="previewBatu"></div>

                <!-- CATATAN
                <div class="form-group mt-3">
                    <label>Catatan</label>
                    <textarea name="catatan"
                        class="form-control"
                        placeholder="Catatan (opsional)"></textarea>
                </div> -->

            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan
                </button>
            </div>

        </form>
    </div>

</div>

<script>
    let batuDipilih = [];

    document.getElementById('btnTambah').addEventListener('click', function() {
        const select = document.getElementById('select_batu');
        const option = select.options[select.selectedIndex];

        if (!option.value) return;

        if (batuDipilih.includes(option.value)) {
            alert('Batu ini sudah ditambahkan');
            return;
        }

        batuDipilih.push(option.value);

        const preview = document.getElementById('previewBatu');

        preview.insertAdjacentHTML('beforeend', `
        <div class="card mb-2 p-3" id="batu-${option.value}">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <strong>${option.dataset.jenis}</strong>
                    <input type="hidden" name="id_batu[]" value="${option.value}">
                </div>
                <div class="col-md-4">
                    <input type="number" name="jumlah_batu[]"
                        class="form-control"
                        placeholder="Jumlah"
                        min="1" required>
                </div>
                <div class="col-md-3 text-right">
                    <button type="button"
                        class="btn btn-danger btn-sm"
                        onclick="hapusBatu('${option.value}')">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `);

        select.value = '';
    });

    function hapusBatu(id) {
        document.getElementById('batu-' + id).remove();
        batuDipilih = batuDipilih.filter(b => b !== id);
    }
</script>

<?= $this->endSection() ?>