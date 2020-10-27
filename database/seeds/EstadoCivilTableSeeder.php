<?php

use Illuminate\Database\Seeder;

class EstadoCivilTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('EstadoCivil')->insert(['Num'=> 1, 'EstadoCivil' => 'Soltero (a)']);
        DB::table('EstadoCivil')->insert(['Num'=> 2, 'EstadoCivil' => 'Casado (a)']);
       
    }
}
