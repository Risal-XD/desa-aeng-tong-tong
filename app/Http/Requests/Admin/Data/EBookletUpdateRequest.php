<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Data;

use Illuminate\Foundation\Http\FormRequest;

class EBookletUpdateRequest extends FormRequest
{
    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'ebooklet_cover' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:8192'],
            'ebooklet_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:61440'],
        ];
    }
}