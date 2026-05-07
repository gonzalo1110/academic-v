<div class="p-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Asignaciones</h2>
            <p class="text-sm text-gray-500">Materias abiertas por período y docente</p>
        </div>
        <a href="{{ route('admin.asignaciones.crear') }}" class="btn btn-primary btn-sm gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva asignación
        </a>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    {{-- Filtros --}}
    <div class="flex gap-3 mb-4">
        <select wire:model.live="filtroPeriodo" class="select select-bordered select-sm">
            <option value="">Todos los períodos</option>
            @foreach($periodos as $periodo)
                <option value="{{ $periodo->id }}">{{ $periodo->nombre }}</option>
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
                            <th>Materia</th>
                            <th>Docente</th>
                            <th>Período</th>
                            <th>Aula</th>
                            <th>Estado</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($asignaciones as $asignacion)
                        <tr class="hover">
                            <td>
                                <div>
                                    <div class="font-medium">{{ $asignacion->materia->nombre }}</div>
                                    <div class="text-sm text-gray-500">{{ $asignacion->materia->codigo }}</div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="font-medium">{{ $asignacion->docente->usuario->nombre_completo }}</div>
                                    <div class="text-sm text-gray-500">{{ $asignacion->docente->usuario->ci }}</div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    {{ $asignacion->periodo->nombre }}
                                    @if($asignacion->periodo->activo)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-ghost">Inactivo</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                {{ $asignacion->aula ?: 'Sin asignar' }}
                            </td>
                            <td>
                                @if($asignacion->periodo->activo)
                                    <span class="badge badge-success">Abierta</span>
                                @else
                                    <span class="badge badge-ghost">Cerrada</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex gap-2 justify-end">
                                    <a href="{{ route('admin.notas', $asignacion->id) }}" class="btn btn-ghost btn-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        Notas
                                    </a>
                                    <a href="{{ route('admin.asignaciones.editar', $asignacion->id) }}" class="btn btn-ghost btn-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    <a href="{{ route('admin.reportes.materia', $asignacion->id) }}" class="btn btn-success btn-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Excel
                                    </a>
                                    <button wire:click="confirmarEliminar({{ $asignacion->id }})" class="btn btn-ghost btn-xs text-error">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-8 text-gray-400">No hay asignaciones registradas</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Paginación --}}
    <div class="mt-4">{{ $asignaciones->links() }}</div>

    {{-- Modal de confirmación --}}
    @if($modalConfirmar)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg">¿Eliminar asignación?</h3>
                <p class="py-4">Esta acción no se puede deshacer. ¿Estás seguro de eliminar esta asignación?</p>
                <div class="modal-action">
                    <button wire:click="$set('modalConfirmar', false)" class="btn btn-ghost">Cancelar</button>
                    <button wire:click="eliminar" class="btn btn-error">Eliminar</button>
                </div>
            </div>
        </div>
    @endif
</div>
