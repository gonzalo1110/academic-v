<div class="p-6">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('docente.materias') }}" wire:navigate class="btn btn-ghost btn-sm btn-circle">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold">Registro de Notas</h2>
            <p class="text-sm text-gray-500">
                {{ $asignacion->materia->nombre }} — {{ $asignacion->periodo->nombre }}
            </p>
        </div>
    </div>

    {{-- Parcial selector --}}
    <div class="flex gap-2 mb-4">
        <button wire:click="$set('parcialActivo', 1)"
            class="btn btn-sm {{ $parcialActivo === 1 ? 'btn-primary' : 'btn-ghost' }}">
            Parcial 1
        </button>
        <button wire:click="$set('parcialActivo', 2)"
            class="btn btn-sm {{ $parcialActivo === 2 ? 'btn-primary' : 'btn-ghost' }}">
            Parcial 2
        </button>
    </div>

    {{-- Tabla de notas --}}
    <div class="card bg-base-100 shadow">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead class="bg-base-200">
                        <tr>
                            <th>Estudiante</th>
                            <th>CI</th>
                            @foreach($categorias as $categoria)
                            <th>{{ $categoria->nombre }}<br><span class="text-xs font-normal opacity-60">{{ $categoria->peso_porcentual }}%</span></th>
                            @endforeach
                            <th>Parcial {{ $parcialActivo }}</th>
                            <th>Final</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inscripciones as $inscripcion)
                        <tr>
                            <td class="font-medium">
                                {{ $inscripcion->estudiante->usuario->primer_apellido }}
                                {{ $inscripcion->estudiante->usuario->segundo_apellido }}
                                {{ $inscripcion->estudiante->usuario->primer_nombre }}
                            </td>
                            <td class="font-mono text-xs">{{ $inscripcion->estudiante->usuario->ci }}</td>
                            @foreach($categorias as $categoria)
                            <td>
                                <input
                                    wire:change="actualizarNota({{ $inscripcion->id }}, {{ $categoria->id }}, $event.target.value)"
                                    type="number" min="0" max="100" step="0.1"
                                    value="{{ $notas[$inscripcion->id][$categoria->id] ?? '' }}"
                                    class="input input-bordered input-xs w-20">
                            </td>
                            @endforeach
                            <td class="font-mono">{{ number_format($this->calcularPromedio($inscripcion->id, $parcialActivo), 1) }}</td>
                            <td class="font-mono font-bold">{{ number_format($this->calcularPromedioFinal($inscripcion->id), 1) }}</td>
                            <td>
                                @php $final = $this->calcularPromedioFinal($inscripcion->id); @endphp
                                @if($final >= 61)
                                    <span class="badge badge-success badge-sm">Aprobado</span>
                                @elseif($final > 0)
                                    <span class="badge badge-error badge-sm">Reprobado</span>
                                @else
                                    <span class="badge badge-ghost badge-sm">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="10" class="text-center py-8 text-gray-400">Sin estudiantes inscritos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
