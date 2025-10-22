<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    use HasFactory;

    protected $table = 'lugares';
    protected $primaryKey = 'id_lugar';
    public $timestamps = false;

    protected $fillable = [
        'nombre_lugar'
    ];


    public function aeropuertos()
    {
        return $this->hasMany(Aeropuerto::class, 'id_lugar', 'id_lugar');
    }

    public function vuelosOrigen()
    {
        return $this->hasMany(Vuelo::class, 'id_origen', 'id_lugar');
    }

    public function vuelosDestino()
    {
        return $this->hasMany(Vuelo::class, 'id_destino', 'id_lugar');
    }
}