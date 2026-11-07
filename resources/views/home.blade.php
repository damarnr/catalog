@extends('layouts.app')

@section('content')
    {{-- Hero / banner slider --}}
    @if ($banners->isNotEmpty())
        <section x-data="{
                    i: 0,
                    n: {{ $banners->count() }},
                    startX: 0,
                    next() { this.i = (this.i + 1) % this.n },
                    prev() { this.i = (this.i - 1 + this.n) % this.n },
                 }"
                 x-init="if (n > 1) setInterval(() => next(), 6000)"
                 @touchstart.passive="startX = $event.touches[0].clientX"
                 @touchend.passive="let d = $event.changedTouches[0].clientX - startX; if (Math.abs(d) > 50) { d < 0 ? next() : prev() }"
                 class="relative aspect-[4/5] w-full overflow-hidden bg-stone-200 sm:aspect-[16/9] lg:aspect-[16/7]">

            @foreach ($banners as $index => $banner)
                <div x-show="i === {{ $index }}"
                     x-transition.opacity.duration.1000ms
                     @if ($index > 0) style="display:none" @endif
                     class="absolute inset-0">
                    <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}"
                         class="absolute inset-0 h-full w-full object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>

                    <div class="relative mx-auto flex h-full max-w-7xl flex-col items-center justify-end px-4 pb-16 text-center text-white sm:pb-20">
                        <h1 class="max-w-3xl font-display text-5xl leading-[1.05] sm:text-6xl lg:text-7xl">{{ $banner->title }}</h1>
                        @if ($banner->subtitle)
                            <p class="mt-4 max-w-md text-sm tracking-wide text-white/90">{{ $banner->subtitle }}</p>
                        @endif
                        <a href="{{ $banner->link ?: route('products.index') }}"
                           class="mt-7 inline-block border border-white px-8 py-3 text-xs uppercase tracking-[0.2em] transition hover:bg-white hover:text-stone-900">
                            Lihat Koleksi
                        </a>
                    </div>
                </div>
            @endforeach

            @if ($banners->count() > 1)
                <div class="absolute bottom-5 left-1/2 flex -translate-x-1/2 gap-2">
                    @foreach ($banners as $index => $banner)
                        <button @click="i = {{ $index }}" aria-label="Banner {{ $index + 1 }}"
                                :class="i === {{ $index }} ? 'bg-white' : 'bg-white/40'"
                                class="h-1.5 w-1.5 rounded-full"></button>
                    @endforeach
                </div>
            @endif
        </section>
    @else
        <section class="px-4 py-28 text-center sm:py-40">
            <h1 class="font-display text-6xl sm:text-8xl">{{ $site->brand_name ?: config('app.name') }}</h1>
            <a href="{{ route('products.index') }}" class="mt-10 inline-block bg-stone-900 px-8 py-3 text-xs uppercase tracking-[0.2em] text-white transition hover:bg-accent">Lihat Koleksi</a>
        </section>
    @endif

    {{-- Kategori --}}
    @if ($categories->isNotEmpty())
        <section class="mx-auto mt-24 max-w-7xl px-4 text-center">
            <p class="text-xs uppercase tracking-[0.3em] text-stone-500">Jelajahi</p>
            <h2 class="mt-2 font-display text-4xl sm:text-5xl">Kategori</h2>
            <div class="mt-10 grid grid-cols-2 gap-4 md:grid-cols-4">
                @foreach ($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                       class="flex aspect-[4/3] items-center justify-center border border-stone-300 transition hover:border-stone-900 hover:bg-stone-900 hover:text-white">
                        <span class="font-display text-2xl">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Produk unggulan --}}
    <section class="mx-auto mt-24 max-w-7xl px-4">
        <div class="text-center">
            <p class="text-xs uppercase tracking-[0.3em] text-stone-500">Pilihan kami</p>
            <h2 class="mt-2 font-display text-4xl sm:text-5xl">Produk Unggulan</h2>
        </div>
        @if ($featured->isEmpty())
            <p class="mt-10 text-center text-stone-500">Belum ada produk unggulan.</p>
        @else
            <div class="mt-12 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4">
                @foreach ($featured as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        @endif
        <div class="mt-12 text-center">
            <a href="{{ route('products.index') }}" class="border-b border-stone-900 pb-0.5 text-xs uppercase tracking-[0.2em] hover:border-accent hover:text-accent">Lihat semua koleksi</a>
        </div>
    </section>
@endsection