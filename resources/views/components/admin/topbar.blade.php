@php
    $user = auth()->user();
    $roles = $user->roles->pluck('name')->implode(', ');
@endphp

<header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-outline-variant/30 bg-surface/95 px-4 backdrop-blur sm:px-6">
    <button
        type="button"
        class="rounded-md p-2 text-on-surface-variant hover:bg-surface-container lg:hidden"
        @click="sidebarOpen = !sidebarOpen"
        aria-label="Buka menu"
    >
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <line x1="3" y1="6" x2="21" y2="6"/>
            <line x1="3" y1="12" x2="21" y2="12"/>
            <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
    </button>

    <div class="hidden items-center gap-2 text-sm text-on-surface-variant sm:flex">
        <span>Panel Admin</span>
    </div>

    <div class="ml-auto flex items-center gap-3">
        <div x-data="{ open: false }" class="relative">
            <button
                type="button"
                @click="open = !open"
                @keydown.escape.window="open = false"
                class="flex items-center gap-2 rounded-md px-2 py-1.5 hover:bg-surface-container"
            >
                <span class="flex h-8 w-8 items-center justify-center overflow-hidden rounded-full bg-primary-container text-xs font-bold text-on-primary-container">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                    @else
                        {{ mb_substr($user->name, 0, 1) }}
                    @endif
                </span>
                <span class="hidden text-left md:block">
                    <span class="block max-w-[160px] truncate text-sm font-medium text-on-surface">{{ $user->name }}</span>
                    <span class="block max-w-[160px] truncate text-xs text-on-surface-variant">{{ $roles }}</span>
                </span>
                <svg class="h-4 w-4 text-outline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 12 15 18 9"/>
                </svg>
            </button>

            <div
                x-show="open"
                x-transition
                @click.outside="open = false"
                class="absolute right-0 mt-2 w-52 overflow-hidden rounded-md border border-outline-variant bg-surface-container-lowest shadow-lg"
            >
                <a href="{{ route('admin.profile.show') }}" class="block px-4 py-2 text-sm text-on-surface hover:bg-surface-container">
                    Profil Saya
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-error hover:bg-error-container">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
