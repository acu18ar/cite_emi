<?php

use Illuminate\Database\Seeder;

class TipoMiembroTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('TipoMiembro')->insert(['Num'=> 1, 'TipoMiembro' => 'Interno', 'Requerido'=> false, 'AccedeNotas' => false,'Descripcion' => 'Descripcion']);
        DB::table('TipoMiembro')->insert(['Num'=> 2, 'TipoMiembro' => 'Externo', 'Requerido'=> true, 'AccedeNotas' => false,'Descripcion' => 'Descripcion']);
        DB::table('TipoMiembro')->insert(['Num'=> 3, 'TipoMiembro' => 'Invitado', 'Requerido'=> true, 'AccedeNotas' => false,'Descripcion' => 'Descripcion']);
       
    }
}
