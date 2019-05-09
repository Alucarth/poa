<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
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
            // 'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'username' =>  'alejandro.cossio',
            'name' =>  'Alejandro J. Cossio',
            // 'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'username' =>  'claudia.flores',
            'name' =>  'Claudia A. Flores',
            // 'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        $role = Role::create(['name' => 'Admin']);
        $role = Role::create(['name' => 'Planificador']);

        $user = User::find(1);
        $user->assignRole('Admin');
        $user = User::find(2);
        $user->assignRole('Admin');
        $user = User::find(3);
        $user->assignRole('Admin');

        //definiendo permisos por modulo
        $actions=array(1,2,3,4);
        $models =  array('Acciones a largo plazo','Acciones a Corto Plazo','Operaciones','Tareas','Tareas Especificas');
        foreach($models as $model){

            foreach($actions as $action)
            {
                switch ($action) {
                    case 1:
                        # create...
                        $permission = Permission::create(['name' => 'crear|'.$model]);
                        break;
                    case 2:
                        # show...
                        $permission = Permission::create(['name' => 'ver|'.$model]);
                        break;
                    case 3:
                        # edit...
                        $permission = Permission::create(['name' => 'editar|'.$model]);
                        break;
                    case 4:
                        # delete...
                        $permission = Permission::create(['name' => 'eliminar|'.$model]);
                        break;

                }
            }

        }



    }
}
