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
    public array $stats = [];
    public array $iaStatus = [];

    public function mount(): void
    {
        $this->cargarStats();
        $this->verificarOllama();
    }

    private function cargarStats(): void
    {
        $this->stats = [
            'usuarios' => Usuario::count(),
            'estudiantes' => Usuario::where('rol', 'estudiante')->count(),
            'docentes' => Usuario::where('rol', 'docente')->count(),
            'materias' => Materia::count(),
            'periodo_activo' => Periodo::where('activo', true)->first()?->nombre_formateado ?? 'Ninguno',
        ];
    }

    private function verificarOllama(): void
    {
        try {
            $ch = curl_init('http://localhost:11434/api/tags');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                $data = json_decode($response, true);
                $modelos = $data['models'] ?? [];
                
                $modeloActivo = collect($modelos)->firstWhere('name', 'like', '%qwen%');
                
                $this->iaStatus = [
                    'disponible' => true,
                    'modelo' => $modeloActivo ? $modeloActivo['name'] : 'qwen2.5:3b',
                    'modelos' => array_map(fn($m) => $m['name'], $modelos),
                ];
            } else {
                $this->iaStatus = [
                    'disponible' => false,
                    'modelo' => null,
                    'error' => 'Sin respuesta',
                ];
            }
        } catch (\Exception $e) {
            $this->iaStatus = [
                'disponible' => false,
                'modelo' => null,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function render()
    {
        return view('livewire.dashboard.admin');
    }
}