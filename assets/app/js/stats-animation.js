/**
 * stats-animation.js
 * Fase 2 — Dashboard Stats Animation
 * GarudaCBT UI/UX Improvement
 * Ref: UI_UX_IMPROVEMENT_DOCS.md - Phase 2
 *
 * Berisi:
 *  2.1 Count-up animation untuk angka di .small-box dan .info-box-number
 *  2.2 Staggered entrance animation untuk stat cards
 *  2.3 Pulse dot untuk status ujian aktif
 */

(function ($) {
    'use strict';

    /* ----------------------------------------------------------
     * 2.1 — Count-Up Animation
     * Angka di .small-box .inner h3/h5 dan .info-box-number
     * naik dari 0 ke nilai nyata dalam 1.5 detik.
     * Menggunakan easing easeOutQuart untuk efek melambat di akhir.
     * ---------------------------------------------------------- */

    /**
     * Easing: easeOutQuart
     * t = waktu (0..1), output = progress (0..1)
     */
    function easeOutQuart(t) {
        return 1 - Math.pow(1 - t, 4);
    }

    /**
     * Parse angka dari string — bersihkan titik/koma ribuan
     * Contoh: "1.234" → 1234, "12,5" → 12
     */
    function parseNumber(str) {
        var cleaned = String(str).replace(/[^0-9]/g, '');
        return parseInt(cleaned, 10) || 0;
    }

    /**
     * Format angka ke string dengan titik ribuan
     * Contoh: 1234 → "1.234"
     */
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    /**
     * Animasikan satu elemen angka dari 0 ke target
     * @param {jQuery} $el  - elemen yang berisi angka
     * @param {number} target - nilai akhir
     * @param {number} duration - durasi ms (default 1400)
     */
    function animateCount($el, target, duration) {
        duration = duration || 1400;
        var start = null;
        var prefix = '';
        var suffix = '';

        // Deteksi prefix/suffix non-angka (e.g., "Rp", "%", "+" di depan/belakang)
        var originalText = $.trim($el.text());
        var prefixMatch = originalText.match(/^([^0-9]*)/);
        var suffixMatch = originalText.match(/([^0-9]*)$/);
        if (prefixMatch) prefix = prefixMatch[1];
        if (suffixMatch && suffixMatch[1] !== prefixMatch[1]) suffix = suffixMatch[1];

        function step(timestamp) {
            if (!start) start = timestamp;
            var elapsed = timestamp - start;
            var progress = Math.min(elapsed / duration, 1);
            var eased = easeOutQuart(progress);
            var current = Math.round(eased * target);

            $el.text(prefix + formatNumber(current) + suffix);

            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                $el.text(prefix + formatNumber(target) + suffix);
            }
        }

        requestAnimationFrame(step);
    }

    /**
     * Jalankan count-up untuk semua elemen angka yang terlihat
     * menggunakan IntersectionObserver agar hanya jalan saat masuk viewport
     */
    function initCountUp() {
        var targets = [];

        // Target 1: .small-box .inner h3, h5 (stat boxes admin/guru)
        $('.small-box .inner h3, .small-box .inner h5').each(function () {
            var $el = $(this);
            var val = parseNumber($el.text());
            if (val > 0) {
                $el.data('countup-target', val);
                $el.data('countup-done', false);
                targets.push(this);
            }
        });

        // Target 2: .info-box-number (info box umum)
        $('.info-box-number').each(function () {
            var $el = $(this);
            var val = parseNumber($el.text());
            if (val > 0) {
                $el.data('countup-target', val);
                $el.data('countup-done', false);
                targets.push(this);
            }
        });

        if (targets.length === 0) return;

        // Gunakan IntersectionObserver jika tersedia (modern browser)
        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        var $el = $(entry.target);
                        if (!$el.data('countup-done')) {
                            $el.data('countup-done', true);
                            animateCount($el, $el.data('countup-target'));
                        }
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.2 });

            targets.forEach(function (el) { observer.observe(el); });
        } else {
            // Fallback: langsung jalankan semua tanpa observer
            targets.forEach(function (el) {
                var $el = $(el);
                animateCount($el, $el.data('countup-target'));
            });
        }
    }

    /* ----------------------------------------------------------
     * 2.2 — Staggered Card Entrance
     * Setiap .small-box muncul satu per satu dengan delay
     * bertahap (0ms, 80ms, 160ms, ...) → efek cascade yang elegan
     * ---------------------------------------------------------- */
    function initStaggeredEntrance() {
        var $boxes = $('.small-box');
        if ($boxes.length === 0) return;

        // Set initial hidden state via inline style
        $boxes.css({
            opacity: 0,
            transform: 'translateY(20px)'
        });

        $boxes.each(function (i) {
            var $box = $(this);
            setTimeout(function () {
                $box.css({
                    transition: 'opacity 0.5s ease, transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1)',
                    opacity: 1,
                    transform: 'translateY(0)'
                });
            }, i * 90); // 90ms stagger per box
        });
    }

    /* ----------------------------------------------------------
     * 2.3 — Pulse Dot untuk Ujian Aktif
     * Jika ada elemen dengan data-ujian-aktif="true" atau
     * class .ujian-aktif, tambahkan pulse indicator hijau.
     * Juga pada token ujian yang aktif di dashboard.
     * ---------------------------------------------------------- */
    function initPulseDot() {
        // Pulse dot pada token jika ada dan bukan '- - - - - -'
        var $token = $('#token-view');
        if ($token.length && $.trim($token.text()) !== '- - - - - -') {
            if (!$token.find('.pulse-dot').length) {
                $token.prepend(
                    '<span class="pulse-dot" title="Token Aktif" style="' +
                    'display:inline-block; width:10px; height:10px;' +
                    'border-radius:50%; background:#1cc88a; margin-right:8px;' +
                    'vertical-align:middle; animation:pulse-ring 2s ease infinite;' +
                    '"></span>'
                );
            }
        }

        // Pulse dot pada badge status ujian aktif
        $('.badge.badge-success, .badge.badge-warning').each(function () {
            $(this).addClass('badge-pulse');
        });
    }

    /* ----------------------------------------------------------
     * INIT — jalankan semua saat document ready
     * Delay kecil (300ms) agar page fade-in selesai lebih dulu
     * ---------------------------------------------------------- */
    $(document).ready(function () {
        setTimeout(function () {
            initStaggeredEntrance();
        }, 100); // Stagger langsung setelah load

        setTimeout(function () {
            initCountUp(); // Count-up dimulai setelah entrance
            initPulseDot();
        }, 300);
    });

})(jQuery);
