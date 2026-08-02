<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Content;

use App\Enums\NewsStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsRequest extends FormRequest
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
                Rule::unique('news', 'slug')->ignore($this->route('news')),
            ],
            'news_category_id' => ['nullable', 'integer', 'exists:news_categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:4096'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'source' => ['nullable', 'string', 'max:191'],
            'tags' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(array_column(NewsStatus::cases(), 'value'))],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Judul Berita',
            'slug' => 'Slug',
            'news_category_id' => 'Kategori',
            'excerpt' => 'Ringkasan',
            'content' => 'Konten',
            'cover_image' => 'Gambar Sampul',
            'thumbnail' => 'Thumbnail',
            'source' => 'Sumber',
            'tags' => 'Tag',
            'status' => 'Status',
            'published_at' => 'Waktu Terbit',
        ];
    }
}
