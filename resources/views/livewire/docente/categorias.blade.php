<div class="p-6 max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('docente.materias') }}" wire:navigate class="btn btn-ghost btn-sm btn-circle">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold">Configurar Categorías</h2>
            <p class="text-sm text-gray-500">{{ $asignacion->materia->nombre }} — {{ $asignacion->periodo->nombre_formateado }}</p>
        </div>
    </div>

    @foreach([1 => 'Parcial 1', 2 => 'Parcial 2'] as $num => $label)
    <div class="card bg-base-100 shadow mb-4">
        <div class="card-body">
            <h3 class="card-title text-base">{{ $label }}</h3>
            <div class="space-y-2">
                @foreach($categorias[$num] ?? [] as $i => $cat)
                <div class="flex gap-2 items-center">
                    <input wire:model="categorias.{{ $num }}.{{ $i }}.nombre"
                        type="text" placeholder="Nombre" class="input input-bordered input-sm flex-1">
                    <input wire:model="categorias.{{ $num }}.{{ $i }}.peso_porcentual"
                        type="number" min="1" max="100" placeholder="%" class="input input-bordered input-sm w-20">
                    <span class="text-xs">%</span>
                    <button wire:click="quitarCategoria({{ $num }}, {{ $i }})" class="btn btn-ghost btn-sm btn-circle text-error">✕</button>
                </div>
                @endforeach
            </div>
            <div class="flex items-center justify-between mt-3">
                <button wire:click="agregarCategoria({{ $num }})" class="btn btn-ghost btn-sm">+ Agregar</button>
                <span class="text-sm {{ abs($totales[$num] - 100) < 0.01 ? 'text-success' : 'text-error' }}">
                    Total: {{ $totales[$num] }}%
                </span>
            </div>
        </div>
    </div>
    @endforeach

    <div class="flex justify-end gap-3">
        <a href="{{ route('docente.materias') }}" wire:navigate class="btn btn-ghost">Cancelar</a>
        <button wire:click="guardar" class="btn btn-primary">Guardar categorías</button>
    </div>
</div>
