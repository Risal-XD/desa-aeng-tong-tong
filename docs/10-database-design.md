# 10 — Database Design

**Website Profil Desa Aeng Tong-Tong**

| Properti | Nilai |
| --- | --- |
| Kode Dokumen | ATT-DB-01 |
| Versi | 1.0 |
| Status | Final |
| DBMS | MySQL 8.x (InnoDB, utf8mb4_unicode_ci) |

---

## 1. Konvensi Umum

| Aspek | Konvensi |
| --- | --- |
| Penamaan tabel | Plural snake_case (contoh: `news_categories`) |
| Penamaan kolom | snake_case |
| Primary Key | `id` bertipe `BIGINT UNSIGNED AUTO_INCREMENT` |
| Foreign Key | `{tabel_singular}_id` bertipe `BIGINT UNSIGNED` + index |
| Timestamp | `created_at`, `updated_at` (`TIMESTAMP NULL`) |
| Soft delete | `deleted_at` (`TIMESTAMP NULL`) |
| Status umum | `is_active` (`TINYINT(1)` default 1), atau `status` (`ENUM/VARCHAR`) |
| Charset | `utf8mb4` + `utf8mb4_unicode_ci` |
| Engine | InnoDB |

Kolom `id` selalu `BIGINT UNSIGNED` PK dan tidak diulang di deskripsi tabel di bawah ini kecuali diperlukan.

---

## 2. Tabel Autentikasi & RBAC

### 2.1 `users`

**Fungsi:** Menyimpan data pengguna sistem (admin, editor, super admin).

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| name | VARCHAR(191) | — | Tidak | — | — | Nama lengkap |
| email | VARCHAR(191) | — | Tidak | UNIQUE | — | Email login |
| password | VARCHAR(191) | — | Tidak | — | — | Hash (bcrypt/argon) |
| email_verified_at | TIMESTAMP | NULL | Ya | — | — | Waktu verifikasi email |
| remember_token | VARCHAR(100) | NULL | Ya | — | — | Token remember me |
| avatar | VARCHAR(191) | NULL | Ya | — | — | Path foto profil |
| is_active | BOOLEAN | true | Tidak | INDEX | — | Status aktif akun |
| last_login_at | TIMESTAMP | NULL | Ya | — | — | Login terakhir |
| created_at | TIMESTAMP | NULL | Ya | — | — | Waktu dibuat |
| updated_at | TIMESTAMP | NULL | Ya | — | — | Waktu diubah |

**Constraint:** UNIQUE(email). Index `is_active`.

### 2.2 `roles`

**Fungsi:** Menyimpan peran pengguna (RBAC).

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| name | VARCHAR(191) | — | Tidak | — | — | Nama role (Super Admin) |
| slug | VARCHAR(191) | — | Tidak | UNIQUE | — | Identitas unik (`super-admin`) |
| description | TEXT | NULL | Ya | — | — | Keterangan |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

### 2.3 `permissions`

**Fungsi:** Menyimpan daftar izin per modul/tindakan.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| name | VARCHAR(191) | — | Tidak | — | — | Nama izin (Mengelola Berita) |
| slug | VARCHAR(191) | — | Tidak | UNIQUE | — | `news-manage` |
| group | VARCHAR(191) | NULL | Ya | INDEX | — | Grup modul (Konten) |
| description | VARCHAR(255) | NULL | Ya | — | — | Keterangan |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

### 2.4 `role_user` (pivot)

**Fungsi:** Relasi banyak-ke-banyak users ↔ roles.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| role_id | BIGINT UNSIGNED | — | Tidak | PK/INDEX | roles.id | Composite PK |
| user_id | BIGINT UNSIGNED | — | Tidak | PK/INDEX | users.id | Composite PK |

**Constraint:** PK(`role_id`,`user_id`); FK keduanya dengan `ON DELETE CASCADE`.

### 2.5 `permission_role` (pivot)

**Fungsi:** Relasi banyak-ke-banyak roles ↔ permissions.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| permission_id | BIGINT UNSIGNED | — | Tidak | PK/INDEX | permissions.id | Composite PK |
| role_id | BIGINT UNSIGNED | — | Tidak | PK/INDEX | roles.id | Composite PK |

### 2.6 `user_permission` (pivot)

**Fungsi:** Pemberian izin langsung ke pengguna (opsional, di luar role).

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| permission_id | BIGINT UNSIGNED | — | Tidak | PK/INDEX | permissions.id | Composite PK |
| user_id | BIGINT UNSIGNED | — | Tidak | PK/INDEX | users.id | Composite PK |

### 2.7 `password_reset_tokens`

**Fungsi:** Menyimpan token reset password.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| email | VARCHAR(191) | — | Tidak | PK | — | Email pengguna |
| token | VARCHAR(255) | — | Tidak | — | — | Token hash |
| created_at | TIMESTAMP | NULL | Ya | — | — | Waktu dibuat |

### 2.8 `personal_access_tokens`

**Fungsi:** Token API (Laravel Sanctum) untuk akses API di masa depan.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| tokenable_type | VARCHAR(191) | — | Tidak | INDEX | — | Polymorphic type |
| tokenable_id | BIGINT UNSIGNED | — | Tidak | INDEX | — | Polymorphic id |
| name | VARCHAR(191) | — | Tidak | — | — | Nama token |
| token | VARCHAR(64) | — | Tidak | UNIQUE | — | Token unik |
| abilities | TEXT | NULL | Ya | — | — | Kemampuan token |
| last_used_at | TIMESTAMP | NULL | Ya | — | — | Terakhir dipakai |
| expires_at | TIMESTAMP | NULL | Ya | — | — | Kedaluwarsa |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

### 2.9 `sessions`

**Fungsi:** Menyimpan sesi login.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | VARCHAR(255) | — | Tidak | PK | — | ID sesi |
| user_id | BIGINT UNSIGNED | NULL | Ya | INDEX | users.id | Pengguna (nullable) |
| ip_address | VARCHAR(45) | NULL | Ya | — | — | IP pengguna |
| user_agent | TEXT | NULL | Ya | — | — | Browser |
| payload | LONGTEXT | — | Tidak | — | — | Data sesi |
| last_activity | BIGINT | — | Tidak | INDEX | — | Waktu aktif |

---

## 3. Tabel Profil Desa & Pemerintahan

### 3.1 `villages`

**Fungsi:** Menyimpan data identitas desa (induk seluruh data konten).

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| name | VARCHAR(191) | — | Tidak | — | — | Nama desa |
| code | VARCHAR(20) | — | Tidak | UNIQUE | — | Kode desa (kemendagri) |
| district | VARCHAR(191) | — | Tidak | — | — | Kecamatan |
| regency | VARCHAR(191) | — | Tidak | — | — | Kabupaten |
| province | VARCHAR(191) | — | Tidak | — | — | Provinsi |
| address | TEXT | NULL | Ya | — | — | Alamat kantor |
| latitude | DECIMAL(10,8) | NULL | Ya | — | — | Koordinat lintang |
| longitude | DECIMAL(11,8) | NULL | Ya | — | — | Koordinat bujur |
| area | DECIMAL(10,2) | NULL | Ya | — | — | Luas desa (km²) |
| total_hamlet | SMALLINT UNSIGNED | 0 | Ya | — | — | Jumlah dusun |
| description | TEXT | NULL | Ya | — | — | Deskripsi umum |
| logo | VARCHAR(191) | NULL | Ya | — | — | Logo desa |
| cover_image | VARCHAR(191) | NULL | Ya | — | — | Gambar sampul |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

**Constraint:** UNIQUE(`code`). Tidak di-soft-delete (data inti).

### 3.2 `village_profiles`

**Fungsi:** Profil umum desa (1:1 dengan villages).

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | UNIQUE | villages.id | FK desa |
| overview | LONGTEXT | NULL | Ya | — | — | Gambaran umum |
| geographic | LONGTEXT | NULL | Ya | — | — | Geografis & wilayah |
| demographics_summary | LONGTEXT | NULL | Ya | — | — | Ringkasan demografi |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

**Constraint:** UNIQUE(`village_id`); FK `ON DELETE CASCADE`.

### 3.3 `village_histories`

**Fungsi:** Catatan sejarah desa (1:1).

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | UNIQUE | villages.id | FK desa |
| history_content | LONGTEXT | NULL | Ya | — | — | Konten sejarah (WYSIWYG) |
| founder_name | VARCHAR(191) | NULL | Ya | — | — | Pendiri desa |
| founded_year | SMALLINT UNSIGNED | NULL | Ya | — | — | Tahun berdiri |
| status | VARCHAR(20) | draft | Tidak | INDEX | — | draft/published |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

### 3.4 `visions`

**Fungsi:** Menyimpan visi desa (satu desa bisa banyak entri).

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| vision | TEXT | — | Tidak | — | — | Pernyataan visi |
| sort_order | SMALLINT UNSIGNED | 0 | Tidak | — | — | Urutan |
| is_active | BOOLEAN | true | Tidak | INDEX | — | Aktif/tidak |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

### 3.5 `missions`

**Fungsi:** Menyimpan misi desa.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| mission | TEXT | — | Tidak | — | — | Pernyataan misi |
| sort_order | SMALLINT UNSIGNED | 0 | Tidak | — | — | Urutan |
| is_active | BOOLEAN | true | Tidak | INDEX | — | Aktif/tidak |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

### 3.6 `organizational_structures`

**Fungsi:** Menyimpan node bagan struktur organisasi (hierarki).

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| parent_id | BIGINT UNSIGNED | NULL | Ya | INDEX | self (`organizational_structures.id`) | Node induk |
| name | VARCHAR(191) | — | Tidak | — | — | Nama bagian/jabatan |
| position | VARCHAR(191) | NULL | Ya | — | — | Jabatan |
| level | SMALLINT UNSIGNED | 0 | Tidak | — | — | Level hierarki |
| image | VARCHAR(191) | NULL | Ya | — | — | Foto/ikon |
| description | TEXT | NULL | Ya | — | — | Uraian tugas |
| sort_order | SMALLINT UNSIGNED | 0 | Tidak | — | — | Urutan |
| is_active | BOOLEAN | true | Tidak | INDEX | — | Aktif/tidak |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

### 3.7 `village_officials`

**Fungsi:** Data perangkat desa (nama, jabatan, kontak).

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| structure_id | BIGINT UNSIGNED | NULL | Ya | INDEX | organizational_structures.id | FK struktur |
| name | VARCHAR(191) | — | Tidak | — | — | Nama perangkat |
| position | VARCHAR(191) | — | Tidak | — | — | Jabatan (Kepala Desa) |
| nip | VARCHAR(50) | NULL | Ya | — | — | NIP/identitas |
| photo | VARCHAR(191) | NULL | Ya | — | — | Foto |
| email | VARCHAR(191) | NULL | Ya | — | — | Email |
| phone | VARCHAR(30) | NULL | Ya | — | — | Telepon |
| sort_order | SMALLINT UNSIGNED | 0 | Tidak | — | — | Urutan |
| is_active | BOOLEAN | true | Tidak | INDEX | — | Aktif/tidak |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

### 3.8 `contacts`

**Fungsi:** Data kontak desa (1:1 dengan villages).

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | UNIQUE | villages.id | FK desa |
| address | TEXT | NULL | Ya | — | — | Alamat |
| phone | VARCHAR(30) | NULL | Ya | — | — | Telepon |
| email | VARCHAR(191) | NULL | Ya | — | — | Email resmi |
| fax | VARCHAR(30) | NULL | Ya | — | — | Fax |
| website | VARCHAR(191) | NULL | Ya | — | — | Situs |
| maps_embed | TEXT | NULL | Ya | — | — | Embed peta |
| facebook | VARCHAR(191) | NULL | Ya | — | — | Sosmed |
| instagram | VARCHAR(191) | NULL | Ya | — | — | Sosmed |
| youtube | VARCHAR(191) | NULL | Ya | — | — | Sosmed |
| twitter | VARCHAR(191) | NULL | Ya | — | — | Sosmed |
| whatsapp | VARCHAR(30) | NULL | Ya | — | — | WhatsApp |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

### 3.9 `settings`

**Fungsi:** Konfigurasi website (key-value per grup).

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | NULL | Ya | INDEX | villages.id | FK desa (opsional) |
| group | VARCHAR(50) | general | Tidak | INDEX | — | Grup (general, seo, sosmed) |
| key | VARCHAR(191) | — | Tidak | UNIQUE | — | Nama setting |
| value | TEXT | NULL | Ya | — | — | Nilai |
| type | VARCHAR(20) | string | Tidak | — | — | string/text/boolean/json |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

**Constraint:** UNIQUE(`key`).

---

## 4. Tabel Konten Informasi

### 4.1 `news_categories`

**Fungsi:** Master kategori berita.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| name | VARCHAR(191) | — | Tidak | — | — | Nama kategori |
| slug | VARCHAR(191) | — | Tidak | UNIQUE | — | Slug SEO |
| description | TEXT | NULL | Ya | — | — | Keterangan |
| is_active | BOOLEAN | true | Tidak | INDEX | — | Aktif/tidak |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

### 4.2 `news`

**Fungsi:** Menyimpan berita/artikel.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| news_category_id | BIGINT UNSIGNED | NULL | Ya | INDEX | news_categories.id | FK kategori |
| user_id | BIGINT UNSIGNED | — | Tidak | INDEX | users.id | FK penulis |
| title | VARCHAR(191) | — | Tidak | — | — | Judul |
| slug | VARCHAR(191) | — | Tidak | UNIQUE | — | Slug SEO |
| excerpt | TEXT | NULL | Ya | — | — | Ringkasan |
| content | LONGTEXT | — | Tidak | — | — | Konten WYSIWYG |
| cover_image | VARCHAR(191) | NULL | Ya | — | — | Gambar sampul |
| thumbnail | VARCHAR(191) | NULL | Ya | — | — | Thumbnail |
| source | VARCHAR(191) | NULL | Ya | — | — | Sumber berita |
| tags | JSON | NULL | Ya | — | — | Tag (array) |
| status | VARCHAR(20) | draft | Tidak | INDEX | — | draft/published/scheduled |
| views_count | INT UNSIGNED | 0 | Tidak | — | — | Jumlah dilihat |
| published_at | TIMESTAMP | NULL | Ya | INDEX | — | Waktu terbit |
| created_at / updated_at / deleted_at | TIMESTAMP | NULL | Ya | INDEX(deleted_at) | — | Timestamp |

**Constraint:** UNIQUE(`slug`); FK `village_id`, `news_category_id`, `user_id`; soft delete. Index komposit `(status, published_at)`.

### 4.3 `announcements`

**Fungsi:** Menyimpan pengumuman resmi.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| user_id | BIGINT UNSIGNED | — | Tidak | INDEX | users.id | FK penulis |
| title | VARCHAR(191) | — | Tidak | — | — | Judul |
| slug | VARCHAR(191) | — | Tidak | UNIQUE | — | Slug SEO |
| content | LONGTEXT | NULL | Ya | — | — | Isi pengumuman |
| attachment | VARCHAR(191) | NULL | Ya | — | — | File lampiran |
| status | VARCHAR(20) | draft | Tidak | INDEX | — | draft/published/scheduled |
| published_at | TIMESTAMP | NULL | Ya | INDEX | — | Waktu tayang |
| expired_at | TIMESTAMP | NULL | Ya | — | — | Waktu berakhir |
| created_at / updated_at / deleted_at | TIMESTAMP | NULL | Ya | INDEX(deleted_at) | — | Timestamp |

### 4.4 `agendas`

**Fungsi:** Menyimpan agenda/jadwal kegiatan.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| user_id | BIGINT UNSIGNED | — | Tidak | INDEX | users.id | FK penulis |
| title | VARCHAR(191) | — | Tidak | — | — | Judul agenda |
| slug | VARCHAR(191) | — | Tidak | UNIQUE | — | Slug SEO |
| description | LONGTEXT | NULL | Ya | — | — | Deskripsi |
| location | VARCHAR(191) | NULL | Ya | — | — | Tempat |
| event_date | DATE | — | Tidak | INDEX | — | Tanggal kegiatan |
| start_time | TIME | NULL | Ya | — | — | Jam mulai |
| end_time | TIME | NULL | Ya | — | — | Jam selesai |
| status | VARCHAR(20) | draft | Tidak | INDEX | — | draft/published |
| is_featured | BOOLEAN | false | Tidak | INDEX | — | Agenda unggulan |
| created_at / updated_at / deleted_at | TIMESTAMP | NULL | Ya | INDEX(deleted_at) | — | Timestamp |

### 4.5 `faqs`

**Fungsi:** Menyimpan pertanyaan & jawaban umum.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| user_id | BIGINT UNSIGNED | NULL | Ya | INDEX | users.id | FK penulis |
| question | VARCHAR(191) | — | Tidak | — | — | Pertanyaan |
| answer | TEXT | — | Tidak | — | — | Jawaban |
| category | VARCHAR(50) | umum | Tidak | INDEX | — | Kategori FAQ |
| sort_order | SMALLINT UNSIGNED | 0 | Tidak | — | — | Urutan |
| is_active | BOOLEAN | true | Tidak | INDEX | — | Aktif/tidak |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

---

## 5. Tabel Media

### 5.1 `gallery_categories`

**Fungsi:** Master kategori galeri foto.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| name | VARCHAR(191) | — | Tidak | — | — | Nama kategori |
| slug | VARCHAR(191) | — | Tidak | UNIQUE | — | Slug SEO |
| description | TEXT | NULL | Ya | — | — | Keterangan |
| is_active | BOOLEAN | true | Tidak | INDEX | — | Aktif/tidak |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

### 5.2 `galleries`

**Fungsi:** Menyimpan item foto galeri.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| gallery_category_id | BIGINT UNSIGNED | NULL | Ya | INDEX | gallery_categories.id | FK kategori |
| user_id | BIGINT UNSIGNED | — | Tidak | INDEX | users.id | FK pengunggah |
| title | VARCHAR(191) | — | Tidak | — | — | Judul foto |
| slug | VARCHAR(191) | — | Tidak | UNIQUE | — | Slug SEO |
| image | VARCHAR(191) | — | Tidak | — | — | Path gambar |
| description | TEXT | NULL | Ya | — | — | Keterangan |
| is_cover | BOOLEAN | false | Tidak | — | — | Foto sampul album |
| sort_order | SMALLINT UNSIGNED | 0 | Tidak | — | — | Urutan |
| is_active | BOOLEAN | true | Tidak | INDEX | — | Aktif/tidak |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

### 5.3 `video_categories`

**Fungsi:** Master kategori video. (Struktur sama dengan `gallery_categories`.)

### 5.4 `videos`

**Fungsi:** Menyimpan item video (embed URL).

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| video_category_id | BIGINT UNSIGNED | NULL | Ya | INDEX | video_categories.id | FK kategori |
| user_id | BIGINT UNSIGNED | — | Tidak | INDEX | users.id | FK pengunggah |
| title | VARCHAR(191) | — | Tidak | — | — | Judul video |
| slug | VARCHAR(191) | — | Tidak | UNIQUE | — | Slug SEO |
| video_url | VARCHAR(255) | — | Tidak | — | — | URL video (YouTube/Vimeo) |
| thumbnail | VARCHAR(191) | NULL | Ya | — | — | Thumbnail |
| platform | VARCHAR(20) | youtube | Tidak | — | — | youtube/vimeo/lainnya |
| description | TEXT | NULL | Ya | — | — | Keterangan |
| is_active | BOOLEAN | true | Tidak | INDEX | — | Aktif/tidak |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

### 5.5 `banners`

**Fungsi:** Menyimpan banner/slider beranda.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| user_id | BIGINT UNSIGNED | — | Tidak | INDEX | users.id | FK pembuat |
| title | VARCHAR(191) | — | Tidak | — | — | Judul banner |
| slug | VARCHAR(191) | — | Tidak | UNIQUE | — | Slug SEO |
| image | VARCHAR(191) | — | Tidak | — | — | Path gambar |
| link | VARCHAR(255) | NULL | Ya | — | — | Tautan |
| description | TEXT | NULL | Ya | — | — | Keterangan |
| position | VARCHAR(20) | home | Tidak | INDEX | — | home/other |
| sort_order | SMALLINT UNSIGNED | 0 | Tidak | — | — | Urutan |
| status | VARCHAR(20) | active | Tidak | INDEX | — | active/inactive |
| started_at | TIMESTAMP | NULL | Ya | — | — | Mulai tayang |
| ended_at | TIMESTAMP | NULL | Ya | — | — | Akhir tayang |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

---

## 6. Tabel Ekonomi & Budaya

### 6.1 `village_potentials`

**Fungsi:** Menyimpan potensi unggulan desa.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| user_id | BIGINT UNSIGNED | NULL | Ya | INDEX | users.id | FK pengelola |
| title | VARCHAR(191) | — | Tidak | — | — | Judul potensi |
| slug | VARCHAR(191) | — | Tidak | UNIQUE | — | Slug SEO |
| category | VARCHAR(50) | NULL | Ya | INDEX | — | Wisata/Budaya/Pertanian |
| description | LONGTEXT | NULL | Ya | — | — | Deskripsi |
| image | VARCHAR(191) | NULL | Ya | — | — | Gambar |
| icon | VARCHAR(50) | NULL | Ya | — | — | Ikon |
| is_featured | BOOLEAN | false | Tidak | INDEX | — | Unggulan |
| sort_order | SMALLINT UNSIGNED | 0 | Tidak | — | — | Urutan |
| is_active | BOOLEAN | true | Tidak | INDEX | — | Aktif/tidak |
| created_at / updated_at / deleted_at | TIMESTAMP | NULL | Ya | INDEX(deleted_at) | — | Timestamp |

### 6.2 `tourism_destinations`

**Fungsi:** Menyimpan destinasi wisata desa.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| user_id | BIGINT UNSIGNED | NULL | Ya | INDEX | users.id | FK pengelola |
| title | VARCHAR(191) | — | Tidak | — | — | Nama destinasi |
| slug | VARCHAR(191) | — | Tidak | UNIQUE | — | Slug SEO |
| description | LONGTEXT | NULL | Ya | — | — | Deskripsi |
| image | VARCHAR(191) | NULL | Ya | — | — | Gambar utama |
| gallery | JSON | NULL | Ya | — | — | Kumpulan gambar |
| address | VARCHAR(255) | NULL | Ya | — | — | Alamat |
| latitude | DECIMAL(10,8) | NULL | Ya | — | — | Koordinat |
| longitude | DECIMAL(11,8) | NULL | Ya | — | — | Koordinat |
| open_hours | VARCHAR(191) | NULL | Ya | — | — | Jam buka |
| entrance_fee | VARCHAR(191) | NULL | Ya | — | — | Harga tiket |
| category | VARCHAR(50) | NULL | Ya | INDEX | — | Kategori wisata |
| is_featured | BOOLEAN | false | Tidak | INDEX | — | Unggulan |
| views_count | INT UNSIGNED | 0 | Tidak | — | — | Dilihat |
| is_active | BOOLEAN | true | Tidak | INDEX | — | Aktif/tidak |
| created_at / updated_at / deleted_at | TIMESTAMP | NULL | Ya | INDEX(deleted_at) | — | Timestamp |

### 6.3 `keris_artisans`

**Fungsi:** Menyimpan data Mpu/perajin keris.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| user_id | BIGINT UNSIGNED | NULL | Ya | INDEX | users.id | FK pengelola |
| name | VARCHAR(191) | — | Tidak | — | — | Nama Mpu |
| title | VARCHAR(191) | NULL | Ya | — | — | Gelar (Mpu) |
| slug | VARCHAR(191) | — | Tidak | UNIQUE | — | Slug SEO |
| bio | LONGTEXT | NULL | Ya | — | — | Biografi |
| photo | VARCHAR(191) | NULL | Ya | — | — | Foto |
| specialties | JSON | NULL | Ya | — | — | Keahlian (array) |
| experience_years | VARCHAR(50) | NULL | Ya | — | — | Lama berkarya |
| award | VARCHAR(255) | NULL | Ya | — | — | Penghargaan |
| address | VARCHAR(255) | NULL | Ya | — | — | Alamat |
| phone | VARCHAR(30) | NULL | Ya | — | — | Telepon |
| email | VARCHAR(191) | NULL | Ya | — | — | Email |
| website | VARCHAR(191) | NULL | Ya | — | — | Situs |
| sort_order | SMALLINT UNSIGNED | 0 | Tidak | — | — | Urutan |
| is_active | BOOLEAN | true | Tidak | INDEX | — | Aktif/tidak |
| created_at / updated_at / deleted_at | TIMESTAMP | NULL | Ya | INDEX(deleted_at) | — | Timestamp |

### 6.4 `umkms`

**Fungsi:** Menyimpan data UMKM desa.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| user_id | BIGINT UNSIGNED | NULL | Ya | INDEX | users.id | FK pengelola |
| name | VARCHAR(191) | — | Tidak | — | — | Nama usaha |
| slug | VARCHAR(191) | — | Tidak | UNIQUE | — | Slug SEO |
| owner_name | VARCHAR(191) | NULL | Ya | — | — | Pemilik |
| category | VARCHAR(50) | NULL | Ya | INDEX | — | Kategori usaha |
| description | LONGTEXT | NULL | Ya | — | — | Deskripsi |
| logo | VARCHAR(191) | NULL | Ya | — | — | Logo |
| cover_image | VARCHAR(191) | NULL | Ya | — | — | Gambar sampul |
| address | VARCHAR(255) | NULL | Ya | — | — | Alamat |
| phone | VARCHAR(30) | NULL | Ya | — | — | Telepon |
| email | VARCHAR(191) | NULL | Ya | — | — | Email |
| website | VARCHAR(191) | NULL | Ya | — | — | Situs |
| instagram | VARCHAR(191) | NULL | Ya | — | — | Instagram |
| is_featured | BOOLEAN | false | Tidak | INDEX | — | Unggulan |
| sort_order | SMALLINT UNSIGNED | 0 | Tidak | — | — | Urutan |
| is_active | BOOLEAN | true | Tidak | INDEX | — | Aktif/tidak |
| created_at / updated_at / deleted_at | TIMESTAMP | NULL | Ya | INDEX(deleted_at) | — | Timestamp |

---

## 7. Tabel Data & Laporan

### 7.1 `statistics`

**Fungsi:** Menyimpan grup/kategori statistik per tahun (induk data statistik).

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| name | VARCHAR(191) | — | Tidak | — | — | Nama statistik (Kependudukan) |
| slug | VARCHAR(191) | — | Tidak | UNIQUE | — | Slug |
| category | VARCHAR(50) | kependudukan | Tidak | INDEX | — | Kategori |
| year | SMALLINT UNSIGNED | — | Tidak | INDEX | — | Tahun data |
| description | TEXT | NULL | Ya | — | — | Keterangan |
| is_active | BOOLEAN | true | Tidak | INDEX | — | Aktif/tidak |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

**Constraint:** UNIQUE(`slug`); UNIQUE(`category`,`year`) untuk mencegah duplikasi.

### 7.2 `population_statistics`

**Fungsi:** Menyimpan baris data rinci statistik (mis. jumlah penduduk per jenis kelamin/usia).

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| statistics_id | BIGINT UNSIGNED | — | Tidak | INDEX | statistics.id | FK induk |
| label | VARCHAR(191) | — | Tidak | — | — | Label (Laki-laki) |
| value | DECIMAL(15,2) | 0 | Tidak | — | — | Nilai |
| unit | VARCHAR(20) | NULL | Ya | — | — | Satuan (jiwa, %) |
| sort_order | SMALLINT UNSIGNED | 0 | Tidak | — | — | Urutan |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

### 7.3 `apbdes`

**Fungsi:** Menyimpan data anggaran (pendapatan, belanja, pembiayaan) per tahun.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| user_id | BIGINT UNSIGNED | NULL | Ya | INDEX | users.id | FK pengelola |
| year | SMALLINT UNSIGNED | — | Tidak | INDEX | — | Tahun anggaran |
| type | VARCHAR(20) | pendapatan | Tidak | INDEX | — | pendapatan/belanja/pembiayaan |
| name | VARCHAR(191) | — | Tidak | — | — | Nama pos anggaran |
| category | VARCHAR(191) | NULL | Ya | — | — | Kategori/rincian |
| budget_amount | DECIMAL(15,2) | 0 | Tidak | — | — | Anggaran (Rp) |
| realization_amount | DECIMAL(15,2) | 0 | Tidak | — | — | Realisasi (Rp) |
| description | TEXT | NULL | Ya | — | — | Keterangan |
| is_active | BOOLEAN | true | Tidak | INDEX | — | Aktif/tidak |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

### 7.4 `documents`

**Fungsi:** Menyimpan dokumen publik yang dapat diunduh.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| user_id | BIGINT UNSIGNED | NULL | Ya | INDEX | users.id | FK pengelola |
| title | VARCHAR(191) | — | Tidak | — | — | Judul dokumen |
| slug | VARCHAR(191) | — | Tidak | UNIQUE | — | Slug SEO |
| category | VARCHAR(50) | NULL | Ya | INDEX | — | Kategori (Peraturan, Laporan) |
| file_path | VARCHAR(255) | — | Tidak | — | — | Path file (storage) |
| file_name | VARCHAR(255) | — | Tidak | — | — | Nama file asli |
| file_size | VARCHAR(50) | NULL | Ya | — | — | Ukuran file |
| file_type | VARCHAR(50) | NULL | Ya | — | — | MIME type |
| description | TEXT | NULL | Ya | — | — | Keterangan |
| download_count | INT UNSIGNED | 0 | Tidak | — | — | Jumlah unduhan |
| status | VARCHAR(20) | draft | Tidak | INDEX | — | draft/published |
| published_at | TIMESTAMP | NULL | Ya | INDEX | — | Waktu terbit |
| created_at / updated_at / deleted_at | TIMESTAMP | NULL | Ya | INDEX(deleted_at) | — | Timestamp |

### 7.5 `downloads`

**Fungsi:** Log unduhan dokumen (audit & statistik).

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| document_id | BIGINT UNSIGNED | — | Tidak | INDEX | documents.id | FK dokumen |
| user_id | BIGINT UNSIGNED | NULL | Ya | INDEX | users.id | FK pengguna (nullable) |
| ip_address | VARCHAR(45) | NULL | Ya | — | — | IP |
| user_agent | TEXT | NULL | Ya | — | — | Browser |
| downloaded_at | TIMESTAMP | NULL | Ya | INDEX | — | Waktu unduh |

---

## 8. Tabel Layanan Publik & Audit

### 8.1 `messages`

**Fungsi:** Menyimpan pesan dari form kontak.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| village_id | BIGINT UNSIGNED | — | Tidak | INDEX | villages.id | FK desa |
| user_id | BIGINT UNSIGNED | NULL | Ya | INDEX | users.id | FK petugas (nullable) |
| name | VARCHAR(191) | — | Tidak | — | — | Nama pengirim |
| email | VARCHAR(191) | — | Tidak | INDEX | — | Email pengirim |
| phone | VARCHAR(30) | NULL | Ya | — | — | Telepon |
| subject | VARCHAR(191) | — | Tidak | — | — | Subjek |
| message | TEXT | — | Tidak | — | — | Isi pesan |
| status | VARCHAR(20) | baru | Tidak | INDEX | — | baru/dibaca/dibalas |
| reply | TEXT | NULL | Ya | — | — | Balasan admin |
| replied_at | TIMESTAMP | NULL | Ya | — | — | Waktu balas |
| created_at / updated_at | TIMESTAMP | NULL | Ya | — | — | Timestamp |

### 8.2 `activity_logs`

**Fungsi:** Mencatat aktivitas pengguna untuk audit.

| Kolom | Tipe | Default | Nullable | Index | FK | Keterangan |
| --- | --- | --- | --- | --- | --- | --- |
| id | BIGINT UNSIGNED | AUTO_INC | Tidak | PK | — | Primary key |
| user_id | BIGINT UNSIGNED | NULL | Ya | INDEX | users.id | FK pengguna (nullable) |
| log_name | VARCHAR(191) | default | Tidak | INDEX | — | Nama log |
| description | TEXT | NULL | Ya | — | — | Deskripsi |
| event | VARCHAR(50) | NULL | Ya | INDEX | — | created/updated/deleted |
| causer_type | VARCHAR(191) | NULL | Ya | INDEX | — | Polymorphic (opsional) |
| causer_id | BIGINT UNSIGNED | NULL | Ya | INDEX | — | Polymorphic id |
| subject_type | VARCHAR(191) | NULL | Ya | INDEX | — | Polymorphic subject |
| subject_id | BIGINT UNSIGNED | NULL | Ya | INDEX | — | Polymorphic id |
| properties | JSON | NULL | Ya | — | — | Detail perubahan |
| created_at | TIMESTAMP | NULL | Ya | INDEX | — | Waktu log |

---

## 9. Tabel Framework (Otomatis)

| Tabel | Kolom Utama | Keterangan |
| --- | --- | --- |
| `jobs` | id, queue, payload, attempts, available_at | Antrian job (default laravel) |
| `job_batches` | id, name, total_jobs, pending_jobs, failed_jobs, cancelled_at, finished_at | Batch job |
| `failed_jobs` | id, uuid, connection, queue, payload, exception, failed_at | Job gagal |
| `cache` | key (PK), value, expiration | Cache database driver |
| `cache_locks` | key (PK), owner, expiration | Kunci cache |

---

## 10. Ringkasan Index Strategis

| Tabel | Index Komposit | Alasan |
| --- | --- | --- |
| news | (status, published_at) | Filter list publik cepat |
| news | (village_id, news_category_id) | List per kategori/desa |
| announcements | (status, published_at) | Filter tayang |
| agendas | (event_date, status) | Kalender agenda |
| apbdes | (year, type) | Ringkasan per tahun & jenis |
| statistics | (category, year) | Query statistik |
| messages | (status, created_at) | Antrian pesan admin |
| downloads | (document_id, downloaded_at) | Statistik unduhan |

## 11. Catatan Implementasi

- Seluruh foreign key menggunakan `ON DELETE CASCADE` kecuali `user_id` (menggunakan `ON DELETE SET NULL` bila nullable) agar riwayat konten tidak hilang saat pengguna dihapus.
- Kolom enumerasi disimpan sebagai `VARCHAR` dengan validasi di **Form Request** (bukan ENUM MySQL) untuk fleksibilitas migrasi.
- Angka moneter (`budget_amount`, `realization_amount`) disimpan sebagai `DECIMAL(15,2)` — tidak pernah `FLOAT`.
- Migrasi dibuat dengan penamaan `create_{tabel}_table` sesuai konvensi Laravel.
