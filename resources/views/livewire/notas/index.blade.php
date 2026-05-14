<div class="p-6">
    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.asignaciones') }}" class="btn btn-ghost btn-sm btn-circle">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-gray-800">Registro de Notas</h2>
            <p class="text-sm text-gray-500">
                {{ $asignacion->materia->nombre }} - {{ $asignacion->periodo->nombre_formateado }}
            </p>
        </div>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error mb-4">{{ session('error') }}</div>
    @endif

    {{-- Tabla de Notas --}}
    <div class="card bg-base-100 shadow">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead class="bg-base-200">
                        <tr>
                            <th>Estudiante</th>
                            <th>CI</th>
                            @foreach($categorias as $categoria)
                                <th>{{ $categoria->nombre }}</th>
                            @endforeach
                            <th>Promedio</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inscripciones as $inscripcion)
                        <tr class="hover">
                            <td>
                                <div class="font-medium">{{ $inscripcion->estudiante->usuario->nombre_completo }}</div>
                            </td>
                            <td>
                                <span class="font-mono text-sm">{{ $inscripcion->estudiante->usuario->ci }}</span>
                            </td>
                            @foreach($categorias as $categoria)
                            <td>
                                @if(auth()->user()->rol === 'docente')
                                    <input 
                                        wire:model.blur="notas.{{ $inscripcion->id }}.{{ $categoria->id }}"
                                        type="number" 
                                        min="0" 
                                        max="100" 
                                        step="0.1"
                                        class="input input-bordered input-sm w-20"
                                    >
                                @else
                                    <span class="font-mono">{{ $notas[$inscripcion->id][$categoria->id] ?? '—' }}</span>
                                @endif
                            </td>
                            @endforeach
                            <td>
                                <div class="font-medium">
                                    {{ $this->calcularPromedio($inscripcion->id) ? number_format($this->calcularPromedio($inscripcion->id), 2) : '-' }}
                                </div>
                            </td>
                            <td>
                                @if($this->esAprobado($inscripcion->id))
                                    <span class="badge badge-success">Aprobado</span>
                                @else
                                    <span class="badge badge-error">Reprobado</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="{{ 3 + $categorias->count() }}" class="text-center py-8 text-gray-400">No hay estudiantes inscritos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    {{-- Modal de estadísticas del estudiante --}}
    @if($estudianteSeleccionado)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg">
                    Estadísticas de {{ $estudianteSeleccionado->usuario->nombre_completo }}
                </h3>
                
                @if($estadisticasEstudiante)
                    <div class="py-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <strong>Promedio Final:</strong> {{ number_format($estadisticasEstudiante['promedio_final'], 2) }}
                            </div>
                            <div>
                                <strong>Estado:</strong> 
                                <span class="badge 
                                    @if($estadisticasEstudiante['estado'] === 'Aprobado') badge-success 
                                    @elseif($estadisticasEstudiante['estado'] === 'Reprobado') badge-error 
                                    @else badge-warning @endif">
                                    {{ $estadisticasEstudiante['estado'] }}
                                </span>
                            </div>
                            <div>
                                <strong>Promedio Parciales:</strong> {{ number_format($estadisticasEstudiante['promedio_parciales'], 2) }}
                            </div>
                            <div>
                                <strong>Promedio Exámenes:</strong> {{ number_format($estadisticasEstudiante['promedio_examenes'], 2) }}
                            </div>
                        </div>
                        
                        @if(isset($estadisticasEstudiante['detalles_parciales']))
                            <div class="mt-4">
                                <strong>Detalles de Parciales:</strong>
                                <ul class="mt-2 space-y-1">
                                    @foreach($estadisticasEstudiante['detalles_parciales'] as $parcial)
                                        <li>Parcial {{ $parcial['numero'] }}: {{ $parcial['nota'] }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        @if(isset($estadisticasEstudiante['detalles_examenes']))
                            <div class="mt-4">
                                <strong>Detalles de Exámenes:</strong>
                                <ul class="mt-2 space-y-1">
                                    @foreach($estadisticasEstudiante['detalles_examenes'] as $examen)
                                        <li>{{ $examen['tipo'] }}: {{ $examen['nota'] }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="py-4 text-center text-gray-500">
                        No hay estadísticas disponibles para este estudiante.
                    </div>
                @endif
                
                <div class="modal-action">
                    <button wire:click="$set('estudianteSeleccionado', null)" class="btn btn-ghost">Cerrar</button>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Estilos adicionales para estadísticas --}}
<style>
.stat {
    @apply bg-base-200 rounded-lg p-4 text-center;
}
.stat-title {
    @apply text-sm text-gray-600 mb-1;
}
.stat-value {
    @apply text-2xl font-bold;
}
</style>
