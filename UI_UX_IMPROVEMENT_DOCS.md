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

### Fase 1 — Micro-Animations & Feel (Prioritas Tinggi)
*Dampak besar, effort kecil, murni CSS + sedikit JS*

- [ ] **1.1** Hover card animation — `transform: translateY(-4px)` + shadow intensify pada semua `.card`
- [ ] **1.2** Button press effect — `transform: scale(0.97)` saat klik
- [ ] **1.3** Page fade-in — `@keyframes fadeInUp` pada `.content-wrapper` saat halaman load
- [ ] **1.4** Sidebar nav link hover — smooth background fill left-to-right
- [ ] **1.5** Avatar siswa hover zoom subtle
- [ ] **1.6** Nav link active indicator — animated left border

**File target:** `mystyle.css` + `modern_emerald.css`

---

### Fase 2 — Dashboard Stats Animation
*Meningkatkan engagement admin/guru saat buka dashboard*

- [ ] **2.1** Count-up animation untuk angka di `.small-box` (0 → angka nyata, 1.5 detik)
- [ ] **2.2** Progress bar animasi pada grafik statistik
- [ ] **2.3** Pulse dot pada status ujian aktif

**File target:** `assets/app/js/dashboard.js` + view `dashboard.php`

---

### Fase 3 — Skeleton Loading
*Mengganti spinner `fa-spin` dengan skeleton yang lebih modern*

- [ ] **3.1** Skeleton card untuk list pengumuman/post di dashboard
- [ ] **3.2** Skeleton table untuk jadwal hari ini
- [ ] **3.3** CSS skeleton class `.skeleton` global

**File target:** `mystyle.css` + JS di masing-masing view

---

### Fase 4 — Empty States
*Tampilan saat tidak ada data*

- [ ] **4.1** Empty state pengumuman (icon + teks informatif)
- [ ] **4.2** Empty state jadwal hari ini
- [ ] **4.3** Empty state daftar ujian siswa
- [ ] **4.4** CSS class `.empty-state` global

**File target:** view files siswa + `mystyle.css`

---

### Fase 5 — Exam Interface Polish (Kritis)
*Halaman paling lama digunakan siswa*

- [ ] **5.1** Progress bar soal (X dari Y sudah dijawab) — sticky di atas
- [ ] **5.2** Navigasi soal grid (kotak nomor soal berwarna: hijau=jawab, abu=belum, merah=ragu)
- [ ] **5.3** Animasi smooth saat pindah soal
- [ ] **5.4** Timer pulse effect saat waktu < 5 menit (warna merah + animasi)
- [ ] **5.5** Konfirmasi submit dengan visual yang lebih jelas
- [ ] **5.6** Mobile layout exam yang lebih ergonomis

**File target:** `views/members/siswa/cbt/ujian.php` + CSS baru `ujian.css`

---

### Fase 6 — Form & Input Redesign
- [ ] **6.1** Floating label pada input login
- [ ] **6.2** Focus ring emerald pada semua input form
- [ ] **6.3** Inline validation feedback yang smooth
- [ ] **6.4** Password show/hide toggle

**File target:** `login-style.css` + `mystyle.css`

---

### Fase 7 — Mobile Optimization
- [ ] **7.1** Audit semua tabel — tambah horizontal scroll wrapper
- [ ] **7.2** Card grid pada mobile 1 kolom
- [ ] **7.3** Touch-friendly button size (min 44px tap target)
- [ ] **7.4** Exam interface mobile-first

---

### Fase 8 — Nice to Have
- [ ] **8.1** Dark mode toggle (CSS custom properties switch)
- [ ] **8.2** Welcome message personal di dashboard siswa ("Halo, Ahmad!")
- [ ] **8.3** Notifikasi badge di navbar untuk jadwal ujian hari ini
- [ ] **8.4** Login page carousel ganti ke ilustrasi SVG

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
| `9939e15e` | HEAD saat ini — semua fase foundation done | ✅ Checkpoint aktif |

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
Fase 1 — Micro-Animations     ░░░░░░░░░░  0%   [ ] Belum dimulai
Fase 2 — Dashboard Stats       ░░░░░░░░░░  0%   [ ] Belum dimulai
Fase 3 — Skeleton Loading      ░░░░░░░░░░  0%   [ ] Belum dimulai
Fase 4 — Empty States          ░░░░░░░░░░  0%   [ ] Belum dimulai
Fase 5 — Exam Interface        ░░░░░░░░░░  0%   [ ] Belum dimulai
Fase 6 — Form Redesign         ░░░░░░░░░░  0%   [ ] Belum dimulai
Fase 7 — Mobile Optimization   ░░░░░░░░░░  0%   [ ] Belum dimulai
Fase 8 — Nice to Have          ░░░░░░░░░░  0%   [ ] Belum dimulai

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
