# 09 — ERD (Entity Relationship Diagram)

**Website Profil Desa Aeng Tong-Tong**

| Properti | Nilai |
| --- | --- |
| Kode Dokumen | ATT-ERD-01 |
| Versi | 1.0 |
| Status | Final |

---

## 1. Tujuan

Dokumen ini menggambarkan **hubungan antar entitas** (Entity Relationship) basis data. Notasi menggunakan **Mermaid ER Diagram** dengan kardinalitas *crow's foot*. Spesifikasi field lengkap (data type, default, index, constraint) ada pada dokumen [10-database-design.md](./10-database-design.md).

> Catatan: Diagram berikut menampilkan atribut kunci (PK, FK, dan field penting). Detail seluruh kolom dijelaskan per tabel pada dokumen database design.

---

## 2. Legenda Notasi

| Notasi | Arti |
| --- | --- |
| `||--o{` | Satu-ke-banyak (one-to-many) |
| `||--||` | Satu-ke-satu (one-to-one) |
| `}o--o{` | Banyak-ke-banyak (many-to-many via pivot) |
| `|o--o{` | Nol-atau-satu-ke-banyak |
| `PK` | Primary Key |
| `FK` | Foreign Key |

---

## 3. Diagram ERD — Modul Autentikasi & RBAC

```mermaid
erDiagram
    USERS ||--o{ ROLE_USER : "punya"
    ROLES ||--o{ ROLE_USER : "dimiliki"
    ROLES ||--o{ PERMISSION_ROLE : "memiliki"
    PERMISSIONS ||--o{ PERMISSION_ROLE : "diberi ke"
    USERS ||--o{ USER_PERMISSION : "langsung"
    PERMISSIONS ||--o{ USER_PERMISSION : "diberi ke"
    USERS ||--o{ PASSWORD_RESET_TOKENS : "meminta"
    USERS ||--o{ PERSONAL_ACCESS_TOKENS : "memiliki"
    USERS ||--o{ SESSIONS : "sesi"

    USERS {
        bigint id PK
        string name
        string email UK
        string password
        datetime email_verified_at
        boolean is_active
        string avatar
        datetime last_login_at
        timestamp created_at
        timestamp updated_at
    }

    ROLES {
        bigint id PK
        string name
        string slug UK
        string description
        timestamp created_at
        timestamp updated_at
    }

    PERMISSIONS {
        bigint id PK
        string name
        string slug UK
        string group
        string description
        timestamp created_at
        timestamp updated_at
    }

    ROLE_USER {
        bigint role_id PK, FK
        bigint user_id PK, FK
        timestamp created_at
    }

    PERMISSION_ROLE {
        bigint permission_id PK, FK
        bigint role_id PK, FK
    }

    USER_PERMISSION {
        bigint permission_id PK, FK
        bigint user_id PK, FK
    }

    PASSWORD_RESET_TOKENS {
        string email PK
        string token
        timestamp created_at
    }

    PERSONAL_ACCESS_TOKENS {
        bigint id PK
        bigint tokenable_id FK
        string tokenable_type
        string name
        string token UK
        text abilities
        timestamp last_used_at
        timestamp expires_at
    }

    SESSIONS {
        string id PK
        bigint user_id FK
        string ip_address
        text user_agent
        text payload
        bigint last_activity
    }
```

---

## 4. Diagram ERD — Profil Desa & Pemerintahan

```mermaid
erDiagram
    VILLAGES ||--o| VILLAGE_PROFILES : "memiliki"
    VILLAGES ||--o| VILLAGE_HISTORIES : "memiliki"
    VILLAGES ||--o{ VISIONS : "memiliki"
    VILLAGES ||--o{ MISSIONS : "memiliki"
    VILLAGES ||--o{ ORGANIZATIONAL_STRUCTURES : "memiliki"
    ORGANIZATIONAL_STRUCTURES ||--o{ VILLAGE_OFFICIALS : "berisi"
    VILLAGES ||--o{ CONTACTS : "memiliki"
    VILLAGES ||--o{ SETTINGS : "dikaitkan"

    VILLAGES {
        bigint id PK
        string name
        string code UK
        string district
        string regency
        string province
        text address
        float latitude
        float longitude
        decimal area
        integer total_hamlet
        text description
        string logo
        string cover_image
        timestamp created_at
        timestamp updated_at
    }

    VILLAGE_PROFILES {
        bigint id PK
        bigint village_id FK
        text overview
        text geographic
        text demographics_summary
        timestamp created_at
        timestamp updated_at
    }

    VILLAGE_HISTORIES {
        bigint id PK
        bigint village_id FK
        text history_content
        string founder_name
        integer founded_year
        string status
        timestamp created_at
        timestamp updated_at
    }

    VISIONS {
        bigint id PK
        bigint village_id FK
        text vision
        integer sort_order
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    MISSIONS {
        bigint id PK
        bigint village_id FK
        text mission
        integer sort_order
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    ORGANIZATIONAL_STRUCTURES {
        bigint id PK
        bigint village_id FK
        bigint parent_id FK
        string name
        string position
        integer level
        string image
        string description
        integer sort_order
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    VILLAGE_OFFICIALS {
        bigint id PK
        bigint village_id FK
        bigint structure_id FK
        string name
        string position
        string nip
        string photo
        string email
        string phone
        integer sort_order
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    CONTACTS {
        bigint id PK
        bigint village_id FK
        string address
        string phone
        string email
        string fax
        string website
        string maps_embed
        string facebook
        string instagram
        string youtube
        string twitter
        string whatsapp
        timestamp created_at
        timestamp updated_at
    }

    SETTINGS {
        bigint id PK
        bigint village_id FK
        string group
        string key
        text value
        string type
        timestamp created_at
        timestamp updated_at
    }
```

---

## 5. Diagram ERD — Konten Informasi (Berita, Pengumuman, Agenda, FAQ)

```mermaid
erDiagram
    NEWS_CATEGORIES ||--o{ NEWS : "memiliki"
    VILLAGES ||--o{ NEWS : "menerbitkan"
    USERS ||--o{ NEWS : "menulis"
    VILLAGES ||--o{ ANNOUNCEMENTS : "menerbitkan"
    USERS ||--o{ ANNOUNCEMENTS : "menulis"
    VILLAGES ||--o{ AGENDAS : "menyusun"
    USERS ||--o{ AGENDAS : "menulis"
    VILLAGES ||--o{ FAQS : "menyediakan"
    USERS ||--o{ FAQS : "menulis"

    NEWS_CATEGORIES {
        bigint id PK
        string name
        string slug UK
        string description
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    NEWS {
        bigint id PK
        bigint village_id FK
        bigint news_category_id FK
        bigint user_id FK
        string title
        string slug UK
        string excerpt
        text content
        string cover_image
        string thumbnail
        string source
        json tags
        string status
        integer views_count
        datetime published_at
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    ANNOUNCEMENTS {
        bigint id PK
        bigint village_id FK
        bigint user_id FK
        string title
        string slug UK
        text content
        string attachment
        string status
        datetime published_at
        datetime expired_at
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    AGENDAS {
        bigint id PK
        bigint village_id FK
        bigint user_id FK
        string title
        string slug UK
        text description
        string location
        date event_date
        time start_time
        time end_time
        string status
        boolean is_featured
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    FAQS {
        bigint id PK
        bigint village_id FK
        bigint user_id FK
        string question
        text answer
        string category
        integer sort_order
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }
```

---

## 6. Diagram ERD — Media (Galeri, Video, Banner)

```mermaid
erDiagram
    GALLERY_CATEGORIES ||--o{ GALLERIES : "memiliki"
    VILLAGES ||--o{ GALLERIES : "memiliki"
    USERS ||--o{ GALLERIES : "mengunggah"
    VIDEO_CATEGORIES ||--o{ VIDEOS : "memiliki"
    VILLAGES ||--o{ VIDEOS : "memiliki"
    USERS ||--o{ VIDEOS : "mengunggah"
    USERS ||--o{ BANNERS : "membuat"
    VILLAGES ||--o{ BANNERS : "menampilkan"

    GALLERY_CATEGORIES {
        bigint id PK
        string name
        string slug UK
        string description
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    GALLERIES {
        bigint id PK
        bigint village_id FK
        bigint gallery_category_id FK
        bigint user_id FK
        string title
        string slug UK
        string image
        string description
        boolean is_cover
        integer sort_order
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    VIDEO_CATEGORIES {
        bigint id PK
        string name
        string slug UK
        string description
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    VIDEOS {
        bigint id PK
        bigint village_id FK
        bigint video_category_id FK
        bigint user_id FK
        string title
        string slug UK
        string video_url
        string thumbnail
        string platform
        text description
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    BANNERS {
        bigint id PK
        bigint village_id FK
        bigint user_id FK
        string title
        string slug UK
        string image
        string link
        text description
        string position
        integer sort_order
        string status
        datetime started_at
        datetime ended_at
        timestamp created_at
        timestamp updated_at
    }
```

---

## 7. Diagram ERD — Ekonomi & Budaya (Potensi, Wisata, Keris, UMKM)

```mermaid
erDiagram
    VILLAGES ||--o{ VILLAGE_POTENTIALS : "memiliki"
    USERS ||--o{ VILLAGE_POTENTIALS : "mengelola"
    VILLAGES ||--o{ TOURISM_DESTINATIONS : "memiliki"
    USERS ||--o{ TOURISM_DESTINATIONS : "mengelola"
    VILLAGES ||--o{ KERIS_ARTISANS : "memiliki"
    USERS ||--o{ KERIS_ARTISANS : "mengelola"
    VILLAGES ||--o{ UMKMS : "memiliki"
    USERS ||--o{ UMKMS : "mengelola"

    VILLAGE_POTENTIALS {
        bigint id PK
        bigint village_id FK
        bigint user_id FK
        string title
        string slug UK
        string category
        text description
        string image
        string icon
        boolean is_featured
        integer sort_order
        boolean is_active
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    TOURISM_DESTINATIONS {
        bigint id PK
        bigint village_id FK
        bigint user_id FK
        string title
        string slug UK
        text description
        string image
        text gallery
        string address
        float latitude
        float longitude
        string open_hours
        string entrance_fee
        string category
        boolean is_featured
        integer views_count
        boolean is_active
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    KERIS_ARTISANS {
        bigint id PK
        bigint village_id FK
        bigint user_id FK
        string name
        string title
        string slug UK
        text bio
        string photo
        text specialties
        string experience_years
        string award
        string address
        string phone
        string email
        string website
        integer sort_order
        boolean is_active
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    UMKMS {
        bigint id PK
        bigint village_id FK
        bigint user_id FK
        string name
        string slug UK
        string owner_name
        string category
        text description
        string logo
        string cover_image
        string address
        string phone
        string email
        string website
        string instagram
        boolean is_featured
        integer sort_order
        boolean is_active
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }
```

---

## 8. Diagram ERD — Data & Laporan (Statistik, APBDes, Dokumen)

```mermaid
erDiagram
    VILLAGES ||--o{ STATISTICS : "memiliki"
    STATISTICS ||--o{ POPULATION_STATISTICS : "berisi"
    VILLAGES ||--o{ APBDES : "memiliki"
    USERS ||--o{ APBDES : "mengelola"
    VILLAGES ||--o{ DOCUMENTS : "memiliki"
    USERS ||--o{ DOCUMENTS : "mengelola"
    DOCUMENTS ||--o{ DOWNLOADS : "dicatat"
    USERS |o--o{ DOWNLOADS : "mengunduh"

    STATISTICS {
        bigint id PK
        bigint village_id FK
        string name
        string slug UK
        string category
        integer year
        text description
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    POPULATION_STATISTICS {
        bigint id PK
        bigint statistics_id FK
        string label
        decimal value
        string unit
        integer sort_order
        timestamp created_at
        timestamp updated_at
    }

    APBDES {
        bigint id PK
        bigint village_id FK
        bigint user_id FK
        integer year
        string type
        string name
        string category
        decimal budget_amount
        decimal realization_amount
        text description
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    DOCUMENTS {
        bigint id PK
        bigint village_id FK
        bigint user_id FK
        string title
        string slug UK
        string category
        string file_path
        string file_name
        string file_size
        string file_type
        text description
        integer download_count
        string status
        datetime published_at
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    DOWNLOADS {
        bigint id PK
        bigint document_id FK
        bigint user_id FK
        string ip_address
        string user_agent
        timestamp downloaded_at
    }
```

---

## 9. Diagram ERD — Layanan Publik & Audit

```mermaid
erDiagram
    VILLAGES ||--o{ MESSAGES : "menerima"
    USERS ||--o{ MESSAGES : "menangani"
    USERS |o--o{ ACTIVITY_LOGS : "menyebabkan"

    MESSAGES {
        bigint id PK
        bigint village_id FK
        bigint user_id FK
        string name
        string email
        string phone
        string subject
        text message
        string status
        string reply
        datetime replied_at
        timestamp created_at
        timestamp updated_at
    }

    ACTIVITY_LOGS {
        bigint id PK
        bigint user_id FK
        string log_name
        string description
        string event
        string causer_type
        bigint causer_id
        string subject_type
        bigint subject_id
        text properties
        timestamp created_at
    }
```

---

## 10. Tabel Pendukung (Sistem Framework)

Tabel berikut ditangani otomatis oleh framework (Laravel):

| Tabel | Fungsi |
| --- | --- |
| `jobs` | Antrian job (queue) |
| `job_batches` | Batch job |
| `failed_jobs` | Job gagal |
| `cache` | Cache database driver |
| `cache_locks` | Kunci cache |
| `personal_access_tokens` | Token API (Sanctum) |

---

## 11. Ringkasan Kardinalitas Utama

| Relasi | Kardinalitas | Keterangan |
| --- | --- | --- |
| VILLAGES → VILLAGE_PROFILES | 1 : 1 | Satu desa satu profil umum |
| VILLAGES → VILLAGE_HISTORIES | 1 : 1 | Satu desa satu catatan sejarah |
| VILLAGES → ORGANIZATIONAL_STRUCTURES | 1 : N | Satu desa banyak struktur |
| ORGANIZATIONAL_STRUCTURES → VILLAGE_OFFICIALS | 1 : N | Struktur berisi banyak perangkat |
| VILLAGES → NEWS/ANNOUNCEMENTS/AGENDAS | 1 : N | Konten milik desa |
| NEWS_CATEGORIES → NEWS | 1 : N | Kategori berisi banyak berita |
| USERS ↔ ROLES | M : N | Melalui `role_user` |
| ROLES ↔ PERMISSIONS | M : N | Melalui `permission_role` |
| STATISTICS → POPULATION_STATISTICS | 1 : N | Data statistik berisi baris rinci |
| DOCUMENTS → DOWNLOADS | 1 : N | Log unduhan per dokumen |
