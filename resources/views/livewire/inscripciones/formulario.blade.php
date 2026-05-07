<div class="p-6 max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.inscripciones') }}" class="btn btn-ghost btn-sm btn-circle">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold">Nueva Inscripción</h2>
            <p class="text-sm text-gray-500">Inscribir estudiante en asignación</p>
        </div>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <form wire:submit="guardar" class="space-y-4">
                {{-- Asignación --}}
                <div class="form-control">
                    <label class="label"><span class="label-text">Asignación *</span></label>
                    <select wire:model.live="asignacion_id" class="select select-bordered">
                        <option value="">-- Seleccionar asignación --</option>
                        @foreach($asignaciones as $asignacion)
                            <option value="{{ $asignacion->id }}">
                                {{ $asignacion->materia->nombre }} ({{ $asignacion->materia->codigo }}) - {{ $asignacion->periodo->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('asignacion_id')<span class="text-error text-xs">{{ $message }}</span>@enderror
                </div>

                {{-- Estudiante --}}
                <div class="form-control">
                    <label class="label"><span class="label-text">Estudiante *</span></label>
                    <select wire:model.live="estudiante_id" class="select select-bordered" @if(!$asignacionInfo) disabled @endif>
                        <option value="">-- Seleccionar estudiante --</option>
                        @foreach($estudiantes as $estudiante)
                            <option value="{{ $estudiante->id }}">
                                {{ $estudiante->usuario->nombre_completo }} (CI: {{ $estudiante->usuario->ci }}) - Semestre {{ $estudiante->semestre_actual }}
                            </option>
                        @endforeach
                    </select>
                    @error('estudiante_id')<span class="text-error text-xs">{{ $message }}</span>@enderror
                </div>

                {{-- Información de prerrequisitos --}}
                @if($asignacionInfo && $asignacionInfo->materia->prerequisitos->count() > 0)
                    <div class="alert alert-info">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <strong>Prerrequisitos:</strong>
                            <ul class="mt-2 space-y-1">
                                @foreach($asignacionInfo->materia->prerequisitos as $prerequisito)
                                    <li>• {{ $prerequisito->nombre }} ({{ $prerequisito->codigo }})</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @elseif($asignacionInfo)
                    <div class="alert alert-success">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Esta materia no tiene prerrequisitos.
                    </div>
                @endif

                {{-- Validación de prerrequisitos --}}
                @if($asignacionInfo && $estudiante_id)
                    @php
                        $puedeCursar = $estudiante_id ? \App\Livewire\Inscripciones\Formulario::estudiantePuedeCursar($estudiante_id, $asignacionInfo->id) : true;
                    @endphp
                    @if(!$puedeCursar)
                        <div class="alert alert-error">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            El estudiante no cumple con los prerrequisitos para esta materia.
                        </div>
                    @endif
                @endif

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" wire:click="cancelar" class="btn btn-ghost">Cancelar</button>
                    <button type="submit" class="btn btn-primary" @if(!$asignacionInfo) disabled @endif>
                        Realizar inscripción
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
