<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaEvaluacion extends Model
{
    protected $table = 'categorias_evaluacion';

    protected $fillable = ['asignacion_id', 'nombre', 'peso_porcentual', 'parcial'];

    public function asignacion()
    {
        return $this->belongsTo(Asignacion::class);
    }

    public function notas()
    {
        return $this->hasMany(Nota::class, 'categoria_id');
    }
}
