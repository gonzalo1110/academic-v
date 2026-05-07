<div class="p-6 max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.periodos') }}" class="btn btn-ghost btn-sm btn-circle">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold">{{ $periodoId ? 'Editar Período' : 'Nuevo Período' }}</h2>
            <p class="text-sm text-gray-500">Período académico del instituto</p>
        </div>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <form wire:submit="guardar" class="space-y-4">
                {{-- Nombre --}}
                <div class="form-control">
                    <label class="label"><span class="label-text">Nombre del período *</span></label>
                    <input wire:model="nombre" type="text" placeholder="Ej: Primer Semestre 2024" class="input input-bordered">
                    @error('nombre')<span class="text-error text-xs">{{ $message }}</span>@enderror
                </div>

                {{-- Fechas --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Fecha de inicio *</span></label>
                        <input wire:model="fecha_inicio" type="date" class="input input-bordered">
                        @error('fecha_inicio')<span class="text-error text-xs">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Fecha de fin *</span></label>
                        <input wire:model="fecha_fin" type="date" class="input input-bordered">
                        @error('fecha_fin')<span class="text-error text-xs">{{ $message }}</span>@enderror
                    </div>
                </div>

                {{-- Estado --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Período activo</span>
                        <span class="label-text-alt text-xs text-gray-400">Solo un período puede estar activo</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="activo" class="checkbox">
                        <span class="text-sm">Marcar como período activo actual</span>
                    </label>
                    @error('activo')<span class="text-error text-xs">{{ $message }}</span>@enderror
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" wire:click="cancelar" class="btn btn-ghost">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        {{ $periodoId ? 'Guardar cambios' : 'Crear período' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
