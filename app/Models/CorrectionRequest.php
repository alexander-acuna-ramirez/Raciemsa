<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorrectionRequest extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'solicitud_de_correccion';
    protected $primaryKey = 'Codigo_solicitud_correccion';
    public $incrementing = true;
    protected $keyType = 'string';
    
    protected $fillable = [
        'Codigo_reposicion',
        'Codigo_guia_remision',
        'Motivo',
        'Fecha',
        'Status',
    ];
}
