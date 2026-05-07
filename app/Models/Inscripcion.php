<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table = 'inscripciones';

    protected $fillable = ['estudiante_id', 'asignacion_id', 'inscrito_por'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function asignacion()
    {
        return $this->belongsTo(Asignacion::class);
    }

    public function inscritoPor()
    {
        return $this->belongsTo(Usuario::class, 'inscrito_por');
    }

    public function notas()
    {
        return $this->hasMany(Nota::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    // UML: calcularPromedioParcial()
    public function calcularPromedioParcial(int $parcial): float
    {
        $categorias = $this->asignacion->categorias->where('parcial', $parcial);
        $total = 0;
        foreach ($categorias as $categoria) {
            $nota = $this->notas
                ->where('categoria_id', $categoria->id)
                ->where('parcial', $parcial)
                ->first();
            if ($nota) {
                $total += ($nota->valor * $categoria->peso_porcentual) / 100;
            }
        }
        return round($total, 2);
    }

    public function calcularPromedioFinal(): float
    {
        $p1 = $this->calcularPromedioParcial(1);
        $p2 = $this->calcularPromedioParcial(2);
        return round(($p1 + $p2) / 2, 2);
    }

    public function puedeRecuperar(): bool
    {
        $final = $this->calcularPromedioFinal();
        $minRec = $this->asignacion->nota_minima_recuperacion ?? 51;
        return $final >= $minRec && $final < 61;
    }

    // UML: calcularPromedioActual()
    public function calcularPromedioActual(): float
    {
        return $this->calcularPromedioFinal();
    }
}
