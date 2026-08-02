<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Media;

use App\Enums\CommonStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BannerRequest extends FormRequest
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
                Rule::unique('banners', 'slug')->ignore($this->route('banner')),
            ],
            'image' => [$imageRule, 'image', 'mimes:jpeg,png,webp', 'max:8192'],
            'link' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
            'position' => ['nullable', 'string', 'max:20'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:32767'],
            'status' => ['required', Rule::in(array_column(CommonStatus::cases(), 'value'))],
            'started_at' => ['nullable', 'date'],
            'ended_at' => ['nullable', 'date', 'after_or_equal:started_at'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Judul Banner',
            'slug' => 'Slug',
            'image' => 'Gambar Banner',
            'link' => 'Tautan',
            'description' => 'Keterangan',
            'position' => 'Posisi',
            'sort_order' => 'Urutan',
            'status' => 'Status',
            'started_at' => 'Mulai Tayang',
            'ended_at' => 'Akhir Tayang',
        ];
    }
}
