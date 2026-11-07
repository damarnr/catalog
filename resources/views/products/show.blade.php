@extends('layouts.app')

@section('title', $product->name . ' - ' . ($site->brand_name ?: config('app.name')))

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10">
    <a href="{{ route('products.index') }}" class="text-xs uppercase tracking-[0.2em] text-stone-500 hover:text-accent">&larr; Koleksi</a>

    <div class="mt-8 grid gap-12 md:grid-cols-2 lg:gap-20">
        {{-- Foto --}}
        <div class="grid grid-cols-2 gap-3">
            @forelse ($product->images ?? [] as $image)
                <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}"
                     class="w-full bg-stone-100 object-cover {{ $loop->first ? 'col-span-2 aspect-[3/4]' : 'aspect-square' }}">
            @empty
                <div class="col-span-2 flex aspect-[3/4] items-center justify-center bg-stone-100 text-xs tracking-widest text-stone-400">
                    Tanpa foto
                </div>
            @endforelse
        </div>

        {{-- Info --}}
        <div class="self-start md:sticky md:top-28">
            <p class="text-xs uppercase tracking-[0.25em] text-stone-500">{{ $product->category?->name }}</p>
            <h1 class="mt-3 font-display text-4xl leading-tight sm:text-5xl">{{ $product->name }}</h1>
            <p class="mt-4 text-xl text-stone-700">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

            @if (!empty($product->sizes))
                <div class="mt-9">
                    <p class="text-xs uppercase tracking-[0.2em] text-stone-900">Ukuran</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($product->sizes as $size)
                            <span class="min-w-[3rem] border border-stone-300 px-4 py-2 text-center text-sm">{{ $size }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (!empty($product->colors))
                <div class="mt-6">
                    <p class="text-xs uppercase tracking-[0.2em] text-stone-900">Warna</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($product->colors as $color)
                            <span class="border border-stone-300 px-4 py-2 text-sm">{{ $color }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($product->description)
                <div class="mt-9 whitespace-pre-line border-t border-stone-200 pt-7 leading-relaxed text-stone-600">{{ $product->description }}</div>
            @endif

            @if ($site->whatsapp)
                @php
                    $waNumber = preg_replace('/\D/', '', $site->whatsapp);
                    $waText = urlencode('Halo, saya tertarik dengan produk ' . $product->name);
                @endphp
                <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank"
                   class="mt-10 flex w-full items-center justify-center bg-stone-900 py-4 text-xs uppercase tracking-[0.2em] text-white transition hover:bg-accent">
                    Pesan via WhatsApp
                </a>
            @endif
        </div>
    </div>

    @if ($related->isNotEmpty())
        <section class="mt-28">
            <h2 class="text-center font-display text-3xl sm:text-4xl">Mungkin kamu suka</h2>
            <div class="mt-10 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4">
                @foreach ($related as $item)
                    @include('partials.product-card', ['product' => $item])
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection