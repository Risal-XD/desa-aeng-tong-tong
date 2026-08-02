<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Economy;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KerisArtisanRequest extends FormRequest
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
            'title' => ['nullable', 'string', 'max:191'],
            'slug' => [
                'nullable',
                'string',
                'max:191',
                Rule::unique('keris_artisans', 'slug')->ignore($this->route('keris_artisan')),
            ],
            'bio' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:4096'],
            'specialties' => ['nullable', 'string', 'max:255'],
            'experience_years' => ['nullable', 'string', 'max:50'],
            'award' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:191'],
            'website' => ['nullable', 'url', 'max:191'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:32767'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama Mpu',
            'title' => 'Gelar',
            'slug' => 'Slug',
            'bio' => 'Biografi',
            'photo' => 'Foto',
            'specialties' => 'Keahlian',
            'experience_years' => 'Pengalaman',
            'award' => 'Penghargaan',
            'address' => 'Alamat',
            'phone' => 'Telepon',
            'email' => 'Email',
            'website' => 'Situs',
            'sort_order' => 'Urutan',
            'is_active' => 'Status Aktif',
        ];
    }
}
