<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Content;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
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
            'question' => ['required', 'string', 'max:191'],
            'answer' => ['required', 'string'],
            'category' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:32767'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'question' => 'Pertanyaan',
            'answer' => 'Jawaban',
            'category' => 'Kategori',
            'sort_order' => 'Urutan',
            'is_active' => 'Status Aktif',
        ];
    }
}
