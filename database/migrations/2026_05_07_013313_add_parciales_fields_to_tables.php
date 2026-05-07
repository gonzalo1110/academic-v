<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categorias_evaluacion', function (Blueprint $table) {
            $table->tinyInteger('parcial')->default(1)->after('peso_porcentual')->comment('Parcial: 1 o 2');
        });

        Schema::table('notas', function (Blueprint $table) {
            $table->tinyInteger('parcial')->default(1)->after('valor')->comment('Parcial: 1 o 2');
        });

        Schema::table('asignaciones', function (Blueprint $table) {
            $table->boolean('permite_recuperacion')->default(false)->after('considera_asistencia');
            $table->decimal('nota_minima_recuperacion', 3, 1)->default(51.0)->after('permite_recuperacion')->comment('Nota mínima para acceder a recuperación');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categorias_evaluacion', function (Blueprint $table) {
            $table->dropColumn('parcial');
        });

        Schema::table('notas', function (Blueprint $table) {
            $table->dropColumn('parcial');
        });

        Schema::table('asignaciones', function (Blueprint $table) {
            $table->dropColumn(['permite_recuperacion', 'nota_minima_recuperacion']);
        });
    }
};
