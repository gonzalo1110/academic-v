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
    public bool $modalConfirmar = false;
    public ?int $usuarioAEliminar = null;

    protected $queryString = ['buscar', 'filtroRol'];

    public function updatingBuscar(): void { $this->resetPage(); }
    public function updatingFiltroRol(): void { $this->resetPage(); }

    public function confirmarEliminar(int $id): void
    {
        $this->usuarioAEliminar = $id;
        $this->modalConfirmar = true;
    }

    public function eliminar(): void
    {
        if ($this->usuarioAEliminar) {
            Usuario::findOrFail($this->usuarioAEliminar)->delete();
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
            ->orderBy('primer_apellido')
            ->paginate(12);

        return view('livewire.usuarios.index', compact('usuarios'));
    }
}
