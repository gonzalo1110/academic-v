<div class="p-4 md:p-6 lg:p-8 animate-fade-in">

    {{-- Header con gradiente --}}
    <div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="font-display text-2xl font-bold text-white">Inscripciones</h2>
            <p class="text-white/80 mt-1">Gestión de inscripciones de estudiantes</p>
        </div>
        <a href="{{ route('admin.inscripciones.crear') }}" class="btn bg-white text-[#1a3a6b] font-bold hover:bg-white/90 gap-2 flex-shrink-0 shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva inscripción
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
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input
                wire:model.live.debounce.300ms="buscar"
                type="text"
                placeholder="Buscar por CI o nombre del estudiante..."
                class="input-premium pl-11"
            >
        </div>
        <select wire:model.live="filtroAsignacion" class="select select-bordered select-sm sm:w-72">
            <option value="">Todas las asignaciones</option>
            @foreach($asignaciones as $asignacion)
                <option value="{{ $asignacion->id }}">
                    {{ $asignacion->materia->nombre }} — {{ $asignacion->periodo->nombre_formateado }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Tabla Premium --}}
    <div class="card-elevated overflow-hidden animate-slide-up animate-delay-200">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-[#1a3a6b] to-[#2563eb] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Estudiante</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Materia</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Período</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Docente</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($inscripciones as $inscripcion)
                    <tr class="group hover:bg-[#1a3a6b]/5 transition-colors">
                        {{-- Estudiante --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center text-green-700 text-xs font-bold flex-shrink-0">
                                    {{ substr($inscripcion->estudiante->usuario->primer_apellido, 0, 1) }}{{ substr($inscripcion->estudiante->usuario->primer_nombre, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">
                                        {{ $inscripcion->estudiante->usuario->primer_apellido }}
                                        {{ $inscripcion->estudiante->usuario->segundo_apellido }}
                                        {{ $inscripcion->estudiante->usuario->primer_nombre }}
                                    </div>
                                    <span class="font-mono text-xs text-gray-500">{{ $inscripcion->estudiante->usuario->ci }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Materia --}}
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-800">{{ $inscripcion->asignacion->materia->nombre }}</div>
                            <span class="font-mono text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded-md">{{ $inscripcion->asignacion->materia->codigo }}</span>
                        </td>

                        {{-- Período --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-gray-700">{{ $inscripcion->asignacion->periodo->nombre_formateado }}</span>
                                @if($inscripcion->asignacion->periodo->activo)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Activo
                                    </span>
                                @endif
                            </div>
                        </td>

                        {{-- Docente --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-700 text-xs font-bold flex-shrink-0">
                                    {{ substr($inscripcion->asignacion->docente->usuario->primer_apellido, 0, 1) }}{{ substr($inscripcion->asignacion->docente->usuario->primer_nombre, 0, 1) }}
                                </div>
                                <span class="text-sm text-gray-700">
                                    {{ $inscripcion->asignacion->docente->usuario->primer_apellido }}
                                    {{ $inscripcion->asignacion->docente->usuario->primer_nombre }}
                                </span>
                            </div>
                        </td>

                        {{-- Fecha --}}
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs text-gray-500 bg-gray-100 px-2.5 py-1 rounded-lg">
                                {{ $inscripcion->created_at->format('d/m/Y H:i') }}
                            </span>
                        </td>

                        {{-- Acciones --}}
                        <td class="px-6 py-4">
                            <div class="flex gap-2 justify-end opacity-60 group-hover:opacity-100 transition-opacity">
                                <button wire:click="confirmarEliminar({{ $inscripcion->id }})" class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                                <p class="text-gray-400 font-medium">No hay inscripciones registradas</p>
                                <a href="{{ route('admin.inscripciones.crear') }}" class="text-sm text-[#1a3a6b] hover:underline mt-2">Crear la primera inscripción</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginación --}}
    <div class="mt-6 animate-fade-in animate-delay-300">{{ $inscripciones->links() }}</div>

    {{-- Modal Premium --}}
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
                        <h3 class="font-display text-lg font-bold text-gray-800">¿Eliminar inscripción?</h3>
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