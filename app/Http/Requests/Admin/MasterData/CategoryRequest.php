<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\MasterData;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $categoryId = $this->route('category');
        $table = $this->route('type') === 'gallery' ? 'gallery_categories'
            : ($this->route('type') === 'video' ? 'video_categories' : 'news_categories');

        return [
            'name' => ['required', 'string', 'max:191'],
            'slug' => ['nullable', 'string', 'max:191', Rule::unique($table, 'slug')->ignore($categoryId)],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama Kategori',
            'slug' => 'Slug',
            'description' => 'Deskripsi',
            'is_active' => 'Status Aktif',
        ];
    }
}
