<div class="p-6 max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.asignaciones') }}" class="btn btn-ghost btn-sm btn-circle">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold">{{ $asignacionId ? 'Editar Asignación' : 'Nueva Asignación' }}</h2>
            <p class="text-sm text-gray-500">Vincula materia, docente y período</p>
        </div>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <form wire:submit="guardar" class="space-y-4">
                {{-- Materia --}}
                <div class="form-control">
                    <label class="label"><span class="label-text">Materia *</span></label>
                    <select wire:model="materia_id" class="select select-bordered">
                        <option value="">-- Seleccionar materia --</option>
                        @foreach($materias as $materia)
                            <option value="{{ $materia->id }}">{{ $materia->nombre }} ({{ $materia->codigo }})</option>
                        @endforeach
                    </select>
                    @error('materia_id')<span class="text-error text-xs">{{ $message }}</span>@enderror
                </div>

                {{-- Docente --}}
                <div class="form-control">
                    <label class="label"><span class="label-text">Docente *</span></label>
                    <select wire:model="docente_id" class="select select-bordered">
                        <option value="">-- Seleccionar docente --</option>
                        @foreach($docentes as $docente)
                            <option value="{{ $docente->id }}">{{ $docente->usuario->nombre_completo }} (CI: {{ $docente->usuario->ci }})</option>
                        @endforeach
                    </select>
                    @error('docente_id')<span class="text-error text-xs">{{ $message }}</span>@enderror
                </div>

                {{-- Período --}}
                <div class="form-control">
                    <label class="label"><span class="label-text">Período *</span></label>
                    <select wire:model="periodo_id" class="select select-bordered">
                        <option value="">-- Seleccionar período --</option>
                        @foreach($periodos as $periodo)
                            <option value="{{ $periodo->id }}">{{ $periodo->nombre }}</option>
                        @endforeach
                    </select>
                    @error('periodo_id')<span class="text-error text-xs">{{ $message }}</span>@enderror
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" wire:click="cancelar" class="btn btn-ghost">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        {{ $asignacionId ? 'Guardar cambios' : 'Crear asignación' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
