<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Media;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GalleryRequest extends FormRequest
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
        $imageRule = $this->isMethod('PUT') ? 'nullable' : 'required';

        return [
            'title' => ['required', 'string', 'max:191'],
            'slug' => [
                'nullable',
                'string',
                'max:191',
                Rule::unique('galleries', 'slug')->ignore($this->route('gallery')),
            ],
            'gallery_category_id' => ['nullable', 'integer', 'exists:gallery_categories,id'],
            'image' => [$imageRule, 'image', 'mimes:jpeg,png,webp', 'max:8192'],
            'description' => ['nullable', 'string'],
            'is_cover' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:32767'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Judul Foto',
            'slug' => 'Slug',
            'gallery_category_id' => 'Kategori',
            'image' => 'Gambar',
            'description' => 'Keterangan',
            'is_cover' => 'Foto Sampul',
            'sort_order' => 'Urutan',
            'is_active' => 'Status Aktif',
        ];
    }
}
