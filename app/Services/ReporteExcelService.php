<?php

namespace App\Services;

use App\Models\Asignacion;
use App\Models\CategoriaEvaluacion;
use App\Models\Inscripcion;
use App\Models\Nota;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReporteExcelService
{
    private const AZUL_OSCURO = '1a3a6b';
    private const GRIS = 'd9d9d9';
    private const VERDE_CLARO = 'd4edda';
    private const ROJO_CLARO = 'f8d7da';

    private function apellidosNombres($usuario): string
    {
        return trim($usuario->primer_apellido . ' ' . $usuario->segundo_apellido . ' ' . $usuario->primer_nombre . ' ' . $usuario->segundo_nombre);
    }

    public function reporteMateria(Asignacion $asignacion): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Cargar todas las relaciones necesarias para evitar N+1 queries
        $asignacion->loadMissing([
            'materia',
            'periodo',
            'docente.usuario',
            'categorias',
            'inscripciones.estudiante.usuario',
            'inscripciones.notas',
            'inscripciones.asignacion.categorias',
        ]);

        $materia = $asignacion->materia;
        $periodo = $asignacion->periodo;
        $docente = $asignacion->docente->usuario;
        $nombreDocente = strtoupper(
            $docente->primer_apellido . ' ' .
            ($docente->segundo_apellido ?? '') . ' ' .
            $docente->primer_nombre . ' ' .
            ($docente->segundo_nombre ?? '')
        );
        $categorias = $asignacion->categorias->sortBy('parcial')->sortBy('nombre')->values();
        $inscripciones = $asignacion->inscripciones
            ->sortBy(fn($i) => $this->apellidosNombres($i->estudiante->usuario))
            ->values();

        $categoriasP1 = $categorias->where('parcial', 1)->values();
        $categoriasP2 = $categorias->where('parcial', 2)->values();

        $this->encabezados($sheet, $materia, $periodo, $docente, $asignacion);
        
        $headerRow = 9;
        $this->encabezadosColumnas($sheet, $headerRow, $categoriasP1, $categoriasP2);

        $this->datosEstudiantes($sheet, $headerRow + 1, $inscripciones, $categoriasP1, $categoriasP2);

        $ultimaFila = $headerRow + $inscripciones->count();
        $this->piePagina($sheet, $ultimaFila + 2, $asignacion);

        $this->autoSizeColumns($sheet, $headerRow, $ultimaFila);

        $filename = 'reporte_' . $materia->codigo . '_' . $periodo->nombre . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    private function encabezados($sheet, $materia, $periodo, $docente, Asignacion $asignacion): void
    {
        $estiloHeader = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => self::AZUL_OSCURO]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ];

        $sheet->setCellValue('A1', 'INSTITUTO TECNOLÓGICO INDUSTRIAL BRASIL-BOLIVIA');
        $sheet->mergeCells('A1:K1');
        $sheet->getStyle('A1')->applyFromArray($estiloHeader);

        $sheet->setCellValue('A2', 'CARRERA: INFORMÁTICA INDUSTRIAL');
        $sheet->mergeCells('A2:K2');
        $sheet->getStyle('A2')->applyFromArray($estiloHeader);

        $sheet->setCellValue('A3', "MATERIA: {$materia->nombre} ({$materia->codigo})");
        $sheet->mergeCells('A3:K3');
        $sheet->getStyle('A3')->applyFromArray($estiloHeader);

        $sheet->setCellValue('A4', 'DOCENTE: ' . trim($nombreDocente));
        $sheet->mergeCells('A4:K4');
        $sheet->getStyle('A4')->applyFromArray($estiloHeader);

        $sheet->setCellValue('A5', 'PERÍODO: ' . $periodo->nombre);
        $sheet->mergeCells('A5:K5');
        $sheet->getStyle('A5')->applyFromArray($estiloHeader);

        $sheet->setCellValue('A6', 'AULA: ' . $asignacion->aula);
        $sheet->mergeCells('A6:K6');
        $sheet->getStyle('A6')->applyFromArray($estiloHeader);

        $sheet->getRowDimension(1)->setRowHeight(25);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getRowDimension(3)->setRowHeight(20);
        $sheet->getRowDimension(4)->setRowHeight(20);
        $sheet->getRowDimension(5)->setRowHeight(20);
        $sheet->getRowDimension(6)->setRowHeight(20);
    }

    private function encabezadosColumnas($sheet, int $fila, $categoriasP1, $categoriasP2): void
    {
        $estiloEncabezado = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => self::GRIS]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];

        $columnas = ['N°', 'CI', 'APELLIDOS Y NOMBRES'];
        foreach ($categoriasP1 as $cat) {
            $columnas[] = $cat->nombre . ' P1';
        }
        $columnas[] = 'PARC.1';
        foreach ($categoriasP2 as $cat) {
            $columnas[] = $cat->nombre . ' P2';
        }
        $columnas[] = 'PARC.2';
        $columnas[] = 'NOTA FINAL';
        $columnas[] = 'ESTADO';

        $col = 'A';
        foreach ($columnas as $header) {
            $sheet->setCellValue($col . $fila, $header);
            $col++;
        }

        $sheet->getStyle('A' . $fila . ':' . $col . $fila)->applyFromArray($estiloEncabezado);
        $sheet->getRowDimension($fila)->setRowHeight(20);
    }

    private function datosEstudiantes($sheet, int $startRow, $inscripciones, $categoriasP1, $categoriasP2): void
    {
        $estiloDatos = [
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];

        $estiloAprobado = array_merge($estiloDatos, [
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => self::VERDE_CLARO]],
        ]);

        $estiloReprobado = array_merge($estiloDatos, [
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => self::ROJO_CLARO]],
        ]);

        $row = $startRow;
        foreach ($inscripciones as $index => $inscripcion) {
            $estudiante = $inscripcion->estudiante->usuario;
            $nombreCompleto = strtoupper($estudiante->apellidos_nombres);
            $ci = strtoupper($estudiante->ci);

            $col = 'A';
            $sheet->setCellValue($col++ . $row, $index + 1);
            $sheet->setCellValue($col++ . $row, $ci);
            $sheet->setCellValue($col++ . $row, $nombreCompleto);

            $notas = $inscripcion->notas->keyBy(fn($n) => $n->categoria_id . '_' . $n->parcial);

            foreach ($categoriasP1 as $cat) {
                $nota = $notas->get($cat->id . '_1');
                $sheet->setCellValue($col++ . $row, $nota?->valor ?? '—');
            }

            $parc1 = $inscripcion->calcularPromedioParcial(1);
            $sheet->setCellValue($col++ . $row, $parc1 > 0 ? $parc1 : '—');

            foreach ($categoriasP2 as $cat) {
                $nota = $notas->get($cat->id . '_2');
                $sheet->setCellValue($col++ . $row, $nota?->valor ?? '—');
            }

            $parc2 = $inscripcion->calcularPromedioParcial(2);
            $sheet->setCellValue($col++ . $row, $parc2 > 0 ? $parc2 : '—');

            $final = $inscripcion->calcularPromedioFinal();
            $sheet->setCellValue($col++ . $row, $final > 0 ? $final : '—');

            $estado = $final >= 61 ? 'APROBADO' : 'REPROBADO';
            $sheet->setCellValue($col . $row, $estado);

            $estilo = $final >= 61 ? $estiloAprobado : $estiloReprobado;
            $sheet->getStyle('A' . $row . ':' . $col . $row)->applyFromArray($estilo);

            $sheet->getRowDimension($row)->setRowHeight(18);
            $row++;
        }
    }

    private function piePagina($sheet, int $startRow, Asignacion $asignacion): void
    {
        $estiloPie = [
            'font' => ['bold' => true, 'size' => 10],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ];

        $notaMinima = $asignacion->nota_minima_aprobacion ?? 61;

        $sheet->setCellValue('A' . $startRow++, "NOTA MÍNIMA DE APROBACIÓN: {$notaMinima}");
        $sheet->getStyle('A' . $startRow)->applyFromArray($estiloPie);

        $sheet->setCellValue('A' . $startRow++, 'ESCALA: 0-60 REPROBADO | 61-100 APROBADO');
        $sheet->getStyle('A' . $startRow)->applyFromArray($estiloPie);

        $fecha = now()->format('d/m/Y');
        $sheet->setCellValue('A' . $startRow, "Lugar y Fecha: El Alto, {$fecha}");
        $sheet->getStyle('A' . $startRow)->applyFromArray($estiloPie);
    }

    private function autoSizeColumns($sheet, int $headerRow, int $ultimaFila): void
    {
        $letter = 'A';
        for ($i = 0; $i <= 10; $i++) {
            $col = chr(ord($letter) + $i);
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}