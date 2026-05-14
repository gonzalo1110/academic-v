<div class="p-4 md:p-6 lg:p-8 animate-fade-in">

    {{-- Header con gradiente --}}
    <div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.materias') }}" class="btn btn-ghost btn-circle hover:bg-white/20 text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="font-display text-2xl font-bold text-white">{{ $materiaId ? 'Editar Materia' : 'Nueva Materia' }}</h2>
                <p class="text-white/80 mt-1">Plan curricular del instituto</p>
            </div>
        </div>
    </div>

    {{-- Formulario Premium --}}
    <div class="card-elevated max-w-2xl mx-auto animate-slide-up animate-delay-100">
        <div class="card-body p-6 sm:p-8">
            <form wire:submit="guardar" class="space-y-6">
                {{-- Nombre --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium text-gray-700">Nombre de la materia <span class="text-red-500 text-xs">*</span></span>
                    </label>
                    <input wire:model="nombre" type="text" placeholder="Ej: Tecnología Web I" class="input-premium">
                    @error('nombre')<span class="text-error text-xs">{{ $message }}</span>@enderror
                </div>

                {{-- Código: Sigla y Número --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium text-gray-700">Sigla <span class="text-red-500 text-xs">*</span></span>
                        </label>
                        <input wire:model.live="sigla" type="text" placeholder="Ej: PRG" maxlength="10" style="text-transform:uppercase;" class="input-premium">
                        @error('sigla')<span class="text-error text-xs">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium text-gray-700">Número <span class="text-red-500 text-xs">*</span></span>
                        </label>
                        <select wire:model.live="numero" class="select select-bordered w-full rounded-xl border-2 border-gray-200 focus:border-[#1a3a6b] focus:ring-2 focus:ring-[#1a3a6b]/20">
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
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-3">
                        <span class="text-sm text-gray-600">Código generado:</span>
                        <strong class="text-[#1a3a6b] font-mono text-lg ml-2">{{ strtoupper($sigla) }}{{ $sigla && $numero ? ' - ' : '' }}{{ $numero }}</strong>
                    </div>
                @endif

                {{-- Semestre --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium text-gray-700">Semestre <span class="text-red-500 text-xs">*</span></span>
                    </label>
                    <select wire:model="semestre_curricular" class="select select-bordered w-full rounded-xl border-2 border-gray-200 focus:border-[#1a3a6b] focus:ring-2 focus:ring-[#1a3a6b]/20">
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
                            <span class="label-text font-medium text-gray-700">Prerrequisitos</span>
                            <span class="label-text-alt text-xs text-gray-400">(opcional)</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2 max-h-40 overflow-y-auto border-2 border-gray-100 rounded-xl p-3">
                            @foreach($materiasDisponibles as $m)
                                <label class="flex items-center gap-2 text-sm cursor-pointer hover:bg-[#1a3a6b]/5 p-2 rounded-lg transition-colors">
                                    <input type="checkbox" wire:model="prerequisitosSeleccionados" value="{{ $m->id }}" class="checkbox checkbox-primary checkbox-sm">
                                    <span class="text-gray-700">{{ $m->nombre }}
                                        <span class="text-xs text-gray-400 block">{{ $m->codigo }} · Sem.{{ $m->semestre_curricular }}</span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Botones --}}
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">
                    <button type="button" wire:click="cancelar" class="btn btn-ghost">Cancelar</button>
                    <button type="submit" class="bg-gradient-to-r from-[#1a3a6b] to-[#2563eb] text-white font-bold px-6 py-2.5 rounded-xl hover:shadow-lg hover:shadow-[#1a3a6b]/30 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $materiaId ? 'Guardar cambios' : 'Crear materia' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>