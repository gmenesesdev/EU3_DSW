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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->date('fecha_inicio');
            $table->string('responsable');
            $table->float('monto');
            $table->boolean('activo')->default(false);
            //$table->unsignedBigInteger('user_id');
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        DB::table('proyectos')->insert([
            [
                'nombre' => 'Proyecto 1',
                'fecha_inicio' => '2024-08-16',
                'responsable' => 'Responsable 1',
                'monto' => 1000,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Proyecto 2',
                'fecha_inicio' => '2024-08-16',
                'responsable' => 'Responsable 2',
                'monto' => 2000,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
