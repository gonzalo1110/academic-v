<?php

namespace App\Livewire\Docente;

use App\Models\Asignacion;
use App\Models\CategoriaEvaluacion;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Configurar Categorías')]
class Categorias extends Component
{
    public int $asignacionId;
    public ?Asignacion $asignacion = null;
    public array $categorias = [];
    public array $totales = [];

    public function mount(Asignacion $asignacion): void
    {
        $this->asignacionId = $asignacion->id;
        $this->asignacion = $asignacion->load([
            'materia',
            'periodo',
            'docente.usuario',
            'categorias',
        ]);

        // Agrupar categorías por parcial
        $this->categorias = $this->asignacion->categorias->groupBy('parcial')->toArray();
        
        // Calcular totales por parcial
        foreach ($this->categorias as $parcial => $cats) {
            $this->totales[$parcial] = array_sum(array_column($cats, 'peso_porcentual'));
        }
    }

    public function agregarCategoria(int $parcial): void
    {
        $this->categorias[$parcial][] = [
            'nombre' => '',
            'peso_porcentual' => 0,
            'id' => 'temp_' . time() . '_' . $parcial
        ];
    }

    public function quitarCategoria(int $parcial, int $index): void
    {
        if (isset($this->categorias[$parcial][$index])) {
            unset($this->categorias[$parcial][$index]);
            $this->categorias[$parcial] = array_values($this->categorias[$parcial]);
            $this->recalcularTotal($parcial);
        }
    }

    public function recalcularTotal(int $parcial): void
    {
        $this->totales[$parcial] = array_sum(array_column($this->categorias[$parcial] ?? [], 'peso_porcentual'));
    }

    public function guardar(): void
    {
        // Eliminar categorías existentes
        CategoriaEvaluacion::where('asignacion_id', $this->asignacionId)->delete();

        // Crear nuevas categorías
        foreach ($this->categorias as $parcial => $cats) {
            foreach ($cats as $cat) {
                if (!empty($cat['nombre']) && $cat['peso_porcentual'] > 0) {
                    CategoriaEvaluacion::create([
                        'asignacion_id' => $this->asignacionId,
                        'nombre' => $cat['nombre'],
                        'peso_porcentual' => $cat['peso_porcentual'],
                        'parcial' => $parcial,
                    ]);
                }
            }
        }

        session()->flash('success', 'Categorías configuradas correctamente.');
        $this->redirect(route('docente.materias'));
    }

    public function render()
    {
        return view('livewire.docente.categorias');
    }
}
