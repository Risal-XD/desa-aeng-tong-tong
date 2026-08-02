@extends('frontend.layouts.app')

@section('title', 'Pengumuman')
@section('meta_description', 'Pengumuman resmi dari Pemerintah Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero
        title="Pengumuman"
        subtitle="Informasi resmi dari Pemerintah Desa Aeng Tong-Tong."
    />

    <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6">
        @if ($announcements->isNotEmpty())
            <div class="space-y-4">
                @foreach ($announcements as $item)
                    <a href="{{ route('announcements.show', $item) }}" class="group flex flex-col gap-2 rounded-2xl border border-ink-200 bg-white p-6 shadow-sm transition hover:border-brand-300 hover:shadow-md sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="font-display text-base font-semibold text-ink-900 group-hover:text-brand-600">
                                {{ $item->title }}
                            </h2>
                            @if ($item->content)
                                <p class="mt-1 line-clamp-2 text-sm text-ink-500">{!! Str::limit(strip_tags((string) $item->content), 120) !!}</p>
                            @endif
                        </div>
                        <div class="shrink-0 text-left sm:text-right">
                            <p class="text-xs font-semibold text-brand-600">{{ $item->published_at?->translatedFormat('d M Y') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $announcements->links() }}
            </div>
        @else
            <div class="rounded-2xl border border-ink-200 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-ink-500">Belum ada pengumuman.</p>
            </div>
        @endif
    </section>
@endsection
