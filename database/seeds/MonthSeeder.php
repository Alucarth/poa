<?php

use Illuminate\Database\Seeder;

class MonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('months')->insert([
            ['name'=>'Enero'],
            ['name'=>'Febrero'],
            ['name'=>'Marzo'],
            ['name'=>'Abril'],
            ['name'=>'Mayo'],
            ['name'=>'Junio'],
            ['name'=>'Julio'],
            ['name'=>'Agosto'],
            ['name'=>'Septiembre'],
            ['name'=>'Octubre'],
            ['name'=>'Noviembre'],
            ['name'=>'Diciembre'],
        ]);
    }
}
