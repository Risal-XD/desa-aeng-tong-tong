# Dokumentasi Proyek — Website Profil Desa Aeng Tong-Tong

**Desa Wisata Sentra Kerajinan Keris · Kecamatan Saronggi · Kabupaten Sumenep · Jawa Timur**

---

## Tentang Proyek

Website Profil Desa Aeng Tong-Tong adalah media informasi resmi desa untuk memperkenalkan sejarah, budaya, pemerintahan, potensi wisata, kerajinan keris, UMKM, berita, agenda, galeri, dokumen publik, serta layanan informasi kepada masyarakat, wisatawan, investor, akademisi, dan instansi pemerintah.

Desa Aeng Tong-Tong dikenal sebagai Sentra Kerajinan Keris dengan Rekor MURI sebagai desa dengan jumlah Mpu (Empu Keris) terbanyak di dunia, serta meraih **Juara 1 Anugerah Desa Wisata Indonesia (ADWI) 2022** pada kategori **Daya Tarik Pengunjung**.

---

## Kontrol Dokumen

| Properti | Nilai |
| --- | --- |
| Nama Proyek | Website Profil Desa Aeng Tong-Tong |
| Kode Proyek | `ATT-WEB` |
| Pemilik Produk | Pemerintah Desa Aeng Tong-Tong |
| Teknologi | Laravel 12, PHP 8.3+, MySQL, Tailwind CSS, Alpine.js |
| Status | Dalam Pengembangan |
| Versi Dokumen | 1.0 |
| Tanggal | 2 Agustus 2026 |

## Daftar Dokumen

| No | Kode | Dokumen | Deskripsi | Status |
| --- | --- | --- | --- | --- |
| 1 | ATT-PRD-01 | [01-prd.md](./01-prd.md) | Product Requirements Document | ✔ Siap |
| 2 | ATT-SRS-01 | [02-srs.md](./02-srs.md) | Software Requirements Specification (IEEE 830) | ✔ Siap |
| 3 | ATT-SM-01 | [03-sitemap.md](./03-sitemap.md) | Sitemap Frontend & Backend | ✔ Siap |
| 4 | ATT-UF-01 | [04-user-flow.md](./04-user-flow.md) | User Flow | ✔ Siap |
| 5 | ATT-UC-01 | [05-use-case-diagram.md](./05-use-case-diagram.md) | Use Case Diagram | ✔ Siap |
| 6 | ATT-AD-01 | [06-activity-diagram.md](./06-activity-diagram.md) | Activity Diagram | ✔ Siap |
| 7 | ATT-SD-01 | [07-sequence-diagram.md](./07-sequence-diagram.md) | Sequence Diagram | ✔ Siap |
| 8 | ATT-RD-01 | [08-roadmap.md](./08-roadmap.md) | Roadmap Pengembangan | ✔ Siap |
| 9 | ATT-ERD-01 | [09-erd.md](./09-erd.md) | Entity Relationship Diagram | ✔ Siap |
| 10 | ATT-DB-01 | [10-database-design.md](./10-database-design.md) | Database Design (detail tabel) | ✔ Siap |
| 11 | ATT-FS-01 | [11-folder-structure.md](./11-folder-structure.md) | Struktur Folder Laravel | ✔ Siap |
| 12 | ATT-CS-01 | [12-coding-standards.md](./12-coding-standards.md) | Standar Coding | ✔ Siap |

---

## Riwayat Revisi

| Versi | Tanggal | Perubahan | Penulis |
| --- | --- | --- | --- |
| 0.1 | 2026-08-02 | Draft awal seluruh dokumen analisis | Senior Product & Engineering Team |
| 1.0 | 2026-08-02 | Disetujui dan difinalkan | — |

## Glosarium Istilah Penting

| Istilah | Definisi |
| --- | --- |
| **Mpu / Empu** | Sebutan bagi perajin keris profesional yang memiliki keahlian tingkat tinggi dalam pembuatan keris. |
| **ADWI** | Anugerah Desa Wisata Indonesia, ajang penghargaan desa wisata tingkat nasional yang digelar Kementerian Pariwisata dan Ekonomi Kreatif. |
| **MURI** | Museum Rekor Dunia Indonesia, lembaga pencatat rekor Indonesia. |
| **UMKM** | Usaha Mikro, Kecil, dan Menengah. |
| **APBDes** | Anggaran Pendapatan dan Belanja Desa. |
| **CMS** | Content Management System. |
| **CRM** | Customer Relationship Management. |
| **SEO** | Search Engine Optimization. |

## Cara Membaca Dokumen

1. Mulailah dari **PRD** untuk memahami konteks bisnis dan kebutuhan produk.
2. Lanjutkan ke **SRS** untuk spesifikasi teknis fungsional dan non-fungsional.
3. Gunakan **Sitemap, User Flow, Use Case, Activity, Sequence Diagram** untuk memahami arsitektur informasi dan alur interaksi.
4. Gunakan **Roadmap** untuk jadwal pengembangan.
5. Gunakan **ERD** dan **Database Design** sebagai acuan implementasi basis data.
6. Gunakan **Folder Structure** dan **Coding Standards** sebagai acuan implementasi kode.

## Stack Teknologi

| Lapisan | Teknologi |
| --- | --- |
| Backend Framework | Laravel 12 |
| Bahasa Pemrograman | PHP 8.3+ |
| Basis Data | MySQL |
| ORM | Eloquent ORM |
| Autentikasi | Laravel Authentication (session-based) |
| Autorisasi | Laravel Policies & Gates |
| Templating | Blade |
| CSS | Tailwind CSS |
| JavaScript | Alpine.js, AOS, SweetAlert2, Chart.js, CKEditor, PDF.js |
| Storage | Laravel Storage (local + opsional S3) |
| Background Job | Queue & Scheduler (sesuai kebutuhan) |
