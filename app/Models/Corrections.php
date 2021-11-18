<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corrections extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'correcciones';
    protected $primaryKey = 'Codigo_solicitud_correccion';
    public $incrementing = true;
    protected $keyType = 'string';
    
    protected $fillable = [
        'Numero_de_parte',
        'Diferencia',
    ];
}
