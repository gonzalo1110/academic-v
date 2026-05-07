<?php

namespace App\Livewire\Docente;

use App\Models\Asignacion;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Mis Materias')]
class MisMaterias extends Component
{
    public function render()
    {
        $docente = auth()->user()->docente;
        
        $asignaciones = Asignacion::with([
            'materia', 
            'periodo',
            'categorias',
            'inscripciones.notas',
            'inscripciones.asistencias',
        ])
        ->where('docente_id', $docente->id)
        ->whereHas('periodo', fn($q) => $q->where('activo', true))
        ->get();

        return view('livewire.docente.mis-materias', compact('asignaciones'));
    }
}
