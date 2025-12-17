<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Kelola Bobot AHP<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Bobot Kriteria (AHP)</h1>
        <a href="/kriteria" class="btn btn-primary btn-sm">
            <i class="fa fa-arrow-left fa-sm"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow">

                <form id="formBobot" action="/kriteria/simpan-bobot" method="post">

                    <?= csrf_field() ?>

                    <div class="card-body">

                        <!-- PILIH BATU -->
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
                                    <button type="button" class="btn btn-primary" id="btnTambahKriteria">
                                        Tambah
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- PREVIEW KRITERIA -->
                        <div id="previewKriteria" class="alert alert-info d-none">
                            <strong>Kriteria Digunakan:</strong>
                            <ul id="listKriteria" class="mb-0"></ul>
                        </div>


                        <!-- PERBANDINGAN AHP -->
                        <div id="pairwiseSection" class="mt-4 d-none">
                            <h5 class="text-primary">Perbandingan Berpasangan (AHP)</h5>
                            <div id="pairwiseForm"></div>
                        </div>


                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary" id="btnSubmit">
                            <i class="fa fa-save mr-1"></i> Simpan Bobot
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

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

            // Cegah duplikasi
            if (selectedKriteria.some(k => k.id === id)) {
                Swal.fire('Info', 'Kriteria sudah dipilih', 'info');
                return;
            }

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

            // Preview
            selectedKriteria.forEach((k, i) => {
                list.innerHTML += `
                <li>
                    ${k.text}
                    <button type="button"
                            class="btn btn-sm btn-danger ml-2"
                            onclick="hapusKriteria(${i})">
                        x
                    </button>
                    <input type="hidden" name="kriteria[]" value="${k.id}">
                </li>
            `;
            });

            // Pairwise AHP
            for (let i = 0; i < selectedKriteria.length; i++) {
                for (let j = i + 1; j < selectedKriteria.length; j++) {
                    pairwise.innerHTML += `
                    <div class="form-group row align-items-center">
                        <div class="col-md-4 text-right font-weight-bold">
                            ${selectedKriteria[i].text}
                        </div>
                        <div class="col-md-4">
                            <input type="number"
                                   name="pair[${selectedKriteria[i].id}][${selectedKriteria[j].id}]"
                                   class="form-control"
                                   min="1" max="9" required>
                        </div>
                        <div class="col-md-4 font-weight-bold">
                            ${selectedKriteria[j].text}
                        </div>
                    </div>
                `;
                }
            }
        }

        window.hapusKriteria = function(index) {
            selectedKriteria.splice(index, 1);
            render();
        }

    });

    document.getElementById('btnSubmit').addEventListener('click', function() {
        Swal.fire({
            title: 'Simpan bobot AHP?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formBobot').submit();
            }
        });
    });
</script>



<?= $this->endSection() ?>