<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Economy;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UmkmRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'slug' => [
                'nullable',
                'string',
                'max:191',
                Rule::unique('umkms', 'slug')->ignore($this->route('umkm')),
            ],
            'owner_name' => ['nullable', 'string', 'max:191'],
            'category' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:8192'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:191'],
            'website' => ['nullable', 'url', 'max:191'],
            'instagram' => ['nullable', 'string', 'max:191'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:32767'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama Usaha',
            'slug' => 'Slug',
            'owner_name' => 'Nama Pemilik',
            'category' => 'Kategori',
            'description' => 'Deskripsi',
            'logo' => 'Logo',
            'cover_image' => 'Gambar Sampul',
            'address' => 'Alamat',
            'phone' => 'Telepon',
            'email' => 'Email',
            'website' => 'Situs',
            'instagram' => 'Instagram',
            'is_featured' => 'Usaha Unggulan',
            'sort_order' => 'Urutan',
            'is_active' => 'Status Aktif',
        ];
    }
}
