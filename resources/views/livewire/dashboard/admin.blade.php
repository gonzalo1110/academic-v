<div>
    <x-header title="Resumen del Sistema" subtitle="Panel de control para la gestión académica">
        <x-slot:actions>
            <span style="">
                <svg style="width:16px;height:16px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Periodo Actual: {{ $stats['periodo_activo'] }}
            </span>
        </x-slot:actions>
    </x-header>

    <div style="">
        <x-stat title="Usuarios Totales" value="{{ $stats['usuarios'] }}" icon="o-users" style="" />
        <x-stat title="Estudiantes" value="{{ $stats['estudiantes'] }}" icon="o-academic-cap" style="" />
        <x-stat title="Docentes" value="{{ $stats['docentes'] }}" icon="o-briefcase" style="" />
        <x-stat title="Materias" value="{{ $stats['materias'] }}" icon="o-book-open" style="" />
    </div>

    <div style="">
        <x-card title="Accesos Rápidos" separator progress-indicator>
            <div style="">
                <x-button label="Gestionar Usuarios" icon="o-user-group" link="{{ route('admin.usuarios') }}" style="" />
                <x-button label="Importar Excel" icon="o-document-arrow-up" style="" />
                <x-button label="Configurar Periodos" icon="o-calendar" style="" />
                <x-button label="Copia de Seguridad" icon="o-cpu-chip" style="" />
            </div>
        </x-card>

        <x-card title="Estado de Inteligencia Artificial" subtitle="Conexión con Ollama SLM" separator>
            <div style="">
                <div style=""></div>
                <span style="">Servidor Ollama: <strong>Activo</strong></span>
            </div>
            <div style="">
                Modelo configurado: qwen2.5:3b (Optimizado para i5 7ma Gen)
            </div>
        </x-card>
    </div>
</div>
