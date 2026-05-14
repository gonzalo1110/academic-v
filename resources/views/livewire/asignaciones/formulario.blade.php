<div class="p-4 md:p-6 lg:p-8 animate-fade-in">

    {{-- Header con gradiente --}}
    <div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.asignaciones') }}" class="btn btn-ghost btn-circle hover:bg-white/20 text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="font-display text-2xl font-bold text-white">{{ $asignacionId ? 'Editar Asignación' : 'Nueva Asignación' }}</h2>
                <p class="text-white/80 mt-1">Vincula materia, docente y período</p>
            </div>
        </div>
    </div>

    {{-- Formulario Premium --}}
    <div class="card-elevated max-w-2xl mx-auto animate-slide-up animate-delay-100">
        <div class="card-body p-6 sm:p-8">
            <form wire:submit="guardar" class="space-y-6">
                {{-- Materia --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium text-gray-700">Materia <span class="text-red-500 text-xs">*</span></span>
                    </label>
                    <select wire:model="materia_id" class="select select-bordered w-full rounded-xl border-2 border-gray-200 focus:border-[#1a3a6b] focus:ring-2 focus:ring-[#1a3a6b]/20">
                        <option value="">-- Seleccionar materia --</option>
                        @foreach($materias as $materia)
                            <option value="{{ $materia->id }}">{{ $materia->nombre }} ({{ $materia->codigo }})</option>
                        @endforeach
                    </select>
                    @error('materia_id')<span class="text-error text-xs">{{ $message }}</span>@enderror
                </div>

                {{-- Docente --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium text-gray-700">Docente <span class="text-red-500 text-xs">*</span></span>
                    </label>
                    <select wire:model="docente_id" class="select select-bordered w-full rounded-xl border-2 border-gray-200 focus:border-[#1a3a6b] focus:ring-2 focus:ring-[#1a3a6b]/20">
                        <option value="">-- Seleccionar docente --</option>
                        @foreach($docentes as $docente)
                            <option value="{{ $docente->id }}">{{ $docente->usuario->nombre_completo }} (CI: {{ $docente->usuario->ci }})</option>
                        @endforeach
                    </select>
                    @error('docente_id')<span class="text-error text-xs">{{ $message }}</span>@enderror
                </div>

                {{-- Período --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium text-gray-700">Período <span class="text-red-500 text-xs">*</span></span>
                    </label>
                    <select wire:model="periodo_id" class="select select-bordered w-full rounded-xl border-2 border-gray-200 focus:border-[#1a3a6b] focus:ring-2 focus:ring-[#1a3a6b]/20">
                        <option value="">-- Seleccionar período --</option>
                        @foreach($periodos as $periodo)
                            <option value="{{ $periodo->id }}">{{ $periodo->nombre }}</option>
                        @endforeach
                    </select>
                    @error('periodo_id')<span class="text-error text-xs">{{ $message }}</span>@enderror
                </div>

                {{-- Botones --}}
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">
                    <button type="button" wire:click="cancelar" class="btn btn-ghost">Cancelar</button>
                    <button type="submit" class="bg-gradient-to-r from-[#1a3a6b] to-[#2563eb] text-white font-bold px-6 py-2.5 rounded-xl hover:shadow-lg hover:shadow-[#1a3a6b]/30 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $asignacionId ? 'Guardar cambios' : 'Crear asignación' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>