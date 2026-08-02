# 07 — Sequence Diagram

**Website Profil Desa Aeng Tong-Tong**

| Properti | Nilai |
| --- | --- |
| Kode Dokumen | ATT-SD-01 |
| Versi | 1.0 |
| Status | Final |

---

## 1. Tujuan

Dokumen ini menggambarkan **interaksi antar objek/komponen** secara berurutan (*time-ordered*) untuk skenario utama sistem, menggunakan Mermaid *sequenceDiagram*.

---

## 2. Sequence — Login Admin

```mermaid
sequenceDiagram
    actor A as Admin
    participant W as Web (Route)
    participant C as AuthController
    participant FR as LoginRequest
    participant S as AuthService
    participant G as Gate/Policy
    participant DB as MySQL

    A->>W: POST /admin/login
    W->>FR: Validasi request
    FR-->>W: Valid (atau 422 error)
    W->>C: authenticate()
    C->>S: attempt(email, password)
    S->>DB: SELECT user WHERE email
    DB-->>S: user
    S->>S: verify password hash
    S-->>C: success(bool)
    alt Gagal
        C-->>A: Redirect back + error
    else Sukses
        C->>S: regenerate session
        C->>DB: INSERT activity_log (login)
        C-->>A: Redirect /admin (dashboard)
    end
```

---

## 3. Sequence — Admin Membuat & Menerbitkan Berita

```mermaid
sequenceDiagram
    actor A as Admin
    participant R as Admin\NewsController
    participant FR as NewsRequest
    participant S as NewsService
    participant M as News Model
    participant P as NewsPolicy
    participant DB as MySQL
    participant FE as Frontend

    A->>R: POST /admin/news
    R->>P: authorize('create', News)
    alt Tidak diizinkan
        P-->>R: 403 Forbidden
        R-->>A: Tampilkan error
    else Diizinkan
        R->>FR: Validasi (judul, kategori, konten, cover)
        FR-->>R: Data tervalidasi
        R->>S: create(data)
        S->>M: new News + relasi kategori
        S->>DB: INSERT + attach tags
        DB-->>S: news record
        S->>DB: INSERT activity_log
        S-->>R: news
        R-->>A: Redirect + SweetAlert sukses
        A->>R: Publish action
        R->>S: publish(news)
        S->>M: update status = published
        S->>DB: UPDATE
        DB-->>FE: Berita tampil di frontend
    end
```

---

## 4. Sequence — Pengunjung Mengirim Pesan Kontak

```mermaid
sequenceDiagram
    actor G as Pengunjung
    participant W as Web
    participant C as ContactController
    participant FR as ContactMessageRequest
    participant S as MessageService
    participant DB as MySQL
    participant Q as Queue
    participant ML as Mail (Notifikasi Admin)

    G->>W: POST /kontak
    W->>FR: Validasi (nama, email, subjek, pesan)
    alt Gagal validasi
        FR-->>G: Error per field (422)
    else Valid
        FR->>C: data tervalidasi
        C->>S: store(data)
        S->>DB: INSERT messages (status = baru)
        DB-->>S: message
        S->>Q: dispatch job kirim email notifikasi
        Q->>ML: kirim email ke admin
        S-->>C: success
        C-->>G: SweetAlert "Pesan terkirim"
    end
```

---

## 5. Sequence — Unduh Dokumen Publik

```mermaid
sequenceDiagram
    actor G as Pengunjung
    participant C as DocumentController
    participant S as DocumentService
    participant M as Document Model
    participant Q as Queue
    participant DB as MySQL
    participant ST as Storage

    G->>C: GET /dokumen/{id}/unduh
    C->>M: findBySlugOrId(id)
    alt Dokumen tidak ditemukan / non-publik
        M-->>C: null
        C-->>G: 404
    else Ditemukan & publik
        C->>S: registerDownload(document)
        S->>Q: dispatch job log unduhan
        Q->>DB: INSERT downloads (doc_id, ip, user_agent)
        S->>ST: get file path
        ST-->>C: file stream
        C-->>G: Download file
    end
```

---

## 6. Sequence — Statistik & Grafik di Frontend

```mermaid
sequenceDiagram
    actor G as Pengunjung
    participant W as Web
    participant C as StatisticController
    participant S as StatisticService
    participant R as Cache (Redis)
    participant DB as MySQL

    G->>W: GET /statistik
    W->>C: index()
    C->>S: getDashboardStats(year)
    S->>R: get cache('stats:{year}')
    alt Cache hit
        R-->>S: data
    else Cache miss
        S->>DB: SELECT statistics + population_statistics (year)
        DB-->>S: data
        S->>R: put cache (ttl)
    end
    S-->>C: data terstruktur
    C-->>W: Blade view (data JSON untuk Chart.js)
    W-->>G: Halaman statistik + grafik
```

---

## 7. Sequence — Scheduler Menerbitkan Konten Terjadwal

```mermaid
sequenceDiagram
    participant K as Scheduler (cron)
    participant J as ScheduledJob
    participant S as PublishService
    participant DB as MySQL
    participant LG as ActivityLog

    K->>J: jalankan tiap menit (schedule)
    J->>S: publishDueContents()
    S->>DB: SELECT konten WHERE status=scheduled AND publish_at <= now
    DB-->>S: daftar konten
    loop Setiap konten
        S->>DB: UPDATE status = published
        S->>LG: catat activity log sistem
    end
    S-->>J: selesai
```

---

## 8. Ringkasan Interaksi Antar Layer

```mermaid
sequenceDiagram
    participant V as View (Blade)
    participant C as Controller
    participant FR as FormRequest
    participant S as Service
    participant R as Repository
    participant P as Policy
    participant M as Model (Eloquent)

    V->>C: HTTP Request (Route)
    C->>FR: Validasi & authz
    FR-->>C: data tervalidasi
    C->>P: authorize(action, model)
    P-->>C: diizinkan/ditolak
    C->>S: panggil business logic
    S->>R: query data
    R->>M: Eloquent
    M-->>R: result
    R-->>S: result
    S-->>C: hasil
    C-->>V: response (view / redirect / json)
```
