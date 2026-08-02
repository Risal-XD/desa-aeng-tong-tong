<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadService
{
    /**
     * Menyimpan file ke disk public dengan nama unik.
     * Mengembalikan path relatif yang aman disimpan di database.
     */
    public function store(UploadedFile $file, string $folder = 'images', string $disk = 'public'): string
    {
        $name = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();

        return $file->storeAs($folder, $name, $disk);
    }

    /**
     * Menghapus file bila path ada di disk. Aman bila path kosong.
     */
    public function delete(?string $path, string $disk = 'public'): void
    {
        if (! $path) {
            return;
        }

        if (Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }
    }

    /**
     * Mengganti file lama dengan file baru, lalu mengembalikan path baru.
     */
    public function replace(?string $oldPath, UploadedFile $file, string $folder = 'images', string $disk = 'public'): string
    {
        $this->delete($oldPath, $disk);

        return $this->store($file, $folder, $disk);
    }
}
