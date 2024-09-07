<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'responsable',
        'user_id_create',
        'user_id_last_update',
        'activo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id_create');
    }
}
