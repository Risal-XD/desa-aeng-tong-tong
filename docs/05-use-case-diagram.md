# 05 — Use Case Diagram

**Website Profil Desa Aeng Tong-Tong**

| Properti | Nilai |
| --- | --- |
| Kode Dokumen | ATT-UC-01 |
| Versi | 1.0 |
| Status | Final |

---

## 1. Tujuan

Dokumen ini memetakan **aktor** dan **fungsi (use case)** utama sistem, serta hubungan antar aktor untuk memberikan gambaran fungsionalitas secara keseluruhan.

---

## 2. Aktor

| Aktor | Tipe | Deskripsi |
| --- | --- | --- |
| **Pengunjung (Guest)** | Primer | Publik yang mengakses halaman tanpa login |
| **Admin (Editor Konten)** | Primer | Staf desa pengelola konten, media, layanan |
| **Super Admin** | Primer | Pengelola sistem penuh (pengguna, role, pengaturan) |
| **Waktu (Scheduler)** | Sekunder | Menjalankan job terjadwal (mis. ubah status tayang) |

Relasi *generalization*: **Super Admin** mewarisi seluruh kemampuan **Admin**; **Admin** dan **Super Admin** termasuk kelompok **Pengguna Terautentikasi**.

---

## 3. Use Case Diagram — Sisi Publik

```mermaid
usecaseDiagram
    actor Guest as Pengunjung (Publik)
    actor Admin as Admin / Editor
    actor SuperAdmin as Super Admin

    package "Portal Publik" {
        usecase UC1 as "Melihat Beranda"
        usecase UC2 as "Membaca Profil & Sejarah Desa"
        usecase UC3 as "Melihat Wisata & Potensi"
        usecase UC4 as "Melihat Kerajinan Keris & Mpu"
        usecase UC5 as "Melihat UMKM"
        usecase UC6 as "Membaca Berita & Pengumuman"
        usecase UC7 as "Melihat Agenda"
        usecase UC8 as "Melihat Galeri Foto & Video"
        usecase UC9 as "Melihat Statistik & APBDes"
        usecase UC10 as "Mengunduh Dokumen"
        usecase UC11 as "Membaca Buku Profil (PDF)"
        usecase UC12 as "Mencari Konten"
        usecase UC13 as "Mengirim Pesan via Kontak"
        usecase UC14 as "Membaca FAQ"
        usecase UC15 as "Melihat Visi & Misi"
        usecase UC16 as "Melihat Struktur & Perangkat Desa"
    }

    Guest --> UC1
    Guest --> UC2
    Guest --> UC3
    Guest --> UC4
    Guest --> UC5
    Guest --> UC6
    Guest --> UC7
    Guest --> UC8
    Guest --> UC9
    Guest --> UC10
    Guest --> UC11
    Guest --> UC12
    Guest --> UC13
    Guest --> UC14
    Guest --> UC15
    Guest --> UC16
```

---

## 4. Use Case Diagram — Sisi Backend (Admin / CMS)

```mermaid
usecaseDiagram
    actor Admin as Admin / Editor
    actor SuperAdmin as Super Admin

    package "Panel Admin (CMS)" {
        usecase A1 as "Login / Logout"
        usecase A2 as "Mengelola Berita"
        usecase A3 as "Mengelola Pengumuman"
        usecase A4 as "Mengelola Agenda"
        usecase A5 as "Mengelola Galeri Foto"
        usecase A6 as "Mengelola Video"
        usecase A7 as "Mengelola Banner"
        usecase A8 as "Mengelola Wisata"
        usecase A9 as "Mengelola Keris & Mpu"
        usecase A10 as "Mengelola UMKM"
        usecase A11 as "Mengelola Potensi Desa"
        usecase A12 as "Mengelola Profil, Sejarah, Visi Misi"
        usecase A13 as "Mengelola Statistik & Kependudukan"
        usecase A14 as "Mengelola APBDes"
        usecase A15 as "Mengelola Dokumen"
        usecase A16 as "Mengelola Struktur & Perangkat"
        usecase A17 as "Mengelola Kategori (Master Data)"
        usecase A18 as "Mengelola Pesan Masuk"
        usecase A19 as "Mengelola FAQ"
        usecase A20 as "Mengelola Kontak Desa"
        usecase A21 as "Melihat Dashboard"
        usecase A22 as "Melihat Activity Log"

        usecase A23 as "Mengelola Pengguna"
        usecase A24 as "Mengelola Role & Permission"
        usecase A25 as "Mengelola Pengaturan Website"
    }

    Admin --> A1
    Admin --> A2
    Admin --> A3
    Admin --> A4
    Admin --> A5
    Admin --> A6
    Admin --> A7
    Admin --> A8
    Admin --> A9
    Admin --> A10
    Admin --> A11
    Admin --> A12
    Admin --> A13
    Admin --> A14
    Admin --> A15
    Admin --> A16
    Admin --> A17
    Admin --> A18
    Admin --> A19
    Admin --> A20
    Admin --> A21
    Admin --> A22

    SuperAdmin --> A23
    SuperAdmin --> A24
    SuperAdmin --> A25
```

---

## 5. Relasi Antar Aktor

```mermaid
usecaseDiagram
    actor Guest as Pengunjung
    actor AuthUser as Pengguna Terautentikasi
    actor Admin as Admin
    actor SuperAdmin as Super Admin

    AuthUser <|-- Admin
    Admin <|-- SuperAdmin
```

---

## 6. Daftar Use Case & Deskripsi Singkat

| ID | Use Case | Aktor | Deskripsi Singkat |
| --- | --- | --- | --- |
| UC-01 | Melihat Beranda | Guest | Menampilkan slider, fitur, statistik, berita terbaru |
| UC-02 | Membaca Profil & Sejarah | Guest | Menampilkan narasi sejarah & profil desa |
| UC-03 | Melihat Wisata & Potensi | Guest | Daftar & detail destinasi wisata dan potensi |
| UC-04 | Melihat Keris & Mpu | Guest | Profil kerajinan keris dan data Mpu |
| UC-05 | Melihat UMKM | Guest | Daftar & detail UMKM |
| UC-06 | Membaca Berita & Pengumuman | Guest | Daftar & detail konten informatif |
| UC-07 | Melihat Agenda | Guest | Agenda & jadwal kegiatan |
| UC-08 | Melihat Galeri Foto & Video | Guest | Menjelajah media visual |
| UC-09 | Melihat Statistik & APBDes | Guest | Data & grafik statistik, realisasi anggaran |
| UC-10 | Mengunduh Dokumen | Guest | Mengunduh dokumen publik + log |
| UC-11 | Membaca Buku Profil (PDF) | Guest | Melihat PDF interaktif via PDF.js |
| UC-12 | Mencari Konten | Guest | Pencarian global |
| UC-13 | Mengirim Pesan | Guest | Form kontak → pesan ke admin |
| UC-14 | Membaca FAQ | Guest | Pertanyaan & jawaban umum |
| UC-15 | Visi & Misi | Guest | Konten visi misi |
| UC-16 | Struktur & Perangkat | Guest | Bagan & data perangkat desa |
| UC-17 | Login/Logout | Admin, Super Admin | Autentikasi ke panel |
| UC-18 | CRUD Berita/Pengumuman/Agenda | Admin | Kelola konten informatif |
| UC-19 | CRUD Galeri/Video/Banner | Admin | Kelola media |
| UC-20 | CRUD Wisata/Keris/UMKM/Potensi | Admin | Kelola konten ekonomi-budaya |
| UC-21 | CRUD Profil/Sejarah/Visi Misi/Perangkat | Admin | Kelola konten profil |
| UC-22 | CRUD Statistik/APBDes/Dokumen | Admin | Kelola data & laporan |
| UC-23 | Kelola Pesan Masuk & Kontak | Admin | Layanan publik |
| UC-24 | Lihat Dashboard & Activity Log | Admin, Super Admin | Monitoring |
| UC-25 | Kelola Pengguna | Super Admin | CRUD pengguna |
| UC-26 | Kelola Role & Permission | Super Admin | RBAC |
| UC-27 | Kelola Pengaturan Website | Super Admin | Konfigurasi identitas & meta |
