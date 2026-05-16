/**
 * dark-mode.js — Fase 8.1 UI/UX Improvement 2026
 *
 * Toggle dark mode menggunakan localStorage 'garudaCBT.theme'.
 * Berlaku di 3 layout: admin (dashboard), guru, siswa (topnav).
 *
 * Cara kerja:
 *  - Saat halaman dimuat, cek localStorage → apply class 'dark-mode' ke body
 *  - Tombol #theme-toggle di navbar → toggle class + simpan ke localStorage
 *  - Icon berubah: fa-moon (light) ↔ fa-sun (dark)
 *
 * AMAN: Tidak menyentuh variabel JS ujian atau logic controller.
 */
(function () {
    'use strict';

    var STORAGE_KEY = 'garudaCBT.theme';
    var DARK_CLASS  = 'dark-mode';

    /* ── Terapkan atau hapus class dark-mode ── */
    function applyTheme(dark) {
        if (dark) {
            document.body.classList.add(DARK_CLASS);
        } else {
            document.body.classList.remove(DARK_CLASS);
        }
        updateIcon(dark);
        localStorage.setItem(STORAGE_KEY, dark ? 'dark' : 'light');
    }

    /* ── Update ikon tombol toggle ── */
    function updateIcon(dark) {
        var icons = document.querySelectorAll('.theme-toggle-icon');
        icons.forEach(function (icon) {
            if (dark) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
                icon.closest('a') && icon.closest('a').setAttribute('title', 'Mode Terang');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
                icon.closest('a') && icon.closest('a').setAttribute('title', 'Mode Gelap');
            }
        });
    }

    /* ── Init: baca localStorage saat DOMContentLoaded ── */
    function init() {
        var saved = localStorage.getItem(STORAGE_KEY);
        var isDark = saved === 'dark';
        applyTheme(isDark);

        /* Pasang event listener ke semua tombol toggle */
        document.querySelectorAll('.btn-theme-toggle').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                applyTheme(!document.body.classList.contains(DARK_CLASS));
            });
        });
    }

    /* Jalankan setelah DOM siap */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
