<!DOCTYPE html>
<html lang="es" data-theme="itibb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar — SisAcad</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/ITIBB.png') }}">
</head>
<body class="min-h-screen bg-gradient-to-br from-primary via-brand-800 to-slate-950 flex items-center justify-center p-4">
    
    {{-- Background decorative elements --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-secondary/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-primary/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-slate-950/50 rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-md relative animate-scale-in">

        {{-- Header con logos --}}
        <div class="text-center mb-8">
            <div class="flex justify-center gap-4 mb-6">
                <div class="w-20 h-20 rounded-2xl bg-white/10 backdrop-blur-sm ring-2 ring-white/20 shadow-2xl p-2 animate-fade-in">
                    <img src="{{ asset('images/ITIBB.png') }}" alt="ITIBB" class="w-full h-full object-contain">
                </div>
                <div class="w-20 h-20 rounded-2xl bg-white/10 backdrop-blur-sm ring-2 ring-white/20 shadow-2xl p-2 animate-fade-in animate-delay-100">
                    <img src="{{ asset('images/informatica.png') }}" alt="Informática" class="w-full h-full object-contain">
                </div>
            </div>
            <h1 class="font-display text-4xl font-bold text-white tracking-tight mb-2 animate-slide-up">
                SisAcad
            </h1>
            <p class="font-body text-white/70 text-sm animate-slide-up animate-delay-200">
                Instituto Tecnológico Industrial<br>Brasil-Bolivia
            </p>
        </div>

        {{-- Card principal --}}
        <div class="card-elevated shadow-2xl animate-slide-up animate-delay-300">
            <div class="card-body p-8">
                
                <div class="text-center mb-6">
                    <h2 class="font-display text-2xl font-semibold text-gray-800 mb-1">Iniciar Sesión</h2>
                    <p class="text-sm text-gray-500">Accede con tu credencial institucional</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-error mb-4 text-sm animate-shake">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                    @csrf
                    
                    <div class="form-control">
                        <label class="label py-1.5">
                            <span class="label-text text-xs font-semibold text-gray-600 uppercase tracking-wider">Carnet de Identidad (CI)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input type="text" name="ci" value="{{ old('ci') }}"
                                placeholder="Ej: 8765432" autofocus required
                                class="input-premium pl-12 @error('ci') input-error @enderror">
                        </div>
                    </div>

                    <div class="form-control">
                        <label class="label py-1.5">
                            <span class="label-text text-xs font-semibold text-gray-600 uppercase tracking-wider">Contraseña</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input type="password" name="password"
                                placeholder="••••••••" required
                                class="input-premium pl-12">
                        </div>
                    </div>

                    <div class="form-control">
                        <label class="label cursor-pointer justify-start gap-3">
                            <input type="checkbox" name="remember" class="checkbox checkbox-sm checkbox-primary">
                            <span class="label-text text-sm text-gray-600">Recordarme</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-gradient btn w-full h-12 text-base font-semibold tracking-wide">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0b8 4m-4-4v12m-4-4h12"/>
                        </svg>
                        Ingresar
                    </button>
                </form>

                <div class="divider text-xs text-gray-400 my-6">Información</div>

                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <p class="text-xs text-gray-500 text-center">
                        <span class="font-semibold text-gray-700">Contraseña inicial:</span><br>
                        <span class="font-mono text-primary">iniciales + dígitos CI</span>
                    </p>
                    <p class="text-[10px] text-gray-400 text-center mt-2">
                        Ejemplo: Si tu nombre es "Juan Pérez" y tu CI es 8765432,<br>
                        tu contraseña sería: <span class="font-mono">JP8765432</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <p class="text-center text-xs text-white/50 mt-6 animate-fade-in animate-delay-500">
            SisAcad · ITI Brasil-Bolivia · {{ date('Y') }}
        </p>
    </div>

    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>
</body>
</html>
