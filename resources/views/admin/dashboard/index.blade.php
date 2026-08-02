@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-ink-900">Selamat Datang, {{ auth()->user()->name }} 👋</h1>
        <p class="mt-1 text-sm text-ink-500">
            Ringkasan kondisi Website Profil Desa Aeng Tong-Tong.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-admin.card>
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-brand-100 text-brand-700">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-ink-500">Total Berita</p>
                    <p class="text-2xl font-bold text-ink-900">{{ $stats['news'] }}</p>
                </div>
            </div>
        </x-admin.card>

        <x-admin.card>
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-amber-100 text-amber-700">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-ink-500">Pesan Baru</p>
                    <p class="text-2xl font-bold text-ink-900">{{ $stats['unread_messages'] }}</p>
                </div>
            </div>
        </x-admin.card>

        <x-admin.card>
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-sky-100 text-sky-700">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-ink-500">Total Dokumen</p>
                    <p class="text-2xl font-bold text-ink-900">{{ $stats['documents'] }}</p>
                </div>
            </div>
        </x-admin.card>

        <x-admin.card>
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-violet-100 text-violet-700">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-ink-500">Total Pengguna</p>
                    <p class="text-2xl font-bold text-ink-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </x-admin.card>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-4 lg:grid-cols-2">
        <x-admin.card title="Grafik Berita 6 Bulan Terakhir">
            <div class="h-64">
                <canvas id="chartNews" data-labels="{{ json_encode($charts['newsPerMonth']['labels']) }}" data-values="{{ json_encode($charts['newsPerMonth']['values']) }}"></canvas>
            </div>
        </x-admin.card>

        <x-admin.card :title="$charts['population'] ? 'Statistik ' . $charts['population']['title'] : 'Statistik Kependudukan'">
            @if ($charts['population'])
                <div class="h-64">
                    <canvas id="chartPopulation" data-labels="{{ json_encode($charts['population']['labels']) }}" data-values="{{ json_encode($charts['population']['values']) }}"></canvas>
                </div>
            @else
                <p class="py-16 text-center text-sm text-ink-500">Belum ada data statistik kependudukan.</p>
            @endif
        </x-admin.card>

        <x-admin.card :title="'APBDes ' . $charts['apbdes']['year'] . ' (Anggaran vs Realisasi)'">
            <div class="h-64">
                <canvas id="chartApbdes" data-labels="{{ json_encode($charts['apbdes']['labels']) }}" data-budget="{{ json_encode($charts['apbdes']['budget']) }}" data-realization="{{ json_encode($charts['apbdes']['realization']) }}"></canvas>
            </div>
        </x-admin.card>

        <x-admin.card title="Dokumen Terpopuler">
            @if ($charts['topDownloads']['labels'])
                <div class="h-64">
                    <canvas id="chartDownloads" data-labels="{{ json_encode($charts['topDownloads']['labels']) }}" data-values="{{ json_encode($charts['topDownloads']['values']) }}"></canvas>
                </div>
            @else
                <p class="py-16 text-center text-sm text-ink-500">Belum ada data unduhan.</p>
            @endif
        </x-admin.card>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-4 lg:grid-cols-2">
        <x-admin.card title="Aktivitas Terbaru">
            @forelse ($recentActivity as $log)
                <div class="flex items-start gap-3 border-b border-ink-100 py-3 last:border-0">
                    <span class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-ink-100 text-xs font-bold text-ink-600">
                        {{ $log->user ? mb_substr($log->user->name, 0, 1) : 'S' }}
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm text-ink-800">{{ $log->description }}</p>
                        <p class="mt-0.5 text-xs text-ink-500">
                            {{ $log->user?->name ?? 'Sistem' }} · {{ $log->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="py-8 text-center text-sm text-ink-500">Belum ada aktivitas tercatat.</p>
            @endforelse

            @can('activity-log-view')
                <a href="{{ route('admin.system.activity-log.index') }}" class="mt-3 inline-block text-sm font-medium text-brand-600 hover:text-brand-700">
                    Lihat semua aktivitas →
                </a>
            @endcan
        </x-admin.card>

        <x-admin.card title="Pesan Masuk Terbaru">
            @forelse ($recentMessages as $message)
                <div class="flex items-start gap-3 border-b border-ink-100 py-3 last:border-0">
                    <span class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-100 text-xs font-bold text-brand-700">
                        {{ mb_substr($message->name, 0, 1) }}
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm text-ink-800">
                            <span class="font-medium">{{ $message->name }}</span> · {{ $message->subject }}
                        </p>
                        <p class="mt-0.5 text-xs text-ink-500">
                            <span class="inline-flex rounded-full px-1.5 py-0.5 text-[10px] font-medium {{ $message->status->badge() }}">
                                {{ $message->status->label() }}
                            </span>
                            · {{ $message->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="py-8 text-center text-sm text-ink-500">Belum ada pesan masuk.</p>
            @endforelse

            @can('message-view')
                <a href="{{ route('admin.service.messages.index') }}" class="mt-3 inline-block text-sm font-medium text-brand-600 hover:text-brand-700">
                    Lihat semua pesan →
                </a>
            @endcan
        </x-admin.card>
    </div>

    <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 xl:grid-cols-6">
        @php
            $mini = [
                ['label' => 'Pengumuman', 'value' => $stats['announcements']],
                ['label' => 'Agenda', 'value' => $stats['agendas']],
                ['label' => 'FAQ', 'value' => $stats['faqs']],
                ['label' => 'Galeri', 'value' => $stats['galleries']],
                ['label' => 'Video', 'value' => $stats['videos']],
                ['label' => 'Banner', 'value' => $stats['banners']],
                ['label' => 'Wisata', 'value' => $stats['tourism']],
                ['label' => 'Keris & Mpu', 'value' => $stats['keris']],
                ['label' => 'UMKM', 'value' => $stats['umkms']],
                ['label' => 'Statistik', 'value' => $stats['statistics']],
                ['label' => 'APBDes', 'value' => $stats['apbdes']],
                ['label' => 'Unduhan', 'value' => $stats['downloads']],
            ];
        @endphp
        @foreach ($mini as $item)
            <div class="rounded-lg border border-ink-200 bg-white px-4 py-3 shadow-sm">
                <p class="text-xs font-medium uppercase tracking-wide text-ink-500">{{ $item['label'] }}</p>
                <p class="mt-0.5 text-xl font-bold text-ink-900">{{ $item['value'] }}</p>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const colors = ['#8b5cf6', '#10b981', '#0ea5e9', '#f59e0b', '#ef4444', '#14b8a6'];

            const chart = (id, config) => {
                const canvas = document.getElementById(id);
                if (!canvas || typeof Chart === 'undefined') return;
                new Chart(canvas, config);
            };

            chart('chartNews', {
                type: 'bar',
                data: {
                    labels: JSON.parse(canvasData('chartNews', 'labels')),
                    datasets: [{
                        label: 'Berita',
                        data: JSON.parse(canvasData('chartNews', 'values')),
                        backgroundColor: '#0ea5e9',
                        borderRadius: 4,
                    }],
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } },
            });

            chart('chartPopulation', {
                type: 'doughnut',
                data: {
                    labels: JSON.parse(canvasData('chartPopulation', 'labels')),
                    datasets: [{
                        data: JSON.parse(canvasData('chartPopulation', 'values')),
                        backgroundColor: colors,
                        borderWidth: 2,
                    }],
                },
                options: { responsive: true, maintainAspectRatio: false },
            });

            chart('chartApbdes', {
                type: 'bar',
                data: {
                    labels: JSON.parse(canvasData('chartApbdes', 'labels')),
                    datasets: [
                        { label: 'Anggaran', data: JSON.parse(canvasData('chartApbdes', 'budget')), backgroundColor: '#8b5cf6', borderRadius: 4 },
                        { label: 'Realisasi', data: JSON.parse(canvasData('chartApbdes', 'realization')), backgroundColor: '#10b981', borderRadius: 4 },
                    ],
                },
                options: { responsive: true, maintainAspectRatio: false },
            });

            chart('chartDownloads', {
                type: 'bar',
                data: {
                    labels: JSON.parse(canvasData('chartDownloads', 'labels')),
                    datasets: [{
                        label: 'Unduhan',
                        data: JSON.parse(canvasData('chartDownloads', 'values')),
                        backgroundColor: '#f59e0b',
                        borderRadius: 4,
                    }],
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                },
            });

            function canvasData(id, attr) {
                return document.getElementById(id).getAttribute('data-' + attr);
            }
        });
    </script>
@endpush
