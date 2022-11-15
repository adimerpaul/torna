<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tornaguia extends Model
{
    use HasFactory;
    protected $fillable = [
        'yacimiento',
        'destino',
        'contratista',
        'cantidad',
        'minerales',
        'tipoManterial',
        'autorizado',
        'transporte_id',
        'empresa_id',
        'contratista_id',
        'user_id',
    ];
}
