<?php

namespace App\Livewire\Docente;

use App\Models\Asignacion;
use App\Models\Nota;
use App\Models\CategoriaEvaluacion;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Registro de Notas')]
class Notas extends Component
{
    public int $asignacionId;
    public ?Asignacion $asignacion = null;
    public $inscripciones;
    public $categorias;
    public array $notas = [];
    public int $parcialActivo = 1;

    public function mount(Asignacion $asignacion): void
    {
        $this->asignacionId = $asignacion->id;
        $this->asignacion = $asignacion->load([
            'materia',
            'periodo',
            'docente.usuario',
            'categorias',
            'inscripciones.estudiante.usuario',
            'inscripciones.notas',
            'inscripciones.asignacion.categorias',
        ]);

        $this->categorias = $this->asignacion->categorias
            ->where('parcial', $this->parcialActivo)
            ->values();
        $this->inscripciones = $this->asignacion->inscripciones;

        // Cargar notas existentes
        foreach ($this->inscripciones as $inscripcion) {
            foreach ($inscripcion->notas as $nota) {
                $this->notas[$inscripcion->id][$nota->categoria_id] = $nota->valor;
            }
        }
    }

    public function actualizarNota(int $inscripcionId, int $categoriaId, float $valor): void
    {
        // Validar que el valor esté entre 0 y 100
        if ($valor < 0 || $valor > 100) {
            session()->flash('error', 'La nota debe estar entre 0 y 100.');
            return;
        }

        // Buscar o crear la nota
        $nota = Nota::updateOrCreate(
            [
                'inscripcion_id' => $inscripcionId,
                'categoria_id' => $categoriaId,
                'parcial' => $this->parcialActivo,
            ],
            [
                'valor' => $valor,
                'parcial' => $this->parcialActivo,
                'editado_por' => auth()->id(),
            ]
        );

        // Actualizar el array de notas para el frontend
        $this->notas[$inscripcionId][$categoriaId] = $valor;

        session()->flash('success', 'Nota actualizada correctamente.');
    }

    public function calcularPromedio(int $inscripcionId, int $parcial = null): float
    {
        $promedio = 0.0;
        $categorias = $this->asignacion->categorias;
        if ($parcial) {
            $categorias = $categorias->where('parcial', $parcial);
        }

        foreach ($categorias as $categoria) {
            $valor = $this->notas[$inscripcionId][$categoria->id] ?? 0;
            $promedio += ($valor * $categoria->peso_porcentual) / 100;
        }
        return round($promedio, 2);
    }

    public function calcularPromedioFinal(int $inscripcionId): float
    {
        $p1 = $this->calcularPromedio($inscripcionId, 1);
        $p2 = $this->calcularPromedio($inscripcionId, 2);
        return round(($p1 + $p2) / 2, 2);
    }

    public function render()
    {
        return view('livewire.docente.notas');
    }
}
