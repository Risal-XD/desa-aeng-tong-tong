# 04 — User Flow

**Website Profil Desa Aeng Tong-Tong**

| Properti | Nilai |
| --- | --- |
| Kode Dokumen | ATT-UF-01 |
| Versi | 1.0 |
| Status | Final |

---

## 1. Tujuan

Dokumen ini menggambarkan **alur langkah pengguna** (user flow) dalam menyelesaikan tugas utama pada sistem, baik untuk sisi **publik (frontend)** maupun **admin (backend)**. Diagram dibuat dengan Mermaid *flowchart*.

---

## 2. User Flow — Pengunjung: Mencari Informasi Wisata (Mas Dimas)

```mermaid
flowchart TD
    A[Mulai] --> B["Membuka Website (URL / Google)"]
    B --> C["Halaman Beranda"]
    C --> D{"Menemukan menu yang relevan?"}
    D -->|Ya, klik Wisata| E["Halaman /wisata"]
    D -->|Tidak, pakai pencarian| S["Isi kata kunci di kotak pencarian"]
    S --> T["Halaman hasil pencarian"]
    T --> E
    E --> F["Melihat daftar destinasi wisata"]
    F --> G["Klik destinasi menarik"]
    G --> H["Detail wisata: deskripsi, galeri, lokasi, kontak"]
    H --> I{"Ingin informasi lebih?"}
    I -->|Ya, kontak| J["Buka halaman Kontak"]
    J --> K["Isi form pesan"]
    K --> L["Validasi sukses?"]
    L -->|Ya| M["Pesan terkirim (notifikasi sukses)"]
    L -->|Tidak| K
    I -->|Tidak| N["Selesai menelusuri / kembali"]
    M --> N[Selesai]
```

---

## 3. User Flow — Pengunjung: Mengunduh Dokumen (Peneliti)

```mermaid
flowchart TD
    A[Mulai] --> B["Buka halaman /dokumen"]
    B --> C["Lihat daftar dokumen berdasarkan kategori"]
    C --> D["Klik tombol Unduh pada dokumen"]
    D --> E["Sistem mencatat log unduhan"]
    E --> F["File diunduh (stream dari storage)"]
    F --> G["Selesai"]
```

---

## 4. User Flow — Admin: Menerbitkan Berita (Bu Rina)

```mermaid
flowchart TD
    A[Mulai] --> B["Buka panel admin (/admin)"]
    B --> C["Login"]
    C --> D{"Autentikasi & otorisasi valid?"}
    D -->|Tidak| E["Tampilkan pesan error login"]
    E --> C
    D -->|Ya| F["Masuk ke Dashboard Admin"]
    F --> G["Menu Konten → Berita"]
    G --> H["Klik Tambah Berita"]
    H --> I["Isi form: judul, kategori, konten CKEditor, gambar cover, tag"]
    I --> J["Klik Simpan (Draf)"]
    J --> K["Berita tersimpan sebagai draf"]
    K --> L{"Lanjut terbitkan?"}
    L -->|Ya| M["Klik Terbitkan"]
    L -->|Tidak| N["Edit / hapus / jadwalkan"]
    M --> O["Berita berstatus Terbit, tampil di frontend"]
    O --> P["Catat activity log"]
    P --> Q["Selesai"]
```

---

## 5. User Flow — Admin: Menjawab Pesan Masuk

```mermaid
flowchart TD
    A[Mulai] --> B["Login admin"]
    B --> C["Menu Layanan → Pesan Masuk"]
    C --> D["Lihat daftar pesan (status baru/dibaca/dibalas)"]
    D --> E["Buka detail pesan"]
    E --> F["Status otomatis menjadi 'Dibaca'"]
    F --> G{"Akan dibalas?"}
    G -->|Ya| H["Tulis balasan & kirim email"]
    H --> I["Status 'Dibalas' + timestamp"]
    G -->|Tidak| J["Tandai selesai / arsip"]
    I --> K["Selesai"]
    J --> K
```

---

## 6. User Flow — Super Admin: Membuat Role & Permission

```mermaid
flowchart TD
    A[Mulai] --> B["Login sebagai Super Admin"]
    B --> C["Sistem → Role & Permission"]
    C --> D["Lihat daftar role"]
    D --> E["Klik Tambah Role"]
    E --> F["Isi nama & deskripsi role"]
    F --> G["Pilih permission yang dimiliki role"]
    G --> H["Simpan"]
    H --> I["Kaitkan role ke pengguna tertentu (opsional)"]
    I --> J["Sistem menerapkan izin baru"]
    J --> K["Selesai"]
```

---

## 7. User Flow — Publik: Mengirim Pesan via Form Kontak

```mermaid
flowchart TD
    A[Mulai] --> B["Buka halaman /kontak"]
    B --> C["Lihat info kontak & peta"]
    C --> D["Isi form: nama, email, subjek, pesan"]
    D --> E{"Validasi server (Form Request) lulus?"}
    E -->|Tidak| F["Tampilkan error pada field"]
    F --> D
    E -->|Ya| G["Simpan pesan ke database (status baru)"]
    G --> H["Kirim notifikasi ke admin (opsional)"]
    H --> I["Tampilkan SweetAlert 'Pesan terkirim'"]
    I --> J["Selesai"]
```

---

## 8. User Flow — Pengunjung: Menelusuri Galeri Foto

```mermaid
flowchart TD
    A[Mulai] --> B["Buka /galeri/foto"]
    B --> C["Lihat album/daftar foto (grid, lazy-load)"]
    C --> D["Klik foto untuk membuka lightbox"]
    D --> E["Navigasi foto sebelumnya/berikutnya"]
    E --> F["Tutup lightbox"]
    F --> G{"Lanjut menjelajah?"}
    G -->|Ya| C
    G -->|Tidak| H["Selesai"]
```

---

## 9. User Flow — Admin: Mengelola Statistik & APBDes

```mermaid
flowchart TD
    A[Mulai] --> B["Login admin"]
    B --> C["Menu Data & Laporan → Statistik / APBDes"]
    C --> D["Pilih tahun"]
    D --> E["Klik Tambah Data"]
    E --> F["Isi kategori & nilai (penduduk, pekerjaan, anggaran, dll.)"]
    F --> G{"Validasi lulus?"}
    G -->|Tidak| E
    G -->|Ya| H["Simpan"]
    H --> I["Data tampil pada halaman publik /statistik & /apbdes"]
    I --> J["Cache statistik diperbarui"]
    J --> K["Selesai"]
```
