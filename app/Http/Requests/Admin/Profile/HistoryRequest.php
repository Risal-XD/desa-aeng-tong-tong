<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;

class HistoryRequest extends FormRequest
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
            'history_content' => ['nullable', 'string'],
            'founder_name' => ['nullable', 'string', 'max:191'],
            'founded_year' => ['nullable', 'integer', 'min:1800', 'max:'.now()->year],
            'status' => ['nullable', 'in:draft,published'],
        ];
    }

    public function attributes(): array
    {
        return [
            'history_content' => 'Konten Sejarah',
            'founder_name' => 'Nama Pendiri',
            'founded_year' => 'Tahun Berdiri',
            'status' => 'Status Publikasi',
        ];
    }
}
