<!DOCTYPE html>
<html lang="es" data-theme="itibb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Sistema Académico del Instituto Tecnológico Industrial Brasil-Bolivia.">
    <title>{{ $title ?? 'SisAcad' }} — ITI Brasil-Bolivia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-base-200 min-h-screen">

<div class="drawer lg:drawer-open">
    <input id="main-drawer" type="checkbox" class="drawer-toggle">

    <div class="drawer-content flex flex-col">

        {{-- TOPBAR --}}
        <div class="navbar text-white sticky top-0 z-30 shadow-lg" style="background: linear-gradient(135deg, #1a3a6b 0%, #0f2744 100%);">
            <div class="flex-none lg:hidden">
                <label for="main-drawer" class="btn btn-ghost btn-sm hover:bg-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="w-5 h-5 stroke-current"><path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </label>
            </div>
            <div class="flex-1 items-center gap-3">
                <div class="flex items-center gap-2">
                    <div class="avatar">
                        <div class="w-9 h-9 rounded-xl bg-white/10 ring-2 ring-white/20 shadow-sm">
                            <img src="{{ asset('images/ITIBB.png') }}" class="object-contain p-1">
                        </div>
                    </div>
                    <div class="avatar">
                        <div class="w-9 h-9 rounded-xl bg-white/10 ring-2 ring-white/20 shadow-sm">
                            <img src="{{ asset('images/informatica.png') }}" class="object-contain p-1">
                        </div>
                    </div>
                </div>
                <div class="hidden sm:block">
                    <span class="font-display font-bold text-base tracking-tight">Sistema Académico</span>
                    <span class="block text-[10px] text-white/60 font-body">Instituto Tecnológico Industrial Brasil-Bolivia</span>
                </div>
            </div>
            <div class="flex items-center gap-4 pr-4">
                <div class="text-right hidden sm:block">
                    <p class="text-xs text-white/60 font-body">{{ ucfirst(auth()->user()->rol) }}</p>
                    <p class="text-sm font-semibold text-white leading-tight">{{ auth()->user()->nombre_completo }}</p>
                </div>
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle hover:bg-white/10">
                        <div class="avatar placeholder">
                            <div class="bg-secondary text-white w-10 rounded-xl font-bold shadow-sm ring-2 ring-white/20 flex items-center justify-center">
                                <span class="text-sm">{{ auth()->user()->iniciales }}</span>
                            </div>
                        </div>
                    </label>
                    <ul tabindex="0" class="dropdown-content z-[100] menu p-2 shadow-xl bg-white rounded-xl w-52 mt-2 border border-gray-100">
                        <li class="menu-title px-1 py-2">
                            <span class="text-xs text-gray-500">{{ auth()->user()->ci }}</span>
                        </li>
                        <div class="divider my-1"></div>
                        <li><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="text-error hover:bg-error/10 rounded-lg"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>Salir</button></form></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- CONTENIDO --}}
        <main class="flex-1 p-4 md:p-6 lg:p-8">
            @isset($header)
                <div class="mb-6 animate-fade-in">
                    {{ $header }}
                </div>
            @endisset
            {{ $slot }}
        </main>

    </div>

    {{-- SIDEBAR --}}
    <div class="drawer-side z-40">
        <label for="main-drawer" class="drawer-overlay"></label>
        <aside class="w-64 min-h-full bg-white border-r border-gray-100 flex flex-col shadow-xl">

            {{-- Logo --}}
            <div class="flex items-center gap-3 px-4 py-5 border-b border-gray-100 bg-gradient-to-r from-primary to-brand-800">
                <div class="avatar">
                    <div class="w-10 h-10 rounded-xl bg-white ring-2 ring-white/40 shadow-sm">
                        <img src="{{ asset('images/ITIBB.png') }}" class="object-contain p-1.5">
                    </div>
                </div>
                <div class="avatar">
                    <div class="w-10 h-10 rounded-xl bg-white ring-2 ring-white/40 shadow-sm">
                        <img src="{{ asset('images/informatica.png') }}" class="object-contain p-1.5">
                    </div>
                </div>
                <div>
                    <p class="font-display font-bold text-white text-base leading-tight">SisAcad</p>
                    <p class="text-[10px] text-white/70 font-body">ITI Brasil-Bolivia</p>
                </div>
            </div>

            {{-- Navegación --}}
            <ul class="menu p-3 flex-1 gap-1">
                @if(auth()->user()->esAdmin())
                    <li class="menu-title mt-2"><span class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Gestión</span></li>
                    <li><a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }} nav-item">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        Dashboard</a></li>
                    <li><a href="{{ route('admin.usuarios') }}" class="{{ request()->routeIs('admin.usuarios*') ? 'active' : '' }} nav-item">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/></svg>
                        Usuarios</a></li>
                    <li><a href="{{ route('admin.materias') }}" class="{{ request()->routeIs('admin.materias*') ? 'active' : '' }} nav-item">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Materias</a></li>
                    <li><a href="{{ route('admin.periodos') }}" class="{{ request()->routeIs('admin.periodos*') ? 'active' : '' }} nav-item">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Períodos</a></li>
                    <li><a href="{{ route('admin.asignaciones') }}" class="{{ request()->routeIs('admin.asignaciones*') ? 'active' : '' }} nav-item">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101"/></svg>
                        Asignaciones</a></li>
                    <li><a href="{{ route('admin.inscripciones') }}" class="{{ request()->routeIs('admin.inscripciones*') ? 'active' : '' }} nav-item">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        Inscripciones</a></li>
                    <li class="menu-title mt-4"><span class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Análisis</span></li>
                    <li><a href="#" class="nav-item">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Reportes</a></li>
                @elseif(auth()->user()->esDocente())
                    <li class="menu-title mt-2"><span class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Docente</span></li>
                    <li><a href="{{ route('docente.dashboard') }}"
                        class="{{ request()->routeIs('docente.dashboard') ? 'active' : '' }} nav-item">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        Dashboard</a></li>
                    <li><a href="{{ route('docente.materias') }}" wire:navigate class="{{ request()->routeIs('docente.materias*') ? 'active' : '' }} nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>Mis materias</a></li>
                    <li><a href="#" class="nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>Notas</a></li>
                    <li><a href="#" class="nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>Asistencia</a></li>
                    <li class="menu-title mt-4"><span class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Asistente IA</span></li>
                    <li><a href="#" class="nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>Agente IA</a></li>
                @else
                    <li class="menu-title mt-2"><span class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Estudiante</span></li>
                    <li><a href="{{ route('estudiante.dashboard') }}"
                        class="{{ request()->routeIs('estudiante.dashboard') ? 'active' : '' }} nav-item">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        Mi rendimiento</a></li>
                    <li><a href="#" class="nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>Mis notas</a></li>
                    <li><a href="#" class="nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>Mi asistencia</a></li>
                    <li class="menu-title mt-4"><span class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Asistente IA</span></li>
                    <li><a href="#" class="nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>Comunicados IA</a></li>
                @endif
            </ul>

            {{-- Footer con user info --}}
            <div class="p-3 border-t border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-gray-100/50">
                    <div class="avatar placeholder">
                        <div class="bg-primary text-white w-8 rounded-lg font-bold flex items-center justify-center text-xs">
                            {{ auth()->user()->iniciales }}
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-800 truncate">{{ auth()->user()->nombre_completo }}</p>
                        <p class="text-[10px] text-gray-500 truncate">{{ auth()->user()->ci }}</p>
                    </div>
                </div>
            </div>

        </aside>
    </div>
</div>

@livewireScripts
</body>
</html>
