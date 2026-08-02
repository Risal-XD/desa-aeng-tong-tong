@extends('admin.layouts.app')

@section('title', 'Activity Log')

@section('content')
    <x-admin.page-header title="Activity Log" description="Riwayat aktivitas pengguna pada panel administrasi." />

    <x-admin.card>
        <form method="GET" class="mb-4 flex flex-wrap items-center gap-3">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari deskripsi..."
                class="w-full rounded-lg border border-ink-300 px-3 py-2 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40 sm:w-64"
            >
            <select name="log_name" class="rounded-lg border border-ink-300 px-3 py-2 text-sm outline-none focus:border-brand-500">
                <option value="">Semua Modul</option>
                @foreach ($logNames as $name)
                    <option value="{{ $name }}" @selected(request('log_name') === $name)>{{ $name }}</option>
                @endforeach
            </select>
            <select name="event" class="rounded-lg border border-ink-300 px-3 py-2 text-sm outline-none focus:border-brand-500">
                <option value="">Semua Event</option>
                @foreach (['created', 'updated', 'deleted'] as $event)
                    <option value="{{ $event }}" @selected(request('event') === $event)>{{ ucfirst($event) }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-600">
                Filter
            </button>
            @if (request()->hasAny(['search', 'log_name', 'event']))
                <a href="{{ route('admin.system.activity-log.index') }}" class="text-sm font-medium text-ink-500 hover:text-ink-700">
                    Reset
                </a>
            @endif
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-ink-200 text-sm">
                <thead>
                    <tr class="bg-ink-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-500">
                        <th class="px-4 py-3">Deskripsi</th>
                        <th class="px-4 py-3">Modul</th>
                        <th class="px-4 py-3">Event</th>
                        <th class="px-4 py-3">Pengguna</th>
                        <th class="px-4 py-3">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-100">
                    @forelse ($logs as $log)
                        <tr>
                            <td class="px-4 py-3 text-ink-800">{{ $log->description }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full bg-ink-100 px-2 py-0.5 text-xs font-medium text-ink-600">{{ $log->log_name }}</span>
                            </td>
                            <td class="px-4 py-3">
                                @if ($log->event)
                                    <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $log->event === 'created' ? 'bg-emerald-100 text-emerald-700' : ($log->event === 'updated' ? 'bg-sky-100 text-sky-700' : 'bg-red-100 text-red-700') }}">
                                        {{ ucfirst($log->event) }}
                                    </span>
                                @else
                                    <span class="text-ink-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-ink-600">{{ $log->user?->name ?? 'Sistem' }}</td>
                            <td class="px-4 py-3 text-ink-500">{{ $log->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-ink-500">
                                Belum ada log aktivitas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-1 py-3">
            {{ $logs->links() }}
        </div>
    </x-admin.card>
@endsection
