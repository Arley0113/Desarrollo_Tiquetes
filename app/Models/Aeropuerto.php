<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aeropuerto extends Model
{
    use HasFactory;

    protected $table = 'aeropuerto';
    protected $primaryKey = 'id_aeropuerto';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'detalle',
        'id_lugar'
    ];


    public function lugar()
    {
        return $this->belongsTo(Lugar::class, 'id_lugar', 'id_lugar');
    }

    public function aviones()
    {
        return $this->hasMany(ModeloAvion::class, 'id_aeropuerto', 'id_aeropuerto');
    }
}