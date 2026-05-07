<div class="p-6 max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.materias') }}" class="btn btn-ghost btn-sm btn-circle">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold">{{ $materiaId ? 'Editar Materia' : 'Nueva Materia' }}</h2>
            <p class="text-sm text-gray-500">Plan curricular del instituto</p>
        </div>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <form wire:submit="guardar" class="space-y-4">
                {{-- Nombre --}}
                <div class="form-control">
                    <label class="label"><span class="label-text">Nombre de la materia *</span></label>
                    <input wire:model="nombre" type="text" placeholder="Ej: Tecnología Web I" class="input input-bordered">
                    @error('nombre')<span class="text-error text-xs">{{ $message }}</span>@enderror
                </div>

                {{-- Código: Sigla y Número --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Sigla *</span></label>
                        <input wire:model.live="sigla" type="text" placeholder="Ej: PRG" maxlength="10" style="text-transform:uppercase;" class="input input-bordered">
                        @error('sigla')<span class="text-error text-xs">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Número *</span></label>
                        <select wire:model.live="numero" class="select select-bordered">
                            <option value="">-- Seleccionar --</option>
                            <option value="100">100 (Semestre 1)</option>
                            <option value="200">200 (Semestre 2)</option>
                            <option value="300">300 (Semestre 3)</option>
                            <option value="400">400 (Semestre 4)</option>
                            <option value="500">500 (Semestre 5)</option>
                            <option value="600">600 (Semestre 6)</option>
                        </select>
                        @error('numero')<span class="text-error text-xs">{{ $message }}</span>@enderror
                    </div>
                </div>

                {{-- Preview del código generado --}}
                @if($sigla || $numero)
                    <div class="text-sm text-gray-500">
                        Código: <strong>{{ strtoupper($sigla) }}{{ $sigla && $numero ? ' - ' : '' }}{{ $numero }}</strong>
                    </div>
                @endif

                {{-- Semestre --}}
                <div class="form-control">
                    <label class="label"><span class="label-text">Semestre *</span></label>
                    <select wire:model="semestre_curricular" class="select select-bordered">
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}">Semestre {{ $i }}</option>
                        @endfor
                    </select>
                    @error('semestre_curricular')<span class="text-error text-xs">{{ $message }}</span>@enderror
                </div>

                {{-- Prerrequisitos --}}
                @if($materiasDisponibles->isNotEmpty())
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Prerrequisitos</span>
                            <span class="label-text-alt text-xs text-gray-400">(opcional)</span>
                        </label>
                        <div class="grid grid-cols-2 gap-2 mt-2 max-h-40 overflow-y-auto border rounded p-2">
                            @foreach($materiasDisponibles as $m)
                                <label class="flex items-center gap-2 text-sm cursor-pointer hover:bg-gray-50 p-1 rounded">
                                    <input type="checkbox" wire:model="prerequisitosSeleccionados" value="{{ $m->id }}">
                                    <span>{{ $m->nombre }}
                                        <span class="text-xs text-gray-400">{{ $m->codigo }} · Sem.{{ $m->semestre_curricular }}</span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" wire:click="cancelar" class="btn btn-ghost">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        {{ $materiaId ? 'Guardar cambios' : 'Crear materia' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
