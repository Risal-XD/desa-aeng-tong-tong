<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Data;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocumentRequest extends FormRequest
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
        $required = $this->route('document') ? 'nullable' : 'required';

        return [
            'title' => ['required', 'string', 'max:191'],
            'slug' => [
                'nullable',
                'string',
                'max:191',
                Rule::unique('documents', 'slug')->ignore($this->route('document')),
            ],
            'category' => ['nullable', 'string', 'max:50'],
            'file' => [$required, 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,jpg,jpeg,png,webp', 'max:20480'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Judul Dokumen',
            'slug' => 'Slug',
            'category' => 'Kategori',
            'file' => 'File',
            'description' => 'Keterangan',
            'status' => 'Status',
        ];
    }
}
