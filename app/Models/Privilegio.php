<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilegio extends Model
{
    use HasFactory;

    protected $table = 'privilegios';

    // Campos que pueden ser asignados en masa
    protected $fillable = [
        'nombre',
        'icono',
        'color',
        'user_id_create',
        'user_id_last_update',
        'activo'
    ];
}
