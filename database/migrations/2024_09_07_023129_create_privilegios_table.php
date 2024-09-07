<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('privilegios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('icono');
            $table->string('color');
        });

        DB::table('privilegios')->insert([
            [
                'nombre' => 'Crear',
                'icono' => 'fa fa-plus',
                'color' => 'primary'
            ],
            [
                'nombre' => 'Ver',
                'icono' => 'fa fa-eye',
                'color' => 'dark'
            ],
            [
                'nombre' => 'Actualizar',
                'icono' => 'fa fa-edit',
                'color' => 'primary'
            ],
            [
                'nombre' => 'Encender',
                'icono' => 'fa fa-arrow-up',
                'color' => 'warning'
            ],
            [
                'nombre' => 'Apagar',
                'icono' => 'fa fa-arrow-down',
                'color' => 'secondary'
            ],
            [
                'nombre' => 'Eliminar',
                'icono' => 'fa fa-trash',
                'color' => 'danger'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('privilegios');
    }
};
