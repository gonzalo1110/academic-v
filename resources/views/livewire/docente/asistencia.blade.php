<div class="p-6">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('docente.materias') }}" wire:navigate class="btn btn-ghost btn-sm btn-circle">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold">Registro de Asistencia</h2>
            <p class="text-sm text-gray-500">{{ $asignacion->materia->nombre }} — {{ $asignacion->periodo->nombre_formateado }}</p>
        </div>
    </div>

    {{-- Selector de fecha --}}
    <div class="flex items-center gap-3 mb-4">
        <input wire:model.live="fecha" type="date" class="input input-bordered input-sm" max="{{ date('Y-m-d') }}">
        <span class="badge badge-info badge-sm">Parcial {{ $parcialActivo }}</span>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead class="bg-base-200">
                        <tr>
                            <th>Estudiante</th>
                            <th>CI</th>
                            <th>Asistencia</th>
                            <th>% Parcial {{ $parcialActivo }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inscripciones as $inscripcion)
                        <tr>
                            <td>
                                {{ $inscripcion->estudiante->usuario->primer_apellido }}
                                {{ $inscripcion->estudiante->usuario->primer_nombre }}
                            </td>
                            <td class="font-mono text-xs">{{ $inscripcion->estudiante->usuario->ci }}</td>
                            <td>
                                <select wire:change="registrarAsistencia({{ $inscripcion->id }}, $event.target.value)"
                                    class="select select-bordered select-xs">
                                    <option value="">— seleccionar —</option>
                                    <option value="Presente" {{ ($asistencias[$inscripcion->id] ?? '') === 'Presente' ? 'selected' : '' }}>✅ Presente</option>
                                    <option value="Ausente" {{ ($asistencias[$inscripcion->id] ?? '') === 'Ausente' ? 'selected' : '' }}>❌ Ausente</option>
                                    <option value="Justificado" {{ ($asistencias[$inscripcion->id] ?? '') === 'Justificado' ? 'selected' : '' }}>📋 Justificado</option>
                                </select>
                            </td>
                            <td>
                                @php $pct = $porcentajes[$inscripcion->id] ?? 0; @endphp
                                <span class="badge badge-sm {{ $pct >= 80 ? 'badge-success' : 'badge-error' }}">
                                    {{ $pct }}%
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-8 text-gray-400">Sin estudiantes inscritos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
