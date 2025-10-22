<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = true;

    protected $fillable = [
        'primer_apellido',
        'segundo_apellido',
        'nombres',
        'fecha_nacimiento',
        'genero',
        'tipo_documento',
        'documento',
        'condicion_infante',
        'celular',
        'correo',
        'id_rol',
        'estado_usuario',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'condicion_infante' => 'boolean'
    ];

    // Especificar el campo para autenticación
    public function getAuthIdentifierName()
    {
        return 'correo';
    }

    // Relaciones
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_usuario', 'id_usuario');
    }

    // Métodos helper
    public function esAdmin()
    {
        return $this->rol && $this->rol->nombre_rol === 'Administrador';
    }

    public function esCliente()
    {
        return $this->rol && $this->rol->nombre_rol === 'Cliente';
    }

    public function estaActivo()
    {
        return $this->estado_usuario === 'Activo';
    }
}