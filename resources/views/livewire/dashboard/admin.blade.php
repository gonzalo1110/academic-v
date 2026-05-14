<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-[#1a3a6b]">Resumen del Sistema</h2>
            <p class="text-sm text-gray-500 mt-1">Panel de control para la gestión académica</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="badge badge-primary badge-outline">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Periodo: {{ $stats['periodo_activo'] }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="card bg-white shadow-lg rounded-xl border border-gray-100">
            <div class="card-body p-4">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 rounded-lg bg-[#1a3a6b]/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#1a3a6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Total</span>
                </div>
                <div class="text-2xl font-bold text-gray-800">{{ $stats['usuarios'] }}</div>
                <div class="text-xs text-gray-500">Usuarios Totales</div>
            </div>
        </div>

        <div class="card bg-white shadow-lg rounded-xl border border-gray-100">
            <div class="card-body p-4">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 rounded-lg bg-secondary/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Registrados</span>
                </div>
                <div class="text-2xl font-bold text-gray-800">{{ $stats['estudiantes'] }}</div>
                <div class="text-xs text-gray-500">Estudiantes</div>
            </div>
        </div>

        <div class="card bg-white shadow-lg rounded-xl border border-gray-100">
            <div class="card-body p-4">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 rounded-lg bg-accent/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Activos</span>
                </div>
                <div class="text-2xl font-bold text-gray-800">{{ $stats['docentes'] }}</div>
                <div class="text-xs text-gray-500">Docentes</div>
            </div>
        </div>

        <div class="card bg-white shadow-lg rounded-xl border border-gray-100">
            <div class="card-body p-4">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 rounded-lg bg-info/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Plan</span>
                </div>
                <div class="text-2xl font-bold text-gray-800">{{ $stats['materias'] }}</div>
                <div class="text-xs text-gray-500">Materias</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card bg-white shadow-lg rounded-xl border border-gray-100">
            <div class="card-body p-5">
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Accesos Rápidos</h3>
                <p class="text-xs text-gray-500 mb-4">Gestiona el sistema desde aquí</p>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.usuarios') }}" class="btn btn-primary btn-sm gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                        </svg>
                        Usuarios
                    </a>
                    <a href="#" class="btn btn-ghost btn-sm gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Importar
                    </a>
                    <a href="{{ route('admin.periodos') }}" class="btn btn-ghost btn-sm gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Periodos
                    </a>
                    <a href="#" class="btn btn-ghost btn-sm gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                        </svg>
                        Backup
                    </a>
                </div>
            </div>
        </div>

        <div class="card bg-white shadow-lg rounded-xl border border-gray-100">
            <div class="card-body p-5">
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Estado de Inteligencia Artificial</h3>
                <p class="text-xs text-gray-500 mb-4">Conexión con Ollama SLM</p>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-success"></span>
                        <span class="text-gray-600">Servidor Ollama: <strong class="text-success">Activo</strong></span>
                    </div>
                    <div class="text-gray-600">
                        Modelo: <strong>qwen2.5:3b</strong> (Optimizado para i5 7ma Gen)
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>