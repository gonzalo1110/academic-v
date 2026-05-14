<?php

namespace App\Livewire\Periodos;

use App\Models\Periodo;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Período')]
class Formulario extends Component
{
    public ?int $periodoId = null;
    public string $nombre = '';
    public string $fecha_inicio = '';
    public string $fecha_fin = '';
    public bool $activo = false;

    protected function rules(): array
    {
        return [
            'nombre'       => 'required|string|max:20|regex:/^(I|II)\s*-\s*\d{4}$/',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after:fecha_inicio',
            'activo'       => 'boolean',
        ];
    }

    protected function messages(): array
    {
        return [
            'nombre.regex' => 'El formato debe ser: I - 2026 o II - 2026',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $periodo = Periodo::findOrFail($id);
            $this->periodoId   = $periodo->id;
            $this->nombre      = $periodo->nombre;
            $this->fecha_inicio = $periodo->fecha_inicio->format('Y-m-d');
            $this->fecha_fin    = $periodo->fecha_fin->format('Y-m-d');
            $this->activo      = $periodo->activo;
        }
    }

    public function guardar(): void
    {
        $this->validate();

        if ($this->activo) {
            Periodo::where('activo', true)->update(['activo' => false]);
        }

        Periodo::updateOrCreate(
            ['id' => $this->periodoId],
            [
                'nombre'       => $this->nombre,
                'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin'    => $this->fecha_fin,
                'activo'       => $this->activo,
            ]
        );

        $accion = $this->periodoId ? 'actualizado' : 'creado';
        session()->flash('success', "Período {$accion} correctamente.");
        $this->redirect(route('admin.periodos'));
    }

    public function cancelar(): void
    {
        $this->redirect(route('admin.periodos'));
    }

    public function render()
    {
        return view('livewire.periodos.formulario');
    }
}
