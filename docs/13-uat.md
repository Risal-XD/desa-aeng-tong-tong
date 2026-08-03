# 13 — UAT (User Acceptance Test)

**Website Profil Desa Aeng Tong-Tong**

| Properti | Nilai |
| --- | --- |
| Kode Dokumen | ATT-UAT-01 |
| Versi | 1.0 |
| Status | Draft |
| Pelaksana | Admin Desa (Super Admin), Operator (Editor), Pengunjung Publik |

---

## 1. Tujuan

Dokumen ini adalah **daftar periksa (checklist) Uji Penerimaan Pengguna (UAT)** untuk memastikan seluruh fitur website berfungsi sesuai kebutuhan sebelum peluncuran (M10). Setiap item dinilai **Pass** atau **Fail**; seluruh item wajib **Pass** sebelum rilis production.

---

## 2. Cara Penggunaan

1. Login sebagai **Super Admin** (`superadmin@aengtongtong.desa.id`), **Admin** (`admin@aengtongtong.desa.id`), dan **Editor** (`editor@aengtongtong.desa.id`) untuk menguji hak akses berbeda.
2. Centang kolom hasil setelah setiap pengujian berhasil.
3. Catat temuan pada kolom catatan; laporkan ke pengembang untuk diperbaiki.

---

## 3. Checklist UAT

### 3.1 Autentikasi & Akun (M2, M8)

| No | Skenario Uji | Peran | Hasil (P/F) | Catatan |
| --- | --- | --- | --- | --- |
| 1 | Login dengan kredensial benar mengarah ke dashboard | Semua | | |
| 2 | Login dengan kredensial salah menampilkan pesan error | Guest | | |
| 3 | Pengguna nonaktif tidak dapat login | Guest | | |
| 4 | Logout mengakhiri sesi | Semua | | |
| 5 | Ubah profil (nama/email/avatar) tersimpan | Semua | | |
| 6 | Ganti kata sandi dengan verifikasi kata sandi lama | Semua | | |

### 3.2 Master Data & Profil Desa (M3)

| No | Skenario Uji | Peran | Hasil (P/F) | Catatan |
| --- | --- | --- | --- | --- |
| 7 | Tambah/ubah/hapus data desa | Super Admin | | |
| 8 | Tambah/ubah/hapus struktur organisasi | Super Admin | | |
| 9 | Tambah/ubah/hapus perangkat desa | Super Admin | | |
| 10 | Tambah/ubah kategori berita/galeri/video | Super Admin | | |
| 11 | Ubah profil desa (gambaran, geografis, demografis) | Super Admin | | |
| 12 | Ubah sejarah desa | Super Admin | | |
| 13 | Ubah visi & misi | Super Admin | | |
| 14 | Tambah/ubah/hapus potensi desa | Super Admin | | |
| 15 | Editor tidak dapat mengakses modul master data & profil | Editor | | |

### 3.3 CMS Konten & Media (M5)

| No | Skenario Uji | Peran | Hasil (P/F) | Catatan |
| --- | --- | --- | --- | --- |
| 16 | Tambah/ubah/hapus berita (status draf/terbit/terjadwal) | Super Admin | | |
| 17 | Tambah/ubah/hapus pengumuman | Super Admin | | |
| 18 | Tambah/ubah/hapus agenda | Super Admin | | |
| 19 | Tambah/ubah/hapus FAQ | Super Admin | | |
| 20 | Tambah/ubah/hapus galeri foto | Super Admin | | |
| 21 | Tambah/ubah/hapus video | Super Admin | | |
| 22 | Tambah/ubah/hapus banner | Super Admin | | |
| 23 | Editor dapat mengelola konten tetapi **tidak dapat menghapus** | Editor | | |
| 24 | Berita berstatus draf tidak tampil di frontend | Publik | | |

### 3.4 Ekonomi & Budaya (M6)

| No | Skenario Uji | Peran | Hasil (P/F) | Catatan |
| --- | --- | --- | --- | --- |
| 25 | Tambah/ubah/hapus destinasi wisata | Super Admin | | |
| 26 | Tambah/ubah/hapus kerajinan keris & Mpu | Super Admin | | |
| 27 | Tambah/ubah/hapus UMKM | Super Admin | | |
| 28 | Destinasi nonaktif tidak tampil di halaman publik | Publik | | |

### 3.5 Data & Laporan (M7)

| No | Skenario Uji | Peran | Hasil (P/F) | Catatan |
| --- | --- | --- | --- | --- |
| 29 | Tambah/ubah/hapus statistik beserta baris datanya | Super Admin | | |
| 30 | Tambah/ubah/hapus pos APBDes | Super Admin | | |
| 31 | Tambah/ubah/hapus dokumen | Super Admin | | |
| 32 | Unduh dokumen publik mencatat log & menambah counter | Publik | | |
| 33 | Statistik nonaktif menghasilkan 404 di publik | Publik | | |

### 3.6 Dashboard & Sistem (M8)

| No | Skenario Uji | Peran | Hasil (P/F) | Catatan |
| --- | --- | --- | --- | --- |
| 34 | Dashboard menampilkan statistik & grafik Chart.js | Super Admin | | |
| 35 | Ubah pengaturan website (nama, logo, SEO, kontak, sosmed) | Super Admin | | |
| 36 | Lihat & filter activity log | Super Admin | | |
| 37 | Tambah/ubah/nonaktifkan pengguna & tetapkan role | Super Admin | | |
| 38 | Ubah role & permission lewat matriks izin | Super Admin | | |
| 39 | Admin dapat mengelola pesan masuk & kontak desa | Admin | | |
| 40 | Admin **tidak dapat** mengelola pengguna & role | Admin | | |
| 41 | Editor tidak dapat mengakses sistem & layanan | Editor | | |

### 3.7 Layanan Publik (M8)

| No | Skenario Uji | Peran | Hasil (P/F) | Catatan |
| --- | --- | --- | --- | --- |
| 42 | Publik mengirim pesan lewat form kontak (validasi & rate limit) | Publik | | |
| 43 | Admin membuka pesan (status menjadi dibaca) | Admin | | |
| 44 | Admin membalas pesan (status menjadi dibalas) | Admin | | |
| 45 | Notifikasi pesan baru muncul di sidebar admin | Admin | | |

### 3.8 Frontend Publik (M4–M8)

| No | Skenario Uji | Peran | Hasil (P/F) | Catatan |
| --- | --- | --- | --- | --- |
| 46 | Beranda menampilkan berita, agenda, potensi, banner | Publik | | |
| 47 | Halaman berita list & detail | Publik | | |
| 48 | Halaman pengumuman, agenda, FAQ | Publik | | |
| 49 | Halaman galeri, video, dokumen (termasuk unduh) | Publik | | |
| 50 | Halaman wisata, keris, UMKM beserta detail | Publik | | |
| 51 | Halaman statistik & APBDes | Publik | | |
| 52 | Halaman tentang: sejarah, visi-misi, struktur, perangkat | Publik | | |
| 53 | Halaman potensi desa & kontak | Publik | | |
| 54 | Navigasi utama tampil konsisten di seluruh halaman | Publik | | |
| 55 | Tampilan responsif pada layar ponsel & tablet | Publik | | |

---

## 4. Hasil Pengujian Otomatis (Referensi QA)

Sebagai pendamping UAT manual, rangkuman **pengujian otomatis** (feature & unit test) M9:

| Item | Nilai |
| --- | --- |
| Total test | 149 |
| Total assertion | 522 |
| Status | Pass seluruhnya (100%) |
| Cakupan | 7 file unit test + 14 file feature test |

---

## 5. Tanda Tangan Persetujuan

| Peran | Nama | Tanggal | Tanda Tangan |
| --- | --- | --- | --- |
| Kepala Desa | | | |
| Admin Operator | | | |
| Developer | | | |
