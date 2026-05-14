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

    public function getNombreFormateadoAttribute(): string
    {
        $nombre = $this->nombre;
        if (preg_match('/^(\d+)\s*-\s*(\d{4})$/', $nombre, $matches)) {
            $numero = (int)$matches[1];
            $anio = $matches[2];
            if ($numero == 1) {
                return "I - {$anio}";
            } elseif ($numero == 2) {
                return "II - {$anio}";
            }
        }
        if (preg_match('/^(I+|II)\s*-\s*(\d{4})$/', $nombre, $matches)) {
            return $nombre;
        }
        if (preg_match('/^(\d{4})$/', $nombre, $matches)) {
            $anio = $matches[1];
            return "I - {$anio}";
        }
        if (preg_match('/(\d{4})/', $nombre, $matches)) {
            $anio = $matches[1];
            if (preg_match('/^primer/i', $nombre)) {
                return "I - {$anio}";
            } elseif (preg_match('/^segundo/i', $nombre)) {
                return "II - {$anio}";
            }
        }
        return $nombre;
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }

    public static function activo()
    {
        return static::where('activo', true)->first();
    }
}
