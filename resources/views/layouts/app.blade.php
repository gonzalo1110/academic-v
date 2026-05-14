<!DOCTYPE html>
<html lang="es" data-theme="itibb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Sistema Académico del Instituto Tecnológico Industrial Brasil-Bolivia. Gestión de estudiantes, docentes, materias, notas y más.">
    <meta name="robots" content="noindex, nofollow">
    <link rel="canonical" href="{{ url()->current() }}">
    <title>{{ $title ?? 'SisAcad' }} — ITI Brasil-Bolivia</title>

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "EducationalOrganization",
      "name": "Instituto Tecnológico Industrial Brasil-Bolivia",
      "alternateName": "ITIBB",
      "url": "https://iti-bb.edu.bo",
      "description": "Institución educativa técnica niveles medio y superior",
      "address": {
        "@type": "PostalAddress",
        "addressCountry": "BO",
        "addressLocality": "Santa Cruz de la Sierra"
      }
    }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans antialiased">

    {{-- TOPBAR --}}
    <header class="bg-[#1a3a6b] h-14 flex items-center px-4 gap-3 fixed top-0 left-0 right-0 z-50">

        {{-- Logos: solo aquí, no se repiten en sidebar --}}
        <div class="flex items-center gap-2 flex-shrink-0">
            <div class="w-9 h-9 rounded-full bg-white flex items-center justify-center overflow-hidden border border-white/30">
                <img src="{{ asset('images/ITIBB.png') }}" alt="ITIBB" class="w-8 h-8 object-contain">
            </div>
            <div class="w-9 h-9 rounded-full bg-white flex items-center justify-center overflow-hidden border border-white/30">
                <img src="{{ asset('images/informatica.png') }}" alt="Informática" class="w-8 h-8 object-contain">
            </div>
        </div>

        {{-- Nombre del sistema --}}
        <div class="flex-1 min-w-0">
            <p class="text-white text-sm font-semibold leading-tight truncate">Sistema Académico</p>
            <p class="text-white/60 text-xs truncate">Instituto Tecnológico Industrial Brasil-Bolivia</p>
        </div>

        {{-- Usuario: nombre + rol + avatar (solo aquí, no en sidebar) --}}
        <div class="flex items-center gap-2 flex-shrink-0">
            <div class="text-right hidden sm:block">
                <p class="text-white text-xs font-medium leading-tight">{{ auth()->user()->nombre_completo }}</p>
                <p class="text-white/60 text-[10px]">{{ ucfirst(auth()->user()->rol) }}</p>
            </div>
            <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold border border-white/30 flex-shrink-0">
                {{ auth()->user()->iniciales }}
            </div>
        </div>
    </header>

    <div class="flex pt-14 min-h-screen">

        {{-- SIDEBAR: sin logos, sin nombre de usuario --}}
        <aside class="w-48 bg-white border-r border-gray-200 fixed left-0 top-14 bottom-0 flex flex-col z-40">

            {{-- Solo muestra el rol como etiqueta de sección, sin repetir nombre ni avatar --}}
            <div class="mx-3 mt-3 mb-1 bg-blue-50 rounded-md px-3 py-1.5">
                <span class="text-[10px] text-[#1a3a6b] font-semibold uppercase tracking-wider">
                    {{ ucfirst(auth()->user()->rol) }}
                </span>
            </div>

            {{-- Navegación --}}
            <nav class="flex-1 overflow-y-auto py-2">
                @include('layouts.nav.' . auth()->user()->rol)
            </nav>

            {{-- Pie del sidebar: logout --}}
            <div class="border-t border-gray-100 p-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 w-full px-3 py-2 text-sm text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Cerrar sesión</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- CONTENIDO --}}
        <main class="flex-1 ml-48 flex flex-col min-h-screen">
            @isset($header)
            <div class="bg-white border-b border-gray-200 px-6 py-3">
                {{ $header }}
            </div>
            @endisset

            <div class="flex-1 p-5">
                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts
</body>
</html>