<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Memastikan pengguna memiliki permission tertentu.
     * Contoh penggunaan: ->middleware('permission:news-create')
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (! $request->user() || ! $request->user()->hasPermission($permission)) {
            abort(403, 'Anda tidak memiliki izin untuk tindakan ini.');
        }

        return $next($request);
    }
}
