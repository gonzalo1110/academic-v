<?php

namespace App\Livewire\Usuarios;

use App\Models\Usuario;
use App\Models\Docente;
use App\Models\Estudiante;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;

#[Layout('components.layouts.app')]
#[Title('Usuario')]
class Formulario extends Component
{
    public ?int $usuarioId = null;
    public string $ci = '';
    public string $primer_nombre = '';
    public string $segundo_nombre = '';
    public string $primer_apellido = '';
    public string $segundo_apellido = '';
    public string $rol = 'estudiante';
    public int $semestre_actual = 1;
    public bool $resetPassword = false;
    public string $passwordPreview = '';

    protected function rules(): array
    {
        $ciRule = $this->usuarioId
            ? 'required|string|unique:usuarios,ci,' . $this->usuarioId
            : 'required|string|unique:usuarios,ci';

        return [
            'ci'               => $ciRule,
            'primer_nombre'    => 'required|string|max:100',
            'segundo_nombre'   => 'nullable|string|max:100',
            'primer_apellido'  => 'required|string|max:100',
            'segundo_apellido' => 'nullable|string|max:100',
            'rol'              => 'required|in:admin,docente,estudiante',
            'semestre_actual'  => 'required_if:rol,estudiante|integer|min:1|max:6',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $usuario = Usuario::with(['docente', 'estudiante'])->findOrFail($id);
            $this->usuarioId        = $usuario->id;
            $this->ci               = $usuario->ci;
            $this->primer_nombre    = $usuario->primer_nombre;
            $this->segundo_nombre   = $usuario->segundo_nombre ?? '';
            $this->primer_apellido  = $usuario->primer_apellido;
            $this->segundo_apellido = $usuario->segundo_apellido ?? '';
            $this->rol              = $usuario->rol;
            if ($usuario->estudiante) {
                $this->semestre_actual = $usuario->estudiante->semestre_actual;
            }
        }
        $this->actualizarPassword();
    }

    public function updated($field): void
    {
        if (in_array($field, ['primer_nombre', 'primer_apellido', 'segundo_apellido', 'ci'])) {
            $this->actualizarPassword();
        }
    }

    public function actualizarPassword(): void
    {
        if ($this->primer_nombre && $this->primer_apellido && $this->ci) {
            $this->passwordPreview = Usuario::generarPasswordInicial(
                $this->primer_nombre,
                $this->primer_apellido,
                $this->ci,
                $this->segundo_apellido ?? ''
            );
        } else {
            $this->passwordPreview = '—';
        }
    }

    public function guardar(): void
    {
        $this->validate();

        $passwordInicial = Usuario::generarPasswordInicial(
            $this->primer_nombre,
            $this->primer_apellido,
            $this->ci,
            $this->segundo_apellido ?? ''
        );

        $datos = [
            'ci'               => $this->ci,
            'primer_nombre'    => $this->primer_nombre,
            'segundo_nombre'   => $this->segundo_nombre ?: null,
            'primer_apellido'  => $this->primer_apellido,
            'segundo_apellido' => $this->segundo_apellido ?: null,
            'rol'              => $this->rol,
        ];

        if (!$this->usuarioId) {
            $datos['password'] = Hash::make($passwordInicial);
            $usuario = Usuario::create($datos);
        } else {
            $usuario = Usuario::findOrFail($this->usuarioId);
            if ($this->resetPassword) {
                $datos['password'] = Hash::make($passwordInicial);
            }
            $usuario->update($datos);
        }

        if ($this->rol === 'docente') {
            Docente::updateOrCreate(
                ['usuario_id' => $usuario->id],
                []
            );
        } elseif ($this->rol === 'estudiante') {
            Estudiante::updateOrCreate(
                ['usuario_id' => $usuario->id],
                ['semestre_actual' => $this->semestre_actual]
            );
        }

        $accion = $this->usuarioId ? 'actualizado' : 'creado';
        session()->flash('success', "Usuario {$accion}. Password: {$passwordInicial}");
        $this->redirect(route('admin.usuarios'));
    }

    public function cancelar(): void
    {
        $this->redirect(route('admin.usuarios'));
    }

    public function render()
    {
        return view('livewire.usuarios.formulario');
    }
}
