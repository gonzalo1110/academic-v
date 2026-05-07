<?php

namespace App\Livewire\Materias;

use App\Models\Materia;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Materias')]
class Index extends Component
{
    use WithPagination;

    public string $buscar = '';
    public bool $modalConfirmar = false;
    public ?int $materiaAEliminar = null;

    protected $queryString = ['buscar'];

    public function updatingBuscar(): void { $this->resetPage(); }

    public function confirmarEliminar(int $id): void
    {
        $this->materiaAEliminar = $id;
        $this->modalConfirmar = true;
    }

    public function eliminar(): void
    {
        if ($this->materiaAEliminar) {
            Materia::findOrFail($this->materiaAEliminar)->delete();
            $this->modalConfirmar = false;
            $this->materiaAEliminar = null;
            session()->flash('success', 'Materia eliminada correctamente.');
        }
    }

    public function render()
    {
        $materias = Materia::when($this->buscar, fn($q) =>
                $q->where('nombre', 'like', "%{$this->buscar}%")
                  ->orWhere('codigo', 'like', "%{$this->buscar}%")
            )
            ->orderBy('semestre_curricular')
            ->orderBy('nombre')
            ->paginate(15);

        return view('livewire.materias.index', compact('materias'));
    }
}
