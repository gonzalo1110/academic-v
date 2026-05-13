<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Livewire\Usuarios\Index as UsuariosIndex;
use App\Livewire\Usuarios\Formulario as UsuariosFormulario;
use App\Livewire\Materias\Index as MateriasIndex;
use App\Livewire\Materias\Formulario as MateriasFormulario;
use App\Livewire\Periodos\Index as PeriodosIndex;
use App\Livewire\Periodos\Formulario as PeriodosFormulario;
use App\Livewire\Asignaciones\Index as AsignacionesIndex;
use App\Livewire\Asignaciones\Formulario as AsignacionesFormulario;
use App\Livewire\Inscripciones\Index as InscripcionesIndex;
use App\Livewire\Inscripciones\Formulario as InscripcionesFormulario;
use App\Livewire\Notas\Index as NotasIndex;
use App\Http\Controllers\ReporteController;

Route::middleware('guest')->group(function () {
    Route::get('/', fn() => redirect('/login'))->name('home');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
});

// Admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/usuarios', UsuariosIndex::class)->name('usuarios');
    Route::get('/usuarios/crear', UsuariosFormulario::class)->name('usuarios.crear');
    Route::get('/usuarios/{id}/editar', UsuariosFormulario::class)->name('usuarios.editar');

    Route::get('/materias', MateriasIndex::class)->name('materias');
    Route::get('/materias/crear', MateriasFormulario::class)->name('materias.crear');
    Route::get('/materias/{id}/editar', MateriasFormulario::class)->name('materias.editar');

    Route::get('/periodos', PeriodosIndex::class)->name('periodos');
    Route::get('/periodos/crear', PeriodosFormulario::class)->name('periodos.crear');
    Route::get('/periodos/{id}/editar', PeriodosFormulario::class)->name('periodos.editar');

    Route::get('/asignaciones', AsignacionesIndex::class)->name('asignaciones');
    Route::get('/asignaciones/crear', AsignacionesFormulario::class)->name('asignaciones.crear');
    Route::get('/asignaciones/{id}/editar', AsignacionesFormulario::class)->name('asignaciones.editar');

    Route::get('/inscripciones', InscripcionesIndex::class)->name('inscripciones');
    Route::get('/inscripciones/crear', InscripcionesFormulario::class)->name('inscripciones.crear');

    Route::get('/notas/{asignacion}', NotasIndex::class)->name('notas');

    Route::get('/reportes/materia/{asignacion}', [ReporteController::class, 'materia'])->name('reportes.materia');
});

// Docente
Route::middleware(['auth', 'rol:docente'])->prefix('docente')->name('docente.')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/mis-materias', \App\Livewire\Docente\MisMaterias::class)->name('materias');
    Route::get('/asignacion/{asignacion}/notas', \App\Livewire\Docente\Notas::class)->name('notas');
    Route::get('/asignacion/{asignacion}/asistencia', \App\Livewire\Docente\AsistenciaRegistro::class)->name('asistencia');
    Route::get('/asignacion/{asignacion}/categorias', \App\Livewire\Docente\Categorias::class)->name('categorias');
    
});

// API para Estadísticas y IA
Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    Route::get('/estadisticas/estudiante/{estudiante}', [\App\Http\Controllers\Api\EstadisticasController::class, 'estudiante']);
    Route::post('/estadisticas/grupo', [\App\Http\Controllers\Api\EstadisticasController::class, 'grupo']);
    Route::get('/estadisticas/prediccion/{estudiante}', [\App\Http\Controllers\Api\EstadisticasController::class, 'prediccion']);
});

// Estudiante
Route::middleware(['auth'])->prefix('estudiante')->name('estudiante.')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
});
