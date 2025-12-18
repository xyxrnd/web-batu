<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Tambah Bobot Kriteria (AHP)<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    ```
    <!-- ALERT INFO -->
    <div class="alert alert-warning">
        <strong>Perhatian:</strong>
        Nilai yang Anda masukkan merupakan <b>penilaian pribadi</b>.
        Bobot akhir akan dihitung berdasarkan <b>seluruh penilai</b> menggunakan metode <b>Group AHP</b>.
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- HEADING -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Bobot Kriteria (AHP)</h1>
        <a href="/kriteria" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow">
        <form id="formBobot" action="/ahp/simpan" method="post">
            <?= csrf_field() ?>

            <div class="card-body">

                <!-- PILIH BATU -->
                <div class="form-group">
                    <label>Jenis Batu</label>
                    <select name="id_batu" class="form-control" required>
                        <option value="">-- Pilih Batu --</option>
                        <?php foreach ($batu as $b): ?>
                            <option value="<?= $b['id_batu'] ?>">
                                <?= esc($b['jenis_batu']) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <small class="text-muted">Setiap user hanya dapat mengisi satu kali per jenis batu.</small>
                </div>

                <hr>

                <!-- PILIH KRITERIA -->
                <div class="form-group">
                    <label>Pilih Kriteria</label>
                    <div class="input-group">
                        <select id="kriteriaSelect" class="form-control">
                            <option value="">-- Pilih Kriteria --</option>
                            <?php foreach ($kriteria as $k): ?>
                                <option value="<?= $k['id_kriteria'] ?>">
                                    <?= esc($k['kriteria']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" id="btnTambahKriteria">Tambah</button>
                        </div>
                    </div>
                </div>

                <!-- PREVIEW KRITERIA -->
                <div id="previewKriteria" class="alert alert-info d-none">
                    <strong>Kriteria yang Digunakan:</strong>
                    <ul id="listKriteria" class="mb-0"></ul>
                </div>

                <!-- PAIRWISE AHP -->
                <div id="pairwiseSection" class="mt-4 d-none">
                    <h5 class="text-primary">Perbandingan Berpasangan (Skala Saaty)</h5>
                    <div id="pairwiseForm"></div>
                </div>

            </div>

            <div class="card-footer text-right">
                <button type="button" class="btn btn-primary" id="btnSubmit">
                    <i class="fa fa-save mr-1"></i> Simpan Penilaian
                </button>
            </div>

        </form>
    </div>
    ```

</div>

<!-- SCRIPT -->

<script>
    const select = document.getElementById('kriteriaSelect');
    const btnAdd = document.getElementById('btnTambahKriteria');
    const list = document.getElementById('listKriteria');
    const preview = document.getElementById('previewKriteria');
    const pairwise = document.getElementById('pairwiseForm');
    const section = document.getElementById('pairwiseSection');

    let selectedKriteria = [];

    btnAdd.addEventListener('click', function() {
        const id = select.value;
        const text = select.options[select.selectedIndex].text;

        if (!id) return;
        if (selectedKriteria.some(k => k.id === id)) return;

        selectedKriteria.push({
            id,
            text
        });
        render();
    });

    function render() {
        list.innerHTML = '';
        pairwise.innerHTML = '';

        if (selectedKriteria.length < 2) {
            preview.classList.add('d-none');
            section.classList.add('d-none');
            return;
        }

        preview.classList.remove('d-none');
        section.classList.remove('d-none');

        // PREVIEW
        selectedKriteria.forEach((k, i) => {
            list.innerHTML += `
                <li>${k.text}
                    <button type="button" class="btn btn-sm btn-danger ml-2" onclick="hapusKriteria(${i})">x</button>
                    <input type="hidden" name="kriteria[]" value="${k.id}">
                </li>`;
        });

        // PAIRWISE
        for (let i = 0; i < selectedKriteria.length; i++) {
            for (let j = i + 1; j < selectedKriteria.length; j++) {
                pairwise.innerHTML += `
                    <div class="form-group row align-items-center">
                        <div class="col-md-4 text-right font-weight-bold">${selectedKriteria[i].text}</div>
                        <div class="col-md-4">
                            <select name="pair[${selectedKriteria[i].id}][${selectedKriteria[j].id}]" class="form-control" required>
                                <option value="">-- Pilih Nilai --</option>
                                <option value="1">1 - Sama penting</option>
                                <option value="3">3 - Sedikit lebih penting</option>
                                <option value="5">5 - Lebih penting</option>
                                <option value="7">7 - Sangat penting</option>
                                <option value="9">9 - Mutlak lebih penting</option>
                            </select>
                        </div>
                        <div class="col-md-4 font-weight-bold">${selectedKriteria[j].text}</div>
                    </div>`;
            }
        }
    }

    window.hapusKriteria = function(index) {
        selectedKriteria.splice(index, 1);
        render();
    }

    document.getElementById('btnSubmit').addEventListener('click', function() {
        if (selectedKriteria.length < 2) {
            alert('Minimal pilih 2 kriteria');
            return;
        }
        if (confirm('Simpan penilaian AHP Anda?')) {
            document.getElementById('formBobot').submit();
        }
    });
</script>

<?= $this->endSection() ?>