<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Economy;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TourismDestinationRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:191'],
            'slug' => [
                'nullable',
                'string',
                'max:191',
                Rule::unique('tourism_destinations', 'slug')->ignore($this->route('tourism_destination')),
            ],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:8192'],
            'gallery.*' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:8192'],
            'address' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'open_hours' => ['nullable', 'string', 'max:191'],
            'entrance_fee' => ['nullable', 'string', 'max:191'],
            'category' => ['nullable', 'string', 'max:50'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Nama Destinasi',
            'slug' => 'Slug',
            'description' => 'Deskripsi',
            'image' => 'Gambar Utama',
            'gallery.*' => 'Galeri',
            'address' => 'Alamat',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'open_hours' => 'Jam Buka',
            'entrance_fee' => 'Harga Tiket',
            'category' => 'Kategori',
            'is_featured' => 'Destinasi Unggulan',
            'is_active' => 'Status Aktif',
        ];
    }
}
