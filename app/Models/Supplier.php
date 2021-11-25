<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'proveedor';
    protected $primaryKey = "Codigo_proveedor";
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable =[
        'Razon_social',
        'RUC'

    ];
}