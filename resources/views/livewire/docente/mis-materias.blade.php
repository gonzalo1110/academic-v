<div class="p-6">
    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Mis Materias</h2>
        <p class="text-sm text-gray-500">Gestiona tus asignaciones activas</p>
    </div>

    {{-- Grid de asignaciones --}}
    @forelse($asignaciones as $asignacion)
        <div class="card bg-base-100 shadow-lg mb-6">
            <div class="card-body">
                {{-- Header de la card --}}
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">
                            {{ $asignacion->materia->nombre }}
                        </h3>
                        <p class="text-sm text-gray-500 font-mono">
                            {{ $asignacion->materia->codigo }}
                        </p>
                    </div>
                    <div class="badge badge-info">
                        {{ $asignacion->periodo->nombre }}
                    </div>
                </div>

                {{-- Información básica --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="stat">
                        <div class="stat-title">Aula</div>
                        <div class="stat-value text-lg">{{ $asignacion->aula ?: 'Sin asignar' }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat-title">Inscritos</div>
                        <div class="stat-value text-lg">{{ $asignacion->inscripciones->count() }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat-title">Categorías</div>
                        <div class="stat-value text-lg">
                            {{ $asignacion->categorias->count() }}
                        </div>
                    </div>
                </div>

                {{-- Estadísticas por parcial --}}
                <div class="grid grid-cols-2 gap-4 mb-6">
                    {{-- Parcial 1 --}}
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-sm text-gray-600 mb-2">Parcial 1</h4>
                        <div class="stats stats-vertical">
                            <div class="stat">
                                <div class="stat-title">Categorías</div>
                                <div class="stat-value text-sm">
                                    {{ $asignacion->categorias->where('parcial', 1)->count() }}
                                </div>
                            </div>
                            <div class="stat">
                                <div class="stat-title">Notas registradas</div>
                                <div class="stat-value text-sm">
                                    {{ $asignacion->inscripciones->sum(function($inscripcion) {
                                        return $inscripcion->notas->where('parcial', 1)->count();
                                    }) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Parcial 2 --}}
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-sm text-gray-600 mb-2">Parcial 2</h4>
                        <div class="stats stats-vertical">
                            <div class="stat">
                                <div class="stat-title">Categorías</div>
                                <div class="stat-value text-sm">
                                    {{ $asignacion->categorias->where('parcial', 2)->count() }}
                                </div>
                            </div>
                            <div class="stat">
                                <div class="stat-title">Notas registradas</div>
                                <div class="stat-value text-sm">
                                    {{ $asignacion->inscripciones->sum(function($inscripcion) {
                                        return $inscripcion->notas->where('parcial', 2)->count();
                                    }) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Botones de acción --}}
                <div class="card-actions justify-end gap-2">
                    <a href="{{ route('docente.notas', $asignacion->id) }}" class="btn btn-primary btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Notas
                    </a>
                    
                    @if($asignacion->considera_asistencia)
                        <a href="{{ route('docente.asistencia', $asignacion->id) }}" class="btn btn-secondary btn-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Asistencia
                        </a>
                    @endif
                    
                    <a href="{{ route('docente.categorias', $asignacion->id) }}" class="btn btn-ghost btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Configurar
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="hero bg-base-200 rounded-lg">
            <div class="hero-content text-center py-12">
                <div class="max-w-md">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-600">Sin asignaciones activas</h3>
                    <p class="py-2 text-gray-500">
                        No tienes materias asignadas en el período activo actual.
                    </p>
                    <p class="text-sm text-gray-400">
                        Contacta al administrador si crees que esto es un error.
                    </p>
                </div>
            </div>
        </div>
    @endforelse
</div>
