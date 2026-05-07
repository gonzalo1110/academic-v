<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaAuditoria extends Model
{
    protected $table = 'nota_auditoria';

    protected $fillable = [
        'nota_id', 'valor_anterior', 'valor_nuevo', 'editado_por',
    ];

    public function nota()
    {
        return $this->belongsTo(Nota::class);
    }

    public function editor()
    {
        return $this->belongsTo(Usuario::class, 'editado_por');
    }
}
