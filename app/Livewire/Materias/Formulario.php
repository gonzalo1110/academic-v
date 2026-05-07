<?php

namespace App\Livewire\Materias;

use App\Models\Materia;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Materia')]
class Formulario extends Component
{
    public ?int $materiaId = null;
    public string $nombre = '';
    public string $sigla = '';
    public string $numero = '';
    public string $codigo = '';
    public int $semestre_curricular = 1;
    public array $prerequisitosSeleccionados = [];

    protected function rules(): array
    {
        $codigoRule = $this->materiaId
            ? 'required|string|max:20|unique:materias,codigo,' . $this->materiaId
            : 'required|string|max:20|unique:materias,codigo';

        return [
            'nombre'              => 'required|string|max:150',
            'sigla'               => 'required|string|max:10',
            'numero'              => 'required|in:100,200,300,400,500,600',
            'codigo'              => $codigoRule,
            'semestre_curricular' => 'required|integer|min:1|max:6',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $materia = Materia::findOrFail($id);
            $this->materiaId          = $materia->id;
            $this->nombre             = $materia->nombre;
            $this->codigo             = $materia->codigo;
            $this->semestre_curricular = $materia->semestre_curricular;
            
            // Separar código existente
            $partes = explode(' - ', $materia->codigo, 2);
            $this->sigla  = $partes[0] ?? '';
            $this->numero = $partes[1] ?? '';
            
            // Cargar prerrequisitos
            $this->prerequisitosSeleccionados = $materia->prerequisitos->pluck('id')->toArray();
        }
    }

    public function updatedNumero(): void
    {
        if ($this->numero) {
            $this->semestre_curricular = (int)($this->numero / 100);
        }
    }

    public function guardar(): void
    {
        // Generar código antes de validar
        $this->codigo = strtoupper(trim($this->sigla)) . ' - ' . trim($this->numero);
        $this->validate();

        $materia = Materia::updateOrCreate(
            ['id' => $this->materiaId],
            [
                'nombre'             => $this->nombre,
                'codigo'             => $this->codigo,
                'semestre_curricular' => $this->semestre_curricular,
            ]
        );

        // Sincronizar prerrequisitos
        $materia->prerequisitos()->sync($this->prerequisitosSeleccionados);

        $this->dispatch('materiaGuardada');
        session()->flash('success', 'Materia guardada correctamente.');
        $this->redirect(route('admin.materias'));
    }

    public function cancelar(): void
    {
        $this->redirect(route('admin.materias'));
    }

    public function render()
    {
        $materiasDisponibles = Materia::where('id', '!=', $this->materiaId ?? 0)
            ->orderBy('semestre_curricular')
            ->orderBy('nombre')
            ->get();

        return view('livewire.materias.formulario', [
            'materiasDisponibles' => $materiasDisponibles
        ]);
    }
}
