<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $table = 'docentes';

    protected $fillable = ['usuario_id', 'especialidad'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }
}
