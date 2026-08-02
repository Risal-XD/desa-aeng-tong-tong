@extends('frontend.layouts.app')

@section('title', 'FAQ')
@section('meta_description', 'Pertanyaan yang sering diajukan mengenai Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero
        title="Pertanyaan Umum"
        subtitle="Jawaban atas pertanyaan yang sering diajukan tentang Desa Aeng Tong-Tong."
    />

    <section class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
        <div x-data="{ open: null }" class="space-y-3">
            @forelse ($faqs as $index => $faq)
                <div class="overflow-hidden rounded-2xl border border-ink-200 bg-white shadow-sm">
                    <button
                        type="button"
                        @click="open = open === {{ $index }} ? null : {{ $index }}"
                        class="flex w-full items-center justify-between gap-4 px-6 py-4 text-left"
                    >
                        <span class="text-sm font-semibold text-ink-900">{{ $faq->question }}</span>
                        <svg class="h-5 w-5 shrink-0 text-brand-500" :class="open === {{ $index }} ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div x-show="open === {{ $index }}" x-cloak x-transition>
                        <div class="prose prose-ink max-w-none border-t border-ink-100 px-6 py-4 text-sm leading-relaxed text-ink-600">
                            {!! $faq->answer !!}
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-ink-200 bg-white p-10 text-center shadow-sm">
                    <p class="text-sm text-ink-500">Belum ada pertanyaan umum.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
