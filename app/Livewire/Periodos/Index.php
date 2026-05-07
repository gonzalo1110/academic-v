<?php

namespace App\Livewire\Periodos;

use App\Models\Periodo;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Períodos')]
class Index extends Component
{
    use WithPagination;

    public bool $modalConfirmar = false;
    public ?int $periodoAEliminar = null;

    public function activar(int $id): void
    {
        Periodo::where('activo', true)->update(['activo' => false]);
        Periodo::findOrFail($id)->update(['activo' => true]);
        session()->flash('success', 'Período activado correctamente.');
    }

    public function confirmarEliminar(int $id): void
    {
        $this->periodoAEliminar = $id;
        $this->modalConfirmar = true;
    }

    public function eliminar(): void
    {
        if ($this->periodoAEliminar) {
            Periodo::findOrFail($this->periodoAEliminar)->delete();
            $this->modalConfirmar = false;
            $this->periodoAEliminar = null;
            session()->flash('success', 'Período eliminado correctamente.');
        }
    }

    public function render()
    {
        $periodos = Periodo::orderByDesc('fecha_inicio')->paginate(10);
        return view('livewire.periodos.index', compact('periodos'));
    }
}
