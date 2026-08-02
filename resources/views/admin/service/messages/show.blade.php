@extends('admin.layouts.app')

@section('title', 'Detail Pesan')

@section('content')
    <x-admin.page-header title="Detail Pesan" description="Pesan dari {{ $message->name }}.">
        <x-slot:actions>
            <a href="{{ route('admin.service.messages.index') }}" class="rounded-lg border border-ink-300 px-4 py-2 text-sm font-semibold text-ink-700 transition hover:bg-ink-50">
                ← Kembali
            </a>
        </x-slot:actions>
    </x-admin.page-header>

    <div class="grid gap-4 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <x-admin.card title="Isi Pesan">
                <div class="mb-4 flex flex-wrap items-center gap-2 text-sm">
                    <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $message->status->badge() }}">
                        {{ $message->status->label() }}
                    </span>
                    <span class="text-ink-500">Diterima {{ $message->created_at->format('d M Y H:i') }}</span>
                </div>
                <h3 class="text-lg font-semibold text-ink-900">{{ $message->subject }}</h3>
                <div class="mt-4 whitespace-pre-line rounded-lg bg-ink-50 p-4 text-sm leading-relaxed text-ink-700">
                    {{ $message->message }}
                </div>
            </x-admin.card>

            <div class="mt-4">
                <x-admin.card title="Balas Pesan">
                    @if ($message->isReplied())
                        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Balasan sebelumnya</p>
                            <p class="mt-2 whitespace-pre-line text-sm text-emerald-900">{{ $message->reply }}</p>
                            <p class="mt-2 text-xs text-emerald-700">Dibalas oleh {{ $message->user?->name ?? '-' }} pada {{ $message->replied_at?->format('d M Y H:i') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.service.messages.update', $message) }}">
                        @csrf
                        @method('PUT')
                        <x-admin.textarea name="reply" label="Balasan" rows="5" :value="old('reply', $message->reply)" required />
                        <div class="mt-4">
                            <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-600">
                                Kirim Balasan
                            </button>
                        </div>
                    </form>
                </x-admin.card>
            </div>
        </div>

        <div>
            <x-admin.card title="Informasi Pengirim">
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-ink-500">Nama</dt>
                        <dd class="mt-0.5 text-ink-800">{{ $message->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-ink-500">Email</dt>
                        <dd class="mt-0.5 break-all text-ink-800">{{ $message->email }}</dd>
                    </div>
                    @if ($message->phone)
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-ink-500">Telepon</dt>
                            <dd class="mt-0.5 text-ink-800">{{ $message->phone }}</dd>
                        </div>
                    @endif
                </dl>
            </x-admin.card>
        </div>
    </div>
@endsection
