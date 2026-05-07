<div class="p-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Inscripciones</h2>
            <p class="text-sm text-gray-500">Gestión de inscripciones de estudiantes</p>
        </div>
        <a href="{{ route('admin.inscripciones.crear') }}" class="btn btn-primary btn-sm gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva inscripción
        </a>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    {{-- Filtros --}}
    <div class="flex gap-3 mb-4">
        <input 
            wire:model.live.debounce.300ms="buscar" 
            type="text" 
            placeholder="Buscar por CI o nombre del estudiante..."
            class="input input-bordered input-sm flex-1"
        >
        <select wire:model.live="filtroAsignacion" class="select select-bordered select-sm">
            <option value="">Todas las asignaciones</option>
            @foreach($asignaciones as $asignacion)
                <option value="{{ $asignacion->id }}">
                    {{ $asignacion->materia->nombre }} - {{ $asignacion->periodo->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Tabla --}}
    <div class="card bg-base-100 shadow">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead class="bg-base-200">
                        <tr>
                            <th>Estudiante</th>
                            <th>Materia</th>
                            <th>Período</th>
                            <th>Docente</th>
                            <th>Fecha inscripción</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                <tbody>
                    @forelse($inscripciones as $inscripcion)
                        <tr class="hover">
                            <td>
                                <div>
                                    <div class="font-medium">
                                        {{ $inscripcion->estudiante->usuario->primer_apellido }}
                                        {{ $inscripcion->estudiante->usuario->segundo_apellido }}
                                        {{ $inscripcion->estudiante->usuario->primer_nombre }}
                                        {{ $inscripcion->estudiante->usuario->segundo_nombre }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $inscripcion->estudiante->usuario->ci }}</div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="font-medium">{{ $inscripcion->asignacion->materia->nombre }}</div>
                                    <div class="text-sm text-gray-500">{{ $inscripcion->asignacion->materia->codigo }}</div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    {{ $inscripcion->asignacion->periodo->nombre }}
                                    @if($inscripcion->asignacion->periodo->activo)
                                        <span class="badge badge-success">Activo</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div>
                                    {{ $inscripcion->asignacion->docente->usuario->primer_apellido }}
                                    {{ $inscripcion->asignacion->docente->usuario->segundo_apellido }}
                                    {{ $inscripcion->asignacion->docente->usuario->primer_nombre }}
                                    {{ $inscripcion->asignacion->docente->usuario->segundo_nombre }}
                                </div>
                            </td>
                            <td>{{ $inscripcion->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-right">
                                <button wire:click="confirmarEliminar({{ $inscripcion->id }})" class="btn btn-ghost btn-xs text-error">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-8 text-gray-400">No hay inscripciones registradas</td></tr>
                    @endforelse
                </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Paginación --}}
    <div class="mt-4">{{ $inscripciones->links() }}</div>

    {{-- Modal de confirmación --}}
    @if($modalConfirmar)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg">¿Eliminar inscripción?</h3>
                <p class="py-4">Esta acción no se puede deshacer. ¿Estás seguro de eliminar esta inscripción?</p>
                <div class="modal-action">
                    <button wire:click="$set('modalConfirmar', false)" class="btn btn-ghost">Cancelar</button>
                    <button wire:click="eliminar" class="btn btn-error">Eliminar</button>
                </div>
            </div>
        </div>
    @endif
</div>
