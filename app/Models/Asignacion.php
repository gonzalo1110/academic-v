<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = 'asignaciones';

    protected $fillable = [
        'materia_id', 'periodo_id', 'docente_id', 'aula',
        'considera_asistencia', 'permite_recuperacion', 'nota_minima_recuperacion',
    ];

    protected $casts = [
        'considera_asistencia'  => 'boolean',
        'permite_recuperacion'  => 'boolean',
        'nota_minima_recuperacion' => 'decimal:1',
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    public function categorias()
    {
        return $this->hasMany(CategoriaEvaluacion::class);
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }
}
