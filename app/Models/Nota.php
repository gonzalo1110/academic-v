<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $table = 'notas';

    protected $fillable = ['inscripcion_id', 'categoria_id', 'valor', 'parcial', 'editado_por'];

    protected static function booted(): void
    {
        // Auditoría automática al actualizar una nota
        static::updating(function (Nota $nota) {
            if ($nota->isDirty('valor')) {
                NotaAuditoria::create([
                    'nota_id'        => $nota->id,
                    'valor_anterior' => $nota->getOriginal('valor'),
                    'valor_nuevo'    => $nota->valor,
                    'editado_por'    => auth()->id(),
                ]);
            }
        });
    }

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class);
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaEvaluacion::class, 'categoria_id');
    }

    public function auditorias()
    {
        return $this->hasMany(NotaAuditoria::class);
    }
}
