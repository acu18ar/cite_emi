<?php

use Illuminate\Database\Seeder;

class NivelAcademicoTableSeeder extends Seeder
{   
    public function run()
    {
        DB::table('NivelAcademico')->insert(['Num'=> 1, 'NivelAcademico' => 'Técnico Superior', 'Descripcion' => 'Técnico Superior', 'Activo' => 1]);
        DB::table('NivelAcademico')->insert(['Num'=> 2, 'NivelAcademico' => 'Licenciatura', 'Descripcion' => 'Licenciatura', 'Activo' => 1]);
        DB::table('NivelAcademico')->insert(['Num'=> 3, 'NivelAcademico' => 'Posgrado', 'Descripcion' => 'Posgrado', 'Activo' => 1]);
    }
}
