# 🎨 UI/UX REVIEW — GarudaCBT 2026
> **Dokumen ini adalah panduan tracing UI/UX dari awal.**  
> Dibuat: **2026-05-22** | Status: 🔴 **Belum Dimulai**  
> Semua halaman dianggap **belum direview** sampai ada tanda ✅

---

## 📌 Cara Menggunakan Dokumen Ini

1. **Pilih halaman** dari daftar di bawah, kerjakan satu per satu
2. **Buka di browser** → `http://172.19.1.201/[path]`
3. **Catat temuan** di kolom "Temuan & Catatan"
4. **Implementasi fix** → commit dengan format `style(scope): ...`
5. **Centang** item setelah fix di-deploy dan diverifikasi

**Legend Status:**
| Simbol | Arti |
|--------|------|
| ⬜ | Belum direview |
| 🔍 | Sedang direview |
| 🛠️ | Ada masalah, sedang diperbaiki |
| ✅ | Selesai — sudah deploy + verified |
| ⏭️ | Di-skip (tidak perlu perubahan) |

---

## 📊 Progress Overview

```
Modul 1 — Auth & Login           ⬜⬜⬜⬜⬜   0%   [ ] Belum dimulai
Modul 2 — Dashboard              ⬜⬜⬜⬜⬜   0%   [ ] Belum dimulai
Modul 3 — Data Master            ⬜⬜⬜⬜⬜   0%   [ ] Belum dimulai
Modul 4 — E-Learning (Kelas)     ⬜⬜⬜⬜⬜   0%   [ ] Belum dimulai
Modul 5 — CBT (Ujian Admin)      ⬜⬜⬜⬜⬜   0%   [ ] Belum dimulai
Modul 6 — CBT (Tampilan Siswa)   ⬜⬜⬜⬜⬜   0%   [ ] Belum dimulai
Modul 7 — Rapor & Nilai          ⬜⬜⬜⬜⬜   0%   [ ] Belum dimulai
Modul 8 — Pengaturan & User      ⬜⬜⬜⬜⬜   0%   [ ] Belum dimulai
Modul 9 — Template & Layout      ⬜⬜⬜⬜⬜   0%   [ ] Belum dimulai
Modul 10 — Error Pages           ⬜⬜⬜⬜⬜   0%   [ ] Belum dimulai
```

---

## 🔑 Modul 1 — Auth & Login

### Halaman yang Perlu Direview

| Status | Halaman | File View | URL |
|--------|---------|-----------|-----|
| ⬜ | Login Utama | `auth/new_login.php` | `/auth/login` |
| ⬜ | Login Lama (backup) | `auth/login.php` | *(tidak aktif)* |
| ⬜ | Ganti Password | `auth/change_password.php` | `/auth/change_password` |
| ⬜ | Lupa Password | `auth/forgot_password.php` | `/auth/forgot_password` |
| ⬜ | Reset Password | `auth/reset_password.php` | `/auth/reset_password/[code]` |
| ⬜ | Disable Login Screen | `disable_login.php` | — |

### Checklist Review per Halaman
Untuk setiap halaman di atas, periksa:
- [ ] Responsif di mobile (≤ 576px)
- [ ] Tipografi konsisten (font Poppins, ukuran, weight)
- [ ] Warna & kontras memenuhi WCAG AA
- [ ] State loading / error form terlihat jelas
- [ ] Animasi / transisi halus
- [ ] Dark mode berfungsi (jika ada toggle)

### Temuan & Catatan
> *(Kosong — belum direview)*

---

## 🖥️ Modul 2 — Dashboard

| Status | Halaman | File View | Akses Role |
|--------|---------|-----------|-----------|
| ⬜ | Dashboard Admin | `dashboard.php` | Admin |
| ⬜ | Dashboard Guru | `members/guru/dashboard.php` | Guru |
| ⬜ | Dashboard Siswa | `members/siswa/dashboard.php` | Siswa |

### Checklist Review
- [ ] Hero section / header area
- [ ] Stat cards / info boxes (layout, angka, ikon)
- [ ] Widget jadwal hari ini
- [ ] Widget pengumuman / aktivitas
- [ ] Konsistensi visual antar role (Admin vs Guru vs Siswa)
- [ ] Responsif mobile
- [ ] Dark mode
- [ ] Empty state ketika tidak ada data

### Temuan & Catatan
> *(Kosong — belum direview)*

---

## 📁 Modul 3 — Data Master (Admin)

| Status | Halaman | File View |
|--------|---------|-----------|
| ⬜ | Data Siswa | `master/siswa/data.php` |
| ⬜ | Tambah Siswa | `master/siswa/add.php` |
| ⬜ | Edit Siswa | `master/siswa/edit.php` |
| ⬜ | Data Guru | `master/guru/data.php` |
| ⬜ | Tambah Guru | `master/guru/add.php` |
| ⬜ | Edit Guru | `master/guru/edit.php` |
| ⬜ | Detail Guru | `master/guru/detail.php` |
| ⬜ | Data Kelas/Rombel | `master/kelas/data.php` |
| ⬜ | Tambah Kelas | `master/kelas/add.php` |
| ⬜ | Detail Kelas | `master/kelas/detail.php` |
| ⬜ | Naik Kelas | `master/kelas/naikkelas.php` |
| ⬜ | Data Jurusan | `master/jurusan/data.php` |
| ⬜ | Data Mata Pelajaran | `master/mapel/data.php` |
| ⬜ | Data Tahun Pelajaran | `master/tahun/data.php` |
| ⬜ | Data Ekstrakurikuler | `master/ekstra/data.php` |
| ⬜ | Data Alumni | `master/alumni/data.php` |
| ⬜ | Pengumuman | `pengumuman/data.php` |
| ⬜ | Tambah Pengumuman | `pengumuman/add.php` |

### Checklist Review
- [ ] Tabel data (sorting, search, pagination) — konsistensi
- [ ] Form tambah/edit — layout, label, validasi visual
- [ ] Tombol aksi (tambah, edit, hapus) — placement & style
- [ ] Konfirmasi hapus (SweetAlert)
- [ ] Pesan sukses / error (toast atau flash)
- [ ] Import/export Excel (jika ada)
- [ ] Responsif di tabel besar

### Temuan & Catatan
> *(Kosong — belum direview)*

---

## 📚 Modul 4 — E-Learning (Kelas)

| Status | Halaman | File View | Akses |
|--------|---------|-----------|-------|
| ⬜ | Jadwal Pelajaran | `kelas/jadwal/data.php` | Admin/Guru |
| ⬜ | Materi | `kelas/materi/data.php` | Admin/Guru |
| ⬜ | Tambah Materi | `kelas/materi/add.php` | Admin/Guru |
| ⬜ | Tugas | `kelas/tugas/data.php` | Admin/Guru |
| ⬜ | Tambah Tugas | `kelas/tugas/add.php` | Admin/Guru |
| ⬜ | Jadwal Materi | `kelas/materijadwal/data.php` | Admin/Guru |
| ⬜ | Nilai E-Learning | `kelas/nilai/data.php` | Admin/Guru |
| ⬜ | Absensi Harian | `kelas/absenharian/data.php` | Admin/Guru |
| ⬜ | Absensi Bulanan | `kelas/absenbulanan/data.php` | Admin/Guru |
| ⬜ | Status Kelas | `kelas/status/data.php` | Admin/Guru |
| ⬜ | Materi Siswa | `members/siswa/materi/data.php` | Siswa |
| ⬜ | View Materi Siswa | `members/siswa/materi/view.php` | Siswa |
| ⬜ | Tugas Siswa | `members/siswa/tugas/data.php` | Siswa |
| ⬜ | View Tugas Siswa | `members/siswa/tugas/view.php` | Siswa |
| ⬜ | Jadwal Siswa | `members/siswa/jadwal/data.php` | Siswa |
| ⬜ | Nilai Siswa | `members/siswa/nilai/data.php` | Siswa |
| ⬜ | Absensi Siswa | `members/siswa/absensi/data.php` | Siswa |
| ⬜ | Catatan Siswa | `members/siswa/catatan/data.php` | Siswa |

### Checklist Review
- [ ] Editor konten materi (tampilan rich text / upload file)
- [ ] Preview materi/tugas dari sisi siswa
- [ ] Tampilan daftar kosong (empty state)
- [ ] Status pengumpulan tugas
- [ ] Kalender / jadwal visual

### Temuan & Catatan
> *(Kosong — belum direview)*

---

## 📝 Modul 5 — CBT Ujian (Sisi Admin/Guru)

| Status | Halaman | File View |
|--------|---------|-----------|
| ⬜ | Bank Soal | `cbt/banksoal/data.php` |
| ⬜ | Tambah Soal | `cbt/banksoal/add.php` |
| ⬜ | Detail Soal | `cbt/banksoal/detail.php` |
| ⬜ | Preview Soal | `cbt/banksoal/soal.php` |
| ⬜ | Import Soal | `cbt/banksoal/import.php` |
| ⬜ | Jadwal Ujian | `cbt/jadwal/data.php` |
| ⬜ | Tambah Jadwal | `cbt/jadwal/add.php` |
| ⬜ | Jenis Ujian | `cbt/jenis/data.php` |
| ⬜ | Sesi Ujian | `cbt/sesi/data.php` |
| ⬜ | Ruang Ujian | `cbt/ruang/data.php` |
| ⬜ | Nomor Peserta | `cbt/nomorpeserta/data.php` |
| ⬜ | Alokasi Waktu | `cbt/alokasi/data.php` |
| ⬜ | Token Ujian | `cbt/token/data.php` |
| ⬜ | Status Ujian | `cbt/status/data.php` |
| ⬜ | Detail Status Siswa | `cbt/status/detail.php` |
| ⬜ | Sesi Siswa | `cbt/sesisiswa/data.php` |
| ⬜ | Pengawas | `cbt/pengawas/data.php` |
| ⬜ | Nilai Ujian | `cbt/nilai/data.php` |
| ⬜ | Koreksi Essai | `cbt/nilai/nilai_essai.php` |
| ⬜ | Rekap Nilai | `cbt/rekap/data.php` |
| ⬜ | Analisis Soal | `cbt/analisis/data.php` |
| ⬜ | Cetak Kartu Ujian | `cbt/cetak/kartu.php` |
| ⬜ | Cetak Daftar Hadir | `cbt/cetak/absen.php` |
| ⬜ | Cetak Berita Acara | `cbt/cetak/beritaacara.php` |
| ⬜ | Cetak Peserta | `cbt/cetak/peserta.php` |
| ⬜ | Status Guru | `members/guru/cbt/status/data.php` |
| ⬜ | Token Guru | `members/guru/cbt/token/data.php` |

### Checklist Review
- [ ] Form soal — editor (PG, essay, menjodohkan, isian singkat)
- [ ] Preview soal dari sudut pandang siswa
- [ ] Monitor status ujian real-time
- [ ] Tampilan token — besar, mudah dibaca
- [ ] Cetak — layout print-friendly
- [ ] Analisis soal — grafik / tabel hasil

### Temuan & Catatan
> *(Kosong — belum direview)*

---

## 🎓 Modul 6 — CBT Ujian (Tampilan Siswa)

> ⚠️ **Prioritas Tinggi** — Ini halaman yang paling sering digunakan siswa saat ujian.

| Status | Halaman | File View |
|--------|---------|-----------|
| ⬜ | Daftar Ujian Siswa | `members/siswa/cbt/data.php` |
| ⬜ | Konfirmasi Mulai Ujian | `members/siswa/cbt/konfirmasi.php` |
| ⬜ | Halaman Ujian | `members/siswa/cbt/ujian.php` |

### Checklist Review
- [ ] Daftar ujian — informasi jadwal jelas (waktu, durasi, token)
- [ ] Halaman konfirmasi — informasi tata tertib, pengawas
- [ ] Timer ujian — ukuran, warna warning (< 10 menit / < 5 menit)
- [ ] Navigasi soal (prev/next, nomor soal grid)
- [ ] Tampilan soal per tipe (PG, essay, menjodohkan, isian)
- [ ] Render rumus matematika (KaTeX / MathJax)
- [ ] Soal bergambar — layout gambar + teks
- [ ] Progress bar soal terjawab / belum
- [ ] Tombol Selesai — visibilitas, konfirmasi
- [ ] Anti-kecurangan (deteksi tab baru, dll)
- [ ] Responsif mobile / tablet

### Temuan & Catatan
> *(Kosong — belum direview)*

---

## 📊 Modul 7 — Rapor & Nilai

| Status | Halaman | File View |
|--------|---------|-----------|
| ⬜ | Setting Rapor | `rapor/editrapor.php` |
| ⬜ | Arsip Rapor | `rapor/arsiprapor.php` |
| ⬜ | Nilai Guru (input) | `members/guru/rapor/nilai/nilaiguru.php` |
| ⬜ | Nilai Harian | `members/guru/rapor/nilai/harian.php` |
| ⬜ | Nilai PTS | `members/guru/rapor/nilai/pts.php` |
| ⬜ | Nilai PAS | `members/guru/rapor/nilai/pas.php` |
| ⬜ | Nilai Ekstra | `members/guru/rapor/nilai/ekstra.php` |
| ⬜ | Periksa Nilai | `members/guru/rapor/nilai/periksa.php` |
| ⬜ | DKN | `members/guru/rapor/dkn/data.php` |
| ⬜ | Leger | `members/guru/rapor/leger/data.php` |
| ⬜ | Cetak Rapor PTS | `members/guru/rapor/cetak/pts.php` |
| ⬜ | Cetak Rapor Akhir | `members/guru/rapor/cetak/akhir.php` |
| ⬜ | Cetak Rapor MI | `members/guru/rapor/cetak/akhir_mi.php` |
| ⬜ | Sikap Spiritual | `members/guru/rapor/sikap/spiritual.php` |
| ⬜ | Sikap Sosial | `members/guru/rapor/sikap/sosial.php` |
| ⬜ | Prestasi | `members/guru/rapor/prestasi/data.php` |
| ⬜ | Fisik | `members/guru/rapor/fisik/data.php` |
| ⬜ | Kenaikan Kelas | `members/guru/rapor/kenaikan/data.php` |
| ⬜ | Wali — Kelas | `members/guru/wali/kelas.php` |
| ⬜ | Wali — Per Siswa | `members/guru/wali/persiswa.php` |
| ⬜ | Wali — Struktur | `members/guru/wali/struktur.php` |
| ⬜ | Catatan Guru | `members/guru/kelas/catatan/data.php` |

### Checklist Review
- [ ] Form input nilai — ergonomis, keyboard-friendly
- [ ] Preview rapor sebelum cetak
- [ ] Layout cetak (A4, margin, header kop)
- [ ] Tanda tangan kepsek di rapor
- [ ] Export nilai ke Excel

### Temuan & Catatan
> *(Kosong — belum direview)*

---

## ⚙️ Modul 8 — Pengaturan & User Management

| Status | Halaman | File View |
|--------|---------|-----------|
| ⬜ | Profil Sekolah | `setting/data.php` |
| ⬜ | Setting Rapor | `setting/rapor.php` |
| ⬜ | Setting Database | `setting/db.php` |
| ⬜ | Manajemen User | `setting/manage.php` |
| ⬜ | User Admin — Daftar | `users/admin/data.php` |
| ⬜ | User Admin — Edit | `users/admin/edit.php` |
| ⬜ | User Guru — Daftar | `users/guru/data.php` |
| ⬜ | User Guru — Edit | `users/guru/edit.php` |
| ⬜ | User Siswa — Daftar | `users/siswa/data.php` |
| ⬜ | User Siswa — Edit | `users/siswa/edit.php` |
| ⬜ | Profil Guru | `members/guru/profile.php` |
| ⬜ | Backup Database | *(via controller)* |

### Checklist Review
- [ ] Upload logo sekolah — preview langsung
- [ ] Form edit profil — foto profil guru
- [ ] Reset password user — flow yang jelas
- [ ] Konfirmasi tindakan destruktif (hapus user)

### Temuan & Catatan
> *(Kosong — belum direview)*

---

## 🧱 Modul 9 — Template & Layout Global

> Perubahan di sini berdampak ke **semua halaman** — kerjakan hati-hati.

| Status | File | Deskripsi |
|--------|------|-----------|
| ⬜ | `_templates/dashboard/_header.php` | HTML head Admin/Guru (load CSS/JS) |
| ⬜ | `_templates/dashboard/_footer.php` | Footer + load JS Admin/Guru |
| ⬜ | `_templates/dashboard/navbar.php` | Topbar Admin (jam, notifikasi, dark mode) |
| ⬜ | `_templates/dashboard/sidebar.php` | Sidebar Admin (menu navigasi) |
| ⬜ | `_templates/topnav/_header.php` | HTML head layout top-nav |
| ⬜ | `_templates/topnav/_footer.php` | Footer layout top-nav |
| ⬜ | `_templates/topnav/_menu.php` | Menu navigasi top-nav |
| ⬜ | `_templates/auth/_header.php` | HTML head halaman auth |
| ⬜ | `members/guru/templates/header.php` | HTML head Guru |
| ⬜ | `members/guru/templates/navbar.php` | Navbar Guru |
| ⬜ | `members/guru/templates/sidebar.php` | Sidebar Guru |
| ⬜ | `members/guru/templates/footer.php` | Footer Guru |
| ⬜ | `members/siswa/templates/header.php` | HTML head Siswa (top-nav) |
| ⬜ | `members/siswa/templates/navbar.php` | Navbar Siswa |
| ⬜ | `members/siswa/templates/top.php` | Profil siswa (foto, nama, NIS) |
| ⬜ | `members/siswa/templates/footer.php` | Footer Siswa |

### Checklist Review
- [ ] Meta viewport — `user-scalable=yes` (jangan `no`)
- [ ] CSS loading order tidak konflik
- [ ] JS tidak ada duplikasi load
- [ ] Dark mode toggle tersedia di semua navbar
- [ ] Badge notifikasi ujian (navbar siswa)
- [ ] Footer teks konsisten di semua role
- [ ] Favicon & title tab sesuai
- [ ] Accessibility: `role`, `aria-label` pada elemen interaktif

### Temuan & Catatan
> *(Kosong — belum direview)*

---

## ❌ Modul 10 — Error Pages

| Status | File | Kapan Muncul |
|--------|------|-------------|
| ⬜ | `errors/html/error_404.php` | Halaman tidak ditemukan |
| ⬜ | `errors/html/error_db.php` | Koneksi database gagal |
| ⬜ | `errors/html/error_general.php` | Error umum PHP/CI |
| ⬜ | `errors/html/error_exception.php` | PHP Exception |
| ⬜ | `errors/html/error_php.php` | PHP Error |

### Checklist Review
- [ ] Desain konsisten dengan tema emerald
- [ ] Pesan error ramah pengguna (bukan raw PHP error)
- [ ] Tombol kembali / ke beranda
- [ ] Tidak menampilkan stack trace di production
- [ ] Responsif mobile

### Temuan & Catatan
> *(Kosong — belum direview)*

---

## 🎨 Referensi Design System

### Palet Warna Utama
```css
--primary-soft:  #1cc88a   /* Emerald terang — hover, accent */
--primary-dark:  #13855c   /* Emerald gelap — gradient end */
--primary-hero:  #23d18b   /* Emerald vivid — gradient start hero */
--primary-deep:  #0f7a52   /* Emerald deep — gradient end hero */
--primary-light: #f0fdf4   /* Ultra light — background card aktif */
--warning-soft:  #f6c23e
--danger-soft:   #e74a3b
--info-soft:     #36b9cc
--text-main:     #4a5568
--text-muted:    #718096
--bg-body:       #f7fafc
```

### Border Radius & Spacing
```css
--radius-main: 20px   /* Card, modal */
--radius-comp: 12px   /* Button, input */
```

### File CSS Utama
| File | Isi |
|------|-----|
| `assets/app/css/mystyle.css` | Override global, animasi, komponen |
| `assets/app/css/modern_emerald.css` | Hero pattern, tema emerald |
| `assets/app/css/login-style.css` | Khusus halaman login |

### File JS Utama
| File | Fungsi |
|------|--------|
| `assets/app/js/dashboard.js` | Dashboard JS (pengumuman, jadwal) |
| `assets/app/js/stats-animation.js` | Count-up animation stat cards |
| `assets/app/js/skeleton-loading.js` | Skeleton placeholder |
| `assets/app/js/exam-polish.js` | Timer warning ujian |
| `assets/app/js/dark-mode.js` | Toggle dark/light mode |
| `assets/app/js/global-loader.js` | AJAX loading overlay |

---

## 📝 Log Sesi Review

> Catat setiap sesi kerja di sini.

### Sesi 1 — [Tanggal]
- Halaman yang direview: ...
- Temuan utama: ...
- File yang diubah: ...
- Commit: ...

---

*Dokumen ini adalah **living document** — update setiap sesi review selesai.*  
*Terakhir diperbarui: 2026-05-22*
