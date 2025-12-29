<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Tambah Bobot Sub Kriteria (AHP)<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

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

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 text-gray-800">Tambah Bobot Sub Kriteria (AHP)</h1>
        <a href="/sub-kriteria" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow">
        <form id="formBobot" action="/ahp-sub/simpan" method="post">
            <?= csrf_field() ?>

            <div class="card-body">

                <!-- BATU -->
                <div class="form-group">
                    <label>Jenis Batu</label>
                    <select name="id_batu" id="id_batu" class="form-control" required>
                        <option value="">-- Pilih Batu --</option>
                        <?php foreach ($batu as $b): ?>
                            <option value="<?= $b['id_batu'] ?>">
                                <?= esc($b['jenis_batu']) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <!-- KRITERIA -->
                <div class="form-group">
                    <label>Kriteria</label>
                    <select name="id_kriteria" id="id_kriteria" class="form-control" required>
                        <option value="">-- Pilih Kriteria --</option>
                    </select>
                </div>

                <hr>

                <!-- SUB KRITERIA -->
                <div class="form-group">
                    <label>Pilih Sub Kriteria</label>
                    <div class="input-group">
                        <select id="subSelect" class="form-control">
                            <option value="">-- Pilih Sub Kriteria --</option>
                            <?php foreach ($sub as $s): ?>
                                <option value="<?= $s['id_sub'] ?>">
                                    <?= esc($s['nama_sub']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" id="btnTambah">
                                Tambah
                            </button>
                        </div>
                    </div>
                </div>

                <!-- PREVIEW -->
                <div id="preview" class="alert alert-info d-none">
                    <strong>Sub Kriteria yang Digunakan:</strong>
                    <ul id="listSub" class="mb-0"></ul>
                </div>

                <!-- PAIRWISE -->
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

</div>

<script>
    /* ===============================
   DOM ELEMENT
================================ */
    const batuSelect = document.getElementById('id_batu');
    const kriteriaSelect = document.getElementById('id_kriteria');
    const subSelect = document.getElementById('subSelect');
    const btnTambah = document.getElementById('btnTambah');
    const btnSubmit = document.getElementById('btnSubmit');

    const preview = document.getElementById('preview');
    const listSub = document.getElementById('listSub');
    const pairwiseForm = document.getElementById('pairwiseForm');
    const pairwiseSection = document.getElementById('pairwiseSection');

    /* ===============================
       STATE
    ================================ */
    let selectedSub = [];

    /* ===============================
       EVENT
    ================================ */

    // Ganti batu → load kriteria
    batuSelect.addEventListener('change', loadKriteria);

    // Ganti batu / kriteria → reset AHP
    batuSelect.addEventListener('change', resetAHP);
    kriteriaSelect.addEventListener('change', resetAHP);

    // Tambah sub kriteria
    btnTambah.addEventListener('click', tambahSub);

    // Submit
    btnSubmit.addEventListener('click', submitForm);

    /* ===============================
       FUNCTION
    ================================ */

    function loadKriteria() {
        const idBatu = batuSelect.value;
        kriteriaSelect.innerHTML = '<option value="">-- Pilih Kriteria --</option>';

        if (!idBatu) return;

        fetch(`/ajax/kriteria-by-batu/${idBatu}`)
            .then(res => res.json())
            .then(data => {
                data.forEach(k => {
                    const opt = document.createElement('option');
                    opt.value = k.id_kriteria;
                    opt.textContent = k.kriteria;
                    kriteriaSelect.appendChild(opt);
                });
            });
    }

    function tambahSub() {
        const id = subSelect.value;
        const text = subSelect.options[subSelect.selectedIndex].text;

        if (!id || selectedSub.some(s => s.id === id)) return;

        selectedSub.push({
            id,
            text
        });
        renderAHP();
    }

    function renderAHP() {
        listSub.innerHTML = '';
        pairwiseForm.innerHTML = '';

        if (selectedSub.length < 2) {
            preview.classList.add('d-none');
            pairwiseSection.classList.add('d-none');
            return;
        }

        preview.classList.remove('d-none');
        pairwiseSection.classList.remove('d-none');

        selectedSub.forEach((s, i) => {
            listSub.innerHTML += `
            <li>
                ${s.text}
                <button type="button" class="btn btn-sm btn-danger ml-2"
                    onclick="hapusSub(${i})">x</button>
                <input type="hidden" name="subkriteria[]" value="${s.id}">
            </li>`;
        });

        for (let i = 0; i < selectedSub.length; i++) {
            for (let j = i + 1; j < selectedSub.length; j++) {
                pairwiseForm.innerHTML += `
                <div class="form-group row align-items-center">
                    <div class="col-md-4 text-right font-weight-bold">${selectedSub[i].text}</div>
                    <div class="col-md-4">
                        <select name="pair[${selectedSub[i].id}][${selectedSub[j].id}]" class="form-control" required>
                            <option value="">-- Pilih Nilai --</option>
                            <option value="1">1 - Sama penting</option>
                            <option value="3">3 - Sedikit lebih penting</option>
                            <option value="5">5 - Lebih penting</option>
                            <option value="7">7 - Sangat penting</option>
                            <option value="9">9 - Mutlak lebih penting</option>
                        </select>
                    </div>
                    <div class="col-md-4 font-weight-bold">${selectedSub[j].text}</div>
                </div>`;
            }
        }
    }

    function hapusSub(index) {
        selectedSub.splice(index, 1);
        renderAHP();
    }

    function resetAHP() {
        selectedSub = [];
        renderAHP();
    }

    function submitForm() {
        if (selectedSub.length < 2) {
            alert('Minimal pilih 2 sub kriteria');
            return;
        }
        if (confirm('Simpan penilaian AHP Anda?')) {
            document.getElementById('formBobot').submit();
        }
    }
</script>

<?= $this->endSection() ?>