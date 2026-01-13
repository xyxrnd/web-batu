<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <?php if (session()->getFlashdata('welcome')): ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('welcome') ?>
        </div>
    <?php endif; ?>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Panitia</h1>
    </div>

    <div class="row">

        <!-- Total Batu Terdaftar -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xxl font-weight-bold text-primary text-uppercase mb-1">
                                Total Batu Terdaftar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <h2><?= $totalBatu ?></h2>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-gem fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Batu Diterima -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xxl font-weight-bold text-success text-uppercase mb-1">
                                Batu Diterima
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <h2><?= $batuDiterima ?></h2>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Batu Ditolak -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xxl font-weight-bold text-danger text-uppercase mb-1">
                                Batu Ditolak
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <h2><?= $batuDitolak ?></h2>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pembayaran -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xxl font-weight-bold text-primary text-uppercase mb-1">
                                Total Pembayaran
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <h2><?= $totalPembayaran ?></h2>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Uang Masuk -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xxl font-weight-bold text-success text-uppercase mb-1">
                                Uang Masuk
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <h2>Rp <?= number_format($uangMasuk, 0, ',', '.') ?></h2>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Uang Belum Masuk -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xxl font-weight-bold text-warning text-uppercase mb-1">
                                Uang Belum Masuk
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <h2>Rp <?= number_format($uangBelumMasuk, 0, ',', '.') ?></h2>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>