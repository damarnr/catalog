<!DOCTYPE html>
<html lang="id" class="bg-[#FAF8F4]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $site->brand_name ?: config('app.name'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Pakai salah satu: build Vite ATAU CDN --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <style>
        :root { --accent: #8A6F3D; --ink: #1C1917; --paper: #FAF8F4; }
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', system-ui, sans-serif; background: var(--paper); color: var(--ink); }
        .font-display { font-family: 'Cormorant Garamond', Georgia, 'Times New Roman', serif; font-weight: 500; letter-spacing: -0.01em; }

        .bg-accent { background-color: var(--accent); }
        .text-accent { color: var(--accent); }
        .border-accent { border-color: var(--accent); }
        .hover\:bg-accent:hover { background-color: var(--accent); }
        .hover\:text-accent:hover { color: var(--accent); }
        .focus\:border-accent:focus { border-color: var(--accent); }
        .group:hover .group-hover\:text-accent { color: var(--accent); }
        ::selection { background: var(--accent); color: #fff; }
    </style>
</head>
<body class="antialiased">

@php
    $brand = $site->brand_name ?: config('app.name');
    $nav = [
        ['Beranda', 'home', 'home'],
        ['Koleksi', 'products.index', 'products.*'],
        ['Tentang', 'about', 'about'],
    ];
@endphp

@if ($site->tagline)
    <div class="bg-stone-900 px-4 py-2 text-center text-[11px] uppercase tracking-[0.2em] text-stone-200">
        {{ $site->tagline }}
    </div>
@endif

<header x-data="{ open: false }" class="sticky top-0 z-50 border-b border-stone-200 bg-[#FAF8F4]/95 backdrop-blur">
    <div class="mx-auto grid max-w-7xl grid-cols-3 items-center px-4 py-5">
        <nav class="hidden items-center gap-8 md:flex">
            @foreach ($nav as [$label, $route, $pattern])
                <a href="{{ route($route) }}"
                   class="border-b pb-0.5 text-[13px] tracking-wide transition hover:text-accent {{ request()->routeIs($pattern) ? 'border-accent text-accent' : 'border-transparent' }}">
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        <button @click="open = !open" class="justify-self-start md:hidden" aria-label="Menu">
            <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 8h16M4 16h16"/></svg>
            <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
        </button>

        <a href="{{ route('home') }}" class="justify-self-center">
            @if ($site->logo)
                <img src="{{ asset('storage/' . $site->logo) }}" alt="{{ $brand }}" class="h-9 w-auto">
            @else
                <span class="font-display text-3xl">{{ $brand }}</span>
            @endif
        </a>

        <div class="justify-self-end">
            @if ($site->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/\D/', '', $site->whatsapp) }}" target="_blank"
                   class="text-[13px] tracking-wide hover:text-accent">Hubungi</a>
            @endif
        </div>
    </div>

    <nav x-show="open" x-cloak class="border-t border-stone-200 px-4 py-4 md:hidden">
        @foreach ($nav as [$label, $route, $pattern])
            <a href="{{ route($route) }}" class="block py-2 font-display text-3xl hover:text-accent">{{ $label }}</a>
        @endforeach
    </nav>
</header>

<main>
    @yield('content')
</main>

<footer class="mt-28 border-t border-stone-200">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 text-sm text-stone-600 md:grid-cols-3">
        <div>
            <p class="font-display text-3xl text-stone-900">{{ $brand }}</p>
            @if ($site->tagline)
                <p class="mt-3 max-w-xs leading-relaxed">{{ $site->tagline }}</p>
            @endif
        </div>
        <div class="space-y-2">
            <p class="text-xs uppercase tracking-[0.2em] text-stone-900">Menu</p>
            @foreach ($nav as [$label, $route, $pattern])
                <a href="{{ route($route) }}" class="block hover:text-accent">{{ $label }}</a>
            @endforeach
        </div>
        <div class="space-y-2">
            <p class="text-xs uppercase tracking-[0.2em] text-stone-900">Kontak</p>
            @if ($site->address)<p>{{ $site->address }}</p>@endif
            @if ($site->email)<a href="mailto:{{ $site->email }}" class="block hover:text-accent">{{ $site->email }}</a>@endif
            @if ($site->whatsapp)<a href="https://wa.me/{{ preg_replace('/\D/', '', $site->whatsapp) }}" target="_blank" class="block hover:text-accent">WhatsApp</a>@endif
            @if ($site->instagram)<a href="https://instagram.com/{{ ltrim($site->instagram, '@') }}" target="_blank" class="block hover:text-accent">Instagram</a>@endif
        </div>
    </div>
    <p class="border-t border-stone-200 py-5 text-center text-xs text-stone-500">&copy; {{ date('Y') }} {{ $brand }}</p>
</footer>

</body>
</html>