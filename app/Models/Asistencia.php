<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencias';

    protected $fillable = [
        'inscripcion_id', 'fecha', 'estado', 'editado_por',
    ];

    protected $casts = ['fecha' => 'date'];

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class);
    }

    public function editor()
    {
        return $this->belongsTo(Usuario::class, 'editado_por');
    }
}
