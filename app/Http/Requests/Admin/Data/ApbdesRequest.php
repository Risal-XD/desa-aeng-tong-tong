<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Data;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApbdesRequest extends FormRequest
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
            'year' => ['required', 'integer', 'min:1900', 'max:2100'],
            'type' => ['required', Rule::in(['pendapatan', 'belanja', 'pembiayaan'])],
            'name' => ['required', 'string', 'max:191'],
            'category' => ['nullable', 'string', 'max:191'],
            'budget_amount' => ['required', 'numeric', 'min:0'],
            'realization_amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'year' => 'Tahun',
            'type' => 'Jenis',
            'name' => 'Nama Pos Anggaran',
            'category' => 'Kategori',
            'budget_amount' => 'Nilai Anggaran',
            'realization_amount' => 'Nilai Realisasi',
            'description' => 'Keterangan',
            'is_active' => 'Status Aktif',
        ];
    }
}
