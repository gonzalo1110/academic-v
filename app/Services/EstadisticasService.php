<?php

namespace App\Services;

use App\Models\Estudiante;
use App\Models\Inscripcion;
use App\Models\Nota;
use App\Models\CategoriaEvaluacion;
use Illuminate\Support\Collection;

class EstadisticasService
{
    /**
     * Obtiene estadísticas completas de un estudiante para todas sus materias
     */
    public function getEstadisticasEstudiante(int $estudianteId): array
    {
        $estudiante = Estudiante::with(['usuario', 'inscripciones.asignacion.materia', 'inscripciones.notas.categoria'])
            ->findOrFail($estudianteId);

        $estadisticas = [];
        $periodosActuales = [];

        foreach ($estudiante->inscripciones as $inscripcion) {
            $periodoKey = $inscripcion->asignacion->periodo->id;
            
            if (!isset($periodosActuales[$periodoKey])) {
                $periodosActuales[$periodoKey] = [
                    'periodo' => $inscripcion->asignacion->periodo,
                    'materias' => []
                ];
            }

            $periodosActuales[$periodoKey]['materias'][] = $this->getEstadisticasMateria($inscripcion);
        }

        // Convertir a formato de array para gráficas
        $graficasData = $this->prepararDatosGraficas($periodosActuales);

        return [
            'estudiante' => $estudiante,
            'periodos' => array_values($periodosActuales),
            'graficas' => $graficasData,
            'resumen' => $this->getResumenGeneral($periodosActuales)
        ];
    }

    /**
     * Obtiene estadísticas específicas de un estudiante en una materia
     */
    public function getEstadisticasEstudianteMateria(int $estudianteId, int $asignacionId): array
    {
        $inscripcion = Inscripcion::with([
            'estudiante.usuario',
            'asignacion.materia',
            'asignacion.periodo',
            'asignacion.categorias',
            'notas.categoria'
        ])->where('estudiante_id', $estudianteId)
          ->where('asignacion_id', $asignacionId)
          ->firstOrFail();

        // Separar notas por tipo (exámenes parciales vs tareas)
        $examenes = [];
        $tareas = [];
        
        foreach ($inscripcion->notas as $nota) {
            if (stripos($nota->categoria->nombre, 'examen') !== false || 
                stripos($nota->categoria->nombre, 'parcial') !== false) {
                $examenes[] = $nota;
            } else {
                $tareas[] = $nota;
            }
        }

        // Calcular promedios
        $promedioExamenes = $this->calcularPromedioSimple($examenes);
        $promedioTareas = $this->calcularPromedioSimple($tareas);
        $promedioGeneral = $this->calcularPromedioPonderado($inscripcion->notas, $inscripcion->asignacion->categorias);

        // Agrupar por parciales para gráfica
        $notasPorParcial = $this->agruparNotasPorParcial($inscripcion->notas);
        
        return [
            'estudiante' => $inscripcion->estudiante,
            'materia' => $inscripcion->asignacion->materia,
            'asignacion' => $inscripcion->asignacion,
            'promedio_general' => $promedioGeneral,
            'promedio_examenes' => $promedioExamenes,
            'promedio_tareas' => $promedioTareas,
            'examenes' => $this->formatearNotas($examenes),
            'tareas' => $this->formatearNotas($tareas),
            'notas_por_parcial' => $notasPorParcial,
            'grafica_data' => $this->prepararGraficaMateria($notasPorParcial),
            'estado' => $promedioGeneral >= 61 ? 'Aprobado' : 'Reprobado'
        ];
    }

    /**
     * Calcula promedio simple (sin ponderar)
     */
    private function calcularPromedioSimple(array $notas): float
    {
        if (empty($notas)) return 0;
        
        $total = array_sum(array_column($notas, 'valor'));
        return round($total / count($notas), 2);
    }

    /**
     * Formatea notas para mostrar
     */
    private function formatearNotas(array $notas): array
    {
        return array_map(function($nota) {
            return [
                'categoria' => $nota->categoria->nombre,
                'valor' => $nota->valor,
                'peso' => $nota->categoria->peso_porcentual,
                'fecha' => $nota->updated_at->format('d/m/Y')
            ];
        }, $notas);
    }

    /**
     * Prepara datos para gráfica de materia específica
     */
    private function prepararGraficaMateria(array $notasPorParcial): array
    {
        $labels = [];
        $data = [];
        
        foreach ($notasPorParcial as $parcial => $notas) {
            $labels[] = "Parcial $parcial";
            $promedio = $this->calcularPromedioSimple($notas->toArray());
            $data[] = $promedio;
        }
        
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Promedio por Parcial',
                    'data' => $data,
                    'borderColor' => 'rgba(59, 130, 246, 1)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.4,
                    'fill' => true
                ]
            ]
        ];
    }

    /**
     * Obtiene estadísticas de una materia específica
     */
    private function getEstadisticasMateria(Inscripcion $inscripcion): array
    {
        $notasPorParcial = $this->agruparNotasPorParcial($inscripcion->notas);
        
        $promedios = [];
        foreach ($notasPorParcial as $parcial => $notas) {
            $promedios[$parcial] = $this->calcularPromedioPonderado($notas, $inscripcion->asignacion->categorias);
        }

        return [
            'materia' => $inscripcion->asignacion->materia,
            'asignacion' => $inscripcion->asignacion,
            'promedios_por_parcial' => $promedios,
            'promedio_final' => count($promedios) > 0 ? array_sum($promedios) / count($promedios) : 0,
            'estado' => $this->determinarEstado($promedios),
            'detalle_notas' => $this->getDetalleNotas($inscripcion->notas)
        ];
    }

    /**
     * Agrupa notas por parcial (1, 2, etc.)
     */
    private function agruparNotasPorParcial(Collection $notas): array
    {
        $agrupadas = [];
        
        foreach ($notas as $nota) {
            // Determinar el parcial basado en el nombre de la categoría
            $parcial = $this->determinarParcial($nota->categoria->nombre);
            
            if (!isset($agrupadas[$parcial])) {
                $agrupadas[$parcial] = collect();
            }
            
            $agrupadas[$parcial]->push($nota);
        }

        return $agrupadas;
    }

    /**
     * Determina el número de parcial basado en el nombre de la categoría
     */
    private function determinarParcial(string $nombreCategoria): int
    {
        if (stripos($nombreCategoria, 'primer') !== false || stripos($nombreCategoria, '1') !== false) {
            return 1;
        } elseif (stripos($nombreCategoria, 'segundo') !== false || stripos($nombreCategoria, '2') !== false) {
            return 2;
        } elseif (stripos($nombreCategoria, 'tercer') !== false || stripos($nombreCategoria, '3') !== false) {
            return 3;
        }
        
        return 1; // Por defecto primer parcial
    }

    /**
     * Calcula promedio ponderado para un conjunto de notas
     */
    private function calcularPromedioPonderado(Collection $notas, Collection $categorias): float
    {
        $totalPonderado = 0;
        $totalPeso = 0;

        foreach ($notas as $nota) {
            $categoria = $categorias->firstWhere('id', $nota->categoria_id);
            if ($categoria) {
                $totalPonderado += $nota->valor * $categoria->peso_porcentual;
                $totalPeso += $categoria->peso_porcentual;
            }
        }

        return $totalPeso > 0 ? round($totalPonderado / $totalPeso, 2) : 0;
    }

    /**
     * Prepara datos para gráficas lineales
     */
    private function prepararDatosGraficas(array $periodos): array
    {
        $graficasData = [];

        foreach ($periodos as $periodo) {
            $labels = [];
            $datasets = [];

            foreach ($periodo['materias'] as $materia) {
                $labels = array_unique(array_merge($labels, array_keys($materia['promedios_por_parcial'])));
                
                $datasets[] = [
                    'label' => $materia['materia']->nombre,
                    'data' => array_values($materia['promedios_por_parcial']),
                    'borderColor' => $this->generarColor($materia['materia']->id),
                    'backgroundColor' => $this->generarColor($materia['materia']->id, 0.1),
                    'tension' => 0.4
                ];
            }

            $graficasData[$periodo['periodo']->id] = [
                'periodo' => $periodo['periodo']->nombre,
                'labels' => array_map(fn($p) => "Parcial $p", $labels),
                'datasets' => $datasets
            ];
        }

        return $graficasData;
    }

    /**
     * Genera colores consistentes para las gráficas
     */
    private function generarColor(int $id, float $alpha = 1.0): string
    {
        $colors = [
            'rgba(59, 130, 246, ' . $alpha . ')',   // Blue
            'rgba(16, 185, 129, ' . $alpha . ')',   // Green
            'rgba(245, 158, 11, ' . $alpha . ')',   // Yellow
            'rgba(239, 68, 68, ' . $alpha . ')',    // Red
            'rgba(139, 92, 246, ' . $alpha . ')',   // Purple
            'rgba(236, 72, 153, ' . $alpha . ')',   // Pink
        ];

        return $colors[$id % count($colors)];
    }

    /**
     * Determina el estado del estudiante
     */
    private function determinarEstado(array $promedios): string
    {
        if (empty($promedios)) return 'Sin datos';
        
        $promedioFinal = array_sum($promedios) / count($promedios);
        
        if ($promedioFinal >= 90) return 'Excelente';
        if ($promedioFinal >= 80) return 'Bueno';
        if ($promedioFinal >= 61) return 'Aprobado';
        
        return 'Reprobado';
    }

    /**
     * Obtiene resumen general del estudiante
     */
    private function getResumenGeneral(array $periodos): array
    {
        $totalMaterias = 0;
        $materiasAprobadas = 0;
        $promedioGeneral = 0;

        foreach ($periodos as $periodo) {
            foreach ($periodo['materias'] as $materia) {
                $totalMaterias++;
                $promedioGeneral += $materia['promedio_final'];
                
                if ($materia['promedio_final'] >= 61) {
                    $materiasAprobadas++;
                }
            }
        }

        return [
            'total_materias' => $totalMaterias,
            'materias_aprobadas' => $materiasAprobadas,
            'materias_reprobadas' => $totalMaterias - $materiasAprobadas,
            'promedio_general' => $totalMaterias > 0 ? round($promedioGeneral / $totalMaterias, 2) : 0,
            'tasa_aprobacion' => $totalMaterias > 0 ? round(($materiasAprobadas / $totalMaterias) * 100, 1) : 0
        ];
    }

    /**
     * Obtiene detalle de notas para mostrar
     */
    private function getDetalleNotas(Collection $notas): array
    {
        $detalle = [];
        
        foreach ($notas as $nota) {
            $detalle[] = [
                'categoria' => $nota->categoria->nombre,
                'valor' => $nota->valor,
                'peso' => $nota->categoria->peso_porcentual,
                'ponderado' => round($nota->valor * $nota->categoria->peso_porcentual / 100, 2)
            ];
        }

        return $detalle;
    }

    /**
     * Datos para API de IA (formato estructurado)
     */
    public function getDatosParaIA(int $estudianteId): array
    {
        $estadisticas = $this->getEstadisticasEstudiante($estudianteId);
        
        return [
            'estudiante_id' => $estudianteId,
            'nombre' => $estadisticas['estudiante']->usuario->nombre_completo,
            'ci' => $estadisticas['estudiante']->usuario->ci,
            'semestre_actual' => $estadisticas['estudiante']->semestre_actual,
            'rendimiento' => [
                'promedio_general' => $estadisticas['resumen']['promedio_general'],
                'tasa_aprobacion' => $estadisticas['resumen']['tasa_aprobacion'],
                'tendencia' => $this->calcularTendencia($estadisticas['graficas'])
            ],
            'materias' => array_map(function($materia) {
                return [
                    'nombre' => $materia['materia']->nombre,
                    'codigo' => $materia['materia']->codigo,
                    'promedio_final' => $materia['promedio_final'],
                    'estado' => $materia['estado'],
                    'parciales' => $materia['promedios_por_parcial']
                ];
            }, array_merge(...array_column($estadisticas['periodos'], 'materias'))),
            'timestamp' => now()->toISOString()
        ];
    }

    /**
     * Calcula tendencia de rendimiento
     */
    private function calcularTendencia(array $graficas): string
    {
        $tendencias = [];
        
        foreach ($graficas as $grafica) {
            foreach ($grafica['datasets'] as $dataset) {
                if (count($dataset['data']) >= 2) {
                    $primero = $dataset['data'][0];
                    $ultimo = $dataset['data'][count($dataset['data']) - 1];
                    
                    if ($ultimo > $primero + 5) $tendencias[] = 'mejora';
                    elseif ($ultimo < $primero - 5) $tendencias[] = 'declive';
                    else $tendencias[] = 'estable';
                }
            }
        }

        if (empty($tendencias)) return 'insuficiente_datos';
        
        $mejora = count(array_filter($tendencias, fn($t) => $t === 'mejora'));
        $declive = count(array_filter($tendencias, fn($t) => $t === 'declive'));
        
        if ($mejora > $declive) return 'mejorando';
        if ($declive > $mejora) return 'empeorando';
        
        return 'estable';
    }
}
