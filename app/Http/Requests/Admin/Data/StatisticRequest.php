<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Data;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StatisticRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:191'],
            'slug' => [
                'nullable',
                'string',
                'max:191',
                Rule::unique('statistics', 'slug')->ignore($this->route('statistic')),
            ],
            'category' => ['required', Rule::in(['kependudukan', 'pendidikan', 'kesehatan', 'ekonomi', 'sosial', 'lainnya'])],
            'year' => ['required', 'integer', 'min:1900', 'max:2100'],
            'description' => ['nullable', 'string'],
            'population' => ['nullable', 'array'],
            'population.*.label' => ['required', 'string', 'max:191'],
            'population.*.value' => ['required', 'numeric', 'min:0'],
            'population.*.unit' => ['nullable', 'string', 'max:20'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama Statistik',
            'slug' => 'Slug',
            'category' => 'Kategori',
            'year' => 'Tahun',
            'description' => 'Keterangan',
            'population' => 'Data Statistik',
            'population.*.label' => 'Label Data',
            'population.*.value' => 'Nilai Data',
            'population.*.unit' => 'Satuan Data',
            'is_active' => 'Status Aktif',
        ];
    }
}
