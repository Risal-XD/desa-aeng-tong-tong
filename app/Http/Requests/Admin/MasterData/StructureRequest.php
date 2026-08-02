<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\MasterData;

use Illuminate\Foundation\Http\FormRequest;

class StructureRequest extends FormRequest
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
            'parent_id' => ['nullable', 'exists:organizational_structures,id'],
            'name' => ['required', 'string', 'max:191'],
            'position' => ['nullable', 'string', 'max:191'],
            'level' => ['nullable', 'integer', 'min:0', 'max:32767'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:32767'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'parent_id' => 'Struktur Induk',
            'name' => 'Nama Struktur',
            'position' => 'Jabatan',
            'level' => 'Level Struktur',
            'image' => 'Gambar',
            'description' => 'Deskripsi',
            'sort_order' => 'Urutan',
            'is_active' => 'Status Aktif',
        ];
    }
}
