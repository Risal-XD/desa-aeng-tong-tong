<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\MasterData;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VillageRequest extends FormRequest
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
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('villages', 'code')->ignore($this->route('village')),
            ],
            'district' => ['required', 'string', 'max:191'],
            'regency' => ['required', 'string', 'max:191'],
            'province' => ['required', 'string', 'max:191'],
            'address' => ['nullable', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'area' => ['nullable', 'numeric', 'between:0,99999999.99'],
            'total_hamlet' => ['nullable', 'integer', 'min:0', 'max:32767'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,webp,svg', 'max:2048'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:4096'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama Desa',
            'code' => 'Kode Desa',
            'district' => 'Kecamatan',
            'regency' => 'Kabupaten',
            'province' => 'Provinsi',
            'address' => 'Alamat Kantor Desa',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'area' => 'Luas Wilayah',
            'total_hamlet' => 'Jumlah Dusun',
            'description' => 'Deskripsi Singkat',
            'logo' => 'Logo Desa',
            'cover_image' => 'Gambar Sampul',
        ];
    }
}
