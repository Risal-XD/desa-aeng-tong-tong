<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;

class VisionMissionRequest extends FormRequest
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
            'vision' => ['required', 'string'],
            'missions' => ['required', 'array', 'min:1'],
            'missions.*' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:32767'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'vision' => 'Visi',
            'missions' => 'Misi',
            'missions.*' => 'Misi',
            'sort_order' => 'Urutan',
            'is_active' => 'Status Aktif',
        ];
    }
}
