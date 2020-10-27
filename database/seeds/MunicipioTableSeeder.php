<?php

use Illuminate\Database\Seeder;

class MunicipioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Municipio')->insert(['Num' => 1, 'DepDocId' =>4,'Municipio'=>'Cercado', 'Descripcion' => 'Cercado', 'Activo'=>0]);
        DB::table('Municipio')->insert(['Num' => 2, 'DepDocId' =>6,'Municipio'=>'Murillo', 'Descripcion' => 'Murillo', 'Activo'=>0]);
       
    }
}
