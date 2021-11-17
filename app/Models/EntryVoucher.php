<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryVoucher extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'vale_de_entrada';
    protected $primaryKey = 'ID_vale_entrada';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'Codigo_guia_remision',
        'Hora',
        'Fecha_recepcion',
        'Activo'
    ];
}
