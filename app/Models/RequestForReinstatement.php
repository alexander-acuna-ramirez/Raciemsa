<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestForReinstatement extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'solicitud_de_reposicion';
    protected $primaryKey = 'Codigo_reposicion';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'Codigo_proveedor',
        'Fecha_solicitud',
    ];
}
