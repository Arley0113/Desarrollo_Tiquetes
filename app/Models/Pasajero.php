<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasajero extends Model
{
    use HasFactory;

    protected $table = 'pasajeros';
    protected $primaryKey = 'id_pasajero';
    public $timestamps = false;

    protected $fillable = [
        'id_reserva',
        'nombre_pasajero',
        'documento',
        'es_acompanante'
    ];

    protected $casts = [
        'es_acompanante' => 'boolean'
    ];

    // Relaciones
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'id_reserva', 'id_reserva');
    }

    // Métodos helper
    public function tieneTiquete()
    {
        return Tiquete::where('id_reserva', $this->id_reserva)
            ->whereHas('reserva.pasajeros', function($query) {
                $query->where('id_pasajero', $this->id_pasajero);
            })
            ->exists();
    }
}