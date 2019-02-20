<?php

use Illuminate\Database\Seeder;

class ProgramacionMedioPlazoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('programacion_medio_plazo')->insert([
            'pilar' =>  6,
            'meta' =>  2,
            'resultado' =>  150,
            'accion' =>  15,
            'descripcion' =>  'apoyar al menos 75% de las operaciones de la empresa de manera transversal',
            'tipo' => 'Apoyo',
            'resultado_intermedio' => 'Gestion Administrativa',
            'linea_base' => '-',
            'indicador_resultado_intermedio' => 'Promedio del cumplimiento de las operaciones',
            'alcance_meta' => '75%',
        ]);
        DB::table('programacion_medio_plazo')->insert([
            'pilar' =>  6,
            'meta' =>  2,
            'resultado' =>  150,
            'accion' =>  5,
            'descripcion' =>  'Producir 4789,9 toneladas de productos derivados acorder a necesisadades  al  mercado nacion e internacional',
            'tipo' => 'Proceso',
            'resultado_intermedio' => 'Produccion de Derivados',
            'linea_base' => '-',
            'indicador_resultado_intermedio' => 'Toneladas de Derivados producidos',
            'alcance_meta' => '4789,9',
        ]);
    }
}
