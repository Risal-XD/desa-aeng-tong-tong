# 12 — Standar Coding

**Website Profil Desa Aeng Tong-Tong**

| Properti | Nilai |
| --- | --- |
| Kode Dokumen | ATT-CS-01 |
| Versi | 1.0 |
| Status | Final |

---

## 1. Tujuan

Dokumen ini menetapkan standar penulisan kode agar konsisten, mudah dipelihara, aman, dan dapat dikembangkan oleh banyak developer. Standar mengikuti prinsip **SOLID**, **DRY**, **KISS**, **Clean Code**, dan **PSR-12**.

---

## 2. Prinsip Dasar

### 2.1 SOLID

| Prinsip | Penerapan di Proyek |
| --- | --- |
| **S**ingle Responsibility | Setiap class memiliki satu tanggung jawab: Controller=HTTP, Service=bisnis, Repository=data, Policy=otorisasi |
| **O**pen/Closed | Ekstensi via interface & polimorfisme (Repository Interface), tidak memodifikasi inti |
| **L**iskov Substitution | Implementasi interface menggantikan interface tanpa mengubah perilaku |
| **I**nterface Segregation | Interface repository kecil & spesifik per domain |
| **D**ependency Inversion | Injeksi dependency (constructor) ke interface, bukan class konkret |

### 2.2 DRY (Don't Repeat Yourself)

- Ekstraksi logika berulang ke **Service**, **Trait**, **Helper**, dan **Blade Component**.
- Pembuatan slug, upload file, dan status dihandle trait/fungsi bersama.
- Form validation per-modul di **Form Request** (tidak ditulis inline berulang).

### 2.3 KISS (Keep It Simple, Stupid)

- Hindari over-engineering. Repository hanya digunakan bila query kompleks/berulang.
- Nama variabel, method, dan class harus deskriptif dan mudah dipahami.
- Gunakan fitur bawaan Laravel sebelum membuat solusi custom.

---

## 3. Standar PSR-12 (PHP)

| Aturan | Ketentuan |
| --- | --- |
| Indentasi | 4 spasi (bukan tab) |
| Braces | `{` pada baris baru untuk class/method; gaya Allman untuk deklarasi |
| Baris | Maksimal 120 karakter (lunak), 80 disarankan |
| Konstanta | `UPPER_SNAKE_CASE` |
| Properti | `camelCase` |
| Method | `camelCase` |
| Nama class | `PascalCase` (setiap file satu class) |
| Deklarasi | Satu statement per baris; `<?php` di baris pertama |
| Trailing comma | Diperbolehkan pada array multi-baris (disarankan) |
| Import | Urut: `use` per kelas, tanpa alias bila sama |

Contoh:

```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNewsRequest;
use App\Services\NewsService;
use Illuminate\Http\RedirectResponse;

class NewsController extends Controller
{
    public function __construct(
        private readonly NewsService $newsService,
    ) {
    }

    public function store(StoreNewsRequest $request): RedirectResponse
    {
        $this->newsService->create($request->validated());

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita berhasil dibuat.');
    }
}
```

---

## 4. Konvensi Laravel

### 4.1 Routing

- Gunakan `Route::resource()` untuk CRUD standar; custom route hanya bila perlu.
- Kelompokkan route admin dengan `prefix`, `name`, dan middleware.
- Gunakan **Route Model Binding** (`{news}` → `News $news`) alih-alih manual lookup.
- Route name konsisten: `admin.news.store`.

### 4.2 Controller

- Controller **tipis** (thin controller): tidak berisi logika bisnis berat.
- Hanya: validasi via Form Request → panggil Service → response.

### 4.3 Form Request

- Semua input admin/public divalidasi melalui **Form Request**.
- Metode `authorize()` memeriksa izin (bisa memanggil Policy).
- Metode `rules()` memuat aturan; gunakan `Rule` enum bila perlu.

Contoh:

```php
public function rules(): array
{
    return [
        'title'      => ['required', 'string', 'max:191'],
        'category_id'=> ['required', 'exists:news_categories,id'],
        'content'    => ['required', 'string'],
        'cover_image'=> ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:5120'],
        'status'     => ['required', Rule::enum(NewsStatus::class)],
    ];
}
```

### 4.4 Model & Eloquent

- Definisikan relasi secara eksplisit & beri nama jelas.
- Gunakan `$casts` untuk konversi tipe (json, boolean, enum).
- Aktifkan **N+1 prevention** dengan `with()` (eager loading).
- Definisikan `$fillable` atau `$guarded` dengan benar (disarankan `$guarded = ['id']` + Form Request).
- Gunakan **query scopes** untuk filter umum (`scopePublished`).

Contoh:

```php
class News extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $guarded = ['id'];

    protected $casts = [
        'tags'         => 'array',
        'published_at' => 'datetime',
        'is_active'    => 'boolean',
        'status'       => NewsStatus::class,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', NewsStatus::Published)
            ->where('published_at', '<=', now());
    }
}
```

### 4.5 Migration

- Berurutan & atomik (satu perubahan per migrasi).
- Selalu sertakan index pada FK.
- Gunakan `$table->timestamps()`; `softDeletes()` untuk konten.
- Hindari `enum` MySQL; gunakan VARCHAR + validasi di Form Request.

---

## 5. Service Layer

- Satu service per domain; nama jelas (`NewsService`).
- Method service mengembalikan hasil yang siap dipakai controller.
- Service boleh memanggil repository & mengkoordinasikan beberapa model (transaksi `DB::transaction()`).
- Inject dependency via constructor dengan `readonly` (PHP 8.3).

```php
final class NewsService
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
    }

    public function create(array $data): News
    {
        return DB::transaction(function () use ($data): News {
            $news = $this->newsRepository->create($data);
            // log, notifikasi, dll.
            return $news;
        });
    }
}
```

---

## 6. Repository Pattern

- **Kapan dipakai:** query kompleks, agregat dashboard, query yang dipakai banyak service.
- **Kapan dihindari:** CRUD sederhana (langsung Eloquent cukup — prinsip KISS).
- Struktur: interface (`Contracts`) + implementasi (`Eloquent`), binding di `AppServiceProvider`.
- Repository mengembalikan **Model/Collection** (bukan array mentah).

---

## 7. Otorisasi (Policies & Gates)

- Setiap modul memiliki Policy (`NewsPolicy`, `UmkmPolicy`, ...).
- Nama method mengikuti konvensi Laravel.
- Super Admin melewati pemeriksaan via `Gate::before()`.
- Gunakan `$this->authorize()` di controller atau `authorize()` di Form Request.

```php
class NewsPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->hasRole('super-admin') ? true : null;
    }

    public function update(User $user, News $news): bool
    {
        return $user->can('news-edit');
    }
}
```

---

## 8. Keamanan

| Aspek | Praktik |
| --- | --- |
| Password | Hash dengan bcrypt cost 12 / argon2id; jangan pernah plain |
| Input | Validasi Form Request + `sanitize` bila perlu; Blade escaping otomatis |
| SQL | Selalu via Eloquent/query builder (parameterized) |
| CSRF | Aktif di semua form POST |
| XSS | Hindari `{!! !!}` tanpa sanitasi (mis. konten WYSIWYG perlu `HTML::clean`) |
| Upload | Validasi MIME & ukuran; simpan nama unik (`Str::random`) |
| File privat | Simpan di storage non-publik; akses via route berotorisasi |
| Rate limit | `throttle` pada login & form publik |
| Log | Jangan pernah mencatat password/token ke log |

---

## 9. Database

- Gunakan **Eloquent** dan **query builder**; hindari raw SQL kecuali sangat diperlukan.
- Selalu **eager loading** untuk relasi di list.
- Gunakan **pagination** (`->paginate()`) untuk data banyak.
- Optimasi query berat dengan **index** (lihat Database Design) & **cache**.
- Pembayaran/moneter: `DECIMAL`, jangan `FLOAT`.

---

## 10. Frontend (Blade, Tailwind, Alpine.js)

### Blade

- Gunakan **Blade Components** untuk elemen berulang (navbar, card, form).
- Klasifikasi: `@if/@foreach` ringkas; hindari logika PHP kompleks di view.
- Kelola asset via **Vite**; kompilasi & minify untuk production.

### Tailwind CSS

- Gunakan utility classes; atur tema/warna di `tailwind.config.js`.
- Konsistensi spacing/warna melalui token (mis. warna aksen keris/golden).
- Hindari CSS kustom berlebih; gunakan `@layer components` untuk pola berulang.

### Alpine.js

- Gunakan untuk interaktivitas ringan (mobile menu, tab, modal, dropdown).
- Data besar/compleks lebih baik dengan JavaScript komponen terpisah.

### Pustaka Pendukung

| Library | Penggunaan |
| --- | --- |
| AOS | Animasi scroll (hanya frontend publik) |
| SweetAlert2 | Konfirmasi & notifikasi admin (dan sukses form publik) |
| CKEditor | Editor WYSIWYG konten berita/profil |
| Chart.js | Grafik statistik & dashboard |
| PDF.js | Viewer Buku Profil Desa (PDF) |

---

## 11. SEO & Aksesibilitas

- Meta `title`, `description`, `canonical`, Open Graph di layout.
- Struktur heading semantik (`h1` → `h6`).
- Alt text wajib pada gambar.
- Gunakan `loading="lazy"` untuk gambar di bawah fold.
- Pastikan kontras & ukuran font memenuhi WCAG AA.
- Navigasi keyboard & focus states jelas.

---

## 12. Testing

| Jenis | Cakupan |
| --- | --- |
| Unit Test | Service, Repository, Helper, Enum |
| Feature Test | Route, Controller, Form Request, Policy, RBAC |
| Test Database | Menggunakan `RefreshDatabase` / in-memory (sqlite) |
| Framework | PHPUnit (bawaan Laravel) |

Contoh:

```php
public function test_admin_can_create_news(): void
{
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $this->actingAs($admin)
        ->post(route('admin.news.store'), $validData)
        ->assertRedirect(route('admin.news.index'));

    $this->assertDatabaseHas('news', ['title' => $validData['title']]);
}
```

---

## 13. Version Control (Git)

- Branch: `main` (production), `develop` (integrasi), fitur di branch `feature/{modul}`.
- Commit message jelas: `feat: add news crud`, `fix: resolve n+1 on gallery`, `docs: update srs`.
- Tidak commit: `.env`, file storage lokal, `vendor/`, `node_modules/` (gunakan `.gitignore`).

---

## 14. Checklist Kode Sebelum Merge

- [ ] Mengikuti PSR-12 & format (jalankan `pint` / `php-cs-fixer`).
- [ ] Tidak ada debug (`dd`, `dump`) tersisa.
- [ ] Validasi melalui Form Request; otorisasi via Policy.
- [ ] Query efisien (tidak ada N+1).
- [ ] Test yang relevan lulus (`php artisan test`).
- [ ] Tidak ada secret/hardcode di kode.
- [ ] UI responsive & memenuhi standar aksesibilitas dasar.
- [ ] Activity log untuk perubahan data penting.
