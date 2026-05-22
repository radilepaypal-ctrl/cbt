/**
 * csrf-refresh.js — Auto-refresh CSRF token setelah setiap AJAX request
 *
 * Diperlukan karena csrf_regenerate = TRUE mengubah token setiap request.
 * Token baru dikirim CI3 via cookie 'csrf_cookie' — script ini membacanya
 * dan memperbarui $.ajaxSetup agar request berikutnya menggunakan token baru.
 *
 * Diimplementasikan: 2026-05-22 (Fase B2 Security Hardening)
 */
(function ($) {
    'use strict';

    var CSRF_TOKEN_NAME = 'csrf_token';
    var CSRF_COOKIE_NAME = 'csrf_cookie';

    /**
     * Baca nilai cookie berdasarkan nama.
     */
    function getCookie(name) {
        var match = document.cookie.match(new RegExp('(?:^|;\\s*)' + name + '=([^;]*)'));
        return match ? decodeURIComponent(match[1]) : null;
    }

    /**
     * Update $.ajaxSetup dengan token CSRF terbaru dari cookie.
     */
    function refreshCsrfToken() {
        var token = getCookie(CSRF_COOKIE_NAME);
        if (!token) return;

        var data = {};
        data[CSRF_TOKEN_NAME] = token;

        $.ajaxSetup({ data: data });
    }

    /**
     * Override ajaxcsrf() global agar juga membaca dari cookie,
     * sehingga kompatibel mundur dengan kode yang sudah ada.
     */
    window.ajaxcsrf = function () {
        refreshCsrfToken();
    };

    /**
     * Setelah setiap AJAX request selesai (sukses maupun gagal),
     * perbarui token dari cookie yang sudah di-set CI3.
     */
    $(document).ajaxComplete(function () {
        refreshCsrfToken();
    });

    // Inisialisasi saat halaman pertama kali dimuat
    $(document).ready(function () {
        refreshCsrfToken();
    });

}(jQuery));
