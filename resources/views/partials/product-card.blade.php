@php
    $second = !empty($product->images[1]) ? asset('storage/' . $product->images[1]) : null;
@endphp

<a href="{{ route('products.show', $product) }}" class="group block">
    <div class="relative aspect-[3/4] overflow-hidden bg-stone-100">
        @if ($product->thumbnail)
            <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}"
                 class="h-full w-full object-cover transition duration-700 {{ $second ? 'group-hover:opacity-0' : 'group-hover:scale-105' }}">
            @if ($second)
                <img src="{{ $second }}" alt="{{ $product->name }}"
                     class="absolute inset-0 h-full w-full object-cover opacity-0 transition duration-700 group-hover:opacity-100">
            @endif
        @else
            <div class="flex h-full items-center justify-center text-xs tracking-widest text-stone-400">Tanpa foto</div>
        @endif

        @if ($product->is_featured)
            <span class="absolute left-3 top-3 bg-[#FAF8F4] px-2.5 py-1 text-[10px] uppercase tracking-[0.15em] text-stone-800">Unggulan</span>
        @endif
    </div>

    <div class="mt-4 text-center">
        <p class="text-[11px] uppercase tracking-[0.2em] text-stone-500">{{ $product->category?->name }}</p>
        <h3 class="mt-1.5 text-[15px] transition group-hover:text-accent">{{ $product->name }}</h3>
        <p class="mt-1 text-sm text-stone-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
    </div>
</a>