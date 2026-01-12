<?php $role = session()->get('role'); ?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-text">Sigertengah Gemstone</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- ================= ROLE PESERTA ================= -->
    <?php if ($role === 'Peserta'): ?>

        <li class="nav-item">
            <a class="nav-link" href="/pendaftaran">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Kelola Pendaftaran</span>
            </a>
        </li>

        <!-- ================= ROLE JURI ================= -->
    <?php elseif ($role === 'Juri'): ?>

        <li class="nav-item">
            <a class="nav-link" href="/penilaian">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Kelola Penilaian</span>
            </a>
        </li>

        <!-- ================= ROLE ADMIN ================= -->
    <?php else: ?>

        <li class="nav-item">
            <a class="nav-link" href="/">
                <i class="fas fa-bars"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/kelas">
                <i class="fas fa-user"></i>
                <span>Kelola Kelas</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/batu">
                <i class="fas fa-user"></i>
                <span>Kelola Batu</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/kriteria">
                <i class="fas fa-car"></i>
                <span>Kelola Kriteria</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/sub-kriteria">
                <i class="fas fa-car"></i>
                <span>Kelola Sub Kriteria</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/user">
                <i class="fas fa-receipt"></i>
                <span>Kelola User</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/pendaftaran">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Kelola Pendaftaran</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/penilaian">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Kelola Penilaian</span>
            </a>
        </li>

    <?php endif; ?>

</ul>