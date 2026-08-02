<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;

class VillageProfileRequest extends FormRequest
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
            'overview' => ['nullable', 'string'],
            'geographic' => ['nullable', 'string'],
            'demographics_summary' => ['nullable', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'overview' => 'Gambaran Umum',
            'geographic' => 'Kondisi Geografis',
            'demographics_summary' => 'Ringkasan Demografis',
        ];
    }
}
