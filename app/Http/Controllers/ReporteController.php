<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Services\ReporteExcelService;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function materia(Asignacion $asignacion, ReporteExcelService $servicio)
    {
        return $servicio->reporteMateria($asignacion);
    }
}