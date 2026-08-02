<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PotentialRequest extends FormRequest
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
                Rule::unique('village_potentials', 'slug')->ignore($this->route('potential')),
            ],
            'category' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:4096'],
            'icon' => ['nullable', 'string', 'max:100'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:32767'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Judul Potensi',
            'slug' => 'Slug',
            'category' => 'Kategori Potensi',
            'description' => 'Deskripsi',
            'image' => 'Gambar',
            'icon' => 'Ikon',
            'is_featured' => 'Potensi Unggulan',
            'sort_order' => 'Urutan',
            'is_active' => 'Status Aktif',
        ];
    }
}
