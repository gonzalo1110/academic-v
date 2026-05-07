<?php

namespace App\Livewire\Inscripciones;

use App\Models\Inscripcion;
use App\Models\Asignacion;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Inscripciones')]
class Index extends Component
{
    use WithPagination;

    public string $buscar = '';
    public string $filtroAsignacion = '';
    public bool $modalConfirmar = false;
    public ?int $inscripcionAEliminar = null;

    protected $queryString = ['buscar', 'filtroAsignacion'];

    public function updatingBuscar(): void { $this->resetPage(); }
    public function updatingFiltroAsignacion(): void { $this->resetPage(); }

    public function confirmarEliminar(int $id): void
    {
        $this->inscripcionAEliminar = $id;
        $this->modalConfirmar = true;
    }

    public function eliminar(): void
    {
        if ($this->inscripcionAEliminar) {
            Inscripcion::findOrFail($this->inscripcionAEliminar)->delete();
            $this->modalConfirmar = false;
            $this->inscripcionAEliminar = null;
            session()->flash('success', 'Inscripción eliminada correctamente.');
        }
    }

    public function render()
    {
        $inscripciones = Inscripcion::with([
            'estudiante.usuario',
            'asignacion.materia',
            'asignacion.periodo',
            'asignacion.docente.usuario',
            'inscritoPor'
        ])
        ->when($this->filtroAsignacion, fn($q) => $q->where('asignacion_id', $this->filtroAsignacion))
        ->when($this->buscar, fn($q) => 
            $q->whereHas('estudiante.usuario', fn($sub) =>
                $sub->where('ci', 'like', "%{$this->buscar}%")
                   ->orWhere('primer_nombre', 'like', "%{$this->buscar}%")
                   ->orWhere('primer_apellido', 'like', "%{$this->buscar}%")
            )
        )
        ->orderBy('created_at', 'desc')
        ->paginate(12);

        $asignaciones = Asignacion::with(['materia', 'periodo', 'docente.usuario'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.inscripciones.index', compact('inscripciones', 'asignaciones'));
    }
}
