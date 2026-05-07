<?php

namespace App\Livewire\Dashboard;

use App\Models\Usuario;
use App\Models\Materia;
use App\Models\Periodo;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Dashboard Administrador')]
class Admin extends Component
{
    public function render()
    {
        // Métricas rápidas
        $stats = [
            'usuarios' => Usuario::count(),
            'estudiantes' => Usuario::where('rol', 'estudiante')->count(),
            'docentes' => Usuario::where('rol', 'docente')->count(),
            'materias' => Materia::count(),
            'periodo_activo' => Periodo::where('activo', true)->first()?->nombre ?? 'Ninguno',
        ];

        return view('livewire.dashboard.admin', [
            'stats' => $stats
        ]);
    }
}
