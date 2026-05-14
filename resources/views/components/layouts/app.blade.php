<!DOCTYPE html>
<html lang="es" data-theme="itibb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Sistema Académico del Instituto Tecnológico Industrial Brasil-Bolivia.">
    <link rel="icon" type="image/png" href="{{ asset('images/ITIBB.png') }}">
    <title>{{ $title ?? 'SisAcad' }} — ITI Brasil-Bolivia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-base-200 min-h-screen">

<div class="drawer lg:drawer-open">
    <input id="main-drawer" type="checkbox" class="drawer-toggle">

    {{-- TOPBAR: más alto con logo + texto a la izquierda --}}
    <div class="fixed top-0 left-0 right-0 z-50 h-16 shadow-md" style="background: linear-gradient(135deg, #1e4a82 0%, #0f2744 100%);">
        <div class="flex items-center justify-between h-full px-2 sm:px-4 max-w-full">
            <div class="flex items-center gap-2 sm:gap-3">
                <div class="flex-none lg:hidden">
                    <label for="main-drawer" class="btn btn-sm btn-square btn-ghost hover:bg-white/20 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-5 h-5 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </label>
                </div>
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" class="h-10 w-10 sm:h-11 sm:w-11 object-contain" alt="Logo">
                    <span class="font-bold text-white text-sm sm:text-base hidden sm:inline">Gestión Académica</span>
                </div>
            </div>

            <div class="flex-none flex items-center gap-1 sm:gap-3">
                {{-- Botón logout móvil (solo icono) --}}
                <form method="POST" action="{{ route('logout') }}" class="lg:hidden">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-ghost hover:bg-white/20 text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
                <div class="hidden md:block text-right">
                    <p class="text-xs text-white/70">{{ auth()->user()->nombre_completo }}</p>
                    <p class="text-[10px] font-medium
                        @if(auth()->user()->esAdmin()) text-blue-300
                        @elseif(auth()->user()->esDocente()) text-green-300
                        @else text-purple-300
                        @endif">
                        @if(auth()->user()->esAdmin()) Administrador
                        @elseif(auth()->user()->esDocente()) Docente
                        @else Estudiante
                        @endif
                    </p>
                </div>
                <div class="avatar">
                    @if(auth()->user()->esAdmin())
                    <div class="w-9 h-9 rounded-full ring-2 ring-white/30 overflow-hidden">
                        <img src="{{ asset('images/administracion.png') }}" alt="Admin" class="w-full h-full object-cover">
                    </div>
                    @elseif(auth()->user()->esDocente())
                    <div class="w-9 h-9 rounded-full ring-2 ring-white/30 overflow-hidden">
                        <img src="{{ asset('images/profesor-masculino.png') }}" alt="Docente" class="w-full h-full object-cover">
                    </div>
                    @else
                    <div class="w-9 h-9 rounded-full ring-2 ring-white/30 overflow-hidden">
                        <img src="{{ asset('images/estudiante-masculino.png') }}" alt="Estudiante" class="w-full h-full object-cover">
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="drawer-content flex flex-col min-h-screen pt-16">

        {{-- MAIN CONTENT --}}
        <main class="flex-1 min-h-[calc(100vh-64px)] relative">
            {{-- Marca de agua --}}
            <div class="absolute inset-0 pointer-events-none opacity-[0.08] overflow-hidden flex items-center justify-center">
                <img src="{{ asset('images/informatica.png') }}" class="w-[600px] max-w-none" alt="">
            </div>
            <div class="relative">
                @isset($header)
                    <div class="mb-6">{{ $header }}</div>
                @endisset
                {{ $slot }}
            </div>
        </main>
    </div>

    {{-- SIDEBAR: navegación responsive --}}
    <div class="drawer-side z-40">
        <label for="main-drawer" class="drawer-overlay"></label>
        <aside class="w-72 min-h-screen bg-white border-r border-gray-100 flex flex-col shadow-xl pt-16">

            {{-- Navegación --}}
            <ul class="menu p-3 flex-1 gap-1 overflow-y-auto">
                @if(auth()->user()->esAdmin())
                    <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-[#1a3a6b] text-white' : 'text-gray-700 font-medium hover:bg-[#1a3a6b]/10 hover:text-[#1a3a6b] transition-all duration-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                        Inicio
                    </a></li>
                    <li><a href="{{ route('admin.usuarios') }}" class="{{ request()->routeIs('admin.usuarios*') ? 'bg-[#1a3a6b] text-white' : 'text-gray-700 font-medium hover:bg-[#1a3a6b]/10 hover:text-[#1a3a6b] transition-all duration-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Usuarios
                    </a></li>
                    <li><a href="{{ route('admin.materias') }}" class="{{ request()->routeIs('admin.materias*') ? 'bg-[#1a3a6b] text-white' : 'text-gray-700 font-medium hover:bg-[#1a3a6b]/10 hover:text-[#1a3a6b] transition-all duration-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Materias
                    </a></li>
                    <li><a href="{{ route('admin.periodos') }}" class="{{ request()->routeIs('admin.periodos*') ? 'bg-[#1a3a6b] text-white' : 'text-gray-700 font-medium hover:bg-[#1a3a6b]/10 hover:text-[#1a3a6b] transition-all duration-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Períodos
                    </a></li>
                    <li><a href="{{ route('admin.asignaciones') }}" class="{{ request()->routeIs('admin.asignaciones*') ? 'bg-[#1a3a6b] text-white' : 'text-gray-700 font-medium hover:bg-[#1a3a6b]/10 hover:text-[#1a3a6b] transition-all duration-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        Asignaciones
                    </a></li>
                    <li><a href="{{ route('admin.inscripciones') }}" class="{{ request()->routeIs('admin.inscripciones*') ? 'bg-[#1a3a6b] text-white' : 'text-gray-700 font-medium hover:bg-[#1a3a6b]/10 hover:text-[#1a3a6b] transition-all duration-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Inscripciones
                    </a></li>
                    <li class="menu-title mt-4"><span class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Análisis</span></li>
                    <li><a href="#" class="text-gray-700 font-medium hover:bg-[#1a3a6b]/10 hover:text-[#1a3a6b] transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Reportes
                    </a></li>
                @elseif(auth()->user()->esDocente())
                    <li><a href="{{ route('docente.dashboard') }}" class="{{ request()->routeIs('docente.dashboard') ? 'bg-[#1a3a6b] text-white' : 'text-gray-700 font-medium hover:bg-[#1a3a6b]/10 hover:text-[#1a3a6b] transition-all duration-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                        Inicio
                    </a></li>
                    <li><a href="{{ route('docente.materias') }}" wire:navigate class="{{ request()->routeIs('docente.materias*') ? 'bg-[#1a3a6b] text-white' : 'text-gray-700 font-medium hover:bg-[#1a3a6b]/10 hover:text-[#1a3a6b] transition-all duration-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Mis materias
                    </a></li>
                    <li><a href="#" class="text-gray-700 font-medium hover:bg-[#1a3a6b]/10 hover:text-[#1a3a6b] transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Notas
                    </a></li>
                    <li><a href="#" class="text-gray-700 font-medium hover:bg-[#1a3a6b]/10 hover:text-[#1a3a6b] transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        Asistencia
                    </a></li>
                    <li class="menu-title mt-4"><span class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Asistente IA</span></li>
                    <li><a href="#" class="text-gray-700 font-medium hover:bg-[#1a3a6b]/10 hover:text-[#1a3a6b] transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Agente IA
                    </a></li>
                @else
                    <li><a href="{{ route('estudiante.dashboard') }}" class="{{ request()->routeIs('estudiante.dashboard') ? 'bg-[#1a3a6b] text-white' : 'text-gray-700 font-medium hover:bg-[#1a3a6b]/10 hover:text-[#1a3a6b] transition-all duration-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Mi rendimiento
                    </a></li>
                    <li><a href="#" class="text-gray-700 font-medium hover:bg-[#1a3a6b]/10 hover:text-[#1a3a6b] transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Mis notas
                    </a></li>
                    <li><a href="#" class="text-gray-700 font-medium hover:bg-[#1a3a6b]/10 hover:text-[#1a3a6b] transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Mi asistencia
                    </a></li>
                    <li class="menu-title mt-4"><span class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">Asistente IA</span></li>
                    <li><a href="#" class="text-gray-700 font-medium hover:bg-[#1a3a6b]/10 hover:text-[#1a3a6b] transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Comunicados IA
                    </a></li>
                @endif
            </ul>

            {{-- Footer: logout solo visible en tablet/PC (lg+) --}}
            <div class="hidden lg:block p-3 border-t border-gray-100">
                <button onclick="document.getElementById('logout-modal').showModal()" class="flex items-center gap-3 w-full px-3 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition-all">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Cerrar sesión</span>
                </button>
            </div>

            {{-- Modal de confirmación de logout --}}
            <dialog id="logout-modal" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box bg-white">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-800">¿Salir del sistema?</h3>
                            <p class="text-sm text-gray-500">Tu sesión será cerrada</p>
                        </div>
                    </div>
                    <div class="modal-action">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn bg-red-600 text-white hover:bg-red-700">Sí, salir</button>
                        </form>
                        <button class="btn btn-ghost" onclick="document.getElementById('logout-modal').close()">Cancelar</button>
                    </div>
                </div>
                <form method="dialog" class="modal-backdrop bg-black/50">
                    <button>close</button>
                </form>
            </dialog>
        </aside>
    </div>
</div>

@livewireScripts
</body>
</html>