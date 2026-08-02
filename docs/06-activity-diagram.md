# 06 — Activity Diagram

**Website Profil Desa Aeng Tong-Tong**

| Properti | Nilai |
| --- | --- |
| Kode Dokumen | ATT-AD-01 |
| Versi | 1.0 |
| Status | Final |

---

## 1. Tujuan

Dokumen ini menggambarkan **alur aktivitas** (workflow) pada proses-proses kunci sistem, baik sisi publik maupun admin, menggunakan Mermaid *state/flowchart*.

---

## 2. Activity — Login Admin

```mermaid
flowchart TD
    A([Mulai]) --> B["Buka halaman /admin/login"]
    B --> C["Masukkan email & password"]
    C --> D["Kirim form (CSRF + throttling)"]
    D --> E{"Kredensial valid?"}
    E -->|Tidak| F["Cek batas percobaan"]
    F --> G{"Melebihi limit?"}
    G -->|Ya| H["Blokir sementara (rate limit)"]
    G -->|Tidak| I["Tampilkan pesan error"]
    I --> C
    E -->|Ya| J["Regenerasi session ID"]
    J --> K["Catat login ke activity log"]
    K --> L["Redirect ke Dashboard"]
    L --> M([Selesai])
    H --> M
```

---

## 3. Activity — Publikasi Berita (Workflow Draf → Terbit)

```mermaid
flowchart TD
    A([Mulai]) --> B["Admin membuka form berita"]
    B --> C["Isi data & konten WYSIWYG"]
    C --> D{"Validasi Form Request lulus?"}
    D -->|Tidak| E["Tampilkan error per field"]
    E --> C
    D -->|Ya| F{"Pilih status"}
    F -->|Draf| G["Simpan sebagai Draf"]
    F -->|Terbit| H["Periksa tanggal tayang"]
    H --> I{"Tanggal tayang ≤ sekarang?"}
    I -->|Ya| J["Status Terbit"]
    I -->|Tidak| K["Status Terjadwal (scheduler terbitkan nanti)"]
    G --> L["Tampil di daftar admin (tidak di publik)"]
    J --> M["Tampil di frontend"]
    K --> M
    M --> N["Catat activity log"]
    N --> O([Selesai])
```

---

## 4. Activity — Pengunjung Mengirim Pesan Kontak

```mermaid
flowchart TD
    A([Mulai]) --> B["Buka halaman /kontak"]
    B --> C["Isi form (nama, email, subjek, pesan)"]
    C --> D{"Validasi client-side lulus?"}
    D -->|Tidak| E["Tampilkan error inline"]
    E --> C
    D -->|Ya| F["Kirim via AJAX / POST"]
    F --> G{"Validasi server (Form Request) lulus?"}
    G -->|Tidak| H["Return error JSON"]
    H --> C
    G -->|Ya| I["Simpan pesan (status = baru)"]
    I --> J["Kirim notifikasi ke admin (queue)"]
    J --> K["Tampilkan SweetAlert sukses"]
    K --> L([Selesai])
```

---

## 5. Activity — Unduh Dokumen Publik

```mermaid
flowchart TD
    A([Mulai]) --> B["Buka halaman /dokumen"]
    B --> C["Filter dokumen per kategori"]
    C --> D["Klik tombol Unduh"]
    D --> E{"Dokumen berstatus publik?"}
    E -->|Tidak| F["Tampilkan pesan 'Tidak tersedia'"]
    E -->|Ya| G["Simpan log unduhan (async/queue)"]
    G --> H["Stream file ke browser"]
    H --> I([Selesai])
    F --> I
```

---

## 6. Activity — Super Admin Mengelola Role

```mermaid
flowchart TD
    A([Mulai]) --> B["Buka Sistem → Role & Permission"]
    B --> C{"Aksi yang dipilih"}
    C -->|Tambah Role| D["Isi nama & deskripsi"]
    C -->|Edit Role| E["Ubah nama/deskripsi"]
    C -->|Kelola Permission| F["Centang/lepas izin per role"]
    C -->|Hapus Role| G["Konfirmasi penghapusan"]
    D --> H{"Validasi lulus?"}
    E --> H
    F --> H
    G --> I{"Role dipakai pengguna?"}
    I -->|Ya| J["Tolak/beri peringatan"]
    I -->|Tidak| K["Hapus"]
    H -->|Tidak| D
    H -->|Ya| L["Simpan"]
    L --> M["Catat activity log"]
    M --> N([Selesai])
    J --> N
    K --> M
```

---

## 7. Activity — Scheduler Menertibkan Konten

```mermaid
flowchart TD
    A([Scheduler berjalan tiap menit/jam]) --> B["Ambil konten terjadwal"]
    B --> C{"Ada konten dengan tanggal tayang tiba?"}
    C -->|Tidak| D([Selesai])
    C -->|Ya| E["Ubah status → Terbit"]
    E --> F["Hapus dari antrian jadwal"]
    F --> G["Catat activity log sistem"]
    G --> B
```
