<?php

namespace App\Livewire\Usuarios;

use App\Models\Usuario;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Gestión de Usuarios')]
class Index extends Component
{
    use WithPagination;

    public string $buscar = '';
    public string $filtroRol = '';
    public ?int $filtroSemestre = null;
    public bool $modalConfirmar = false;
    public ?int $usuarioAEliminar = null;

    protected $queryString = ['buscar', 'filtroRol', 'filtroSemestre'];

    public function updatingBuscar(): void { $this->resetPage(); }
    public function updatingFiltroRol(): void { 
        $this->resetPage(); 
        $this->filtroSemestre = null;
    }

    public function updatedFiltroRol(): void
    {
        $this->filtroSemestre = null;
    }
    public function updatingFiltroSemestre(): void { $this->resetPage(); }

    public function confirmarEliminar(int $id): void
    {
        $this->usuarioAEliminar = $id;
        $this->modalConfirmar = true;
    }

    public function eliminar(): void
    {
        if ($this->usuarioAEliminar) {
            $usuario = Usuario::findOrFail($this->usuarioAEliminar);
            
            if ($usuario->docente) {
                $usuario->docente->delete();
            }
            if ($usuario->estudiante) {
                $usuario->estudiante->delete();
            }
            
            $usuario->delete();
            $this->modalConfirmar = false;
            $this->usuarioAEliminar = null;
            session()->flash('success', 'Usuario eliminado correctamente.');
        }
    }

    public function render()
    {
        $usuarios = Usuario::with(['docente', 'estudiante'])
            ->when($this->buscar, fn($q) =>
                $q->where('ci', 'like', "%{$this->buscar}%")
                  ->orWhere('primer_nombre', 'like', "%{$this->buscar}%")
                  ->orWhere('primer_apellido', 'like', "%{$this->buscar}%")
            )
            ->when($this->filtroRol, fn($q) => $q->where('rol', $this->filtroRol))
            ->when($this->filtroRol === 'estudiante' && $this->filtroSemestre, fn($q) => 
                $q->whereHas('estudiante', fn($sq) => $sq->where('semestre_actual', $this->filtroSemestre))
            )
            ->orderBy('primer_apellido')
            ->paginate(12);

        return view('livewire.usuarios.index', compact('usuarios'));
    }
}
