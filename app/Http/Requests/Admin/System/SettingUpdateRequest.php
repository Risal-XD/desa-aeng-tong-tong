<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\System;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingUpdateRequest extends FormRequest
{
    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'general' => ['sometimes', 'array'],
            'general.site_name' => ['nullable', 'string', 'max:191'],
            'general.site_tagline' => ['nullable', 'string', 'max:191'],
            'general.site_description' => ['nullable', 'string', 'max:500'],
            'general.site_logo' => ['nullable', 'image', 'mimes:jpeg,png,svg,webp', 'max:2048'],
            'seo' => ['sometimes', 'array'],
            'seo.meta_title' => ['nullable', 'string', 'max:191'],
            'seo.meta_description' => ['nullable', 'string', 'max:500'],
            'seo.meta_keywords' => ['nullable', 'string', 'max:191'],
            'contact' => ['sometimes', 'array'],
            'contact.contact_phone' => ['nullable', 'string', 'max:30'],
            'contact.contact_email' => ['nullable', 'email', 'max:191'],
            'contact.contact_whatsapp' => ['nullable', 'string', 'max:30'],
            'contact.contact_address' => ['nullable', 'string', 'max:500'],
            'contact.office_hours' => ['nullable', 'string', 'max:191'],
            'sosmed' => ['sometimes', 'array'],
            'sosmed.sosmed_facebook' => ['nullable', 'string', 'max:191', Rule::when(filled($this->input('sosmed.sosmed_facebook')), ['url'])],
            'sosmed.sosmed_instagram' => ['nullable', 'string', 'max:191', Rule::when(filled($this->input('sosmed.sosmed_instagram')), ['url'])],
            'sosmed.sosmed_twitter' => ['nullable', 'string', 'max:191', Rule::when(filled($this->input('sosmed.sosmed_twitter')), ['url'])],
            'sosmed.sosmed_youtube' => ['nullable', 'string', 'max:191', Rule::when(filled($this->input('sosmed.sosmed_youtube')), ['url'])],
            'sosmed.sosmed_tiktok' => ['nullable', 'string', 'max:191', Rule::when(filled($this->input('sosmed.sosmed_tiktok')), ['url'])],
        ];
    }
}
