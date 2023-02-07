<?php

namespace Database\Seeders;

use App\Models\Administrador;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Administradores
        User::factory(5)->create([
            'rol' => 'administrador',
        ])->each(function (User $usuario) {
            Administrador::factory(1)->create([
                'user_id' => $usuario->id,
                'email' => $usuario->email,
            ]);
        });

        //Clientes        
        User::factory(5)->create([
            'rol' => 'cliente',
        ])->each(function (User $usuario) {
            Cliente::factory(1)->create([
                'user_id' => $usuario->id,
                'email' => $usuario->email,
            ]);
        });
    }
}
