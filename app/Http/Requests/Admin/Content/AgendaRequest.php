<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Content;

use App\Enums\AgendaStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgendaRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:191'],
            'slug' => [
                'nullable',
                'string',
                'max:191',
                Rule::unique('agendas', 'slug')->ignore($this->route('agenda')),
            ],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:191'],
            'event_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],
            'status' => ['required', Rule::in(array_column(AgendaStatus::cases(), 'value'))],
            'is_featured' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Judul Agenda',
            'slug' => 'Slug',
            'description' => 'Deskripsi',
            'location' => 'Lokasi',
            'event_date' => 'Tanggal Kegiatan',
            'start_time' => 'Jam Mulai',
            'end_time' => 'Jam Selesai',
            'status' => 'Status',
            'is_featured' => 'Agenda Unggulan',
        ];
    }
}
