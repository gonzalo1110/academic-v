<div class="p-4 md:p-6 lg:p-8 animate-fade-in">

    {{-- Header con gradiente --}}
    <div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.usuarios') }}" class="btn btn-ghost btn-circle hover:bg-white/20 text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="font-display text-2xl font-bold text-white">{{ $usuarioId ? 'Editar Usuario' : 'Nuevo Usuario' }}</h2>
                <p class="text-white/80 mt-1">Completa el formulario para {{ $usuarioId ? 'actualizar' : 'crear' }} un usuario</p>
            </div>
        </div>
    </div>

    {{-- Formulario Premium --}}
    <div class="card-elevated max-w-2xl mx-auto animate-slide-up animate-delay-100">
        <div class="card-body p-6 sm:p-8">
            <form wire:submit="guardar" class="space-y-6">

                {{-- CI + Rol --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium text-gray-700">
                                CI <span class="text-red-500 text-xs">*</span>
                            </span>
                        </label>
                        <input wire:model.live="ci" type="text" placeholder="Ej: 8765432"
                            class="input-premium @error('ci') border-error focus:border-error @enderror">
                        @error('ci')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium text-gray-700">
                                Rol <span class="text-red-500 text-xs">*</span>
                            </span>
                        </label>
                        <select wire:model.live="rol" class="select select-bordered w-full rounded-xl border-2 border-gray-200 focus:border-[#1a3a6b] focus:ring-2 focus:ring-[#1a3a6b]/20">
                            <option value="estudiante">Estudiante</option>
                            <option value="docente">Docente</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                </div>

                {{-- Nombres --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium text-gray-700">
                                Primer nombre <span class="text-red-500 text-xs">*</span>
                            </span>
                        </label>
                        <input wire:model.live="primer_nombre" type="text" placeholder="Juan"
                            class="input-premium @error('primer_nombre') border-error focus:border-error @enderror">
                        @error('primer_nombre')<span class="text-error text-xs">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium text-gray-700">Segundo nombre</span>
                        </label>
                        <input wire:model="segundo_nombre" type="text" placeholder="Carlos"
                            class="input-premium">
                    </div>
                </div>

                {{-- Apellidos --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium text-gray-700">
                                Primer apellido <span class="text-red-500 text-xs">*</span>
                            </span>
                        </label>
                        <input wire:model.live="primer_apellido" type="text" placeholder="Pérez"
                            class="input-premium @error('primer_apellido') border-error focus:border-error @enderror">
                        @error('primer_apellido')<span class="text-error text-xs">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium text-gray-700">Segundo apellido</span>
                        </label>
                        <input wire:model.live="segundo_apellido" type="text" placeholder="García (opcional)"
                            class="input-premium">
                    </div>
                </div>

                {{-- Campo condicional estudiante --}}
                @if($rol === 'estudiante')
                <div class="form-control animate-fade-in">
                    <label class="label">
                        <span class="label-text font-medium text-gray-700">
                            Semestre actual <span class="text-red-500 text-xs">*</span>
                        </span>
                    </label>
                    <select wire:model="semestre_actual" class="select select-bordered w-full rounded-xl border-2 border-gray-200 focus:border-[#1a3a6b] focus:ring-2 focus:ring-[#1a3a6b]/20">
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
                        <input wire:model="resetPassword" type="checkbox" class="checkbox checkbox-primary checkbox-sm">
                        <span class="label-text text-gray-700">Resetear contraseña</span>
                    </label>
                </div>
                @endif

                {{-- Contraseña inicial preview --}}
                @if(!$usuarioId || $resetPassword)
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-4 animate-fade-in">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#1a3a6b]/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-[#1a3a6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Contraseña inicial:</p>
                            <p class="font-mono font-bold text-lg text-[#1a3a6b]">
                                {{ $passwordPreview === '—' ? '—' : $passwordPreview }}
                            </p>
                            <p class="text-xs text-gray-500">
                                @if($segundo_apellido)
                                    ({{ substr($primer_nombre, 0, 1) }}{{ substr($primer_apellido, 0, 1) }}{{ substr($segundo_apellido, 0, 1) }}{{ $ci }})
                                @else
                                    ({{ substr($primer_nombre, 0, 1) }}{{ substr($primer_apellido, 0, 1) }}{{ $ci }})
                                @endif
                            </p>
                        </div>
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
                        {{ $usuarioId ? 'Actualizar' : 'Crear usuario' }}
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>