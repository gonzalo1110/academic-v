<?php

namespace App\Livewire\Docente;

use App\Models\Asignacion;
use App\Models\Asistencia;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Registro de Asistencia')]
class AsistenciaRegistro extends Component
{
    public int $asignacionId;
    public ?Asignacion $asignacion = null;
    public $inscripciones;
    public array $asistencias = [];
    public array $porcentajes = [];
    public string $fecha = '';
    public int $parcialActivo = 1;

    public function mount(Asignacion $asignacion): void
    {
        $this->asignacionId = $asignacion->id;
        $this->asignacion = $asignacion->load([
            'materia',
            'periodo',
            'docente.usuario',
            'inscripciones.estudiante.usuario',
            'inscripciones.asistencias',
        ]);

        $this->inscripciones = $this->asignacion->inscripciones;
        $this->fecha = date('Y-m-d');

        // Calcular porcentajes de asistencia
        foreach ($this->inscripciones as $inscripcion) {
            $totalClases = 20; // Asumir 20 clases por parcial
            $asistencias = $inscripcion->asistencias->count();
            $this->porcentajes[$inscripcion->id] = $totalClases > 0 ? round(($asistencias / $totalClases) * 100, 1) : 0;
        }
    }

    public function registrarAsistencia(int $inscripcionId, string $estado): void
    {
        if (empty($this->fecha)) {
            session()->flash('error', 'Debe seleccionar una fecha.');
            return;
        }

        // Verificar si ya existe registro para esta fecha
        $existente = Asistencia::where('inscripcion_id', $inscripcionId)
            ->where('fecha', $this->fecha)
            ->first();

        if ($existente) {
            $existente->estado = $estado;
            $existente->save();
        } else {
            Asistencia::create([
                'inscripcion_id' => $inscripcionId,
                'fecha' => $this->fecha,
                'estado' => $estado,
            ]);
        }

        // Actualizar array para frontend
        $this->asistencias[$inscripcionId] = $estado;

        session()->flash('success', 'Asistencia registrada correctamente.');
    }

    public function render()
    {
        return view('livewire.docente.asistencia');
    }
}
