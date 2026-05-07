<div class="p-6 max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.usuarios') }}" class="btn btn-ghost btn-sm btn-circle">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold">{{ $usuarioId ? 'Editar Usuario' : 'Nuevo Usuario' }}</h2>
            <p class="text-sm text-gray-500">Completa el formulario para {{ $usuarioId ? 'actualizar' : 'crear' }} un usuario</p>
        </div>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <form wire:submit="guardar" class="space-y-4">

                {{-- CI + Rol --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">CI *</span></label>
                        <input wire:model.live="ci" type="text" placeholder="Ej: 8765432"
                            class="input input-bordered @error('ci') input-error @enderror">
                        @error('ci')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Rol *</span></label>
                        <select wire:model.live="rol" class="select select-bordered">
                            <option value="estudiante">Estudiante</option>
                            <option value="docente">Docente</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                </div>

                {{-- Nombres --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Primer nombre *</span></label>
                        <input wire:model.live="primer_nombre" type="text" placeholder="Juan"
                            class="input input-bordered @error('primer_nombre') input-error @enderror">
                        @error('primer_nombre')<span class="text-error text-xs">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Segundo nombre</span></label>
                        <input wire:model="segundo_nombre" type="text" placeholder="Carlos"
                            class="input input-bordered">
                    </div>
                </div>

                {{-- Apellidos --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Primer apellido *</span></label>
                        <input wire:model.live="primer_apellido" type="text" placeholder="Pérez"
                            class="input input-bordered @error('primer_apellido') input-error @enderror">
                        @error('primer_apellido')<span class="text-error text-xs">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Segundo apellido</span></label>
                        <input wire:model="segundo_apellido" type="text" placeholder="García"
                            class="input input-bordered">
                    </div>
                </div>

                {{-- Campo condicional estudiante --}}
                @if($rol === 'estudiante')
                <div class="form-control">
                    <label class="label"><span class="label-text">Semestre actual *</span></label>
                    <select wire:model="semestre_actual" class="select select-bordered">
                        @for($s = 1; $s <= 6; $s++)
                        <option value="{{ $s }}">Semestre {{ $s }}</option>
                        @endfor
                    </select>
                </div>
                @endif

                {{-- Reset password (solo edición) --}}
                @if($usuarioId)
                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-3">
                        <input wire:model="resetPassword" type="checkbox" class="checkbox checkbox-sm">
                        <span class="label-text">Resetear contraseña</span>
                    </label>
                </div>
                @endif

                {{-- Password preview --}}
                @if(!$usuarioId || $resetPassword)
                <div class="alert alert-info py-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm">Password {{ $usuarioId ? 'inicial (si reseteas)' : 'inicial' }}:
                        <strong class="font-mono">{{ $passwordPreview }}</strong>
                    </span>
                </div>
                @endif

                {{-- Botones --}}
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" wire:click="cancelar" class="btn btn-ghost">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        {{ $usuarioId ? 'Actualizar' : 'Crear usuario' }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
