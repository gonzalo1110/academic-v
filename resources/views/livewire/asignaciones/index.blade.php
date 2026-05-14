<div class="p-4 md:p-6 lg:p-8 animate-fade-in">

    {{-- Header con gradiente --}}
    <div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="font-display text-2xl font-bold text-white">Asignaciones</h2>
            <p class="text-white/80 mt-1">Materias abertas por período y docente</p>
        </div>
        <a href="{{ route('admin.asignaciones.crear') }}" class="btn bg-white text-[#1a3a6b] font-bold hover:bg-white/90 gap-2 flex-shrink-0 shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva asignación
        </a>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-2 border-green-200 rounded-xl flex items-center gap-3 animate-slide-up">
            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-green-700 font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Filtros --}}
    <div class="flex flex-col sm:flex-row gap-3 mb-6 animate-slide-up animate-delay-100">
        <select wire:model.live="filtroPeriodo" class="select select-bordered select-sm sm:w-56">
            <option value="">Todos los períodos</option>
            @foreach($periodos as $periodo)
                <option value="{{ $periodo->id }}">{{ $periodo->nombre_formateado }}</option>
            @endforeach
        </select>
    </div>

    {{-- Tabla Premium --}}
    <div class="card-elevated overflow-hidden animate-slide-up animate-delay-200">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-[#1a3a6b] to-[#2563eb] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Materia</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Docente</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Período</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Aula</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($asignaciones as $asignacion)
                    <tr class="group hover:bg-[#1a3a6b]/5 transition-colors">
                        {{-- Materia --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-[#1a3a6b]/10 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-[#1a3a6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">{{ $asignacion->materia->nombre }}</div>
                                    <span class="font-mono text-xs font-medium text-gray-500 bg-gray-100 px-2 py-0.5 rounded-md">{{ $asignacion->materia->codigo }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Docente --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center text-blue-700 text-xs font-bold flex-shrink-0">
                                    {{ substr($asignacion->docente->usuario->nombre_completo, 0, 2) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">{{ $asignacion->docente->usuario->nombre_completo }}</div>
                                    <span class="font-mono text-xs text-gray-500">{{ $asignacion->docente->usuario->ci }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Período --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-gray-700">{{ $asignacion->periodo->nombre }}</span>
                                @if($asignacion->periodo->activo)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-200">
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200">
                                        Inactivo
                                    </span>
                                @endif
                            </div>
                        </td>

                        {{-- Aula --}}
                        <td class="px-6 py-4">
                            @if($asignacion->aula)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 border border-blue-200">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    {{ $asignacion->aula }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-400 border border-gray-200">
                                    Sin asignar
                                </span>
                            @endif
                        </td>

                        {{-- Estado --}}
                        <td class="px-6 py-4">
                            @if($asignacion->periodo->activo)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium bg-green-100 text-green-700 border border-green-200">
                                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                    Abierta
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-500 border border-gray-200">
                                    Cerrada
                                </span>
                            @endif
                        </td>

                        {{-- Acciones --}}
                        <td class="px-6 py-4">
                            <div class="flex gap-2 justify-end opacity-60 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.notas', $asignacion->id) }}" class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium text-blue-600 hover:bg-blue-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <span class="hidden sm:inline">Notas</span>
                                </a>
                                <a href="{{ route('admin.asignaciones.editar', $asignacion->id) }}" class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium text-[#1a3a6b] hover:bg-[#1a3a6b]/10 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span class="hidden sm:inline">Editar</span>
                                </a>
                                <a href="{{ route('admin.reportes.materia', $asignacion->id) }}" class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium text-green-600 hover:bg-green-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span class="hidden sm:inline">Excel</span>
                                </a>
                                <button wire:click="confirmarEliminar({{ $asignacion->id }})" class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-16">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                                <p class="text-gray-400 font-medium">No hay asignaciones registradas</p>
                                <a href="{{ route('admin.asignaciones.crear') }}" class="text-sm text-[#1a3a6b] hover:underline mt-2">Crear la primera asignación</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginación --}}
    <div class="mt-6 animate-fade-in animate-delay-300">{{ $asignaciones->links() }}</div>

    {{-- Modal de confirmación --}}
    @if($modalConfirmar)
        <div class="modal modal-open">
            <div class="modal-box bg-white max-w-md animate-scale-in">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-display text-lg font-bold text-gray-800">¿Eliminar asignación?</h3>
                        <p class="text-sm text-gray-500">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <div class="modal-action mt-6">
                    <button wire:click="$set('modalConfirmar', false)" class="btn btn-ghost">Cancelar</button>
                    <button wire:click="eliminar" class="btn bg-red-600 text-white hover:bg-red-700">Eliminar</button>
                </div>
            </div>
            <form method="dialog">
                <button class="modal-backdrop bg-black/50 backdrop-blur-sm"></button>
            </form>
        </div>
    @endif

</div>