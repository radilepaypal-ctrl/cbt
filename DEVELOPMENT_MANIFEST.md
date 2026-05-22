# 📋 GARUDA CBT — DEVELOPMENT MANIFEST
> **Dokumen ini adalah satu-satunya referensi operasional proyek.**  
> Versi terakhir diperbarui: **2026-05-22**  
> Status: 🟡 **In Progress — Security Hardening Phase**

**WAJIB DIBACA SEBELUM MENYENTUH SATU BARIS KODE PUN.**

---

## 📚 Daftar Isi
1. [Struktur Folder & Deployment](#1-struktur-folder--deployment)
2. [Status Proyek & Checkpoint Git](#2-status-proyek--checkpoint-git)
3. [TO-DO LIST (Berurutan)](#3-to-do-list-berurutan)
4. [Vulnerability yang Ditemukan](#4-vulnerability-yang-ditemukan)
5. [Arsitektur Sistem](#5-arsitektur-sistem)
6. [SOP Version Control](#6-sop-version-control)
7. [SOP Deployment ke Apache](#7-sop-deployment-ke-apache)
8. [Disaster Recovery](#8-disaster-recovery)
9. [AI Assistant Protocol](#9-ai-assistant-protocol)
10. [Riwayat Pekerjaan Selesai](#10-riwayat-pekerjaan-selesai)

### 📄 Dokumen Terkait
| Dokumen | Lokasi | Status |
|---------|--------|---------|
| **UI/UX Review 2026** | [`docs/UI_UX_REVIEW_2026.md`](docs/UI_UX_REVIEW_2026.md) | 🔴 Belum dimulai |
| **UI/UX Arsip Fase 1-10** | [`docs/archive/UI_UX_IMPROVEMENT_DOCS_fase1-10_SELESAI.md`](docs/archive/UI_UX_IMPROVEMENT_DOCS_fase1-10_SELESAI.md) | ✅ Referensi saja |

---

## 1. Struktur Folder & Deployment

| Direktori | Fungsi | Aturan |
|-----------|--------|--------|
| `/root/cbt/cbt/` | **Development** — source of truth | ✅ Semua edit di sini |
| `/var/www/html/cbt/` | **Production** — Apache DocumentRoot | ⛔ Hanya sync, JANGAN edit langsung |
| `/root/cbt/lms/` | **Referensi** — kode LMS asli | ⛔ Jangan diubah, acuan saja |

**Akses browser:** `http://172.19.1.201/`  
**Database:** `cbt_db` — User: `garuda_user`  
**Apache error log:** `/var/log/apache2/error.log`

---

## 2. Status Proyek & Checkpoint Git

### Branch Saat Ini
```
master                              ← Base stabil original
├── gemini/ui-ux-improvement-2026   ← UI/UX Fase 1-10 (SELESAI)
├── gemini/ui-ux-redo               ← Reimplementasi alternatif
└── bugfix/dashboard-appearance     ← ✅ AKTIF SEKARANG (HEAD)
```

### Tag Checkpoint Stabil
| Tag | Commit | Deskripsi | Status |
|-----|--------|-----------|--------|
| `v1.6.2-stable` | `70d35a90` | Stats-animation guru + dashboard alignment | ✅ **Stabil Terakhir** |
| `v1.6.1-stable` | `e8ca41b4` | Penyelarasan dashboard admin/guru | ✅ Stabil |
| `v1.6.0-gemini.1` | `bfb80736` | UI/UX Fase 10 selesai | ✅ Stabil |
| `v1.6.3-stable` | — | **[BELUM DIBUAT]** Setelah KaTeX fix | ⏳ Perlu dibuat |

> **Cara kembali ke versi stabil:**
> ```bash
> cd /root/cbt/cbt
> git checkout tags/v1.6.2-stable
> rsync -av --exclude='.git' /root/cbt/cbt/ /var/www/html/cbt/
> ```

### Commit Terbaru (sejak v1.6.2-stable)
```
4ff9845b  fix(siswa): KaTeX ter-render setelah soal AJAX  ← HEAD
3ff454a4  docs: log skeleton loading fase 3 siswa
cae0cbf1  feat(siswa): skeleton loading fase 3 tabel jadwal siswa
d088b5ed  fix: penyelesaian fase 2 dan 8 untuk tampilan siswa
70d35a90  (tag: v1.6.2-stable)  ← titik aman sebelumnya
```

---

## 3. TO-DO LIST (Berurutan)

> Kerjakan **dari atas ke bawah**. Jangan lompat urutan kecuali ada alasan kuat.  
> Setiap task selesai: commit → deploy → ✅ centang di sini.

---

### 🏷️ FASE A — Version Control Checkpoint (SEKARANG)

- [ ] **A1. Buat tag `v1.6.3-stable`** untuk commit HEAD saat ini
  ```bash
  cd /root/cbt/cbt
  git add DEVELOPMENT_MANIFEST.md
  git commit -m "docs: restrukturisasi manifest — merge semua dok, tambah to-do list security"
  git tag -a v1.6.3-stable -m "checkpoint: KaTeX fix + skeleton siswa + manifest restrukturisasi"
  ```
- [ ] **A2. Hapus file dokumentasi lama yang sudah tidak aktif** ✅ *(sudah dihapus: README_149.md, README_152.md, _Sidebar.md, contributing.md)*
- [ ] **A3. Archive UI_UX_IMPROVEMENT_DOCS.md** — pindah ke folder `docs/archive/`
  ```bash
  mkdir -p docs/archive
  mv UI_UX_IMPROVEMENT_DOCS.md docs/archive/UI_UX_IMPROVEMENT_DOCS_fase1-10_SELESAI.md
  ```

---

### 🔒 FASE B — Security Hardening (PRIORITAS TINGGI)

> Kerjakan urut. Setiap sub-task: edit file → deploy → verifikasi → commit → tag.

#### B1. Fix `cookie_httponly` — Proteksi Session dari XSS
**File:** `application/config/config.php` baris 125  
**Risk:** Session cookie bisa dicuri via JavaScript jika ada XSS  
- [ ] Ubah `$config['cookie_httponly'] = FALSE;` → `TRUE`
- [ ] Deploy ke Apache: `cp application/config/config.php /var/www/html/cbt/application/config/config.php`
- [ ] Verifikasi login masih berfungsi normal
- [ ] Commit: `fix(security): aktifkan cookie_httponly untuk proteksi session`

#### B2. Fix `csrf_regenerate` — CSRF Token Lebih Kuat
**File:** `application/config/config.php` baris 187  
**Risk:** Token CSRF fixed/tidak diperbarui → lebih mudah diserang  
- [ ] Ubah `$config['csrf_regenerate'] = FALSE;` → `TRUE`
- [ ] Test semua form AJAX (login, bank soal, jadwal) — pastikan tidak ada error `Token Mismatch`
- [ ] Jika ada AJAX error: tambahkan token refresh di JS yang bermasalah
- [ ] Deploy + verifikasi
- [ ] Commit: `fix(security): aktifkan csrf_regenerate`

#### B3. Blokir Akses File Sensitif via .htaccess
**File:** `.htaccess` (root project)  
**Risk:** `composer.json`, `options.json`, `README.md`, dll bisa diakses dari browser  
- [ ] Tambahkan rule deny di `.htaccess`
- [ ] Verifikasi: `curl http://172.19.1.201/composer.json` harus return 403
- [ ] Deploy + commit: `fix(security): blokir akses file sensitif via htaccess`

#### B4. Blokir Eksekusi PHP di Folder `uploads/`
**File:** Buat `uploads/.htaccess` dan subfolder masing-masing  
**Risk:** Upload bypass → eksekusi webshell PHP  
- [ ] Buat `.htaccess` di `uploads/` berisi:
  ```apache
  php_flag engine off
  Options -ExecCGI
  AddType text/plain .php .php3 .php4 .php5 .phtml
  ```
- [ ] Salin ke semua subfolder (`bank_soal/`, `foto_siswa/`, `materi/`, dll)
- [ ] Turunkan permission: `chmod -R 755 /var/www/html/cbt/uploads/`
- [ ] Verifikasi upload foto siswa masih berfungsi
- [ ] Commit: `fix(security): blokir PHP execution di folder uploads`

#### B5. Proteksi Kredensial Database (Planning)
**File:** `application/config/database.php`  
**Risk:** Password DB hardcoded di git history  
> ⚠️ **Task ini butuh koordinasi** — perubahan ini mempengaruhi deployment dan environment setup.
- [ ] Diskusikan opsi: `.env` file vs Apache `SetEnv` vs CI3 `config/development/`
- [ ] Implementasi setelah ada kesepakatan metode
- [ ] Update `.gitignore` untuk mengecualikan file credential

#### B6. Proteksi Encryption Key (Planning)
**File:** `application/config/config.php` baris 45  
**Risk:** Encryption key bocor → session dapat diforged  
> ⚠️ **Setelah B5 selesai** — gunakan metode yang sama.
- [ ] Pindahkan `encryption_key` ke env variable
- [ ] Generate ulang key baru (key lama sudah exposed di git)

---

### 🧹 FASE C — Code & Permission Cleanup

#### C1. Audit Permission Folder Kritis
- [ ] Periksa dan sesuaikan permission production:
  ```bash
  chmod -R 755 /var/www/html/cbt/
  chmod -R 777 /var/www/html/cbt/application/cache
  chmod -R 777 /var/www/html/cbt/application/logs
  chmod -R 755 /var/www/html/cbt/uploads/   # ← turunkan dari 777
  chown -R www-data:www-data /var/www/html/cbt/
  ```
- [ ] Verifikasi upload foto siswa + materi masih jalan
- [ ] Commit: `fix(permission): turunkan permission uploads ke 755`

#### C2. Hapus File `pass_hash.txt` dari Root Project
- [ ] Pindahkan `/root/cbt/pass_hash.txt` ke lokasi aman (di luar direktori project)
- [ ] Dokumentasikan lokasi barunya di catatan internal (BUKAN di sini)

#### C3. Verifikasi `db_debug` di Environment Production
- [ ] Cek `ENVIRONMENT` sudah di-set: `grep -n "ENVIRONMENT" /var/www/html/cbt/index.php`
- [ ] Pastikan production server set ke `'production'`
- [ ] Commit jika ada perubahan: `fix(config): pastikan ENVIRONMENT production untuk disable db_debug`

---

### 🔍 FASE D — Verifikasi & Monitoring

- [ ] **D1.** Test menyeluruh setelah semua security fix: login admin, guru, siswa, ujian, upload
- [ ] **D2.** Buat tag final setelah Fase B+C selesai: `v1.7.0-stable`
- [ ] **D3.** Update bagian [Riwayat Pekerjaan](#10-riwayat-pekerjaan-selesai) di dokumen ini

---

### 🎨 FASE E — UI/UX Review & Improvement (Tracing Ulang)

> Dikerjakan **setelah Fase B & C selesai** agar kondisi aplikasi sudah stabil & aman.  
> Detail checklist per halaman ada di 👉 [`docs/UI_UX_REVIEW_2026.md`](docs/UI_UX_REVIEW_2026.md)

- [ ] **E1.** Modul 1 — Auth & Login (6 halaman)
- [ ] **E2.** Modul 2 — Dashboard Admin, Guru, Siswa
- [ ] **E3.** Modul 3 — Data Master (18 halaman)
- [ ] **E4.** Modul 4 — E-Learning / Kelas (18 halaman)
- [ ] **E5.** Modul 5 — CBT Admin/Guru (26 halaman)
- [ ] **E6.** Modul 6 — CBT Siswa (3 halaman — ⚠️ Prioritas Tinggi)
- [ ] **E7.** Modul 7 — Rapor & Nilai (22 halaman)
- [ ] **E8.** Modul 8 — Pengaturan & User Management (12 halaman)
- [ ] **E9.** Modul 9 — Template & Layout Global (16 file)
- [ ] **E10.** Modul 10 — Error Pages (5 halaman)
- [ ] **E11.** Buat tag setelah UI/UX Fase E selesai: `v1.8.0-stable`

---

## 4. Vulnerability yang Ditemukan

> Diaudit pada 2026-05-22. Diurutkan berdasarkan prioritas perbaikan.

| ID | Severity | File | Masalah | Status |
|----|----------|------|---------|--------|
| B1 | 🟠 Tinggi | `config/config.php:125` | `cookie_httponly = FALSE` — XSS bisa curi session | ⏳ To-do |
| B2 | 🟡 Sedang | `config/config.php:187` | `csrf_regenerate = FALSE` — token CSRF statis | ⏳ To-do |
| B3 | 🟡 Sedang | `.htaccess` | File sensitif bisa diakses browser | ⏳ To-do |
| B4 | 🟠 Tinggi | `uploads/` | Permission 777 + tidak ada blokir PHP exec | ⏳ To-do |
| B5 | 🔴 Kritis | `config/database.php:11` | Password DB hardcoded di git | ⏳ Planning |
| B6 | 🔴 Kritis | `config/config.php:45` | Encryption key hardcoded di git | ⏳ Planning |
| C2 | 🟡 Sedang | `/root/cbt/pass_hash.txt` | File hash password ada di direktori project | ⏳ To-do |
| C3 | 🟡 Sedang | `config/database.php:16` | `db_debug` aktif jika ENVIRONMENT bukan 'production' | ⏳ Verifikasi |
| — | 🔵 Info | Semua controller | Controller ter-obfuscated — tidak bisa diaudit manual | ℹ️ Known |
| — | 🟠 Tinggi | `config/config.php:153` | `global_xss_filtering = FALSE` | ⏳ Evaluasi |
| — | 🟡 Sedang | `config/config.php:124` | `cookie_secure = FALSE` (perlu HTTPS dulu) | ⏳ Bergantung HTTPS |

---

## 5. Arsitektur Sistem

| Komponen | Detail |
|----------|--------|
| **Framework** | CodeIgniter 3 (PHP 7.x / 8.x) |
| **Database** | MySQL — DB: `cbt_db`, User: `garuda_user` |
| **Web Server** | Apache2 — DocumentRoot: `/var/www/html/cbt` |
| **CSS** | AdminLTE 3 + Bootstrap 4 + Custom (`mystyle.css`, `modern_emerald.css`) |
| **JS** | jQuery 3.x + SweetAlert2 + Toastr + KaTeX |
| **Font** | Poppins (self-hosted) |
| **Icon** | FontAwesome 5 + Bootstrap Icons |

### File Kunci yang Sering Diedit
```
application/config/config.php          ← Session, CSRF, security settings
application/config/database.php        ← Koneksi DB
application/controllers/Api.php        ← Satu-satunya controller readable
assets/app/css/mystyle.css             ← CSS utama (override global)
assets/app/css/modern_emerald.css      ← Tema emerald + hero pattern
assets/app/css/login-style.css         ← CSS halaman login
```

### Role User
| Role | Template Layout | Navbar |
|------|----------------|--------|
| Admin | `_templates/dashboard/` (sidebar) | `_templates/dashboard/navbar.php` |
| Guru | `_templates/dashboard/` (sidebar) | `members/guru/templates/navbar.php` |
| Siswa | `members/siswa/templates/` (top-nav) | `members/siswa/templates/header.php` |

---

## 6. SOP Version Control

### ⚠️ Aturan Wajib Branch
- **DILARANG** commit langsung ke `master`
- Format branch: `feature/[nama]`, `bugfix/[nama]`, `hotfix/[nama-darurat]`
- Setiap task besar selesai → wajib buat **git tag**

### Perintah Checkpoint Standar
```bash
# Setelah selesai mengerjakan satu task:
git add [file yang diubah]
git commit -m "fix(scope): deskripsi singkat dan jelas"

# Setelah satu FASE selesai dan sudah ditest:
git tag -a v1.X.Y-stable -m "deskripsi fase yang selesai"
```

### Format Commit (Wajib)
| Prefix | Kapan |
|--------|-------|
| `fix(scope):` | Bugfix / perbaikan keamanan |
| `feat(scope):` | Fitur baru |
| `style(scope):` | Perubahan CSS/visual |
| `docs:` | Update dokumentasi |
| `refactor(scope):` | Refactoring tanpa ubah fungsi |
| `chore:` | Maintenance (permission, cleanup) |

### Rollback Jika Ada Masalah
```bash
# Lihat daftar checkpoint
git log --oneline --tags

# Kembali ke tag stabil (AMAN)
git checkout tags/v1.6.2-stable
rsync -av --exclude='.git' /root/cbt/cbt/ /var/www/html/cbt/

# Batalkan file yang belum di-commit
git restore application/config/config.php

# Undo commit terakhir (simpan perubahan)
git reset HEAD~1 --soft
```

---

## 7. SOP Deployment ke Apache

### ⚠️ JANGAN PERNAH rsync langsung ke `/var/www/html/` tanpa subfolder `cbt/`

### Quick Sync — File Tunggal
```bash
# CSS
cp /root/cbt/cbt/assets/app/css/mystyle.css /var/www/html/cbt/assets/app/css/mystyle.css

# Config (hati-hati!)
cp /root/cbt/cbt/application/config/config.php /var/www/html/cbt/application/config/config.php

# View PHP
cp /root/cbt/cbt/application/views/[path]/[file].php /var/www/html/cbt/application/views/[path]/[file].php
```

### Bulk Sync — Semua Sekaligus
```bash
rsync -av --exclude='.git' /root/cbt/cbt/ /var/www/html/cbt/
chown -R www-data:www-data /var/www/html/cbt/
chmod -R 755 /var/www/html/cbt/
chmod -R 777 /var/www/html/cbt/application/cache /var/www/html/cbt/application/logs
```

### Verifikasi Deploy
```bash
# 1. Cek file sudah berubah
ls -la /var/www/html/cbt/application/config/config.php

# 2. Cek keyword perubahan ada di production
grep -n "cookie_httponly" /var/www/html/cbt/application/config/config.php

# 3. Restart Apache jika ada issue cache PHP
service apache2 reload
```

---

## 8. Disaster Recovery

Jika web blank / error 404 / error 500 setelah update:

1. Cek URL benar: `http://172.19.1.201`
2. Cek webroot: `ls -la /var/www/html/cbt/` → harus ada `index.php` + folder `application/`
3. Cek Apache log: `tail -n 50 /var/log/apache2/error.log`
4. Jika fatal, rollback ke tag stabil:
   ```bash
   cd /root/cbt/cbt
   git checkout tags/v1.6.2-stable
   rsync -av --exclude='.git' /root/cbt/cbt/ /var/www/html/cbt/
   chown -R www-data:www-data /var/www/html/cbt/
   ```

---

## 9. AI Assistant Protocol

Jika AI membaca dokumen ini, **wajib**:

1. **CEK BRANCH:** `git status && git branch` sebelum edit apapun
2. **PATH BENAR:** Edit hanya di `/root/cbt/cbt/` — bukan di `/var/www/html/cbt/`
3. **KERJAKAN URUT:** Ikuti To-Do List di [Bagian 3](#3-to-do-list-berurutan) dari atas ke bawah
4. **BUAT TAG:** Setiap fase selesai dan sudah ditest → buat git tag
5. **UPDATE DOKUMEN INI:** Centang task yang selesai, catat commit hash di Bagian 2 dan 10
6. **JANGAN DESTRUKTIF:** Tidak ada `rm -rf` tanpa konfirmasi eksplisit

---

## 10. Riwayat Pekerjaan Selesai

### ✅ UI/UX Improvement 2026 (Fase 1-10) — SELESAI
*Branch: `gemini/ui-ux-improvement-2026` | Tag: `v1.6.0-gemini.1`*  
*Detail lengkap: lihat `docs/archive/UI_UX_IMPROVEMENT_DOCS_fase1-10_SELESAI.md`*

| Fase | Deskripsi | Commit |
|------|-----------|--------|
| Foundation | Pattern, spacing, siswa views fix | `9939e15e` |
| Fase 1 | Micro-animations | `cf4816fa` |
| Fase 2 | Dashboard stats count-up | `3b464291` |
| Fase 3 | Skeleton loading | `faa502cd` |
| Fase 4 | Empty states | `75c0b5d0` |
| Fase 5 | Exam interface polish | `3066e67f` |
| Fase 6 | Form & input polish + hapus CSS duplikat | `5c46f621` |
| Fase 7 | Mobile optimization, fix `user-scalable=no` | `8a673d57` |
| Fase 8 | Dark mode, welcome greeting, badge notifikasi | `73acb240` |
| Fase 9 | Full codebase audit | `b854fab0` |
| Fase 10 | Custom error pages, accessibility, print CSS, AJAX loader | `bfb80736` |

### ✅ Dashboard Alignment & Bugfix — SELESAI
*Branch: `bugfix/dashboard-appearance` | Tag: `v1.6.2-stable`*

| Perbaikan | Commit |
|-----------|--------|
| Penyelarasan tampilan dashboard admin/guru | `c2af87d9` |
| CSS footer guru disamakan dengan admin | `4fa99bd4` |
| `modern_emerald.css` diintegrasikan ke siswa | `d756463d` |
| `stats-animation.js` ditambah ke guru | `f9acc50d` |
| Dark mode + badge notif siswa yang terlewat | `d088b5ed` |
| Skeleton loading fase 3 — tabel jadwal siswa | `cae0cbf1` |
| **KaTeX math rendering fix setelah AJAX** | `4ff9845b` |

---

*Dokumen ini adalah **living document** — wajib diupdate setiap kali task selesai dikerjakan.*  
*Terakhir diperbarui: 2026-05-22 oleh Antigravity AI*
