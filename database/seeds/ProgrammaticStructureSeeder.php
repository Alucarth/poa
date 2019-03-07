<?php

use Illuminate\Database\Seeder;

class ProgrammaticStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('programmatic_structures')->insert([
            'code' =>  '00 0000 00',
            'description' => 'ADMINISTRACION CENTRAL',
        ]);
        DB::table('programmatic_structures')->insert([
            'code' =>  '21 0000 00',
            'description' => 'GESTION PRODUCTIVA - PRODUCTOS AMAZONICOS Y DERIVADOS',
        ]);
        DB::table('programmatic_structures')->insert([
            'code' =>  '22 0000 00',
            'description' => 'GESTION PRODUCTIVA LACTEOS Y DERIVADOS',
        ]);
    }
}
