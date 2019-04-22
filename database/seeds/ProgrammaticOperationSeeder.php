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
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 3,
            'code' =>  '22 0000 03',
            'description' => 'PLANTA PROCESADORA DE LECHE CHALLAPATA',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 3,
            'code' =>  '22 0000 04',
            'description' => 'PLANTA PROCESADORA DE LECHE SAN LORENZO',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 3,
            'code' =>  '22 0000 06',
            'description' => 'PLANTA PROCESADORA DE LECHE BENI',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 3,
            'code' =>  '22 0000 05',
            'description' => 'FONDO PROLECHE',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 3,
            'code' =>  '05740000500000',
            'description' => 'IMPLEMENTACIÓN PLANTA PROCESADORA DE LÁCTEOS EN EL DEPARTAMENTO DEL BENI',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 3,
            'code' =>  '05740000700000',
            'description' => 'IMPLEMENTACIÓN PLANTA PROCESADORA DE LÁCTEOS EN EL TRÓPICO DE COCHABAMBA',
            'da' => '03',
            'ue' => '03',
        ]);
//
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 4,
            'code' =>  '23 0000 01',
            'description' => 'PLANTA PROCESADORA DE CÍTRICOS VILLA 14 DE SEPTIEMBRE',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 4,
            'code' =>  '23 0000 02',
            'description' => 'PLANTA PROCESADORA DE CÍTRICOS CARANAVI',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 4,
            'code' =>  '23 0000 03',
            'description' => 'PLANTA PROCESADORA DE FRUTAS VALLE SACTA - COCHABAMBA',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 4,
            'code' =>  '23 0000 04',
            'description' => 'PLANTA LIOFILIZADORA DE FRUTAS EN PALOS BLANCOS - LA PAZ',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 4,
            'code' =>  '23 0000 05',
            'description' => 'PLANTA LIOFILIZADORA DE FRUTAS EN EL TRÓPICO DE COCHABAMBA',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 4,
            'code' =>  '05740000500000',
            'description' => 'IMPLEM. PLANTA LIOFILIZADORA DE FRUTAS EN EL TRÓPICO DE COCHABAMBA',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 4,
            'code' =>  '05740000200000',
            'description' => ' IMPLEM. PLANTA LIOFILIZADORA DE FRUTAS EN PALOS BLANCOS - LA PAZ',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 4,
            'code' =>  '5740000100000',
            'description' => 'IMPLEM. PLANTA PROCESADORA  DE FRUTAS EN VALLE SACTA - COCHABAMBA',
            'da' => '03',
            'ue' => '03',
        ]);
        ///
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 5,
            'code' =>  '24 0000 01',
            'description' => 'GESTIÓN  OPERATIVA  VILLA TUNARI',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 5,
            'code' =>  '24 0000 02',
            'description' => 'GESTIÓN  OPERATIVA  CHUQUISACA',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 5,
            'code' =>  '24 0000 03',
            'description' => 'GESTIÓN  OPERATIVA  IRUPANA',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 5,
            'code' =>  '24 0000 04',
            'description' => 'PLANTA DE PROCESAMIENTO DE ESTEVIA SHINAHOTA-  COCHABAMBA',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 5,
            'code' =>  '01320006300000',
            'description' => 'IMPLEM. PLANTA DE PROCESAMIENTO DE ESTEVIA SHINAHOTA-COCHABAMBA',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 5,
            'code' =>  '01320006900000',
            'description' => 'IMPLEM. Y DESARROLLO DEL COMPLEJO PRODUCTIVO APÍCOLA LOS YUNGAS IRUPANA DEPARTAMENTO DE LA PAZ',
            'da' => '03',
            'ue' => '03',
        ]);
        ////
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 6,
            'code' =>  '25 0000 01',
            'description' => 'ACOPIO DE CASTAÑA',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 6,
            'code' =>  '25 0000 02',
            'description' => 'PLANTA DE BENEFICIADO EBA AMAZÓNICA',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 6,
            'code' =>  '25 0000 03',
            'description' => 'AOTRAS PLANTAS DE BENEFICIADO',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 6,
            'code' =>  '05820000200000',
            'description' => 'IMPLEM. PROG. APROVECHAMIENTO INTEGRAL SOSTENIBLE E INCLUSIVO DE LA CASTAÑA EN LA REGIÓN AMAZÓNICA BOLIVIANA',
            'da' => '03',
            'ue' => '03',
        ]);
        /////
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 7,
            'code' =>  '05990000200000',
            'description' => 'IMPLEMENTACIÓN PLANTA INDUSTRIALIZADORA DE QUINUA BOLIVIANA',
            'da' => '03',
            'ue' => '03',
        ]);
        //////
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 8,
            'code' =>  '41 0000 01',
            'description' => 'COMERCIALIZACIÓN PRODUCTOS AMAZÓNICOS Y DERIVADOS MERCADO INTERNO',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 8,
            'code' =>  '41 0000 02',
            'description' => 'COMERCIALIZACIÓN PRODUCTOS AMAZÓNICOS MERCADO EXTERNO',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 8,
            'code' =>  '41 0000 03',
            'description' => 'COMERCIALIZACIÓN PRODUCTOS LÁCTEOS',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 8,
            'code' =>  '41 0000 04',
            'description' => 'COMERCIALIZACIÓN PRODUCTOS  FRUTÍCOLAS',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 8,
            'code' =>  '41 0000 05',
            'description' => 'COMERCIALIZACIÓN PRODUCTOS ENDULZANTES',
            'da' => '03',
            'ue' => '03',
        ]);
        //////
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 9,
            'code' =>  '42 0000 01',
            'description' => 'DISTRIBUCIÓN SUBSIDIO PRENATAL Y LACTANCIA - SANTA CRUZ',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 9,
            'code' =>  '42 0000 02',
            'description' => 'DISTRIBUCIÓN SUBSIDIO PRENATAL Y DE LACTANCIA - BENI',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 9,
            'code' =>  '42 0000 03',
            'description' => 'DISTRIBUCIÓN SUBSIDIO PRENATAL Y DE LACTANCIA - PANDO',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 9,
            'code' =>  '42 0000 04',
            'description' => 'DISTRIBUCIÓN SUBSIDIO PRENATAL Y DE LACTANCIA - SUCRE',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 9,
            'code' =>  '42 0000 05',
            'description' => 'DISTRIBUCIÓN SUBSIDIO PRENATAL Y DE LACTANCIA - ORURO',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 9,
            'code' =>  '42 0000 06',
            'description' => 'DISTRIBUCIÓN SUBSIDIO PRENATAL Y DE LACTANCIA - POTOSÍ',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 9,
            'code' =>  '42 0000 07',
            'description' => 'DISTRIBUCIÓN SUBSIDIO PRENATAL Y LACTANCIA - SANTA CRUZ',
            'da' => '03',
            'ue' => '03',
        ]);
        //////
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 10,
            'code' =>  '43 0000 01',
            'description' => 'DISTRIBUCIÓN SUBSIDIO UNIVERSAL PRENATAL POR LA VIDA REGIÓN  ORIENTE',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 10,
            'code' =>  '43 0000 02',
            'description' => 'DISTRIBUCIÓN SUBSIDIO UNIVERSAL PRENATAL POR LA VIDA REGIÓN - OCCIDENTE',
            'da' => '03',
            'ue' => '03',
        ]);
        ///////
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 11,
            'code' =>  '99 0000 21',
            'description' => 'SERVICIO DE LA DEUDA PRODUCTOS AMAZÓNICOS',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 11,
            'code' =>  '99 0000 22',
            'description' => 'SERVICIO DE LA DEUDA LÁCTEOS Y FRUTÍCOLA ',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 11,
            'code' =>  '99 0000 23',
            'description' => 'SERVICIO DE LA DEUDA ENDULZANTES',
            'da' => '03',
            'ue' => '03',
        ]);
        DB::table('programmatic_operations')->insert([
            'programmatic_structure_id' => 11,
            'code' =>  '99 0000 24',
            'description' => 'SERVICIO DE LA DEUDA ',
            'da' => '03',
            'ue' => '03',
        ]);

    }
}
