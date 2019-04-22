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
        // son actividades a corto plazo
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
        DB::table('programmatic_structures')->insert([
            'code' =>  '23 0000 00',
            'description' => 'GESTIÓN PRODUCTIVA FRUTÍCOLA Y DERIVADOS',
        ]);
        DB::table('programmatic_structures')->insert([
            'code' =>  '24 0000 00',
            'description' => 'GESTIÓN PRODUCTIVA ENDULZANTES',
        ]);
        DB::table('programmatic_structures')->insert([
            'code' =>  '25 0000 00',
            'description' => 'GESTIÓN  DE ACOPIO  Y BENEFICIADO - PRODUCTOS AMAZÓNICOS',
        ]);
        DB::table('programmatic_structures')->insert([
            'code' =>  '26 0000 00',
            'description' => 'GESTIÓN PRODUCTIVA DE GRANOS',
        ]);
        DB::table('programmatic_structures')->insert([
            'code' =>  '27 0000 00',
            'description' => 'GESTIÓN COMERCIAL',
        ]);
        DB::table('programmatic_structures')->insert([
            'code' =>  '41 0000 00',
            'description' => 'GESTIÓN COMERCIAL',
        ]);
        DB::table('programmatic_structures')->insert([
            'code' =>  '42 0000 00',
            'description' => 'DISTRIBUCIÓN SUBSIDIO PRENATAL Y DE LACTANCIA',
        ]);
        DB::table('programmatic_structures')->insert([
            'code' =>  '43 0000 00',
            'description' => 'DISTRIBUCIÓN SUBSIDIO UNIVERSAL PRENATAL POR LA VIDA',
        ]);
        DB::table('programmatic_structures')->insert([
            'code' =>  '99 0000 00',
            'description' => 'SERVICIO DE LA DEUDA',
        ]);
    }
}
