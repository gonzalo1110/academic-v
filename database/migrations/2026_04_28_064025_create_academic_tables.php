<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. USUARIOS Y HERENCIA
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('ci')->unique();
            $table->string('primer_nombre');
            $table->string('segundo_nombre')->nullable();
            $table->string('primer_apellido');
            $table->string('segundo_apellido')->nullable();
            $table->string('password');
            $table->enum('rol', ['admin', 'docente', 'estudiante']);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->unsignedTinyInteger('semestre_actual'); // 1 al 6
            $table->timestamps();
        });

        // 2. ESTRUCTURA ACADÉMICA
        Schema::create('periodos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Ej: 2026-I
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->boolean('activo')->default(false);
            $table->timestamps();
        });

        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo')->unique();
            $table->unsignedTinyInteger('semestre_curricular'); // 1 al 6
            $table->timestamps();
        });

        // Prerrequisitos (Para el arrastre de materias)
        Schema::create('materia_prerequisitos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->foreignId('prerequisito_id')->constrained('materias')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['materia_id', 'prerequisito_id']);
        });

        // Asignaciones: Materia abierta en un Periodo, con su Docente y su Aula
        Schema::create('asignaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materia_id')->constrained('materias');
            $table->foreignId('periodo_id')->constrained('periodos');
            $table->foreignId('docente_id')->constrained('docentes');
            $table->string('aula')->nullable();
            $table->boolean('considera_asistencia')->default(false);
            $table->timestamps();

            $table->unique(['materia_id', 'periodo_id']);
        });

        // 3. CATEGORÍAS DE EVALUACIÓN
        Schema::create('categorias_evaluacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asignacion_id')->constrained('asignaciones')->onDelete('cascade');
            $table->string('nombre');
            $table->decimal('peso_porcentual', 5, 2);
            $table->timestamps();
        });

        // 4. TRANSACCIONES ACADÉMICAS
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('asignacion_id')->constrained('asignaciones')->onDelete('cascade');
            $table->foreignId('inscrito_por')->nullable()->constrained('usuarios');
            $table->timestamps();

            $table->unique(['estudiante_id', 'asignacion_id']);
        });

        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inscripcion_id')->constrained('inscripciones')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained('categorias_evaluacion')->onDelete('cascade');
            $table->decimal('valor', 5, 2);
            $table->foreignId('editado_por')->nullable()->constrained('usuarios');
            $table->timestamps();

            $table->unique(['inscripcion_id', 'categoria_id']);
        });

        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inscripcion_id')->constrained('inscripciones')->onDelete('cascade');
            $table->date('fecha');
            $table->enum('estado', ['Presente', 'Ausente', 'Justificado']);
            $table->foreignId('editado_por')->nullable()->constrained('usuarios');
            $table->timestamps();

            $table->unique(['inscripcion_id', 'fecha']);
        });

        // 5. AUDITORÍA
        Schema::create('nota_auditoria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nota_id')->constrained('notas')->onDelete('cascade');
            $table->decimal('valor_anterior', 5, 2);
            $table->decimal('valor_nuevo', 5, 2);
            $table->foreignId('editado_por')->constrained('usuarios');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nota_auditoria');
        Schema::dropIfExists('asistencias');
        Schema::dropIfExists('notas');
        Schema::dropIfExists('inscripciones');
        Schema::dropIfExists('categorias_evaluacion');
        Schema::dropIfExists('asignaciones');
        Schema::dropIfExists('materia_prerequisitos');
        Schema::dropIfExists('materias');
        Schema::dropIfExists('periodos');
        Schema::dropIfExists('estudiantes');
        Schema::dropIfExists('docentes');
        Schema::dropIfExists('usuarios');
    }
};
