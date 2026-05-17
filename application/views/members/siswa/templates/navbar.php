<nav class="main-header navbar navbar-expand-md navbar-dark navbar-green border-bottom-0">
    <ul class="navbar-nav ml-2">
        <li class="nav-item">
            <?php
            $page = $this->uri->segment(1);
            if ($page !== 'dashboard') : ?>
                <a class="nav-link" href="javascript:history.back()" role="button" aria-label="Kembali ke halaman sebelumnya"><i class="fas fa-arrow-left" aria-hidden="true"></i></a>
            <?php endif; ?>
        </li>
    </ul>

    <div class="mx-auto text-white text-center" style="line-height: 1">
        <span class="text-lg p-0">e-Learning</span>
        <br>
        <small>Belajar kapanpun dimanapun</small>
    </div>

    <!-- Kanan navbar: badge ujian + dark mode -->
    <ul class="navbar-nav ml-auto mr-2">
        <!-- Badge notifikasi ujian aktif hari ini -->
        <li class="nav-item">
            <a href="<?= base_url('siswa/cbt') ?>" class="nav-link" id="ujian-badge-btn" title="Ujian Hari Ini" aria-label="Daftar ujian hari ini">
                <i class="fas fa-clipboard-list" aria-hidden="true"></i>
                <span class="badge badge-danger navbar-badge d-none" id="ujian-badge-count">0</span>
            </a>
        </li>
        <!-- Dark mode toggle -->
        <li class="nav-item">
            <a href="#" class="nav-link btn-theme-toggle" title="Mode Gelap" role="button" aria-label="Toggle mode gelap">
                <i class="fas fa-moon theme-toggle-icon" aria-hidden="true"></i>
            </a>
        </li>
    </ul>
</nav>

<script src="<?= base_url() ?>/assets/app/js/dark-mode.js"></script>

<script>
/* Badge ujian: fetch count dari /api/badge_ujian */
(function() {
    function loadBadge() {
        $.getJSON(base_url + 'api/badge_ujian', function(data) {
            var count = data.count || 0;
            var badge = document.getElementById('ujian-badge-count');
            if (badge && count > 0) {
                badge.textContent = count > 9 ? '9+' : count;
                badge.classList.remove('d-none');
                /* Animasi pulse ringan */
                badge.style.animation = 'examPulse 1.5s ease-in-out 3';
            }
        }).fail(function() {
            /* Gagal fetch — badge tetap tersembunyi, tidak error */
        });
    }

    /* Load saat DOM siap */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadBadge);
    } else {
        loadBadge();
    }
})();
</script>

