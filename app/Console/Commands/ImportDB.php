<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\ActionMediumTerm;
use App\Year;
use App\ActionShortTerm;

class ImportDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keyrus:ImportDB';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migracion de Informacion XD';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->info("migrando informacion del backcup");
        $asms = DB::connection('pgsql_backup')->table('action_medium_terms')->orderBy('id')->get();
        foreach($asms as $asm){
            $this->info($asm->code);

            // $ast = DB::connection('pgsql_backup')->table('action_short_terms')->where('id',$asm)->first();
            $action_medium_term = new ActionMediumTerm(); //programacion a mediano plazo

            //  $action_medium_term->programmatic_structure_id = $asm->programmatic_structure_id;
             $action_medium_term->pilar = $asm->pilar;
             $action_medium_term->meta = $asm->meta;
             $action_medium_term->resultado = $asm->resultado;
             $action_medium_term->accion = $asm->accion;
             $action_medium_term->description = $asm->description;
             $action_medium_term->tipo = $asm->tipo;
             $action_medium_term->resultado_intermedio = $asm->resultado_intermedio;
             $action_medium_term->linea_base = $asm->linea_base;
             $action_medium_term->indicador_resultado_intermedio = $asm->indicador_resultado_intermedio;
             $action_medium_term->alcance_meta = $asm->alcance_meta;
             $action_medium_term->weighing = $asm->weighing;
             $action_medium_term->save();
             $action_medium_term->code='AMP-'.$action_medium_term->id;
             $action_medium_term->save();

             $gestiones =  DB::connection('pgsql_backup')->table('years')->where('action_medium_term_id',$asm->id)->orderBy('id')->get();
             //
            foreach($gestiones as $gestion)
            {

                $year = new Year;
                $year->action_medium_term_id = $action_medium_term->id;
                $year->year = $gestion->year;
                $year->meta = $gestion->meta;
                $year->save();

                $asts = DB::connection('pgsql_backup')->table('action_short_terms')->where('year_id',$gestion->id)->orderBy('id')->get();
                foreach($asts as $ast)
                {
                    $action_short_term = new ActionShortTerm;
                    $action_short_term->year_id = $year->id;
                    // $action_short_term->programmatic_structure_id = $ast->structure_id;
                    $action_short_term->description = $ast->description;
                    $action_short_term->meta = $ast->meta;
                    $action_short_term->weighing = $ast->weighing;
                    $action_short_term->unidad_de_medida = $ast->unidad_de_medida;
                    $action_short_term->linea_base = $ast->linea_base;
                    $action_short_term->producto_esperado = $ast->producto_esperado;
                    $action_short_term->save();
                    $action_short_term->code = 'ACP-'.$action_short_term->id;
                    $action_short_term->save();

                }


            }


        }
        // $this->info($asm);
    }
}
