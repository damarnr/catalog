@extends('layouts.app')

@section('title', 'Tentang - ' . ($site->brand_name ?: config('app.name')))

@section('content')
<div class="mx-auto max-w-3xl px-4 py-20 text-center">
    <p class="text-xs uppercase tracking-[0.3em] text-accent">Tentang kami</p>
    <h1 class="mt-4 font-display text-5xl leading-tight sm:text-7xl">{{ $site->brand_name ?: config('app.name') }}</h1>
    <div class="mx-auto mt-8 h-px w-16 bg-accent"></div>

    @if ($site->about)
        <div class="mt-10 whitespace-pre-line text-lg leading-loose text-stone-600">{{ $site->about }}</div>
    @else
        <p class="mt-10 text-stone-500">Cerita brand belum diisi.</p>
    @endif
</div>
@endsection