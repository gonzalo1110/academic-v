<?php

namespace App\Livewire\Asignaciones;

use App\Models\Asignacion;
use App\Models\CategoriaEvaluacion;
use App\Models\Materia;
use App\Models\Periodo;
use App\Models\Docente;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Asignación')]
class Formulario extends Component
{
    public ?int $asignacionId = null;
    public string $materia_id = '';
    public string $periodo_id = '';
    public string $docente_id = '';
    public string $aula = '';
    public bool $considera_asistencia = false;
    public array $categorias = [];

    protected function rules(): array
    {
        return [
            'materia_id'           => 'required|exists:materias,id',
            'periodo_id'           => 'required|exists:periodos,id',
            'docente_id'           => 'required|exists:docentes,id',
            'aula'                 => 'nullable|string|max:100',
            'considera_asistencia' => 'boolean',
            'categorias'           => 'required|array|min:1',
            'categorias.*.nombre'  => 'required|string|max:100',
            'categorias.*.peso'    => 'required|numeric|min:1|max:100',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $asignacion = Asignacion::with('categorias')->findOrFail($id);
            $this->asignacionId         = $asignacion->id;
            $this->materia_id           = (string) $asignacion->materia_id;
            $this->periodo_id           = (string) $asignacion->periodo_id;
            $this->docente_id           = (string) $asignacion->docente_id;
            $this->aula                 = $asignacion->aula ?? '';
            $this->considera_asistencia = $asignacion->considera_asistencia;
            $this->categorias = $asignacion->categorias->map(fn($c) => [
                'nombre' => $c->nombre,
                'peso'   => $c->peso_porcentual,
            ])->toArray();
        } else {
            $this->categorias = [
                ['nombre' => 'Práctica', 'peso' => 70],
                ['nombre' => 'Teoría',   'peso' => 30],
            ];
            $periodoActivo = Periodo::activo();
            if ($periodoActivo) {
                $this->periodo_id = (string) $periodoActivo->id;
            }
        }
    }

    public function agregarCategoria(): void
    {
        $this->categorias[] = ['nombre' => '', 'peso' => 0];
    }

    public function quitarCategoria(int $index): void
    {
        array_splice($this->categorias, $index, 1);
        $this->categorias = array_values($this->categorias);
    }

    public function getPesoTotalProperty(): float
    {
        return (float) array_sum(array_column($this->categorias, 'peso'));
    }

    public function guardar(): void
    {
        $this->validate();

        $total = $this->getPesoTotalProperty();
        if (abs($total - 100) > 0.01) {
            $this->addError('categorias', "La suma de pesos debe ser 100%. Actual: {$total}%");
            return;
        }

        $asignacion = Asignacion::updateOrCreate(
            ['id' => $this->asignacionId],
            [
                'materia_id'           => $this->materia_id,
                'periodo_id'           => $this->periodo_id,
                'docente_id'           => $this->docente_id,
                'aula'                 => $this->aula ?: null,
                'considera_asistencia' => $this->considera_asistencia,
            ]
        );

        $asignacion->categorias()->delete();
        foreach ($this->categorias as $cat) {
            CategoriaEvaluacion::create([
                'asignacion_id'   => $asignacion->id,
                'nombre'          => $cat['nombre'],
                'peso_porcentual' => $cat['peso'],
            ]);
        }

        $accion = $this->asignacionId ? 'actualizada' : 'creada';
        session()->flash('success', "Asignación {$accion} correctamente.");
        $this->redirect(route('admin.asignaciones'));
    }

    public function cancelar(): void
    {
        $this->redirect(route('admin.asignaciones'));
    }

    public function render()
    {
        return view('livewire.asignaciones.formulario', [
            'materias' => Materia::orderBy('semestre_curricular')->orderBy('nombre')->get(),
            'periodos' => Periodo::orderByDesc('fecha_inicio')->get(),
            'docentes' => Docente::with('usuario')->get(),
        ]);
    }
}
