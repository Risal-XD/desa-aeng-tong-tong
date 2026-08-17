<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class EBookletController extends Controller
{
    /**
     * Mengirim e-booklet sebagai inline PDF melalui rute milik aplikasi.
     * Mendukung Range (pdf.js mengambil per-chunk, tidak mengunduh 58MB sekali jalan),
     * no-store, dan CORS agar selalu bisa dimuat dari host mana pun.
     */
    public function pdf(SettingService $settings): SymfonyResponse
    {
        $path = $settings->get('ebooklet_pdf');

        if (! $path) {
            abort(404, 'File e-booklet tidak ditemukan.');
        }

        $absolute = Storage::disk('public')->path($path);

        if (! is_file($absolute)) {
            abort(404, 'File e-booklet tidak ditemukan.');
        }

        $size = (int) filesize($absolute);
        $range = request()->header('Range');

        $start = 0;
        $end = $size - 1;
        $status = 200;

        if ($range !== null && preg_match('/bytes=(\d*)-(\d*)/', $range, $matches)) {
            if ($matches[1] !== '') {
                $start = (int) $matches[1];
            }

            if ($matches[2] !== '') {
                $end = min((int) $matches[2], $size - 1);
            }

            if ($start > $end || $start >= $size) {
                return Response::make('', 416)->header('Content-Range', "bytes */{$size}");
            }

            $status = 206;
        }

        $length = $end - $start + 1;

        $stream = Response::stream(function () use ($absolute, $start, $length) {
            $handle = fopen($absolute, 'rb');

            if ($handle === false) {
                return;
            }

            fseek($handle, $start);
            $chunkSize = 1024 * 64;
            $remaining = $length;

            while ($remaining > 0 && ! feof($handle)) {
                $chunk = min($chunkSize, $remaining);
                $data = fread($handle, $chunk);

                if ($data === false || $data === '') {
                    break;
                }

                echo $data;
                flush();
                $remaining -= strlen($data);
            }

            fclose($handle);
        }, $status, [
            'Content-Type' => 'application/pdf',
            'Content-Length' => (string) $length,
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Access-Control-Allow-Origin' => '*',
            'Cross-Origin-Resource-Policy' => 'cross-origin',
        ]);

        if ($status === 206) {
            $stream->headers->set('Content-Range', "bytes {$start}-{$end}/{$size}");
        }

        return $stream;
    }
}