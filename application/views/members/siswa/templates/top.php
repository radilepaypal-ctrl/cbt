<div class="siswa-welcome-wrap d-flex align-items-center mb-2">
    <!-- Avatar -->
    <div class="siswa-avatar-wrap mr-3 flex-shrink-0">
        <img class="avatar siswa-avatar-img"
             src="<?= base_url($siswa->foto) ?>"
             width="72" height="72" alt="Foto <?= $siswa->nama ?>">
    </div>
    <!-- Greeting -->
    <div class="siswa-welcome-text">
        <div class="siswa-greeting text-white small mb-1" id="siswa-greeting-time">Selamat datang,</div>
        <h5 class="text-white font-weight-bold mb-0 siswa-nama-display"><?= $siswa->nama ?></h5>
        <div class="text-white-50 small mt-1">
            <i class="fas fa-id-card mr-1 small"></i><?= $siswa->nis ?>
            &nbsp;·&nbsp;
            <i class="fas fa-school mr-1 small"></i><?= $siswa->nama_kelas ?>
        </div>
    </div>
</div>

<style>
.siswa-welcome-wrap { padding: 0.25rem 0; }
.siswa-avatar-img {
    width: 72px; height: 72px;
    border-radius: 50%;
    border: 3px solid rgba(255,255,255,0.4);
    object-fit: cover;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    transition: border-color 0.3s;
}
.siswa-avatar-img:hover { border-color: rgba(255,255,255,0.8); }
.siswa-greeting { opacity: 0.85; letter-spacing: 0.02em; }
.siswa-nama-display { font-size: 1.1rem; line-height: 1.3; text-shadow: 0 1px 4px rgba(0,0,0,0.15); }
</style>

<script>
    /* Greeting personal berdasarkan jam */
    (function() {
        var jam = new Date().getHours();
        var salam;
        if      (jam >= 5  && jam < 11) salam = '☀️ Selamat Pagi,';
        else if (jam >= 11 && jam < 15) salam = '🌤️ Selamat Siang,';
        else if (jam >= 15 && jam < 19) salam = '🌅 Selamat Sore,';
        else                             salam = '🌙 Selamat Malam,';
        var el = document.getElementById('siswa-greeting-time');
        if (el) el.textContent = salam;
    })();

    /* Fallback foto siswa */
    $(`.avatar`).each(function () {
        $(this).on("error", function () {
            var src = $(this).attr('src').replace('profiles', 'foto_siswa');
            $(this).attr("src", src);
            $(this).on("error", function () {
                $(this).attr("src", base_url + 'assets/img/siswa.png');
            });
        });
    });
</script>

