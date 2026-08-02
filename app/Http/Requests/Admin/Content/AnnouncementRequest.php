<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Content;

use App\Enums\AnnouncementStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnnouncementRequest extends FormRequest
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
                Rule::unique('announcements', 'slug')->ignore($this->route('announcement')),
            ],
            'content' => ['nullable', 'string'],
            'attachment' => ['nullable', 'file', 'max:10240'],
            'status' => ['required', Rule::in(array_column(AnnouncementStatus::cases(), 'value'))],
            'published_at' => ['nullable', 'date'],
            'expired_at' => ['nullable', 'date', 'after_or_equal:published_at'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Judul Pengumuman',
            'slug' => 'Slug',
            'content' => 'Isi Pengumuman',
            'attachment' => 'Lampiran',
            'status' => 'Status',
            'published_at' => 'Waktu Tayang',
            'expired_at' => 'Waktu Berakhir',
        ];
    }
}
