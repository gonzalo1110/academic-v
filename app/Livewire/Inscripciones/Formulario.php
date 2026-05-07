<?php

namespace App\Livewire\Inscripciones;

use App\Models\Inscripcion;
use App\Models\Asignacion;
use App\Models\Estudiante;
use App\Models\Materia;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Inscripción')]
class Formulario extends Component
{
    public ?int $asignacion_id = null;
    public ?int $estudiante_id = null;
    public $asignacionInfo = null;

    protected function rules(): array
    {
        return [
            'asignacion_id' => 'required|exists:asignaciones,id',
            'estudiante_id' => 'required|exists:estudiantes,id',
        ];
    }

    public function updatedAsignacionId($value): void
    {
        $this->asignacionInfo = null;
        $this->estudiante_id = null;

        if ($this->asignacion_id) {
            $this->asignacionInfo = Asignacion::with([
                'materia.prerequisitos',
                'periodo',
                'docente.usuario'
            ])->find($this->asignacion_id);
        }
    }

    public function getEstudiantesProperty()
    {
        // Cargar todos los estudiantes activos (sin filtrar por semestre)
        return Estudiante::with('usuario')
            ->whereHas('usuario', fn($q) => $q->where('activo', true))
            ->get()
            ->sortBy('usuario.primer_apellido');
    }

    public function guardar(): void
    {
        $this->validate();

        // Validar prerrequisitos
        if (!$this->estudiantePuedeCursar($this->estudiante_id, $this->asignacion_id)) {
            $this->addError('estudiante_id', 'El estudiante no cumple los prerrequisitos para esta materia.');
            return;
        }

        // Validar duplicado
        $existe = Inscripcion::where('estudiante_id', $this->estudiante_id)
            ->where('asignacion_id', $this->asignacion_id)
            ->exists();

        if ($existe) {
            $this->addError('estudiante_id', 'Este estudiante ya está inscrito en esta asignación.');
            return;
        }

        Inscripcion::create([
            'estudiante_id' => $this->estudiante_id,
            'asignacion_id' => $this->asignacion_id,
            'inscrito_por' => auth()->id(),
        ]);

        $this->dispatch('inscripcionGuardada');
        session()->flash('success', 'Inscripción realizada correctamente.');
        $this->redirect(route('admin.inscripciones'));
    }

    /**
     * Verifica si un estudiante puede cursar una asignación basado en prerrequisitos
     */
    private function estudiantePuedeCursar(int $estudianteId, int $asignacionId): bool
    {
        $asignacion = Asignacion::with('materia.prerequisitos')->findOrFail($asignacionId);
        $prerequisitos = $asignacion->materia->prerequisitos;

        // Sin prerrequisitos: puede inscribirse siempre
        if ($prerequisitos->isEmpty()) {
            return true;
        }

        // Verificar cada prerrequisito
        foreach ($prerequisitos as $prerequisito) {
            $aprobo = Inscripcion::where('estudiante_id', $estudianteId)
                ->whereHas('asignacion', fn($q) =>
                    $q->where('materia_id', $prerequisito->id)
                )
                ->with(['notas', 'asignacion.categorias'])
                ->get()
                ->contains(fn($inscripcion) =>
                    $inscripcion->calcularPromedioActual() >= 61
                );

            if (!$aprobo) {
                return false;
            }
        }
        return true;
    }

    public function cancelar(): void
    {
        $this->redirect(route('admin.inscripciones'));
    }

    public function render()
    {
        $asignaciones = Asignacion::with(['materia', 'periodo', 'docente.usuario'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.inscripciones.formulario', [
            'asignaciones' => $asignaciones,
            'estudiantes' => $this->estudiantes,
        ]);
    }
}
