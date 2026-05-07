<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $table = 'periodos';

    protected $fillable = ['nombre', 'fecha_inicio', 'fecha_fin', 'activo'];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
        'activo'       => 'boolean',
    ];

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }

    public static function activo()
    {
        return static::where('activo', true)->first();
    }
}
