<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asiento extends Model
{
    use HasFactory;

    protected $table = 'asientos';
    protected $primaryKey = 'id_asiento';
    public $timestamps = false;

    protected $fillable = [
        'numero_asiento',
        'id_avion'
    ];

    // Relaciones
    public function avion()
    {
        return $this->belongsTo(ModeloAvion::class, 'id_avion', 'id_avion');
    }

    public function tiquetes()
    {
        return $this->hasMany(Tiquete::class, 'id_asiento', 'id_asiento');
    }

    // Métodos helper
    public function estaDisponible($idVuelo)
    {
        return !Tiquete::where('id_asiento', $this->id_asiento)
            ->where('id_vuelo', $idVuelo)
            ->exists();
    }
}