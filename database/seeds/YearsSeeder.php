<?php

use Illuminate\Database\Seeder;

class YearsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('years')->insert([
            ['action_medium_term_id'=>1,'year'=>'2019','meta'=>1000],
            ['action_medium_term_id'=>1,'year'=>'2020','meta'=>1000],
            ['action_medium_term_id'=>1,'year'=>'2021','meta'=>1000],
            ['action_medium_term_id'=>1,'year'=>'2022','meta'=>1000],
            ['action_medium_term_id'=>1,'year'=>'2023','meta'=>1000],
            ['action_medium_term_id'=>2,'year'=>'2019','meta'=>1000],
            ['action_medium_term_id'=>2,'year'=>'2020','meta'=>1000],
            ['action_medium_term_id'=>2,'year'=>'2021','meta'=>1000],
            ['action_medium_term_id'=>2,'year'=>'2022','meta'=>1000],
            ['action_medium_term_id'=>2,'year'=>'2023','meta'=>1000],
            
        ]);
    }
}
