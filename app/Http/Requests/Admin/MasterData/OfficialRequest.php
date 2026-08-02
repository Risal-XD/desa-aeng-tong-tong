<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\MasterData;

use Illuminate\Foundation\Http\FormRequest;

class OfficialRequest extends FormRequest
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
            'structure_id' => ['nullable', 'exists:organizational_structures,id'],
            'name' => ['required', 'string', 'max:191'],
            'position' => ['required', 'string', 'max:191'],
            'nip' => ['nullable', 'string', 'max:50'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'email' => ['nullable', 'string', 'email', 'max:191'],
            'phone' => ['nullable', 'string', 'max:30'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:32767'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'structure_id' => 'Struktur',
            'name' => 'Nama Perangkat',
            'position' => 'Jabatan',
            'nip' => 'NIP',
            'photo' => 'Foto',
            'email' => 'Email',
            'phone' => 'Telepon',
            'sort_order' => 'Urutan',
            'is_active' => 'Status Aktif',
        ];
    }
}
