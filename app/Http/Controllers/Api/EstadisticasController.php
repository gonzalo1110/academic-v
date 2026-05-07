<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\EstadisticasService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EstadisticasController extends Controller
{
    public function estudiante(int $estudianteId): JsonResponse
    {
        try {
            $datos = (new EstadisticasService())->getDatosParaIA($estudianteId);
            
            return response()->json([
                'success' => true,
                'data' => $datos,
                'timestamp' => now()->toISOString()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Estudiante no encontrado',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function grupo(Request $request): JsonResponse
    {
        try {
            $estudianteIds = $request->input('estudiantes', []);
            $datosGrupo = [];
            
            foreach ($estudianteIds as $estudianteId) {
                $datosGrupo[] = (new EstadisticasService())->getDatosParaIA($estudianteId);
            }
            
            // Análisis comparativo del grupo
            $analisis = [
                'promedio_general_grupo' => array_sum(array_column($datosGrupo, 'promedio_general')) / count($datosGrupo),
                'tasa_aprobacion_grupo' => array_sum(array_column($datosGrupo, 'tasa_aprobacion')) / count($datosGrupo),
                'tendencias' => $this->analizarTendenciasGrupo($datosGrupo),
                'materias_dificiles' => $this->identificarMateriasDificiles($datosGrupo),
                'estudiantes_destacados' => $this->identificarEstudiantesDestacados($datosGrupo)
            ];
            
            return response()->json([
                'success' => true,
                'data' => [
                    'estudiantes' => $datosGrupo,
                    'analisis_comparativo' => $analisis
                ],
                'timestamp' => now()->toISOString()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error procesando datos del grupo',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function prediccion(int $estudianteId): JsonResponse
    {
        try {
            $datos = (new EstadisticasService())->getDatosParaIA($estudianteId);
            
            // Lógica de predicción simple basada en tendencias
            $prediccion = $this->generarPrediccion($datos);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'datos_actuales' => $datos,
                    'prediccion' => $prediccion
                ],
                'timestamp' => now()->toISOString()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error generando predicción',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function analizarTendenciasGrupo(array $datosGrupo): array
    {
        $tendencias = array_count_values(array_column($datosGrupo, 'tendencia'));
        
        return [
            'mejorando' => $tendencias['mejorando'] ?? 0,
            'estable' => $tendencias['estable'] ?? 0,
            'empeorando' => $tendencias['empeorando'] ?? 0,
            'insuficiente_datos' => $tendencias['insuficiente_datos'] ?? 0
        ];
    }

    private function identificarMateriasDificiles(array $datosGrupo): array
    {
        $materias = [];
        
        foreach ($datosGrupo as $estudiante) {
            foreach ($estudiante['materias'] as $materia) {
                if (!isset($materias[$materia['nombre']])) {
                    $materias[$materia['nombre']] = [
                        'promedios' => [],
                        'aprobados' => 0,
                        'total' => 0
                    ];
                }
                
                $materias[$materia['nombre']]['promedios'][] = $materia['promedio_final'];
                $materias[$materia['nombre']]['total']++;
                
                if ($materia['estado'] === 'Aprobado') {
                    $materias[$materia['nombre']]['aprobados']++;
                }
            }
        }
        
        // Calcular dificultad (menor tasa de aprobación = más difícil)
        foreach ($materias as $nombre => $datos) {
            $materias[$nombre]['tasa_aprobacion'] = ($datos['aprobados'] / $datos['total']) * 100;
            $materias[$nombre]['promedio_general'] = array_sum($datos['promedios']) / count($datos['promedios']);
        }
        
        // Ordenar por dificultad (menor tasa de aprobación primero)
        uasort($materias, function($a, $b) {
            return $a['tasa_aprobacion'] <=> $b['tasa_aprobacion'];
        });
        
        return array_slice($materias, 0, 5, true); // Top 5 materias más difíciles
    }

    private function identificarEstudiantesDestacados(array $datosGrupo): array
    {
        // Ordenar por promedio general
        usort($datosGrupo, function($a, $b) {
            return $b['promedio_general'] <=> $a['promedio_general'];
        });
        
        return array_slice($datosGrupo, 0, 3); // Top 3 estudiantes
    }

    private function generarPrediccion(array $datos): array
    {
        $tendencia = $datos['rendimiento']['tendencia'];
        $promedioActual = $datos['rendimiento']['promedio_general'];
        
        // Predicción simple basada en tendencia actual
        $predicciones = [];
        
        foreach ($datos['materias'] as $materia) {
            $prediccionBase = $materia['promedio_final'];
            
            switch ($tendencia) {
                case 'mejorando':
                    $prediccionFinal = min(100, $prediccionBase + 5);
                    break;
                case 'empeorando':
                    $prediccionFinal = max(0, $prediccionBase - 3);
                    break;
                case 'estable':
                default:
                    $prediccionFinal = $prediccionBase;
                    break;
            }
            
            $predicciones[] = [
                'materia' => $materia['nombre'],
                'promedio_actual' => $materia['promedio_final'],
                'prediccion_final' => round($prediccionFinal, 2),
                'estado_predicho' => $prediccionFinal >= 61 ? 'Aprobado' : 'Reprobado',
                'confianza' => $this->calcularConfianza($tendencia, count($materia['parciales']))
            ];
        }
        
        return [
            'tendencia_general' => $tendencia,
            'predicciones_materias' => $predicciones,
            'recomendaciones' => $this->generarRecomendaciones($datos, $tendencia)
        ];
    }

    private function calcularConfianza(string $tendencia, int $cantidadDatos): float
    {
        $baseConfianza = match($tendencia) {
            'mejorando' => 0.8,
            'empeorando' => 0.7,
            'estable' => 0.6,
            default => 0.4
        };
        
        // Ajustar confianza basada en cantidad de datos
        $ajusteDatos = min(1.0, $cantidadDatos / 4); // Máxima confianza con 4+ parciales
        
        return round($baseConfianza * $ajusteDatos, 2);
    }

    private function generarRecomendaciones(array $datos, string $tendencia): array
    {
        $recomendaciones = [];
        
        if ($tendencia === 'mejorando') {
            $recomendaciones[] = 'El estudiante muestra una tendencia positiva. Mantener el ritmo actual.';
            $recomendaciones[] = 'Considerar asignar materias con mayor dificultad para seguir desafiándose.';
        } elseif ($tendencia === 'empeorando') {
            $recomendaciones[] = 'El estudiante necesita apoyo adicional. Recomendar tutorías.';
            $recomendaciones[] = 'Revisar hábitos de estudio y carga académica actual.';
            $recomendaciones[] = 'Considerar reunión con consejero académico.';
        } else {
            $recomendaciones[] = 'Rendimiento estable. Buscar oportunidades de mejora.';
            $recomendaciones[] = 'Establecer metas de superación personales.';
        }
        
        if ($datos['rendimiento']['promedio_general'] < 70) {
            $recomendaciones[] = 'Priorizar materias con mayor peso en promedio general.';
        }
        
        return $recomendaciones;
    }
}
