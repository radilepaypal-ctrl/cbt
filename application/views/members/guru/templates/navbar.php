<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light shadow">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Toggle navigation menu"><i class="fas fa-bars" aria-hidden="true"></i></a>
        </li>

        <li class="nav-item">
            <span class="nav-link text-dark">TP: <?= isset($tp_active) ? $tp_active->tahun : "Belum di set" ?> Smt: <?= isset($smt_active) ? $smt_active->nama_smt : "Belum di set" ?></span>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <div id="live-clock"></div>
        </li>
        <!-- Dark Mode Toggle -->
        <li class="nav-item">
            <a href="#" class="nav-link btn-theme-toggle" title="Mode Gelap" role="button" aria-label="Toggle mode gelap">
                <i class="fas fa-moon theme-toggle-icon" aria-hidden="true"></i>
            </a>
        </li>
    </ul>

</nav>
<script src="<?= base_url() ?>/assets/app/js/dark-mode.js"></script>
