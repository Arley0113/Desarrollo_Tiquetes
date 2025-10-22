<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------------------
        // 0) Helpers y fecha
        // ---------------------------
        $hoy = Carbon::today()->toDateString();

        // ---------------------------
        // 1) DESACTIVAR FK CHECKS (solo en DEV)
        // ---------------------------
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // ---------------------------
        // 2) TRUNCAR TABLAS (hijos -> padres)
        // ---------------------------
        $tables = [
            'tiquetes',
            'pagos',
            'pasajeros',
            'reservas',
            'vuelos',
            'precios',
            'tipo_viaje',
            'asientos',
            'modelo_avion',
            'aeropuerto',
            'lugares',
            'usuarios',
            'rol'
        ];

        foreach ($tables as $table) {
            // Si la tabla existe, truncar
            if (DB::getSchemaBuilder()->hasTable($table)) {
                DB::table($table)->truncate();
            }
        }

        // ---------------------------
        // 3) REACTIVAR FK CHECKS
        // ---------------------------
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ---------------------------
        // 4) INSERTS DINÁMICOS (sin asumir IDs)
        // ---------------------------

        // 4.1 ROLES
        $idRolAdmin = DB::table('rol')->insertGetId([
            'nombre_rol' => 'Administrador'
        ]);
        $idRolCliente = DB::table('rol')->insertGetId([
            'nombre_rol' => 'Cliente'
        ]);

        // 4.2 USUARIOS (no incluimos password porque tu DDL no lo define)
        $idUsuarioJuan = DB::table('usuarios')->insertGetId([
            'primer_apellido' => 'Pérez',
            'segundo_apellido' => 'Gómez',
            'nombres' => 'Juan',
            'fecha_nacimiento' => '1990-05-10',
            'genero' => 'M',
            'tipo_documento' => 'CC',
            'documento' => '100200300',
            'condicion_infante' => false,
            'celular' => '3100000001',
            'correo' => 'juan.perez@example.com',
            'id_rol' => $idRolCliente,
            'estado_usuario' => 'Activo'
        ]);

        $idUsuarioAdmin = DB::table('usuarios')->insertGetId([
            'primer_apellido' => 'Admin',
            'segundo_apellido' => 'Root',
            'nombres' => 'Administrador',
            'fecha_nacimiento' => null,
            'genero' => 'Otro',
            'tipo_documento' => 'CC',
            'documento' => '99999999',
            'condicion_infante' => false,
            'celular' => '3100000000',
            'correo' => 'admin@example.com',
            'id_rol' => $idRolAdmin,
            'estado_usuario' => 'Activo'
        ]);

        // 4.3 LUGARES
        $lugares = [
            'Bogotá',
            'Medellín',
            'Cali',
            'Cartagena'
        ];
        $idsLugares = [];
        foreach ($lugares as $nombre) {
            $idsLugares[] = DB::table('lugares')->insertGetId(['nombre_lugar' => $nombre]);
        }
        // Mapear por índice si necesitas: $idsLugares[0] => Bogotá

        // 4.4 AEROPUERTOS vinculados a lugares (tomamos los 4 lugares insertados)
        $idAeropuertoBogota = DB::table('aeropuerto')->insertGetId([
            'nombre' => 'El Dorado',
            'detalle' => 'Aeropuerto principal de Bogotá',
            'id_lugar' => $idsLugares[0]
        ]);
        $idAeropuertoMedellin = DB::table('aeropuerto')->insertGetId([
            'nombre' => 'José María Córdova',
            'detalle' => 'Aeropuerto de Medellín',
            'id_lugar' => $idsLugares[1]
        ]);
        $idAeropuertoCali = DB::table('aeropuerto')->insertGetId([
            'nombre' => 'Alfonso Bonilla Aragón',
            'detalle' => 'Aeropuerto de Cali',
            'id_lugar' => $idsLugares[2]
        ]);
        $idAeropuertoCartagena = DB::table('aeropuerto')->insertGetId([
            'nombre' => 'Rafael Núñez',
            'detalle' => 'Aeropuerto de Cartagena',
            'id_lugar' => $idsLugares[3]
        ]);

        // 4.5 MODELO_AVION (vinculado a aeropuertos)
        $idAvion1 = DB::table('modelo_avion')->insertGetId([
            'nombre_avion' => 'Airbus A320',
            'capacidad' => 180,
            'serial' => 'A320-0001',
            'id_aeropuerto' => $idAeropuertoBogota
        ]);
        $idAvion2 = DB::table('modelo_avion')->insertGetId([
            'nombre_avion' => 'Boeing 737',
            'capacidad' => 160,
            'serial' => 'B737-0001',
            'id_aeropuerto' => $idAeropuertoMedellin
        ]);
        $idAvion3 = DB::table('modelo_avion')->insertGetId([
            'nombre_avion' => 'ATR 72',
            'capacidad' => 70,
            'serial' => 'ATR72-0001',
            'id_aeropuerto' => $idAeropuertoCali
        ]);

        // 4.6 ASIENTOS por avión (insertamos con insert para performance)
        $asientosToInsert = [];
        // Avión 1 (A320) - filas 1 y 2 A-F
        $nums1 = ['1A','1B','1C','1D','1E','1F','2A','2B','2C','2D','2E','2F'];
        foreach ($nums1 as $n) {
            $asientosToInsert[] = ['numero_asiento' => $n, 'id_avion' => $idAvion1];
        }
        // Avión 2 (B737)
        $nums2 = ['1A','1B','1C','1D','1E','1F','2A','2B','2C','2D'];
        foreach ($nums2 as $n) {
            $asientosToInsert[] = ['numero_asiento' => $n, 'id_avion' => $idAvion2];
        }
        // Avión 3 (ATR72)
        $nums3 = ['1A','1B','1C','1D','2A','2B','2C','2D'];
        foreach ($nums3 as $n) {
            $asientosToInsert[] = ['numero_asiento' => $n, 'id_avion' => $idAvion3];
        }
        DB::table('asientos')->insert($asientosToInsert);

        // 4.7 TIPO_VIAJE
        $idTipoIda = DB::table('tipo_viaje')->insertGetId(['nombre' => 'Ida']);
        $idTipoIdaVuelta = DB::table('tipo_viaje')->insertGetId(['nombre' => 'Ida y vuelta']);

        // 4.8 PRECIOS (vinculados a tipo_viaje)
        $idPrecio1 = DB::table('precios')->insertGetId([
            'precio_ida' => 120000.00,
            'precio_ida_vuelta' => 220000.00,
            'id_viaje' => $idTipoIda
        ]);
        $idPrecio2 = DB::table('precios')->insertGetId([
            'precio_ida' => 200000.00,
            'precio_ida_vuelta' => 380000.00,
            'id_viaje' => $idTipoIdaVuelta
        ]);
        $idPrecio3 = DB::table('precios')->insertGetId([
            'precio_ida' => 80000.00,
            'precio_ida_vuelta' => 150000.00,
            'id_viaje' => $idTipoIda
        ]);

        // 4.9 VUELOS (referenciando lugares, aviones y precios)
        $idVuelo1 = DB::table('vuelos')->insertGetId([
            'fecha_vuelo' => Carbon::parse($hoy)->addDays(1)->toDateString(),
            'hora' => '08:00:00',
            'id_origen' => $idsLugares[0],   // Bogotá
            'id_destino' => $idsLugares[1],  // Medellín
            'id_avion' => $idAvion1,
            'id_precio' => $idPrecio1
        ]);
        $idVuelo2 = DB::table('vuelos')->insertGetId([
            'fecha_vuelo' => Carbon::parse($hoy)->addDays(2)->toDateString(),
            'hora' => '14:30:00',
            'id_origen' => $idsLugares[1],
            'id_destino' => $idsLugares[2],
            'id_avion' => $idAvion2,
            'id_precio' => $idPrecio2
        ]);
        $idVuelo3 = DB::table('vuelos')->insertGetId([
            'fecha_vuelo' => Carbon::parse($hoy)->addDays(3)->toDateString(),
            'hora' => '10:15:00',
            'id_origen' => $idsLugares[0],
            'id_destino' => $idsLugares[3],
            'id_avion' => $idAvion3,
            'id_precio' => $idPrecio3
        ]);

        // ---------------------------
        // 5) CREAR UNA RESERVA + PASAJEROS + PAGO + TIQUETES (relaciones correctas)
        // ---------------------------

        // 5.1 RESERVA para el usuario Juan (cliente)
        $numeroReserva = 'RES-' . strtoupper(Str::random(6));
        $idReserva = DB::table('reservas')->insertGetId([
            'numero_reserva' => $numeroReserva,
            'fecha_reserva' => $hoy,
            'hora_reserva' => now()->format('H:i:s'),
            'id_usuario' => $idUsuarioJuan
        ]);

        // 5.2 PASAJEROS (2 pasajeros para la reserva)
        $pasajerosData = [
            ['id_reserva' => $idReserva, 'nombre_pasajero' => 'María López', 'documento' => '200300400', 'es_acompanante' => false],
            ['id_reserva' => $idReserva, 'nombre_pasajero' => 'Carlos Díaz', 'documento' => '300400500', 'es_acompanante' => true]
        ];
        DB::table('pasajeros')->insert($pasajerosData);

        // Obtener los pasajeros recién insertados
        $pasajeros = DB::table('pasajeros')->where('id_reserva', $idReserva)->get();

        // 5.3 PAGO asociado a la reserva
        DB::table('pagos')->insert([
            'id_reserva' => $idReserva,
            'nombre_titular' => 'Juan Pérez',
            'tipo_documento' => 'CC',
            'documento' => '100200300',
            'correo' => 'juan.perez@example.com',
            'telefono' => '3100000001',
            'medio_pago' => 'Tarjeta de crédito',
            'monto' => 120000.00,
            'fecha_pago' => now()
        ]);

        // 5.4 TIQUETES: creamos 1 tiquete por pasajero para el VUELO 1
        // Obtener lista de id_asiento disponibles para el avion del vuelo 1
        $avionDelVuelo1 = DB::table('vuelos')->where('id_vuelo', $idVuelo1)->value('id_avion');
        $asientosDisponibles = DB::table('asientos')->where('id_avion', $avionDelVuelo1)->pluck('id_asiento')->toArray();

        // Asegurarnos de tener suficientes asientos
        if (count($asientosDisponibles) < $pasajeros->count()) {
            // Si por alguna razón no hay suficientes asientos, duplicamos la lista (evita error en seeder dev)
            $asientosDisponibles = array_pad($asientosDisponibles, $pasajeros->count(), null);
        }

        // asignar asientos secuencialmente
        foreach ($pasajeros as $index => $p) {
            $idAsientoAsignado = array_shift($asientosDisponibles); // toma y remueve el primer id
            DB::table('tiquetes')->insert([
                'codigo' => 'TIC-' . strtoupper(Str::random(8)),
                'detalle_tiquete' => 'Vuelo ' . $idVuelo1 . ' ' . Carbon::parse($hoy)->addDays(1)->toDateString(),
                'id_reserva' => $idReserva,
                'id_vuelo' => $idVuelo1,
                'id_asiento' => $idAsientoAsignado,
                'id_precio' => $idPrecio1,
                'fecha_emision' => now()
            ]);
        }

        // ---------------------------
        // 6) FIN - Mensaje opcional en logs (seeder no imprime por defecto)
        // ---------------------------
        // Puedes verificar conteos:
        // - DB::table('usuarios')->count()
        // - DB::table('vuelos')->count()
        // etc.
    }
}
