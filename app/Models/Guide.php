<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'guia_de_remision';
    protected $primaryKey = 'Codigo_guia_remision';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'Fecha_de_emision',
        'Inicio_traslado',
        'Fin_traslado',
        'Codigo_proveedor',
    ];
}
