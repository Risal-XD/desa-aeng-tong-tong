<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Media;

use App\Enums\VideoPlatform;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VideoRequest extends FormRequest
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
                Rule::unique('videos', 'slug')->ignore($this->route('video')),
            ],
            'video_category_id' => ['nullable', 'integer', 'exists:video_categories,id'],
            'video_url' => ['required', 'url', 'max:255'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:4096'],
            'platform' => ['required', Rule::in(array_column(VideoPlatform::cases(), 'value'))],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Judul Video',
            'slug' => 'Slug',
            'video_category_id' => 'Kategori',
            'video_url' => 'URL Video',
            'thumbnail' => 'Thumbnail',
            'platform' => 'Platform',
            'description' => 'Keterangan',
            'is_active' => 'Status Aktif',
        ];
    }
}
