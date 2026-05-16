<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Api.php — Endpoint JSON ringan untuk kebutuhan UI/UX
 *
 * Dibuat pada Fase 8 UI/UX Improvement 2026.
 * Controller ini SATU-SATUNYA controller yang ditulis secara
 * readable (tidak obfuscated) dalam proyek ini.
 *
 * Tujuan: menyediakan data untuk notifikasi badge di navbar
 * tanpa harus menyentuh controller yang sudah ada.
 *
 * Auth: semua endpoint dicek session ion_auth.
 * Response: JSON selalu, tidak pernah render HTML.
 */
class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->database();
        // Pastikan response selalu JSON
        $this->output->set_content_type('application/json');
    }

    /* ----------------------------------------------------------
     * Helper: kirim JSON response
     * ---------------------------------------------------------- */
    private function json($data, $code = 200)
    {
        $this->output
            ->set_status_header($code)
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    /* ----------------------------------------------------------
     * Helper: cek user sudah login, return row user atau false
     * ---------------------------------------------------------- */
    private function getUser()
    {
        if (!$this->ion_auth->logged_in()) {
            return false;
        }
        return $this->ion_auth->user()->row();
    }

    /* ----------------------------------------------------------
     * GET /api/badge_ujian
     *
     * Mengembalikan jumlah jadwal ujian yang aktif HARI INI
     * untuk siswa yang sedang login.
     *
     * Response:
     *   { "count": 2, "jadwal": [...] }
     *   { "count": 0, "jadwal": [] }
     *   { "error": "Unauthorized" }        jika belum login
     *   { "error": "Bukan role siswa" }    jika bukan siswa
     * ---------------------------------------------------------- */
    public function badge_ujian()
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'Unauthorized', 'count' => 0], 401);
        }

        // Endpoint ini hanya untuk siswa
        // Role siswa: tidak dalam grup admin (id=1) atau guru (id=2)
        $isAdmin = $this->ion_auth->is_admin();
        $isGuru  = $this->ion_auth->in_group('guru');
        if ($isAdmin || $isGuru) {
            return $this->json(['error' => 'Bukan role siswa', 'count' => 0], 403);
        }

        $today     = date('Y-m-d');
        $now       = date('H:i:s');
        $username  = $user->username;

        // Query: jadwal ujian hari ini yang aktif,
        // dimana siswa (username) terdaftar sebagai peserta.
        // Menggunakan CI Query Builder — tidak bergantung pada model obfuscated.
        $this->db->select('j.id_jadwal, j.nm_jadwal, j.tgl_mulai, j.tgl_selesai, j.waktu_mulai, j.waktu_selesai, j.durasi');
        $this->db->from('cbt_jadwal j');
        $this->db->join('cbt_jadwal_ujian ju', 'j.id_jadwal = ju.id_jadwal', 'inner');
        $this->db->join('cbt_kelas_ruang kr', 'ju.id_kelas_ruang = kr.id_kelas_ruang', 'inner');
        $this->db->join('cbt_siswa s', 'kr.id_kelas = s.id_kelas', 'inner');
        $this->db->where('s.username', $username);
        $this->db->where('j.tgl_mulai <=', $today);
        $this->db->where('j.tgl_selesai >=', $today);
        $this->db->where('j.aktif', '1');
        $this->db->where('j.waktu_mulai <=', $now);
        $this->db->where('j.waktu_selesai >=', $now);

        $query  = $this->db->get();
        $jadwal = $query ? $query->result() : [];

        return $this->json([
            'count'  => count($jadwal),
            'jadwal' => $jadwal,
        ]);
    }

    /* ----------------------------------------------------------
     * GET /api/ping
     * Health check — tidak butuh auth.
     * ---------------------------------------------------------- */
    public function ping()
    {
        $this->json(['status' => 'ok', 'time' => date('Y-m-d H:i:s')]);
    }
}
