<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';
    protected $primaryKey = 'id_reserva';
    public $timestamps = false;

    protected $fillable = [
        'numero_reserva',
        'fecha_reserva',
        'hora_reserva',
        'id_usuario'
    ];

    protected $casts = [
        'fecha_reserva' => 'date',
        'hora_reserva' => 'datetime:H:i:s'
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function pasajeros()
    {
        return $this->hasMany(Pasajero::class, 'id_reserva', 'id_reserva');
    }

    public function tiquetes()
    {
        return $this->hasMany(Tiquete::class, 'id_reserva', 'id_reserva');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_reserva', 'id_reserva');
    }

    // Métodos helper
    public function estaPagada()
    {
        return $this->pagos()->where('monto', '>', 0)->exists();
    }

    public function montoTotal()
    {
        return $this->pagos()->sum('monto');
    }

    public function cantidadPasajeros()
    {
        return $this->pasajeros()->count();
    }

    public function tieneTiquetesGenerados()
    {
        return $this->tiquetes()->count() > 0;
    }



    // Reserva.php
public function vuelo() {
    return $this->belongsTo(Vuelo::class);
}

public function pasajero() {
    return $this->belongsTo(Pasajero::class);
}

}