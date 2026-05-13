<!DOCTYPE html>
<html lang="es" data-theme="itibb">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema Académico ITI Brasil-Bolivia - Instituto Tecnológico Industrial. Gestiona estudiantes, docentes, materias, inscripciones y calificaciones.">
    <meta name="robots" content="index, follow">
    <meta name="author" content="ITI Brasil-Bolivia">
    <title>Sistema Académico | ITI Brasil-Bolivia</title>

    <link rel="canonical" href="{{ url('/') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebApplication",
      "name": "Sistema Académico ITI Brasil-Bolivia",
      "description": "Plataforma de gestión académica para instituciones educativas técnicas",
      "url": "{{ url('/') }}",
      "applicationCategory": "EducationApplication",
      "creator": {
        "@type": "Organization",
        "name": "Instituto Tecnológico Industrial Brasil-Bolivia",
        "url": "https://iti-bb.edu.bo"
      }
    }
    </script>
</head>
<body class="bg-base-200 min-h-screen flex flex-col">

    {{-- FONDO PATRÓN GEOMÉTRICO --}}
    <div class="fixed inset-0 z-0 opacity-40 pointer-events-none"
         style="background-image: url('data:image/svg+xml,%3Csvg width=%2260%22 height=%2260%22 viewBox=%220 0 60 60%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cg fill=%22none%22 fill-rule=%22evenodd%22%3E%3Cg fill=%22%231a3a6b%22 fill-opacity=%220.08%22%3E%3Cpath d=%22M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
    </div>

    {{-- HEADER --}}
    <header class="relative z-10 navbar text-white shadow-xl" style="background: linear-gradient(135deg, #1a3a6b 0%, #0f2744 100%);">
        <div class="flex-1 items-center gap-3">
            <div class="flex items-center gap-2">
                <div class="avatar">
                    <div class="w-11 h-11 rounded-xl bg-white/10 ring-2 ring-white/30 shadow-sm">
                        <img src="{{ asset('images/ITIBB.png') }}" class="object-contain p-1.5">
                    </div>
                </div>
                <div class="avatar">
                    <div class="w-11 h-11 rounded-xl bg-white/10 ring-2 ring-white/30 shadow-sm">
                        <img src="{{ asset('images/informatica.png') }}" class="object-contain p-1.5">
                    </div>
                </div>
            </div>
            <div class="hidden sm:block">
                <span class="font-display font-bold text-lg tracking-tight">Instituto Tecnológico</span>
                <span class="block text-[10px] text-white/60 font-body">Industrial Brasil-Bolivia</span>
            </div>
        </div>
        <div class="flex-none">
            <a href="{{ route('login') }}" class="btn btn-ghost text-white hover:bg-white/10 gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                <span class="hidden sm:inline">Iniciar Sesión</span>
            </a>
        </div>
    </header>

    {{-- HERO PRINCIPAL --}}
    <main class="relative z-10 flex-1 flex items-center justify-center p-6 md:p-10">
        <div class="max-w-5xl w-full">

            {{-- Badge --}}
            <div class="flex justify-center mb-8 animate-fade-in">
                <div class="badge badge-lg gap-2 px-4 py-3 bg-gradient-to-r from-primary/20 to-secondary/20 border-primary/30 text-primary">
                    <span class="w-2 h-2 rounded-full bg-success animate-pulse"></span>
                    Sistema Académico 2026
                </div>
            </div>

            {{-- Título Principal --}}
            <div class="text-center mb-6 animate-fade-in animate-delay-100">
                <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-bold text-base-content mb-4">
                    <span class="bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent bg-[length:200%_200%] animate-gradient">
                        Gestión Académica
                    </span>
                </h1>
                <p class="text-lg md:text-xl text-base-content/70 font-body max-w-2xl mx-auto">
                    Plataforma integral para el control de estudiantes, docentes, materias, inscripciones, calificaciones y asistencia.
                </p>
            </div>

            {{-- Tarjetas de Información --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10 animate-fade-in animate-delay-200">

                {{-- Tarjeta 1: Usuarios --}}
                <div class="card-elevated stat-card group hover:scale-[1.02] transition-all duration-300">
                    <div class="card-body p-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary to-primary/60 flex items-center justify-center mb-4 shadow-lg group-hover:shadow-xl transition-shadow">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a4 4 0 11-8 0 4 4 0 018 0zM17 20a4 4 0 100-8 4 4 0 000 8z"/>
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-xl text-base-content mb-2">Gestión de Usuarios</h3>
                        <p class="text-base-content/60 text-sm font-body">
                            Administradores, docentes y estudiantes con roles diferenciados y control de acceso seguro.
                        </p>
                    </div>
                </div>

                {{-- Tarjeta 2: Académico --}}
                <div class="card-elevated stat-card group hover:scale-[1.02] transition-all duration-300">
                    <div class="card-body p-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-secondary to-info flex items-center justify-center mb-4 shadow-lg group-hover:shadow-xl transition-shadow">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-xl text-base-content mb-2">Control Académico</h3>
                        <p class="text-base-content/60 text-sm font-body">
                            Materias, períodos lectivos, inscripciones y asignación de cursos por docente.
                        </p>
                    </div>
                </div>

                {{-- Tarjeta 3: Evaluación --}}
                <div class="card-elevated stat-card group hover:scale-[1.02] transition-all duration-300">
                    <div class="card-body p-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-accent to-warning flex items-center justify-center mb-4 shadow-lg group-hover:shadow-xl transition-shadow">
                            <svg class="w-7 h-7 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-xl text-base-content mb-2">Evaluación Integral</h3>
                        <p class="text-base-content/60 text-sm font-body">
                            Registro de notas por categorías, promedio ponderado y auditoría automática de cambios.
                        </p>
                    </div>
                </div>
            </div>

            {{-- CTA Principal --}}
            <div class="text-center mt-12 animate-fade-in animate-delay-300">
                <a href="{{ route('login') }}" class="btn btn-lg btn-gradient gap-3 px-8 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Acceder al Sistema
                </a>
            </div>

            {{-- Información adicional --}}
            <div class="flex flex-wrap justify-center gap-4 mt-8 text-base-content/50 text-sm animate-fade-in animate-delay-400">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-success" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Acceso por CI</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-success" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Intranet Local</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-success" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Sin internet requerido</span>
                </div>
            </div>

        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="relative z-10 footer bg-base-100 border-t border-base-200 py-6">
        <div class="text-center text-base-content/50 text-sm">
            <p>&copy; 2026 <span class="font-semibold text-primary">ITI Brasil-Bolivia</span>. Todos los derechos reservados.</p>
            <p class="text-xs mt-1">Instituto Tecnológico Industrial Brasil-Bolivia - Carrera de Informática Industrial</p>
        </div>
    </footer>

    <style>
        @keyframes gradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .animate-gradient {
            animation: gradient 5s ease infinite;
        }
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
            opacity: 0;
        }
        .animate-delay-100 { animation-delay: 0.1s; }
        .animate-delay-200 { animation-delay: 0.2s; }
        .animate-delay-300 { animation-delay: 0.3s; }
        .animate-delay-400 { animation-delay: 0.4s; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>