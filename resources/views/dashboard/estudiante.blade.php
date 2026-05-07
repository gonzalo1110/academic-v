<x-layouts.app title="Mi rendimiento académico">
    <x-slot name="header">
        <h2 class="text-lg font-bold text-base-content">Mi rendimiento académico</h2>
        <p class="text-sm text-base-content/60">{{ auth()->user()->nombre_completo }}</p>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="stat bg-base-100 rounded-xl shadow">
            <div class="stat-title text-xs">Materias inscritas</div>
            <div class="stat-value text-2xl text-primary">—</div>
            <div class="stat-desc">este período</div>
        </div>
        <div class="stat bg-base-100 rounded-xl shadow">
            <div class="stat-title text-xs">Promedio global</div>
            <div class="stat-value text-2xl text-secondary">—</div>
            <div class="stat-desc">puntos</div>
        </div>
        <div class="stat bg-base-100 rounded-xl shadow">
            <div class="stat-title text-xs">Asistencia</div>
            <div class="stat-value text-2xl text-accent">—</div>
            <div class="stat-desc">promedio</div>
        </div>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h3 class="card-title text-sm">Mis materias</h3>
            <p class="text-sm text-base-content/60">Aquí verás tus notas y asistencia por materia.</p>
        </div>
    </div>
</x-layouts.app>
