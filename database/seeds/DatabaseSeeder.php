<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UnidadAcademicaTableSeeder::class);
        $this->call(RolTableSeeder::class);
        $this->call(DepDocIdTableSeeder::class);
        $this->call(PersonaTableSeeder::class);
        $this->call(TipoMiembroTableSeeder::class);
        $this->call(NivelAcademicoTableSeeder::class);
        $this->call(EspecialidadTableSeeder::class);
         $this->call(EstadoCivilTableSeeder::class);
         $this->call(MunicipioTableSeeder::class);
         $this->call(TipoMiembroTableSeeder::class);
         
    }
}
