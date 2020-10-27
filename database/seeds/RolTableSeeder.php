<?php

use Illuminate\Database\Seeder;

class RolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Rol')->insert(['Num'=>1, 'Rol' => 'Administrador']);
        DB::table('Rol')->insert(['Num'=>2, 'Rol' => 'Responsable UA']);
        DB::table('Rol')->insert(['Num'=>3, 'Rol' => 'Responsable Especialidad']);
        DB::table('Rol')->insert(['Num'=>4, 'Rol' => 'Operador']);
        DB::table('Rol')->insert(['Num'=>5, 'Rol' => 'Invitado']);
    } 
}