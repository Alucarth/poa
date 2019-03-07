<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' =>  'admin',
            'name' =>  'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        DB::table('roles')->insert([
            'name' =>  'admin',
            'description' => 'Administrador del Sistema',
        ]);

        DB::table('roles')->insert([
            'name' =>  'planificacion',
            'description' => 'Planificacion',
        ]);

        DB::table('user_roles')->insert([
            'user_id' =>  1,
            'rol_id' =>  1,
        ]);
        
    }
}
