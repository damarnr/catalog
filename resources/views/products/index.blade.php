@extends('layouts.app')

@section('title', 'Koleksi - ' . ($site->brand_name ?: config('app.name')))

@section('content')
<div class="mx-auto max-w-7xl px-4 pt-16">
    <div class="text-center">
        <h1 class="font-display text-5xl sm:text-6xl">Koleksi</h1>
        <p class="mt-2 text-xs uppercase tracking-[0.2em] text-stone-500">{{ $products->total() }} produk</p>
    </div>

    <div class="mt-10 flex flex-col gap-5 border-y border-stone-200 py-4 md:flex-row md:items-center md:justify-between">
        <div class="flex flex-wrap gap-x-6 gap-y-2 text-[13px] tracking-wide">
            <a href="{{ route('products.index', array_filter(['q' => request('q')])) }}"
               class="border-b pb-0.5 {{ ! request('category') ? 'border-accent text-accent' : 'border-transparent hover:text-accent' }}">Semua</a>
            @foreach ($categories as $category)
                <a href="{{ route('products.index', array_filter(['category' => $category->slug, 'q' => request('q')])) }}"
                   class="border-b pb-0.5 {{ request('category') === $category->slug ? 'border-accent text-accent' : 'border-transparent hover:text-accent' }}">{{ $category->name }}</a>
            @endforeach
        </div>

        <form method="GET" class="flex">
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk"
                   class="w-full border-0 border-b border-stone-300 bg-transparent px-1 py-1.5 text-sm placeholder-stone-400 focus:border-accent focus:outline-none focus:ring-0 md:w-56">
            <button class="px-3 text-xs uppercase tracking-[0.15em] hover:text-accent">Cari</button>
        </form>
    </div>

    @if ($products->isEmpty())
        <p class="mt-20 text-center text-stone-500">Produk tidak ditemukan.</p>
    @else
        <div class="mt-12 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4">
            @foreach ($products as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
        <div class="mt-14">{{ $products->links() }}</div>
    @endif
</div>
@endsection