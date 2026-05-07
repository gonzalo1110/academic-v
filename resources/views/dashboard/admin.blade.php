<x-layouts.app title="Panel Administrativo">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-display text-2xl font-bold text-gray-800">Panel Administrativo</h2>
                <p class="text-sm text-gray-500 mt-1">Bienvenido, {{ auth()->user()->nombre_completo }}</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="badge badge-primary badge-outline">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ now()->format('d M Y') }}
                </span>
            </div>
        </div>
    </x-slot>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8 animate-slide-up">
        <div class="stat-card group cursor-pointer">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-primary/10 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-primary/60 bg-primary/10 px-2 py-1 rounded-full">Total</span>
                </div>
                <div class="stat-value text-3xl font-bold text-gray-800 mb-1">0</div>
                <div class="text-sm font-medium text-gray-600">Estudiantes</div>
                <div class="text-xs text-gray-400 mt-1">registrados</div>
            </div>
        </div>

        <div class="stat-card group cursor-pointer">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-secondary/10 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-secondary/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-secondary/60 bg-secondary/10 px-2 py-1 rounded-full">Activos</span>
                </div>
                <div class="stat-value text-3xl font-bold text-gray-800 mb-1">0</div>
                <div class="text-sm font-medium text-gray-600">Docentes</div>
                <div class="text-xs text-gray-400 mt-1">en actividad</div>
            </div>
        </div>

        <div class="stat-card group cursor-pointer">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-accent/10 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-accent/60 bg-accent/10 px-2 py-1 rounded-full">Plan</span>
                </div>
                <div class="stat-value text-3xl font-bold text-gray-800 mb-1">0</div>
                <div class="text-sm font-medium text-gray-600">Materias</div>
                <div class="text-xs text-gray-400 mt-1">en el currículo</div>
            </div>
        </div>

        <div class="stat-card group cursor-pointer">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-info/10 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-info/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-info/60 bg-info/10 px-2 py-1 rounded-full">Actual</span>
                </div>
                <div class="stat-value text-lg font-bold text-gray-800 mb-1">—</div>
                <div class="text-sm font-medium text-gray-600">Período</div>
                <div class="text-xs text-gray-400 mt-1">sin asignar</div>
            </div>
        </div>
    </div>

    {{-- Quick Actions & Info --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Quick Actions --}}
        <div class="lg:col-span-2">
            <div class="card-elevated animate-slide-up animate-delay-200">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-display text-lg font-semibold text-gray-800">Acciones Rápidas</h3>
                    <p class="text-xs text-gray-500 mt-1">Gestiona el sistema desde aquí</p>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <a href="{{ route('admin.usuarios.crear') }}" class="flex flex-col items-center p-4 rounded-xl bg-gray-50 hover:bg-primary/5 hover:text-primary transition-all duration-200 group">
                            <div class="w-12 h-12 rounded-xl bg-white shadow-soft flex items-center justify-center mb-3 group-hover:shadow-soft-lg transition-shadow">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700 group-hover:text-primary">Nuevo Usuario</span>
                        </a>
                        <a href="{{ route('admin.materias.crear') }}" class="flex flex-col items-center p-4 rounded-xl bg-gray-50 hover:bg-primary/5 hover:text-primary transition-all duration-200 group">
                            <div class="w-12 h-12 rounded-xl bg-white shadow-soft flex items-center justify-center mb-3 group-hover:shadow-soft-lg transition-shadow">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700 group-hover:text-primary">Nueva Materia</span>
                        </a>
                        <a href="{{ route('admin.periodos') }}" class="flex flex-col items-center p-4 rounded-xl bg-gray-50 hover:bg-primary/5 hover:text-primary transition-all duration-200 group">
                            <div class="w-12 h-12 rounded-xl bg-white shadow-soft flex items-center justify-center mb-3 group-hover:shadow-soft-lg transition-shadow">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700 group-hover:text-primary">Períodos</span>
                        </a>
                        <a href="{{ route('admin.asignaciones') }}" class="flex flex-col items-center p-4 rounded-xl bg-gray-50 hover:bg-primary/5 hover:text-primary transition-all duration-200 group">
                            <div class="w-12 h-12 rounded-xl bg-white shadow-soft flex items-center justify-center mb-3 group-hover:shadow-soft-lg transition-shadow">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700 group-hover:text-primary">Asignaciones</span>
                        </a>
                        <a href="{{ route('admin.inscripciones') }}" class="flex flex-col items-center p-4 rounded-xl bg-gray-50 hover:bg-primary/5 hover:text-primary transition-all duration-200 group">
                            <div class="w-12 h-12 rounded-xl bg-white shadow-soft flex items-center justify-center mb-3 group-hover:shadow-soft-lg transition-shadow">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700 group-hover:text-primary">Inscripciones</span>
                        </a>
                        <a href="#" class="flex flex-col items-center p-4 rounded-xl bg-gray-50 hover:bg-primary/5 hover:text-primary transition-all duration-200 group">
                            <div class="w-12 h-12 rounded-xl bg-white shadow-soft flex items-center justify-center mb-3 group-hover:shadow-soft-lg transition-shadow">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700 group-hover:text-primary">Reportes</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Info Card --}}
        <div class="lg:col-span-1">
            <div class="card-elevated animate-slide-up animate-delay-300 h-full">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-display text-lg font-semibold text-gray-800">Información</h3>
                </div>
                <div class="p-5">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-700">Sistema Académico</p>
                                <p class="text-xs text-gray-500 mt-0.5">Gestiona usuarios, materias, períodos y asignaciones desde el menú lateral.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-700">Período Actual</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ now()->locale('es')->settings(['formatLocale' => 'es'])->translatedFormat('F Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-accent/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-700">Versión</p>
                                <p class="text-xs text-gray-500 mt-0.5">SisAcad v1.0.0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
