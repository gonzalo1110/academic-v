<div class="p-4 md:p-6 lg:p-8 animate-fade-in">

    {{-- Header con gradiente --}}
    <div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="font-display text-2xl font-bold text-white">Dashboard</h2>
            <p class="text-white/80 mt-1">Panel de control para la gestión académica</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium bg-white/20 text-white border border-white/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Período: {{ $this->stats['periodo_activo'] ?? 'Ninguno' }}
            </span>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8 animate-slide-up animate-delay-100">
        {{-- Total Usuarios --}}
        <div class="card-elevated p-4 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-[#1a3a6b]/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#1a3a6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">Total</span>
            </div>
            <div class="text-3xl font-bold text-[#1a3a6b] mb-1">{{ $this->stats['usuarios'] ?? 0 }}</div>
            <div class="text-sm text-gray-500">Usuarios Totales</div>
        </div>

        {{-- Estudiantes --}}
        <div class="card-elevated p-4 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">Registrados</span>
            </div>
            <div class="text-3xl font-bold text-green-600 mb-1">{{ $this->stats['estudiantes'] ?? 0 }}</div>
            <div class="text-sm text-gray-500">Estudiantes</div>
        </div>

        {{-- Docentes --}}
        <div class="card-elevated p-4 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">Activos</span>
            </div>
            <div class="text-3xl font-bold text-blue-600 mb-1">{{ $this->stats['docentes'] ?? 0 }}</div>
            <div class="text-sm text-gray-500">Docentes</div>
        </div>

        {{-- Materias --}}
        <div class="card-elevated p-4 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">Plan</span>
            </div>
            <div class="text-3xl font-bold text-amber-600 mb-1">{{ $this->stats['materias'] ?? 0 }}</div>
            <div class="text-sm text-gray-500">Materias</div>
        </div>
    </div>

    {{-- Accesos Rápidos y Estado IA --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-slide-up animate-delay-200">
        {{-- Accesos Rápidos --}}
        <div class="card-elevated p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-[#1a3a6b]/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#1a3a6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Accesos Rápidos</h3>
                    <p class="text-xs text-gray-500">Gestiona el sistema desde aquí</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.usuarios') }}" class="bg-gradient-to-r from-[#1a3a6b] to-[#2563eb] text-white font-medium px-4 py-2 rounded-lg hover:shadow-lg transition-all text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                    </svg>
                    Usuarios
                </a>
                <a href="#" class="bg-gray-100 text-gray-700 font-medium px-4 py-2 rounded-lg hover:bg-gray-200 transition-all text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Importar
                </a>
                <a href="{{ route('admin.periodos') }}" class="bg-gray-100 text-gray-700 font-medium px-4 py-2 rounded-lg hover:bg-gray-200 transition-all text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Períodos
                </a>
                <a href="#" class="bg-gray-100 text-gray-700 font-medium px-4 py-2 rounded-lg hover:bg-gray-200 transition-all text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                    </svg>
                    Backup
                </a>
            </div>
        </div>

        {{-- Estado IA --}}
        <div class="card-elevated p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Estado de Inteligencia Artificial</h3>
                    <p class="text-xs text-gray-500">Conexión con Ollama SLM</p>
                </div>
            </div>
            <div class="space-y-3">
                @if($this->iaStatus['disponible'] ?? false)
                    <div class="flex items-center gap-3 p-3 bg-green-50 rounded-xl border border-green-200">
                        <span class="w-3 h-3 rounded-full bg-green-500 animate-pulse"></span>
                        <span class="text-gray-700">Servidor Ollama: <strong class="text-green-700">Activo</strong></span>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                        <span class="text-gray-600">Modelo: <strong class="text-[#1a3a6b]">{{ $this->iaStatus['modelo'] }}</strong></span>
                        @if(!empty($this->iaStatus['modelos']))
                            <p class="text-xs text-gray-400 mt-1">Modelos disponibles: {{ implode(', ', $this->iaStatus['modelos']) }}</p>
                        @endif
                    </div>
                @else
                    <div class="flex items-center gap-3 p-3 bg-red-50 rounded-xl border border-red-200">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span>
                        <span class="text-gray-700">Servidor Ollama: <strong class="text-red-700">Inactivo</strong></span>
                    </div>
                    <div class="p-3 bg-amber-50 rounded-xl border border-amber-200">
                        <p class="text-sm text-amber-700">Para activar Ollama, ejecuta:</p>
                        <code class="text-xs text-amber-800 block mt-1">ollama serve</code>
                        <code class="text-xs text-amber-800 block">ollama pull qwen2.5:3b</code>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>