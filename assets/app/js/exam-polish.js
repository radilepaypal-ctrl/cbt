/**
 * exam-polish.js — Fase 5: Exam Interface Polish
 *
 * SCOPE: Hanya menambah/hapus CSS class ke <body>.
 *        TIDAK mengubah logika ujian, timer countdown,
 *        AJAX submit, atau navigasi soal apapun.
 *
 * Cara kerja:
 *  - MutationObserver memantau teks #timer (format HH:MM:SS)
 *  - Saat sisa waktu ≤ 10 menit → body.timer-warning
 *  - Saat sisa waktu ≤  5 menit → body.timer-danger (menggantikan warning)
 *  - Saat ujian selesai (timer 00:00:00) → kedua class dihapus
 */
(function () {
    'use strict';

    var timerEl = document.getElementById('timer');
    if (!timerEl) return; // Hanya aktif di halaman ujian

    var body = document.body;
    var WARN_MINUTES  = 10;
    var DANGER_MINUTES = 5;

    function parseTimerMinutes(text) {
        // Format: HH:MM:SS
        var parts = text.trim().split(':');
        if (parts.length !== 3) return Infinity;
        var h = parseInt(parts[0], 10) || 0;
        var m = parseInt(parts[1], 10) || 0;
        var s = parseInt(parts[2], 10) || 0;
        return h * 60 + m + (s > 0 ? 1 : 0); // menit sisa (bulatkan ke atas)
    }

    function updateTimerClass(minutesLeft) {
        if (minutesLeft <= DANGER_MINUTES) {
            body.classList.remove('timer-warning');
            body.classList.add('timer-danger');
        } else if (minutesLeft <= WARN_MINUTES) {
            body.classList.remove('timer-danger');
            body.classList.add('timer-warning');
        } else {
            body.classList.remove('timer-warning', 'timer-danger');
        }
    }

    // MutationObserver: pantau perubahan teks #timer
    var observer = new MutationObserver(function () {
        var mins = parseTimerMinutes(timerEl.textContent);
        updateTimerClass(mins);
    });

    observer.observe(timerEl, { childList: true, subtree: true, characterData: true });

    // Cek sekali saat halaman pertama kali load
    updateTimerClass(parseTimerMinutes(timerEl.textContent));

})();
