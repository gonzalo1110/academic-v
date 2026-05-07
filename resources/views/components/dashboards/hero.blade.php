{{-- Hero section para dashboards con imágenes de fondo --}}
@props([
    'title' => 'Dashboard',
    'subtitle' => '',
    'role' => 'admin',
    'stats' => []
])

<div class="relative overflow-hidden rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 shadow-2xl">
    <!-- Background component -->
    <x-dashboards.background :role="$role" :opacity="0.05" />
    
    <!-- Contenido -->
    <div class="relative px-6 py-8 sm:px-8 sm:py-12 lg:px-12 lg:py-16">
        <div class="max-w-7xl mx-auto">
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 drop-shadow-lg">
                    {{ $title }}
                </h1>
                @if($subtitle)
                    <p class="text-lg sm:text-xl text-white/90 mb-8 drop-shadow">
                        {{ $subtitle }}
                    </p>
                @endif
                
                <!-- Stats -->
                @if(!empty($stats))
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
                        @foreach($stats as $stat)
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                                <div class="text-2xl sm:text-3xl font-bold text-white mb-1">
                                    {{ $stat['value'] }}
                                </div>
                                <div class="text-sm text-white/80">
                                    {{ $stat['label'] }}
                                </div>
                                @if(isset($stat['change']))
                                    <div class="text-xs mt-1 {{ $stat['change'] > 0 ? 'text-green-300' : 'text-red-300' }}">
                                        {{ $stat['change'] > 0 ? '+' : '' }}{{ $stat['change'] }}%
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
