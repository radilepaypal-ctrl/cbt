/**
 * skeleton-loading.js
 * Fase 3 — Skeleton Loading
 * GarudaCBT UI/UX Improvement
 * Ref: UI_UX_IMPROVEMENT_DOCS.md - Phase 3
 *
 * Berisi:
 *  3.1 Skeleton card untuk #log-list (Aktivitas) sebelum load_log() selesai
 *  3.2 Skeleton post untuk #pengumuman sebelum getPosts() selesai
 *  3.3 Skeleton table untuk jadwal hari ini (tab-pane static)
 */

(function ($) {
    'use strict';

    /* ----------------------------------------------------------
     * Helper: Buat satu skeleton log item (Aktivitas)
     * ---------------------------------------------------------- */
    function skeletonLogItem() {
        return (
            '<li class="skeleton-log-item">' +
                '<span class="skeleton skeleton-log-avatar"></span>' +
                '<div class="skeleton-log-body">' +
                    '<span class="skeleton skeleton-log-name"></span>' +
                    '<span class="skeleton skeleton-log-desc"></span>' +
                '</div>' +
            '</li>'
        );
    }

    /**
     * 3.1 — Tampilkan skeleton di #log-list
     * Dipanggil sebelum AJAX load_log() dikirim
     */
    function showLogSkeleton(count) {
        count = count || 5;
        var html = '<ul class="skeleton-wrapper" id="log-skeleton-wrap" style="list-style:none; padding:0; margin:0;">';
        for (var i = 0; i < count; i++) {
            html += skeletonLogItem();
        }
        html += '</ul>';
        $('#log-list').html(html);
    }

    /**
     * 3.1 — Sembunyikan skeleton log sebelum inject konten nyata
     * (dipanggil dari patch load_log di bawah)
     */
    function hideLogSkeleton(callback) {
        var $wrap = $('#log-skeleton-wrap');
        if ($wrap.length) {
            $wrap.addClass('fade-out');
            setTimeout(function () {
                $wrap.remove();
                if (callback) callback();
            }, 350);
        } else {
            if (callback) callback();
        }
    }

    /* ----------------------------------------------------------
     * Helper: Buat satu skeleton post card (Pengumuman)
     * ---------------------------------------------------------- */
    function skeletonPostCard() {
        return (
            '<div class="skeleton-post-card skeleton-wrapper">' +
                '<div class="skeleton-post-header">' +
                    '<span class="skeleton skeleton-post-avatar"></span>' +
                    '<div class="skeleton-post-meta">' +
                        '<span class="skeleton skeleton-post-title"></span>' +
                        '<span class="skeleton skeleton-post-date"></span>' +
                    '</div>' +
                '</div>' +
                '<span class="skeleton skeleton-post-line"></span>' +
                '<span class="skeleton skeleton-post-line"></span>' +
                '<span class="skeleton skeleton-post-line"></span>' +
            '</div>'
        );
    }

    /**
     * 3.2 — Tampilkan skeleton di #pengumuman (post section)
     */
    function showPostSkeleton(count) {
        count = count || 3;
        var html = '';
        for (var i = 0; i < count; i++) {
            html += skeletonPostCard();
        }
        // Sisipkan skeleton sebelum #loading-post agar terlihat
        var $pengumuman = $('#pengumuman');
        if ($pengumuman.length && $pengumuman.find('.skeleton-post-card').length === 0) {
            $pengumuman.prepend(html);
        }
    }

    /**
     * 3.2 — Hapus semua skeleton post saat konten sudah ditambahkan
     */
    function hidePostSkeletons() {
        $('#pengumuman .skeleton-post-card').each(function () {
            var $card = $(this);
            $card.addClass('fade-out');
            setTimeout(function () { $card.remove(); }, 350);
        });
    }

    /* ----------------------------------------------------------
     * Helper: Buat skeleton rows untuk tabel jadwal
     * ---------------------------------------------------------- */
    function skeletonTableRow() {
        return (
            '<div class="skeleton-table-row skeleton-wrapper">' +
                '<span class="skeleton skeleton-table-cell-time"></span>' +
                '<span class="skeleton skeleton-table-cell-text"></span>' +
            '</div>'
        );
    }

    /**
     * 3.3 — Inject skeleton di dalam tab-pane jadwal yang aktif
     * Jadwal dirender PHP (server-side) jadi skeleton hanya muncul
     * sebentar saat DOM belum paint (menggunakan CSS visibility trick)
     */
    function initJadwalSkeleton() {
        // Jadwal dirender server-side, tidak ada AJAX — tapi tabel bisa
        // lambat paint jika banyak kelas. Kita tambahkan skeleton wrapper
        // di atas tabel asli, lalu hapus setelah tabel siap dirender.
        var $tabPanes = $('.tab-pane .table-responsive');
        if ($tabPanes.length === 0) return;

        $tabPanes.each(function () {
            var $pane = $(this);
            // Hanya jadwal tab (bukan tabel lain)
            if ($pane.find('table.w-100').length === 0) return;

            // Sembunyikan tabel asli dulu (opacity, bukan display)
            $pane.css('opacity', 0);

            // Inject skeleton sebelum tabel
            var skelHtml = '<div id="jadwal-skeleton" class="skeleton-wrapper">';
            for (var i = 0; i < 6; i++) {
                skelHtml += skeletonTableRow();
            }
            skelHtml += '</div>';
            $pane.before(skelHtml);

            // Fade in tabel asli setelah delay singkat (simulasi paint)
            setTimeout(function () {
                $('#jadwal-skeleton').addClass('fade-out');
                setTimeout(function () {
                    $('#jadwal-skeleton').remove();
                    $pane.css({ opacity: 0, transition: 'opacity 0.4s ease' });
                    // Force reflow
                    $pane[0].offsetHeight; // jslint: ignore
                    $pane.css('opacity', 1);
                }, 350);
            }, 600);
        });
    }

    /* ----------------------------------------------------------
     * Patch: Override behavior getPosts & load_log
     * dengan mengintegrasikan skeleton show/hide
     * ---------------------------------------------------------- */
    $(document).ready(function () {

        // 3.1 — Pasang skeleton log sebelum load_log dipanggil
        // Intercept menggunakan MutationObserver pada #log-list
        var $logList = $('#log-list');
        if ($logList.length) {
            // Tampilkan skeleton langsung (load_log() dipanggil by dashboard.js)
            showLogSkeleton(5);

            // Observer: saat #log-list diisi konten nyata (ul.products-list),
            // fade out skeleton terlebih dahulu
            var logObserver = new MutationObserver(function (mutations, obs) {
                mutations.forEach(function (mutation) {
                    if (mutation.addedNodes.length > 0) {
                        var $added = $(mutation.addedNodes[0]);
                        // Konten nyata punya class products-list
                        if ($added.hasClass('products-list')) {
                            obs.disconnect();
                            // Fade in konten nyata
                            $added.css({ opacity: 0, transition: 'opacity 0.4s ease' });
                            // Wait sedikit lalu tampilkan
                            setTimeout(function () {
                                $added.css('opacity', 1);
                            }, 50);
                        }
                    }
                });
            });
            logObserver.observe($logList[0], { childList: true });
        }

        // 3.2 — Pasang skeleton pengumuman
        var $pengumuman = $('#pengumuman');
        if ($pengumuman.length) {
            showPostSkeleton(3);

            // Observer: saat konten post pertama diinjeksi oleh addPosts(),
            // hapus skeleton cards
            var postObserver = new MutationObserver(function (mutations, obs) {
                mutations.forEach(function (mutation) {
                    if (mutation.addedNodes.length > 0) {
                        // Cek apakah yang ditambah bukan skeleton itu sendiri
                        var $added = $(mutation.addedNodes[0]);
                        if (!$added.hasClass('skeleton-post-card')) {
                            obs.disconnect();
                            hidePostSkeletons();
                        }
                    }
                });
            });
            postObserver.observe($pengumuman[0], { childList: true });
        }

        // 3.3 — Jadwal skeleton (hanya di halaman yang ada tabel jadwal)
        if ($('.tab-pane .table-responsive table.w-100').length > 0) {
            initJadwalSkeleton();
        }

    });

})(jQuery);
