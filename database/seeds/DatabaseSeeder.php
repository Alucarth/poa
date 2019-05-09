<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        // $this->call(ProgramacionMedioPlazoSeeder::class);
        // $this->call(YearsSeeder::class);
        $this->call(MonthSeeder::class);
        $this->call(ProgrammaticStructureSeeder::class);
        $this->call(ProgrammaticOperationSeeder::class);
        $this->call(AlertTableSeeder::class);
    }
}
