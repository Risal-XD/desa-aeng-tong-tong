<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;

class SettingService
{
    private ?Collection $items = null;

    /**
     * Memuat seluruh setting (cache per-request).
     */
    public function all(): Collection
    {
        if ($this->items === null) {
            $this->items = Setting::query()
                ->orderBy('group')
                ->orderBy('key')
                ->get()
                ->keyBy('key');
        }

        return $this->items;
    }

    /**
     * Membaca nilai setting dengan tipe yang sesuai.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $setting = $this->all()->get($key);

        if (! $setting) {
            return $default;
        }

        return match ($setting->type) {
            'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            'json' => $setting->value === null || $setting->value === '' ? [] : json_decode($setting->value, true),
            default => (string) $setting->value,
        };
    }

    /**
     * @return array<string, mixed>
     */
    public function allByGroup(string $group): array
    {
        return $this->all()
            ->where('group', $group)
            ->mapWithKeys(fn (Setting $setting) => [$setting->key => $this->get($setting->key)])
            ->all();
    }

    /**
     * Menyimpan satu setting.
     */
    public function set(string $key, mixed $value, string $group = 'general', string $type = 'string'): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            [
                'group' => $group,
                'value' => $type === 'json' ? json_encode($value) : (string) $value,
                'type' => $type,
            ],
        );

        $this->items = null;
    }

    /**
     * Menyimpan banyak setting dalam satu grup.
     *
     * @param  array<string, mixed>  $values
     */
    public function setMany(array $values, string $group): void
    {
        foreach ($values as $key => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            $this->set($key, $value, $group);
        }

        $this->items = null;
    }
}
