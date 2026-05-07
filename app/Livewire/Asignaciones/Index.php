<?php

namespace App\Livewire\Asignaciones;

use App\Models\Asignacion;
use App\Models\Periodo;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Asignaciones')]
class Index extends Component
{
    use WithPagination;

    public string $filtroPeriodo = '';
    public bool $modalConfirmar = false;
    public ?int $asignacionAEliminar = null;

    public function mount(): void
    {
        $periodoActivo = Periodo::activo();
        if ($periodoActivo) {
            $this->filtroPeriodo = (string) $periodoActivo->id;
        }
    }

    public function updatingFiltroPeriodo(): void { $this->resetPage(); }

    public function confirmarEliminar(int $id): void
    {
        $this->asignacionAEliminar = $id;
        $this->modalConfirmar = true;
    }

    public function eliminar(): void
    {
        if ($this->asignacionAEliminar) {
            Asignacion::findOrFail($this->asignacionAEliminar)->delete();
            $this->modalConfirmar = false;
            $this->asignacionAEliminar = null;
            session()->flash('success', 'Asignación eliminada correctamente.');
        }
    }

    public function render()
    {
        $asignaciones = Asignacion::with(['materia', 'periodo', 'docente.usuario'])
            ->when($this->filtroPeriodo, fn($q) => $q->where('periodo_id', $this->filtroPeriodo))
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $periodos = Periodo::orderByDesc('fecha_inicio')->get();

        return view('livewire.asignaciones.index', compact('asignaciones', 'periodos'));
    }
}
