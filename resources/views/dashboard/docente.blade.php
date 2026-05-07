<x-layouts.app title="Dashboard Docente">
    <x-slot name="header">
        <h2 class="text-lg font-bold text-base-content">Dashboard</h2>
        <p class="text-sm text-base-content/60">Bienvenido, {{ auth()->user()->nombre_completo }}</p>
    </x-slot>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stat bg-base-100 rounded-xl shadow">
            <div class="stat-title text-xs">Estudiantes</div>
            <div class="stat-value text-2xl text-primary">—</div>
            <div class="stat-desc">en tu materia</div>
        </div>
        <div class="stat bg-base-100 rounded-xl shadow">
            <div class="stat-title text-xs">Promedio aula</div>
            <div class="stat-value text-2xl text-secondary">—</div>
            <div class="stat-desc">puntos</div>
        </div>
        <div class="stat bg-base-100 rounded-xl shadow">
            <div class="stat-title text-xs">En riesgo</div>
            <div class="stat-value text-2xl text-error">—</div>
            <div class="stat-desc">promedio &lt; 61</div>
        </div>
        <div class="stat bg-base-100 rounded-xl shadow">
            <div class="stat-title text-xs">Asistencia</div>
            <div class="stat-value text-2xl text-accent">—</div>
            <div class="stat-desc">promedio</div>
        </div>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h3 class="card-title text-sm">Panel docente</h3>
            <p class="text-sm text-base-content/60">Selecciona una materia del menú para comenzar.</p>
        </div>
    </div>
</x-layouts.app>
