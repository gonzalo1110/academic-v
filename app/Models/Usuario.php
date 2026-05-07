<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Docente;
use App\Models\Estudiante;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'ci',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'password',
        'rol',
        'activo',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed',
        'activo'   => 'boolean',
    ];

    // ── Accessors ─────────────────────────────────────────────
    public function getNombreCompletoAttribute(): string
    {
        return trim(
            $this->capitalizar($this->primer_apellido) . ' ' .
            $this->capitalizar($this->segundo_apellido ?? '') . ' ' .
            $this->capitalizar($this->primer_nombre) . ' ' .
            $this->capitalizar($this->segundo_nombre ?? '')
        );
    }

    private function capitalizar(string $texto): string
    {
        return mb_convert_case(mb_strtolower($texto), MB_CASE_TITLE, 'UTF-8');
    }

    public function getInicialesAttribute(): string
    {
        $i = mb_strtoupper(mb_substr($this->primer_nombre ?? '', 0, 1, 'UTF-8'), 'UTF-8');
        $i .= mb_strtoupper(mb_substr($this->primer_apellido ?? '', 0, 1, 'UTF-8'), 'UTF-8');
        if (!empty($this->segundo_apellido)) {
            $i .= mb_strtoupper(mb_substr($this->segundo_apellido, 0, 1, 'UTF-8'), 'UTF-8');
        }
        return $i;
    }

    // ── Relaciones ────────────────────────────────────────────
    public function docente()
    {
        return $this->hasOne(Docente::class, 'usuario_id');
    }

    public function estudiante()
    {
        return $this->hasOne(Estudiante::class, 'usuario_id');
    }

    // ── Helpers ───────────────────────────────────────────────
    public function esAdmin(): bool      { return $this->rol === 'admin'; }
    public function esDocente(): bool    { return $this->rol === 'docente'; }
    public function esEstudiante(): bool { return $this->rol === 'estudiante'; }

    /**
     * Genera la contraseña inicial basada en la regla de negocio:
     * Inicial del primer nombre + Inicial del primer apellido + Inicial del segundo apellido + CI (todo en minúsculas).
     */
    public static function generarPasswordInicial(?string $nombre, ?string $apellido, ?string $ci, ?string $segundoApellido = null): string
    {
        // Si falta algún dato, devolvemos un string vacío o un placeholder
        if (empty($nombre) || empty($apellido) || empty($ci)) {
            return '—';
        }

        // Obtener la primera letra del nombre y apellido (usando mb_substr para caracteres latinos como tildes o la Ñ)
        $inicialNombre = mb_substr($nombre, 0, 1, 'UTF-8');
        $inicialApellido = mb_substr($apellido, 0, 1, 'UTF-8');
        $inicialApellido2 = $segundoApellido ? mb_substr($segundoApellido, 0, 1, 'UTF-8') : '';

        // Retornar la combinación: iniciales en mayúsculas + CI
        return mb_strtoupper($inicialNombre . $inicialApellido . $inicialApellido2, 'UTF-8') . $ci;
    }
}
