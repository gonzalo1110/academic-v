{{-- Componente para imágenes de fondo de dashboards --}}
@props([
    'role' => 'admin', // admin, docente, estudiante
    'opacity' => 0.1, // opacidad del overlay
    'gradient' => true // si usa gradiente adicional
])

@php
    $backgrounds = [
        'admin' => [
            'image' => '/images/dashboards/admin-bg.jpg',
            'gradient' => 'from-blue-900/90 via-blue-800/80 to-indigo-900/90',
            'pattern' => 'bg-grid-white/[0.02]'
        ],
        'docente' => [
            'image' => '/images/dashboards/docente-bg.jpg',
            'gradient' => 'from-emerald-900/90 via-teal-800/80 to-cyan-900/90',
            'pattern' => 'bg-grid-white/[0.02]'
        ],
        'estudiante' => [
            'image' => '/images/dashboards/estudiante-bg.jpg',
            'gradient' => 'from-purple-900/90 via-violet-800/80 to-indigo-900/90',
            'pattern' => 'bg-grid-white/[0.02]'
        ]
    ];

    $config = $backgrounds[$role] ?? $backgrounds['admin'];
@endphp

<div class="fixed inset-0 -z-10 overflow-hidden">
    <!-- Imagen de fondo -->
    @if(file_exists(public_path($config['image'])))
        <div class="absolute inset-0">
            <img src="{{ $config['image'] }}" 
                 alt="Background {{ $role }}" 
                 class="w-full h-full object-cover"
                 loading="lazy">
        </div>
    @endif
    
    <!-- Overlay con gradiente -->
    @if($gradient)
        <div class="absolute inset-0 bg-gradient-to-br {{ $config['gradient'] }}"></div>
    @endif
    
    <!-- Patrón sutil -->
    <div class="absolute inset-0 {{ $config['pattern'] }}"></div>
    
    <!-- Overlay de opacidad adicional -->
    <div class="absolute inset-0 bg-black/20" style="opacity: {{ $opacity }}"></div>
</div>
