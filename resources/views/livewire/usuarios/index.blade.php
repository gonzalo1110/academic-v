<div class="p-4 md:p-6 lg:p-8 animate-fade-in">
    {{-- Header con gradiente --}}
    <div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="font-display text-2xl font-bold text-white">Gestión de Usuarios</h2>
            <p class="text-white/80 mt-1">Administra docentes, estudiantes y administradores del sistema</p>
        </div>
        <a href="{{ route('admin.usuarios.crear') }}" class="btn bg-white text-[#1a3a6b] font-bold hover:bg-white/90 gap-2 flex-shrink-0 shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Nuevo usuario
        </a>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success mb-6 animate-slide-up">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
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
                placeholder="Buscar por CI, nombre o apellido..."
                class="input-premium pl-11"
            >
        </div>
        <select wire:model.live="filtroRol" class="select select-bordered select-sm sm:w-48">
            <option value="">Todos los roles</option>
            <option value="admin">Administradores</option>
            <option value="docente">Docentes</option>
            <option value="estudiante">Estudiantes</option>
        </select>
    </div>

    {{-- Tabla Premium --}}
    <div class="card-elevated overflow-hidden animate-slide-up animate-delay-200">
        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th class="pl-6">Usuario</th>
                        <th>CI</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th class="pr-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                    <tr class="group">
                        <td class="pl-6">
                            <div class="flex items-center gap-3">
                                <div class="avatar placeholder">
                                    <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary font-bold flex items-center justify-center text-sm">
                                        {{ $usuario->iniciales }}
                                    </div>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">{{ $usuario->nombre_completo }}</div>
                                    <div class="text-sm text-gray-500">{{ $usuario->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="font-mono text-sm font-medium text-gray-600 bg-gray-100 px-2.5 py-1 rounded-lg">{{ $usuario->ci }}</span>
                        </td>
                        <td>
                            <span class="badge-premium @if($usuario->rol === 'admin') bg-warning/10 text-warning border-warning/20 @elseif($usuario->rol === 'docente') bg-info/10 text-info border-info/20 @else bg-success/10 text-success border-success/20 @endif border">
                                @if($usuario->rol === 'admin')
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                @elseif($usuario->rol === 'docente')
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                @else
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/></svg>
                                @endif
                                {{ ucfirst($usuario->rol) }}
                            </span>
                        </td>
                        <td>
                            @if($usuario->docente || $usuario->estudiante)
                                <span class="badge-premium bg-success/10 text-success border border-success/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-success mr-1.5"></span>
                                    Activo
                                </span>
                            @else
                                <span class="badge-premium bg-gray-100 text-gray-500 border border-gray-200">
                                    Sin perfil
                                </span>
                            @endif
                        </td>
                        <td class="pr-6">
                            <div class="flex gap-2 justify-end opacity-60 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.usuarios.editar', $usuario->id) }}" class="btn btn-ghost btn-sm hover:bg-primary/10 hover:text-primary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span class="hidden sm:inline ml-1">Editar</span>
                                </a>
                                <button wire:click="confirmarEliminar({{ $usuario->id }})" class="btn btn-ghost btn-sm text-error hover:bg-error/10">
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                                </svg>
                                <p class="text-gray-400 font-medium">No hay usuarios registrados</p>
                                <a href="{{ route('admin.usuarios.crear') }}" class="text-sm text-primary hover:underline mt-2">Crear el primer usuario</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginación --}}
    <div class="mt-6 animate-fade-in animate-delay-300">{{ $usuarios->links() }}</div>

    {{-- Modal de confirmación Premium --}}
    @if($modalConfirmar)
        <div class="modal modal-open">
            <div class="modal-box max-w-md animate-scale-in">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-error/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-display text-lg font-bold text-gray-800">¿Eliminar usuario?</h3>
                        <p class="text-sm text-gray-500">Esta acción no se puede deshacer</p>
                    </div>
                </div>
                <div class="modal-action mt-6">
                    <button wire:click="$set('modalConfirmar', false)" class="btn btn-ghost">Cancelar</button>
                    <button wire:click="eliminar" class="btn btn-error">Eliminar</button>
                </div>
            </div>
            <div class="modal-backdrop bg-black/40 backdrop-blur-sm"></div>
        </div>
    @endif
</div>
