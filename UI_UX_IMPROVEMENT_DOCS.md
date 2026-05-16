# 📋 Dokumentasi UI/UX Improvement — GarudaCBT
**Project:** GarudaCBT + LMS  
**Versi App:** 1.5.3  
**Dibuat:** 2026-05-16  
**Author:** Antigravity AI (Senior UI/UX + Fullstack)  
**Status:** 🟡 In Progress

---

## 📌 Aturan Wajib Baca

> [!IMPORTANT]
> **Dua direktori utama — jangan sampai tertukar:**
> - `/root/cbt/cbt/` → Direktori **development** (source of truth, semua edit di sini)
> - `/var/www/html/cbt/` → Direktori **production** (Apache serve, harus selalu disync)
>
> **Setiap selesai edit, selalu jalankan:**
> ```bash
> cp /root/cbt/cbt/assets/app/css/[file].css /var/www/html/cbt/assets/app/css/[file].css
> cp /root/cbt/cbt/application/views/[path]/[file].php /var/www/html/cbt/application/views/[path]/[file].php
> ```

> [!WARNING]
> Folder `/root/cbt/lms/` adalah **referensi saja** — jangan diubah. Gunakan sebagai acuan jika ada kebingungan struktur kode.

---

## 🏗️ Arsitektur Sistem

### Stack Teknologi
| Komponen | Detail |
|----------|--------|
| **Framework** | CodeIgniter 3 (PHP) |
| **PHP** | 7.x / 8.x |
| **Database** | MySQL — DB: `cbt_db`, User: `garuda_user` |
| **Web Server** | Apache2 — DocumentRoot: `/var/www/html/cbt` |
| **CSS Framework** | AdminLTE 3 + Bootstrap 4 |
| **JS** | jQuery 3.x + SweetAlert2 + Toastr |
| **Font** | Poppins (Google Fonts lokal) |
| **Icon** | FontAwesome 5 + Bootstrap Icons |

### Struktur Direktori Kunci
```
/root/cbt/cbt/                          ← SOURCE (edit di sini)
├── application/
│   ├── controllers/                    ← Logic per modul
│   │   ├── Auth.php                    ← Login/logout
│   │   ├── Dashboard.php               ← Dashboard admin
│   │   ├── Siswa.php                   ← Semua fitur siswa
│   │   ├── Cbt*.php                    ← Modul ujian (8 file)
│   │   └── Kelas*.php                  ← Modul e-learning
│   └── views/
│       ├── auth/
│       │   ├── new_login.php           ← ⭐ Halaman login aktif
│       │   └── login.php               ← Login lama (tidak aktif)
│       ├── dashboard.php               ← ⭐ Dashboard admin
│       ├── members/
│       │   ├── guru/
│       │   │   └── dashboard.php       ← ⭐ Dashboard guru
│       │   └── siswa/
│       │       ├── templates/
│       │       │   ├── header.php      ← ⭐ Navbar siswa (layout top-nav)
│       │       │   └── top.php         ← ⭐ Profil siswa (foto, nama, NIS)
│       │       ├── dashboard.php       ← ⭐ Dashboard siswa
│       │       ├── cbt/
│       │       │   ├── ujian.php       ← ⭐ Halaman ujian (kritis!)
│       │       │   ├── data.php        ← Daftar ujian
│       │       │   └── konfirmasi.php  ← Konfirmasi mulai ujian
│       │       ├── jadwal/data.php
│       │       ├── materi/data.php
│       │       ├── nilai/data.php
│       │       ├── tugas/data.php
│       │       ├── catatan/data.php
│       │       └── absensi/data.php
│       └── _templates/
│           └── dashboard/
│               ├── _header.php         ← HTML head admin (CSS/JS links)
│               ├── navbar.php          ← Topbar admin (jam, dll)
│               └── sidebar.php         ← Sidebar admin + menu JS
└── assets/
    └── app/
        ├── css/
        │   ├── mystyle.css             ← ⭐ CSS UTAMA (paling sering diedit)
        │   ├── modern_emerald.css      ← ⭐ CSS tema emerald + hero pattern
        │   ├── login-style.css         ← ⭐ CSS khusus halaman login
        │   └── show.toast.css          ← CSS toast notification
        └── js/
            ├── auth/login.js           ← JS halaman login
            └── dashboard.js            ← JS dashboard admin

/var/www/html/cbt/                      ← PRODUCTION (sync dari source)
```

### Role User
| Role | Controller | Template Layout |
|------|-----------|-----------------|
| Admin | `Dashboard.php` | `_templates/dashboard/` (sidebar) |
| Guru | `Guruview.php` | `_templates/dashboard/` (sidebar) |
| Siswa | `Siswa.php` | `members/siswa/templates/` (top-nav) |
| Wali | `Wali*.php` | `_templates/dashboard/` (sidebar) |

### CSS Loading Order (per role)
**Admin/Guru/Wali** (`_templates/dashboard/_header.php`):
1. `adminlte.min.css`
2. `mystyle.css` ← override utama
3. `modern_emerald.css` ← tema + hero pattern

**Siswa** (`members/siswa/templates/header.php`):
1. `adminlte.min.css`
2. `mystyle.css` ← override utama (tidak ada modern_emerald)

**Login** (`auth/new_login.php`):
1. `bootstrap.min.css`
2. `adminlte.min.css`
3. `login-style.css` ← styling login khusus
4. `mystyle.css`

---

## ✅ Yang Sudah Dikerjakan (DONE)

### Sesi Kerja: 2026-05-16

#### 1. ✅ Fix Profil Siswa Menempel ke Navbar
**Problem:** Info box siswa (foto, nama, NIS, kelas) terlalu mepet dengan header logout navbar.  
**Root Cause:**
- `margin-top: -1px` inline style di semua `content-wrapper` view siswa
- `.info-box` CSS global menimpa `bg-transparent` dengan `background: #ffffff`
- Tidak ada class CSS `overlap` yang mendefinisikan hero area

**Files Changed:**
- `assets/app/css/mystyle.css` — Tambah CSS class `.overlap`, fix `.info-box.bg-transparent`
- `application/views/members/siswa/dashboard.php` — Hapus `margin-top: -1px`
- `application/views/members/siswa/jadwal/data.php` — Hapus `margin-top: -1px`
- `application/views/members/siswa/materi/data.php` — Hapus `margin-top: -1px`
- `application/views/members/siswa/materi/view.php` — Hapus `margin-top: -1px`
- `application/views/members/siswa/nilai/data.php` — Hapus `margin-top: -1px`
- `application/views/members/siswa/cbt/data.php` — Hapus `margin-top: -1px`
- `application/views/members/siswa/cbt/konfirmasi.php` — Hapus `margin-top: -1px`
- `application/views/members/siswa/cbt/ujian.php` — Hapus `margin-top: -1px`
- `application/views/members/siswa/tugas/data.php` — Hapus `margin-top: -1px`
- `application/views/members/siswa/tugas/view.php` — Hapus `margin-top: -1px`
- `application/views/members/siswa/catatan/data.php` — Hapus `margin-top: -1px`
- `application/views/members/siswa/absensi/data.php` — Hapus `margin-top: -1px`

---

#### 2. ✅ Hapus Background SVG Wallpaper (content-wrapper)
**Problem:** Background `content-wrapper` menggunakan SVG dot pattern gaya WhatsApp yang ramai.  
**Solution:** Ganti ke `background-image: none`, solid warna `#f7fafc`.

**Files Changed:**
- `assets/app/css/mystyle.css` — Baris 30-34

---

#### 3. ✅ Hapus Wallpaper `wall2.png` dari Hero Header
**Problem:** Hero header dashboard admin/guru menggunakan gambar `wall2.png` (400px tinggi, load berat).  
**Used in:** `views/dashboard.php` dan `views/members/guru/dashboard.php`  
**Solution:** Ganti ke gradient emerald CSS murni, tinggi dikurangi ke 180px.

**Files Changed:**
- `assets/app/css/modern_emerald.css` — Baris 30-53 (class `.hero-header`)

---

#### 4. ✅ Terapkan Pattern Modern (Dot Grid + Radial Glow) ke Hero Header Admin/Guru
**Problem:** Hero header polos setelah wallpaper dihapus.  
**Solution:** CSS-only pattern: dot grid 22px + dual radial glow + diagonal stripe 45° + decorative circles `::before`/`::after`.

**Files Changed:**
- `assets/app/css/modern_emerald.css` — Rewrite total class `.hero-header`

**CSS Pattern Stack:**
```
Layer 1: radial-gradient → dot grid 22px (opacity 0.18)
Layer 2: radial-gradient ellipse → glow kanan atas (putih)
Layer 3: radial-gradient ellipse → depth kiri bawah (hijau gelap)
Layer 4: repeating-linear-gradient 45° → stripe samar
Layer 5: linear-gradient 135° → base emerald #23d18b → #0f7a52
::before → circle dekorasi kanan atas
::after  → circle dekorasi kiri bawah
```

---

#### 5. ✅ Terapkan Pattern ke Hero Section Siswa (Overlap)
**Problem:** `overlap::before` masih plain gradient.  
**Solution:** Pattern sama dengan hero-header, tambah `border-radius: 0 0 24px 24px` untuk efek melengkung elegan.

**Files Changed:**
- `assets/app/css/mystyle.css` — Baris 73-120 (class `.layout-top-nav .content.overlap::before`)

---

#### 6. ✅ Terapkan Pattern ke Navbar Siswa
**Problem:** Navbar siswa warna berbeda dari hero section.  
**Solution:** Pattern identik (dot grid + glow + stripe + gradient) pada `.layout-top-nav .navbar.navbar-green`.

**Files Changed:**
- `assets/app/css/mystyle.css` — Baris 207-220

---

#### 7. ✅ Terapkan Pattern ke Halaman Login
**Problem:** Background login polos, panel kiri (`.content .bg`) tidak ada pattern.  
**Solution:**
- `body` → dot grid hijau transparan (28px) di atas `#f5fdf9`
- `.content .bg` → pattern penuh + decorative circles

**Files Changed:**
- `assets/app/css/login-style.css` — Baris 1-55

---

## 🔲 Yang Belum Dikerjakan (TODO)

### Fase 1 — Micro-Animations & Feel ✅ SELESAI
*Commit: `cf4816fa`*

- [x] **1.1** Card hover lift — `translateY(-5px)` + shadow intensify (card, small-box, info-box)
- [x] **1.2** Button press — `scale(0.95) translateY(1px)` on `:active`, `translateY(-1px)` on hover
- [x] **1.3** Page fade-in — `@keyframes fadeInUp` pada `.content-wrapper` (0.45s spring)
- [x] **1.4** Sidebar nav link hover — animated `::before` left-border indicator + icon scale
- [x] **1.5** Avatar siswa hover zoom — `scale(1.08)` + double ring (white + emerald)
- [x] **1.6** Table row hover — emerald background tint + inset left border 3px
- [x] **BONUS** Form input focus ring — emerald border + glow `rgba(28,200,138,0.15)`
- [x] **BONUS** `.badge-pulse` — `@keyframes pulse-ring` untuk status aktif
- [x] **BONUS** Global link transition + dropdown smooth fade-in

**File Changed:** `assets/app/css/mystyle.css` (216 lines added)

---

### Fase 2 — Dashboard Stats Animation ✅ SELESAI
*Commit: `3b464291`*

- [x] **2.1** Count-up animation untuk angka di `.small-box` dan `.info-box-number` (0 → angka nyata, 1.4 detik, easing `easeOutQuart`)
- [x] **2.2** Staggered entrance animation pada stat cards — cascade 90ms per card dengan spring cubic-bezier
- [x] **2.3** Pulse dot pada status ujian aktif — `#token-view` + `.badge-success/.badge-warning` menggunakan class `.badge-pulse`

**Files Changed:**
- `assets/app/js/stats-animation.js` — File baru, 3 fungsi utama: `initCountUp()`, `initStaggeredEntrance()`, `initPulseDot()`
- `application/views/_templates/dashboard/_footer.php` — Tambah `<script>` include `stats-animation.js` (baris 103)

---

### Fase 3 — Skeleton Loading ✅ SELESAI
*Commit: `faa502cd`*

- [x] **3.1** Skeleton card Aktivitas — `#log-list` via MutationObserver sebelum `load_log()` resolve
- [x] **3.2** Skeleton post cards — `#pengumuman` sebelum `getPosts()` resolve, fade-out smooth saat konten tiba
- [x] **3.3** CSS global `.skeleton` + `.skeleton-gray` — shimmer animation `@keyframes skeleton-shimmer`, siap pakai di elemen apapun
- [x] **BONUS** Skeleton table rows jadwal — 6 row placeholder dengan fade-in reveal setelah 600ms
- [x] **BONUS** `.skeleton-wrapper.fade-out` — transisi opacity 350ms agar perpindahan skeleton → konten tidak kasar

**Files Changed:**
- `assets/app/css/mystyle.css` — +170 baris: base skeleton, log, post, table variants
- `assets/app/js/skeleton-loading.js` — File baru, MutationObserver-based, zero coupling dengan dashboard.js
- `application/views/_templates/dashboard/_footer.php` — Tambah include `skeleton-loading.js`

---

### Fase 4 — Empty States ✅ SELESAI
*Commit: `75c0b5d0`*

- [x] **4.1** Empty state pengumuman — `addPosts()` empty response + komentar kosong (admin & siswa)
- [x] **4.2** Empty state jadwal hari ini — PHP server-side (admin, guru, siswa) + `loadJadwal()` AJAX (siswa)
- [x] **4.3** Empty state daftar ujian siswa — 3 kondisi di `cbt/data.php`: tidak ada jadwal, tidak bisa mengerjakan, tidak ada hari ini
- [x] **4.4** CSS global `.empty-state` + `.empty-state--sm` — floating icon animation, 3 varian warna (warning, info, muted/emerald)

**Files Changed:**
- `assets/app/css/mystyle.css` — +105 baris: base `.empty-state`, variants, `@keyframes empty-float`
- `assets/app/js/dashboard.js` — Upgrade `addPosts()` empty + komentar kosong
- `application/views/dashboard.php` — 2 lokasi (jadwal hari ini, jadwal penilaian)
- `application/views/members/guru/dashboard.php` — 3 lokasi (jadwal kelas, hari ini, penilaian)
- `application/views/members/siswa/dashboard.php` — 4 lokasi (jadwal, loadJadwal AJAX, komentar)
- `application/views/members/siswa/cbt/data.php` — 3 lokasi (tidak ada jadwal, tidak bisa mengerjakan, tidak ada hari ini)

---

### Fase 5 — Exam Interface Polish ✅ SELESAI
*Commit: `3066e67f`*

- [x] **5.1** `.btn-oval-sm` — definisi CSS additive untuk tombol navigasi ujian (Prev/Next/Timer/Daftar Soal)
- [x] **5.2** Timer warning color — `exam-polish.js` (MutationObserver ~55 baris, read-only)
  - ≤ 10 menit → `body.timer-warning` (kuning pulse)
  - ≤ 5 menit → `body.timer-danger` (merah pulse cepat)
- [x] **5.3** `#nomor-soal` badge — radius + shadow emerald
- [x] **5.4** `.card > .overlay` — blur + spinner emerald (ganti spinner-grow default)
- [x] **5.5** `.konten-soal-jawab` border — radius + warna neutral
- [x] **5.6** `#konten-modal` grid — CSS override (controller obfuscated, tidak bisa edit HTML)
- [x] **5.7** Tombol Selesai `#next.btn-success` — `@keyframes selesai-pulse` emerald glow
- [x] **5.8** `.card-footer` — transparan + border neutral
- [x] **5.9-5.13** `konfirmasi.php` full upgrade — header badge emerald, list-group modern, pengawas-box, alert animasi, tombol MULAI pill+hover

**Files Changed:**
- `assets/app/css/mystyle.css` — +350 baris (5.1–5.13)
- `assets/app/js/exam-polish.js` — **file baru** (55 baris)
- `application/views/members/siswa/cbt/ujian.php` — include `exam-polish.js`
- `application/views/members/siswa/cbt/konfirmasi.php` — full card upgrade

---

### Fase 6 — Form & Input Polish ✅ SELESAI
*Commit: `5c46f621`*
> Scope asli direvisi berdasarkan Audit Fase 9: login page sudah modern.

- [x] **6.1** Hapus 3 CSS duplikat di `_header.php` (icheck + select2 di-load 2x) — -3 HTTP request
- [x] **6.2** Hapus `login-main.js` — tidak di-load (sudah terkonfirmasi dari audit)
- [x] **6.3** Pindahkan 147 baris CSS inline login ke `login-style.css` (refactor bersih)
- [x] **6.4** Focus ring emerald global — `.form-control:focus` + `.select2-container--open`
- [x] **6.5** Label polish global — uppercase, weight 600, muted, dengan pengecualian `.icheck-primary`

**Files Changed:**
- `assets/app/css/mystyle.css` — +90 baris (6.1–6.5)
- `assets/app/css/login-style.css` — CSS login card modern
- `application/views/auth/login.php` — hapus 147 baris inline `<style>`
- `application/views/_templates/auth/_header.php` — include `login-style.css`
- `application/views/_templates/dashboard/_header.php` — hapus CSS duplikat

---

### Fase 7 — Mobile Optimization ✅ SELESAI
*Commit: `8a673d57`*
> Berdasarkan Audit Fase 9: `user-scalable=no` di 5 template, DataTables tidak bisa dibungkus HTML.

- [x] **7.1** Ubah `user-scalable=no` → `user-scalable=yes, maximum-scale=5` di **5 template** (admin, guru, siswa, auth, topnav) — zoom pinch kini diizinkan
- [x] **7.2** CSS `.dataTables_wrapper { overflow-x: auto }` — fix tabel di mobile tanpa sentuh JS init
- [x] **7.3** CSS `@media (max-width: 576px)` — card padding, DataTables stack, card-tools wrap
- [x] **7.4** CSS `@media (max-width: 576px)` exam interface — `.btn-oval-sm`, `#timer`, modal grid, konfirmasi kompak
- [x] **7.5** CSS tablet (577-768px) penyesuaian ringan
- [x] **7.6** Touch target min 40px di semua tombol layar ≤ 768px (WCAG 2.5.5)
- [x] **7.7** `.content-wrapper { overflow-x: hidden }` — global overflow guard

**Files Changed:**
- 5 template header — viewport meta diperbarui
- `assets/app/css/mystyle.css` — +175 baris (7.1–7.7)

**File target:** 5 template header + `mystyle.css`

---

### Fase 8 — Nice to Have *(Direvisi berdasarkan Audit Fase 9)*
> Temuan kritis: Login sudah tidak punya panel ganda (no carousel). Notifikasi badge butuh PHP baru.

- [ ] **8.1** Dark mode toggle — CSS var override + localStorage `garudaCBT.theme` + 3 navbar
- [ ] **8.2** Welcome message personal di dashboard siswa (`$siswa->nama`)
- [ ] **8.3** Notifikasi badge — buat `Api.php` controller baru (satu-satunya PHP baru dalam proyek ini)
- [ ] **8.4** ~~Login page carousel~~ → Animasi background SVG halus di login card

---

### Fase 9 — Full Codebase Audit ✅ SELESAI
*Dokumen lengkap: `fase9_full_audit.md` (brain artifacts)*

Audit menyeluruh seluruh source code — backend, frontend, keamanan, performa.

**Temuan Kritis yang Ditemukan:**
- [x] **KB-1** Semua controller & model = 7 baris stub obfuscated → kita hanya bisa sentuh Views + Assets
- [x] **KB-3** `notification.js` menangkap SEMUA form submit via `.preventDefault()` → bug potensial
- [x] **KB-6** Dual `:root` token di `modern_emerald.css` + `mystyle.css` → technical debt
- [x] **KP-3** 3 CSS file (select2, icheck) di-load DUA KALI di setiap halaman admin/guru
- [x] **KF-1** Login sudah modern → Fase 6 direvisi total
- [x] **KF-2** `user-scalable=no` di 5 template → blokir zoom mobile
- [x] **KF-3** `table-responsive` tidak bisa dipakai di DataTables (butuh `scrollX` CSS)
- [x] **F8-3** Notifikasi badge butuh PHP controller baru (Api.php)
- [x] **F8-4** Login tidak punya carousel — Fase 8.4 direvisi ke animasi SVG

---

## 🔀 Version Control (Git)

### Branch Strategy
```
master                          ← Produksi stabil (JANGAN langsung edit di sini)
└── feature/ui-ux-improvement-2026  ← Branch aktif semua pekerjaan UI/UX ini
    ├── [commit] style(mystyle): ...
    ├── [commit] style(modern_emerald): ...
    ├── [commit] style(login): ...
    ├── [commit] fix(siswa-views): ...
    ├── [commit] style(admin-guru-views): ...
    └── [commit berikutnya setiap fase selesai...]
```

### Commit Convention
Format: `type(scope): pesan singkat`

| Type | Kapan Digunakan |
|------|-----------------|
| `style` | Perubahan CSS, visual, layout |
| `fix` | Bugfix (spacing, override CSS, dll) |
| `feat` | Fitur baru (animasi baru, komponen baru) |
| `docs` | Update dokumentasi |
| `refactor` | Refactoring kode tanpa ubah fungsi |
| `js` | Perubahan JavaScript |

**Contoh commit yang baik:**
```bash
git commit -m "feat(exam): add progress bar and question navigation grid

- Sticky progress bar showing X/Y answered
- Color-coded question grid: green=answered, gray=unanswered, red=flagged
- Smooth scroll transition between questions
- Timer pulse red animation when < 5 minutes

Refs: UI_UX_IMPROVEMENT_DOCS.md - Phase 5, Task 5.1-5.4"
```

### Workflow Setiap Sesi Kerja
```bash
# 1. Pastikan di branch yang benar
git branch
# Harus tampil: * feature/ui-ux-improvement-2026

# 2. Lihat status perubahan sebelum mulai
git status
git diff assets/app/css/mystyle.css   # lihat diff spesifik

# 3. Setelah selesai edit, commit
git add [file yang diubah]
git commit -m "type(scope): pesan"

# 4. Sync ke Apache
cp /root/cbt/cbt/[file] /var/www/html/cbt/[file]
```

### Rollback — Jika Ada Masalah

**Lihat daftar commit:**
```bash
git log --oneline
```

**Batalkan perubahan file yang belum di-commit:**
```bash
git restore assets/app/css/mystyle.css
```

**Kembali ke commit tertentu (lihat dulu, tidak permanen):**
```bash
git checkout [hash-commit] -- assets/app/css/mystyle.css
# Contoh:
git checkout 0525d038 -- assets/app/css/mystyle.css
```

**Undo commit terakhir (simpan perubahan, hanya batalkan commit):**
```bash
git reset HEAD~1 --soft
```

**Undo commit terakhir + buang perubahan (HATI-HATI!):**
```bash
git reset HEAD~1 --hard
```

**Kembali ke kondisi master yang stabil:**
```bash
git checkout master
# Atau buat branch baru dari master untuk eksperimen
git checkout -b experiment/test-something master
```

### Hash Commit Penting (Checkpoint)
| Hash | Deskripsi | Kondisi |
|------|-----------|----------|
| `9f5407eb` | `master` sebelum UI/UX dimulai | ✅ Titik aman kembali |
| `0525d038` | Setelah mystyle.css emerald theme | ✅ Checkpoint 1 |
| `b7a29ef0` | Setelah modern_emerald.css hero pattern | ✅ Checkpoint 2 |
| `b940f1e7` | Setelah login pattern | ✅ Checkpoint 3 |
| `89c98fb4` | Setelah fix semua siswa views | ✅ Checkpoint 4 |
| `9939e15e` | Foundation semua fase done | ✅ Checkpoint 5 |
| `cf4816fa` | Phase 1 Micro-Animations COMPLETE | ✅ Checkpoint |
| `3b464291` | Phase 2 Dashboard Stats Animation COMPLETE | ✅ Checkpoint |
| `faa502cd` | Phase 3 Skeleton Loading COMPLETE | ✅ Checkpoint |
| `75c0b5d0` | Phase 4 Empty States COMPLETE | ✅ Checkpoint |
| `3066e67f` | **Phase 5 Exam Interface Polish COMPLETE** | ✅ Checkpoint aktif |

> [!TIP]
> Setiap awal fase baru (Fase 1, 2, 3, dst), catat hash commit terakhir di tabel ini agar ada checkpoint yang jelas.

### Merge ke Master (Saat Sudah Siap)
```bash
# Pastikan semua di-commit dan di-test
git checkout master
git merge feature/ui-ux-improvement-2026 --no-ff \
  -m "feat: UI/UX improvement - Foundation Phase complete"
git push origin master
```

---

## 🔄 SOP Deploy (Setiap Selesai Edit)

### Quick Sync — Single File
```bash
# CSS
cp /root/cbt/cbt/assets/app/css/mystyle.css /var/www/html/cbt/assets/app/css/mystyle.css
cp /root/cbt/cbt/assets/app/css/modern_emerald.css /var/www/html/cbt/assets/app/css/modern_emerald.css
cp /root/cbt/cbt/assets/app/css/login-style.css /var/www/html/cbt/assets/app/css/login-style.css

# View PHP
cp /root/cbt/cbt/application/views/[path]/[file].php /var/www/html/cbt/application/views/[path]/[file].php
```

### Bulk Sync — Semua View Siswa
```bash
rsync -av --checksum \
  /root/cbt/cbt/application/views/members/siswa/ \
  /var/www/html/cbt/application/views/members/siswa/
```

### Verifikasi Deploy
```bash
# Cek CSS sudah terupdate
grep -n "KEYWORD" /var/www/html/cbt/assets/app/css/mystyle.css

# Cek tidak ada sisa margin-top -1px
find /var/www/html/cbt/application/views/members/siswa -name "*.php" \
  -exec grep -l "margin-top: -1px" {} \;
```

---

## 🎨 Design System / Token

### Warna Utama
```css
--primary-soft:  #1cc88a   /* Emerald terang — hover, accent */
--primary-dark:  #13855c   /* Emerald gelap — gradient end */
--primary-hero:  #23d18b   /* Emerald vivid — gradient start hero */
--primary-deep:  #0f7a52   /* Emerald deep — gradient end hero */
--primary-light: #f0fdf4   /* Emerald ultra light — background card aktif */
--warning-soft:  #f6c23e
--danger-soft:   #e74a3b
--info-soft:     #36b9cc
--text-main:     #4a5568
--text-muted:    #718096
--bg-body:       #f7fafc
```

### Border Radius
```css
--radius-main: 20px   /* Card, modal */
--radius-comp: 12px   /* Button, input */
```

### Pattern CSS (reusable)
```css
/* Terapkan di elemen apapun yang butuh pattern emerald */
background-image:
    radial-gradient(circle, rgba(255,255,255,0.17) 1.5px, transparent 1.5px),
    radial-gradient(ellipse at 95% 10%, rgba(255,255,255,0.18) 0%, transparent 55%),
    radial-gradient(ellipse at 8% 90%, rgba(15,122,82,0.45) 0%, transparent 50%),
    repeating-linear-gradient(45deg, transparent, transparent 18px,
        rgba(255,255,255,0.03) 18px, rgba(255,255,255,0.03) 19px),
    linear-gradient(135deg, #23d18b 0%, #0f7a52 100%);
background-size: 22px 22px, 100% 100%, 100% 100%, 100% 100%, 100% 100%;
```

---

## 📊 Progress Overview

```
Fase 1 — Micro-Animations     ██████████ 100%  [✅] SELESAI — commit cf4816fa
Fase 2 — Dashboard Stats       ██████████ 100%  [✅] SELESAI — commit 3b464291
Fase 3 — Skeleton Loading      ██████████ 100%  [✅] SELESAI — commit faa502cd
Fase 4 — Empty States          ██████████ 100%  [✅] SELESAI — commit 75c0b5d0
Fase 5 — Exam Interface        ██████████ 100%  [✅] SELESAI — commit 3066e67f
Fase 6 — Form Polish           ██████████ 100%  [✅] SELESAI — commit 5c46f621
Fase 7 — Mobile Optimization   ██████████ 100%  [✅] SELESAI — commit 8a673d57
Fase 8 — Nice to Have          ░░░░░░░░░░  0%   [ ] Belum dimulai
Fase 9 — Full Codebase Audit   ██████████ 100%  [✅] SELESAI — audit doc: fase9_full_audit.md

Foundation (Pattern + Spacing) ██████████ 100%  [✅] SELESAI
```

---

## 📝 Catatan Sesi

### Sesi 1 — 2026-05-16
- Ditemukan masalah utama: profil siswa mepet ke navbar akibat `margin-top: -1px` di semua view siswa
- CSS `mystyle.css` memiliki rule `.info-box { background: #fff }` yang menimpa `bg-transparent` → sudah diperbaiki
- `wall2.png` digunakan sebagai hero background admin/guru → sudah diganti CSS gradient
- Semua pattern menggunakan CSS-only (zero external image dependency)
- `/root/cbt/lms/` digunakan sebagai referensi saja, tidak diubah

---

*Dokumen ini harus diupdate setiap kali ada perubahan yang selesai dikerjakan.*
