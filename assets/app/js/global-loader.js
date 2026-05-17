/*
 * Global AJAX Loader for GarudaCBT
 * Shows a loading overlay for long-running AJAX requests.
 */

(function($) {
    'use strict';

    // Buat elemen loader jika belum ada
    if ($('.global-ajax-loader').length === 0) {
        var loaderHtml = `
            <div class="global-ajax-loader">
                <div class="spinner"></div>
                <div class="loader-text">Memproses Data...</div>
            </div>
        `;
        $('body').append(loaderHtml);
    }

    var $loader = $('.global-ajax-loader');
    var ajaxReqs = 0;
    var timer;

    $(document).ajaxSend(function(event, jqXHR, ajaxOptions) {
        // Jangan tampilkan loader untuk polling/notifikasi/background task ringan
        if (ajaxOptions.url.indexOf('badge_ujian') !== -1 || ajaxOptions.url.indexOf('load_log') !== -1 || ajaxOptions.global === false) {
            return;
        }

        ajaxReqs++;
        if (ajaxReqs === 1) {
            // Delay 400ms sebelum nampilin loader (biar request cepat gak kedip-kedip)
            timer = setTimeout(function() {
                $loader.addClass('active');
            }, 400);
        }
    });

    $(document).ajaxComplete(function(event, jqXHR, ajaxOptions) {
        if (ajaxOptions.url.indexOf('badge_ujian') !== -1 || ajaxOptions.url.indexOf('load_log') !== -1 || ajaxOptions.global === false) {
            return;
        }

        ajaxReqs--;
        if (ajaxReqs <= 0) {
            ajaxReqs = 0;
            clearTimeout(timer);
            $loader.removeClass('active');
        }
    });

    $(document).ajaxError(function() {
        // Pastikan loader hilang jika error
        ajaxReqs = 0;
        clearTimeout(timer);
        $loader.removeClass('active');
    });

})(jQuery);
