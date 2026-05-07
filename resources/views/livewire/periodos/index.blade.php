<div class="p-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Períodos Académicos</h2>
            <p class="text-sm text-gray-500">Solo puede haber un período activo a la vez</p>
        </div>
        <a href="{{ route('admin.periodos.crear') }}" class="btn btn-primary btn-sm gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo período
        </a>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    {{-- Tabla --}}
    <div class="card bg-base-100 shadow">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead class="bg-base-200">
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Estado</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($periodos as $periodo)
                        <tr class="hover">
                            <td>
                                <div class="font-medium">{{ $periodo->nombre }}</div>
                            </td>
                            <td>{{ $periodo->fecha_inicio->format('d/m/Y') }}</td>
                            <td>{{ $periodo->fecha_fin->format('d/m/Y') }}</td>
                            <td>
                                @if($periodo->activo)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-ghost">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex gap-2 justify-end">
                                    <a href="{{ route('admin.periodos.editar', $periodo->id) }}" class="btn btn-ghost btn-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    @if(!$periodo->activo)
                                        <button wire:click="confirmarEliminar({{ $periodo->id }})" class="btn btn-ghost btn-xs text-error">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-8 text-gray-400">No hay períodos registrados</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Paginación --}}
    <div class="mt-4">{{ $periodos->links() }}</div>

    {{-- Modal de confirmación --}}
    @if($modalConfirmar)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg">¿Eliminar período?</h3>
                <p class="py-4">Esta acción no se puede deshacer. ¿Estás seguro de eliminar este período?</p>
                <div class="modal-action">
                    <button wire:click="$set('modalConfirmar', false)" class="btn btn-ghost">Cancelar</button>
                    <button wire:click="eliminar" class="btn btn-error">Eliminar</button>
                </div>
            </div>
        </div>
    @endif
</div>
