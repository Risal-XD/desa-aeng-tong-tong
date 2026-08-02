@extends('admin.layouts.app')

@section('title', 'Pesan Masuk')

@section('content')
    <x-admin.page-header title="Pesan Masuk" description="Kelola pesan dari formulir kontak publik." />

    <x-admin.card>
        <form method="GET" class="mb-4 flex flex-wrap items-center gap-3">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama / email / subjek..."
                class="w-full rounded-lg border border-ink-300 px-3 py-2 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40 sm:w-64"
            >
            <select name="status" class="rounded-lg border border-ink-300 px-3 py-2 text-sm outline-none focus:border-brand-500">
                <option value="">Semua Status</option>
                @foreach ($statusOptions as $value => $label)
                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-600">
                Filter
            </button>
            @if (request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.service.messages.index') }}" class="text-sm font-medium text-ink-500 hover:text-ink-700">
                    Reset
                </a>
            @endif
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-ink-200 text-sm">
                <thead>
                    <tr class="bg-ink-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-500">
                        <th class="px-4 py-3">Pengirim</th>
                        <th class="px-4 py-3">Subjek</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-100">
                    @forelse ($messages as $message)
                        <tr class="{{ $message->status->value === 'baru' ? 'bg-amber-50/50' : '' }}">
                            <td class="px-4 py-3">
                                <p class="font-medium text-ink-900">{{ $message->name }}</p>
                                <p class="text-xs text-ink-500">{{ $message->email }}</p>
                            </td>
                            <td class="px-4 py-3 text-ink-700">{{ $message->subject }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $message->status->badge() }}">
                                    {{ $message->status->label() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-ink-500">{{ $message->created_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.service.messages.show', $message) }}" class="rounded-md border border-ink-200 px-3 py-1.5 text-xs font-semibold text-ink-700 transition hover:bg-ink-50">
                                    Buka
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-ink-500">
                                Belum ada pesan masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-1 py-3">
            {{ $messages->links() }}
        </div>
    </x-admin.card>
@endsection
