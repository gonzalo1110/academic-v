<div class="p-4 md:p-6 lg:p-8 animate-fade-in">

    {{-- Header con gradiente --}}
    <div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="font-display text-2xl font-bold text-white">Materias</h2>
            <p class="text-white/80 mt-1">Plan curricular — semestres 1 al 6</p>
        </div>
        <a href="{{ route('admin.materias.crear') }}" class="btn bg-white text-[#1a3a6b] font-bold hover:bg-white/90 gap-2 flex-shrink-0 shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva materia
        </a>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-2 border-green-200 rounded-xl flex items-center gap-3 animate-slide-up">
            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-green-700 font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Filtros --}}
    <div class="flex flex-col sm:flex-row gap-3 mb-6 animate-slide-up animate-delay-100">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input 
                wire:model.live="buscar" 
                type="text" 
                placeholder="Buscar materia..."
                class="input-premium pl-11"
            >
        </div>
        <select wire:model.live="filtroSemestre" class="select select-bordered select-sm sm:w-48">
            <option value="">Todos los semestres</option>
            @for($i = 1; $i <= 6; $i++)
                <option value="{{ $i }}">Semestre {{ $i }}</option>
            @endfor
        </select>
    </div>

    {{-- Tabla Premium --}}
    <div class="card-elevated overflow-hidden animate-slide-up animate-delay-200">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-[#1a3a6b] to-[#2563eb] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Código</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Semestre</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Prerrequisitos</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($materias as $materia)
                    <tr class="group hover:bg-[#1a3a6b]/5 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-mono text-sm font-medium text-[#1a3a6b] bg-[#1a3a6b]/10 px-2.5 py-1 rounded-lg">{{ $materia->codigo }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-800">{{ $materia->nombre }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium bg-blue-100 text-blue-700 border border-blue-200">
                                Semestre {{ $materia->semestre_curricular }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($materia->prerequisitos->count() > 0)
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($materia->prerequisitos->take(3) as $prerequisito)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">{{ $prerequisito->codigo }}</span>
                                    @endforeach
                                    @if($materia->prerequisitos->count() > 3)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-200 text-gray-500 border border-gray-300">+{{ $materia->prerequisitos->count() - 3 }}</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-400 text-sm">Ninguno</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2 justify-end opacity-60 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.materias.editar', $materia->id) }}" class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium text-[#1a3a6b] hover:bg-[#1a3a6b]/10 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span class="hidden sm:inline">Editar</span>
                                </a>
                                <button wire:click="confirmarEliminar({{ $materia->id }})" class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-16">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <p class="text-gray-400 font-medium">No hay materias registradas</p>
                                <a href="{{ route('admin.materias.crear') }}" class="text-sm text-[#1a3a6b] hover:underline mt-2">Crear la primera materia</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginación --}}
    <div class="mt-6 animate-fade-in animate-delay-300">{{ $materias->links() }}</div>

    {{-- Modal de confirmación Premium --}}
    @if($modalConfirmar)
        <div class="modal modal-open">
            <div class="modal-box max-w-md animate-scale-in">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-display text-lg font-bold text-gray-800">¿Eliminar materia?</h3>
                        <p class="text-sm text-gray-500">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <div class="modal-action mt-6">
                    <button wire:click="$set('modalConfirmar', false)" class="btn btn-ghost">Cancelar</button>
                    <button wire:click="eliminar" class="btn bg-red-600 text-white hover:bg-red-700">Eliminar</button>
                </div>
            </div>
            <div class="modal-backdrop bg-black/40 backdrop-blur-sm"></div>
        </div>
    @endif
</div>