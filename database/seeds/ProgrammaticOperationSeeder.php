<?php

use Illuminate\Database\Seeder;

class ProgrammaticOperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 1,
            'code' =>  '00 0000 01',
            'description' => 'ADMINISTRACION CENTRAl EBA ALIMENTOS',
            'da' => '01',
            'ue' => '01',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 1,
            'code' =>  '00 0000 02',
            'description' => 'ADMINISTRACION CENTRAl EBA PRODUCTOS AMAZONICOS',
            'da' => '02',
            'ue' => '02',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 2,
            'code' =>  '21 0000 01',
            'description' => 'PLANTA DE PRODUCCION DE DERIVADOS',
            'da' => '02',
            'ue' => '02',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 3,
            'code' =>  '22 0000 01',
            'description' => 'PLANTA PROCESADORA DE LECHE IVIRGARZAMA',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 3,
            'code' =>  '22 0000 02',
            'description' => 'PLANTA PROCESADORA DE LECHE ACHACACHI',
            'da' => '03',
            'ue' => '03',
        ]);
        
    }
}
