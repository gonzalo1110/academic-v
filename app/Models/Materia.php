<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $table = 'materias';

    protected $fillable = ['nombre', 'codigo', 'semestre_curricular'];

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }

    public function prerequisitos()
    {
        return $this->belongsToMany(
            Materia::class,
            'materia_prerequisitos',
            'materia_id',
            'prerequisito_id'
        );
    }
}
