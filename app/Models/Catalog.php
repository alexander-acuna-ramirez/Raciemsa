<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'catalogo';
    protected $primaryKey = 'ID_Catalogo';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'Ubicacion',
    ];
}
