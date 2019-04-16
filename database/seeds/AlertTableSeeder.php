<?php

use Illuminate\Database\Seeder;

class AlertTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('alerts')->insert([
            ['name'=>'Rojo','min'=>0,'max'=>50,'color'=> 'danger'],
            ['name'=>'Amarillo','min'=>51,'max'=>69 ,'color'=> 'warning'],
            ['name'=>'Verde','min'=>70,'max'=>100,'color'=> 'success'],
        ]);
    }
}
