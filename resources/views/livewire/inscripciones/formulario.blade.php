<div class="p-4 md:p-6 lg:p-8 animate-fade-in">

    {{-- Header con gradiente --}}
    <div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.inscripciones') }}" class="btn btn-ghost btn-circle hover:bg-white/20 text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="font-display text-2xl font-bold text-white">Nueva Inscripción</h2>
                <p class="text-white/80 mt-1">Inscribir estudiante en asignación</p>
            </div>
        </div>
    </div>

    {{-- Formulario Premium --}}
    <div class="card-elevated max-w-2xl mx-auto animate-slide-up animate-delay-100">
        <div class="card-body p-6 sm:p-8">
            <form wire:submit="guardar" class="space-y-6">
                {{-- Asignación --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium text-gray-700">Asignación <span class="text-red-500 text-xs">*</span></span>
                    </label>
                    <select wire:model.live="asignacion_id" class="select select-bordered w-full rounded-xl border-2 border-gray-200 focus:border-[#1a3a6b] focus:ring-2 focus:ring-[#1a3a6b]/20">
                        <option value="">-- Seleccionar asignación --</option>
                        @foreach($asignaciones as $asignacion)
                            <option value="{{ $asignacion->id }}">
                                {{ $asignacion->materia->nombre }} ({{ $asignacion->materia->codigo }}) - {{ $asignacion->periodo->nombre_formateado }}
                            </option>
                        @endforeach
                    </select>
                    @error('asignacion_id')<span class="text-error text-xs">{{ $message }}</span>@enderror
                </div>

                {{-- Estudiante --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium text-gray-700">Estudiante <span class="text-red-500 text-xs">*</span></span>
                    </label>
                    <select wire:model.live="estudiante_id" class="select select-bordered w-full rounded-xl border-2 border-gray-200 focus:border-[#1a3a6b] focus:ring-2 focus:ring-[#1a3a6b]/20 @if(!$asignacionInfo) opacity-50 @endif" @if(!$asignacionInfo) disabled @endif>
                        <option value="">-- Seleccionar estudiante --</option>
                        @foreach($estudiantes as $estudiante)
                            <option value="{{ $estudiante->id }}">
                                {{ $estudiante->usuario->nombre_completo }} (CI: {{ $estudiante->usuario->ci }}) - Semestre {{ $estudiante->semestre_actual }}
                            </option>
                        @endforeach
                    </select>
                    @error('estudiante_id')<span class="text-error text-xs">{{ $message }}</span>@enderror
                </div>

                {{-- Información de prerrequisitos --}}
                @if($asignacionInfo && $asignacionInfo->materia->prerequisitos->count() > 0)
                    <div class="bg-amber-50 border-2 border-amber-200 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <strong class="text-amber-800">Prerrequisitos:</strong>
                                <ul class="mt-2 space-y-1">
                                    @foreach($asignacionInfo->materia->prerequisitos as $prerequisito)
                                        <li class="text-amber-700 text-sm">• {{ $prerequisito->nombre }} ({{ $prerequisito->codigo }})</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @elseif($asignacionInfo)
                    <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-green-700 text-sm">Esta materia no tiene prerrequisitos.</span>
                        </div>
                    </div>
                @endif

                {{-- Validación de prerrequisitos --}}
                @if($asignacionInfo && $estudiante_id)
                    @php
                        $puedeCursar = $estudiante_id ? \App\Livewire\Inscripciones\Formulario::estudiantePuedeCursar($estudiante_id, $asignacionInfo->id) : true;
                    @endphp
                    @if(!$puedeCursar)
                        <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-red-700 text-sm font-medium">El estudiante no cumple con los prerrequisitos para esta materia.</span>
                            </div>
                        </div>
                    @endif
                @endif

                {{-- Botones --}}
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">
                    <button type="button" wire:click="cancelar" class="btn btn-ghost">Cancelar</button>
                    <button type="submit" class="bg-gradient-to-r from-[#1a3a6b] to-[#2563eb] text-white font-bold px-6 py-2.5 rounded-xl hover:shadow-lg hover:shadow-[#1a3a6b]/30 transition-all duration-300 flex items-center gap-2 @if(!$asignacionInfo) opacity-50 cursor-not-allowed @endif" @if(!$asignacionInfo) disabled @endif>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Realizar inscripción
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>