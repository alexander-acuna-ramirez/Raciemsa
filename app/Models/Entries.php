<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entries extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'entradas';
    protected $primaryKey = 'Codigo_proveedor';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'Razon_social',
        'RUC',
    ];
    public function providerReinstatement(){
        return $this->hasMany(Provider::class);
    }
}
