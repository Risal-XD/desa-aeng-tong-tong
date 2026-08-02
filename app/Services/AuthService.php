<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(
        private readonly ActivityLogService $activityLog,
    ) {}

    /**
     * Autentikasi pengguna aktif, catat last_login & activity log.
     * Mengembalikan true bila sukses.
     */
    public function authenticate(string $email, string $password, bool $remember = false): bool
    {
        if (! Auth::attempt(['email' => $email, 'password' => $password, 'is_active' => true], $remember)) {
            return false;
        }

        /** @var User $user */
        $user = Auth::user();

        session()->regenerate();

        $user->update(['last_login_at' => now()]);

        $this->activityLog->log('Pengguna berhasil login', 'login', $user, ['email' => $user->email]);

        return true;
    }

    public function logout(Request $request): void
    {
        $user = Auth::user();

        if ($user instanceof User) {
            $this->activityLog->log('Pengguna logout', 'logout', $user);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
