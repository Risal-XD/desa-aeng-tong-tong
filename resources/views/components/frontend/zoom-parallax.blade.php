@props(['items' => [], 'title' => 'Galeri Foto'])

@php
    $layers = collect($items)->take(5)->values()->map(function ($item, $index) {
        $positions = [
            ['top' => '0', 'left' => '0', 'width' => '25vw', 'height' => '25vh', 'scale' => [1, 4]],
            ['top' => '-43vh', 'left' => '5vw', 'width' => '35vw', 'height' => '30vh', 'scale' => [1, 5]],
            ['top' => '-16.5vh', 'left' => '-25vw', 'width' => '20vw', 'height' => '45vh', 'scale' => [1, 8]],
            ['top' => '0', 'left' => '28vw', 'width' => '25vw', 'height' => '25vh', 'scale' => [1, 7]],
            ['top' => '21vw', 'left' => '-5vw', 'width' => '35vw', 'height' => '35vh', 'scale' => [1, 6]],
        ];

        $position = $positions[$index] ?? $positions[0];

        return [
            'image' => $item['image'] ?? null,
            'alt' => $item['title'] ?? 'Foto galeri',
            'first' => $item['first'] ?? 'G',
            'top' => $position['top'],
            'left' => $position['left'],
            'width' => $position['width'],
            'height' => $position['height'],
            'scale' => $position['scale'],
        ];
    });
@endphp

@if ($layers->isNotEmpty())
    <section class="relative h-[300vh]">
        <div class="sticky top-0 h-dvh overflow-hidden">
            <div x-data="zoomParallax(@js($layers))" class="relative h-full w-full">
                <template x-for="(item, index) in layers" :key="index">
                    <div
                        class="absolute left-0 top-0 flex h-full w-full items-center justify-center"
                        :style="'transform: scale(' + scale(index) + ')'"
                    >
                        <div
                            class="relative overflow-hidden rounded-2xl shadow-2xl"
                            :style="'top:' + item.top + ';left:' + item.left + ';width:' + item.width + ';height:' + item.height"
                        >
                            <img
                                x-show="item.image"
                                :src="item.image"
                                :alt="item.alt"
                                x-cloak
                                class="h-full w-full object-cover"
                            >
                            <div
                                x-show="!item.image"
                                x-cloak
                                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-400 to-brand-700 font-display text-5xl font-semibold text-white"
                                x-text="item.first"
                            ></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>
@endif
