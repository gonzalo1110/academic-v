<?php

namespace App\Livewire\Notas;

use App\Models\Asignacion;
use App\Models\Nota;
use App\Models\CategoriaEvaluacion;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Notas')]
class Index extends Component
{
    public int $asignacionId;
    public ?Asignacion $asignacion = null;
    public $inscripciones;
    public $categorias;
    public array $notas = [];
    public int $estudianteSeleccionado = 0;

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
        ]);

        $this->categorias = $this->asignacion->categorias;

        $this->inscripciones = $this->asignacion->inscripciones()
            ->with(['estudiante.usuario', 'notas'])
            ->get();

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
            ],
            [
                'valor' => $valor,
                'editado_por' => auth()->id(),
            ]
        );

        // Actualizar el array de notas para el frontend
        $this->notas[$inscripcionId][$categoriaId] = $valor;

        session()->flash('success', 'Nota actualizada correctamente.');
    }

    public function calcularPromedio(int $inscripcionId): float
    {
        $promedio = 0.0;
        foreach ($this->asignacion->categorias as $categoria) {
            $valor = $this->notas[$inscripcionId][$categoria->id] ?? 0;
            $promedio += ($valor * $categoria->peso_porcentual) / 100;
        }
        return round($promedio, 2);
    }

    public function esAprobado(int $inscripcionId): bool
    {
        return $this->calcularPromedio($inscripcionId) >= 61;
    }

    public function updated($property, $value): void
    {
        // property format: notas.{inscripcionId}.{categoriaId}
        if (str_starts_with($property, 'notas.')) {
            $parts = explode('.', $property);
            if (count($parts) === 3) {
                $this->actualizarNota((int)$parts[1], (int)$parts[2], (float)$value);
            }
        }
    }

    public function render()
    {
        return view('livewire.notas.index');
    }
}
