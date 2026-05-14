<div class="p-4 md:p-6 lg:p-8 animate-fade-in">

    {{-- Header con gradiente --}}
    <div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.periodos') }}" class="btn btn-ghost btn-circle hover:bg-white/20 text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="font-display text-2xl font-bold text-white">{{ $periodoId ? 'Editar Período' : 'Nuevo Período' }}</h2>
                <p class="text-white/80 mt-1">Período académico del instituto</p>
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
                        <span class="label-text font-medium text-gray-700">Nombre del período <span class="text-red-500 text-xs">*</span></span>
                    </label>
                    <input wire:model="nombre" type="text" placeholder="Ej: Primer Semestre 2024" class="input-premium">
                    @error('nombre')<span class="text-error text-xs">{{ $message }}</span>@enderror
                </div>

                {{-- Fechas --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium text-gray-700">Fecha de inicio <span class="text-red-500 text-xs">*</span></span>
                        </label>
                        <input wire:model="fecha_inicio" type="date" class="input-premium">
                        @error('fecha_inicio')<span class="text-error text-xs">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium text-gray-700">Fecha de fin <span class="text-red-500 text-xs">*</span></span>
                        </label>
                        <input wire:model="fecha_fin" type="date" class="input-premium">
                        @error('fecha_fin')<span class="text-error text-xs">{{ $message }}</span>@enderror
                    </div>
                </div>

                {{-- Estado --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium text-gray-700">Período activo</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" wire:model="activo" class="toggle toggle-primary toggle-md">
                        <span class="text-sm text-gray-600">Marcar como período activo actual</span>
                    </label>
                    <p class="text-xs text-gray-400 mt-1">Solo un período puede estar activo a la vez</p>
                    @error('activo')<span class="text-error text-xs">{{ $message }}</span>@enderror
                </div>

                {{-- Botones --}}
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">
                    <button type="button" wire:click="cancelar" class="btn btn-ghost">Cancelar</button>
                    <button type="submit" class="bg-gradient-to-r from-[#1a3a6b] to-[#2563eb] text-white font-bold px-6 py-2.5 rounded-xl hover:shadow-lg hover:shadow-[#1a3a6b]/30 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $periodoId ? 'Guardar cambios' : 'Crear período' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>