<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'title' => 'CODIGO VALIDO',
            'html' => 'PASE',
            'icon' => 'success',
            'timer' => 1300,
        ]);

        Status::create([
            'title' => 'CODIGO YA INGRESADO',
            'html' => 'ALTO - TARJETA YA INGRESADA <br>',
            'icon' => 'error',
            'timer' => 2500,
        ]);

        Status::create([
            'title' => 'SALIDA ASIGNADA',
            'html' => 'TARJETA REINICIADA PARA REINGRESO',
            'icon' => 'success',
            'timer' => 1300,
        ]);

        Status::create([
            'title' => 'CODIGO VALIDO',
            'html' => 'PASE - TARJETA DE REINGRESO',
            'icon' => 'success',
            'timer' => 1300,
        ]);

        Status::create([
            'title' => 'LA TARJETA NO A INGRESADO',
            'html' => 'ESTA TARJETA NO HA INGRESADO',
            'icon' => 'warning',
            'timer' => 2500,
        ]);

        Status::create([
            'title' => 'NO SE LE PUEDE ASIGNAR SALIDA',
            'html' => 'YA CUENTA CON UNA SALIDA ASIGNADA',
            'icon' => 'warning',
            'timer' => 2500,
        ]);
    }
}
