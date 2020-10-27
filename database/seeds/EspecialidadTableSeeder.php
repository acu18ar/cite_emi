<?php

use Illuminate\Database\Seeder;

class EspecialidadTableSeeder extends Seeder
{    
    public function run()
    {
        // DB::table('Especialidad')->insert(['Num'=>1,'NivelAcademico'=>2, 'Especialidad' => 'Ingeniería de Sistemas', 'Descripcion' => 'Ingeniería de Sistemas', 'Activo' => 1]);
        // DB::table('Especialidad')->insert(['Num'=>2,'NivelAcademico'=>2, 'Especialidad' => 'Ingeniería Comercial', 'Descripcion' => 'Ingeniería Comercial','Activo' => 1]);
        // DB::table('Especialidad')->insert(['Num'=>3,'NivelAcademico'=>2, 'Especialidad' => 'Ingeniería Civil', 'Descripcion' => 'Ingeniería Civil', 'Activo' => 1]);
        // DB::table('Especialidad')->insert(['Num'=>4,'NivelAcademico'=>2, 'Especialidad' => 'Ingeniería en Telecomunicaciones', 'Descripcion' => 'Ingeniería en Telecomunicaciones', 'Activo' => 1]);
        // DB::table('Especialidad')->insert(['Num'=>5,'NivelAcademico'=>2, 'Especialidad' => 'Ingeniería Electrónica', 'Descripcion' => 'Ingeniería Electrónica', 'Activo' => 1]);
        // DB::table('Especialidad')->insert(['Num'=>6,'NivelAcademico'=>2, 'Especialidad' => 'Ingeniería Bionanotecnologia', 'Descripcion' => 'Ingeniería Bionanotecnologia', 'Activo' => 1]);
        // DB::table('Especialidad')->insert(['Num'=>7,'NivelAcademico'=>2, 'Especialidad' => 'Ingeniería Petrolera', 'Descripcion' => 'Ingeniería Petrolera', 'Activo' => 1]);
        // DB::table('Especialidad')->insert(['Num'=>8,'NivelAcademico'=>2, 'Especialidad' => 'Ingeniería Agronómica', 'Descripcion' => 'Ingeniería Agronómica', 'Activo' => 1]);
        // DB::table('Especialidad')->insert(['Num'=>9,'NivelAcademico'=>2, 'Especialidad' => 'Ingeniería Geográfica', 'Descripcion' => 'Ingeniería Geográfica', 'Activo' => 1]);
        // DB::table('Especialidad')->insert(['Num'=>10,'NivelAcademico'=>2, 'Especialidad' => 'Ingeniería Industrial', 'Descripcion' => 'Ingeniería Industrial', 'Activo' => 1]);
        // DB::table('Especialidad')->insert(['Num'=>11,'NivelAcademico'=>2, 'Especialidad' => 'Ingeniería Agroindustrial', 'Descripcion' => 'Ingeniería Agroindustrial', 'Activo' => 1]);
        // DB::table('Especialidad')->insert(['Num'=>12,'NivelAcademico'=>2, 'Especialidad' => 'Ingeniería Mecatrónica', 'Descripcion' => 'Ingeniería Mecatrónica', 'Activo' => 1]);
        // DB::table('Especialidad')->insert(['Num'=>13,'NivelAcademico'=>2, 'Especialidad' => 'Ingeniería Económica', 'Descripcion' => 'Ingeniería Económica', 'Activo' => 1]);
        // DB::table('Especialidad')->insert(['Num'=>14,'NivelAcademico'=>1, 'Especialidad' => 'en Informática', 'Descripcion' => 'en Informática', 'Activo' => 1]);
        // DB::table('Especialidad')->insert(['Num'=>15,'NivelAcademico'=>1, 'Especialidad' => 'en Sistemas Electrónicos', 'Descripcion' => 'en Sistemas Electrónicos', 'Activo' => 1]);

        // DB::table('Especialidad')->insert(['Num'=>16,'NivelAcademico'=>1, 'Especialidad' => 'en Sistemas Electrónicos', 'Descripcion' => 'en Sistemas Electrónicos', 'Activo' => 1]);
        // DB::table('Especialidad')->insert(['Num'=>17,'NivelAcademico'=>1, 'Especialidad' => 'en Energías Renovables', 'Descripcion' => 'en Energías Renovables', 'Activo' => 1]);
        // DB::table('Especialidad')->insert(['Num'=>18,'NivelAcademico'=>1, 'Especialidad' => 'en Construcción Civil', 'Descripcion' => 'en Construcción Civil', 'Activo' => 1]);

        // DB::table('Especialidad')->insert(['Num'=>19,'NivelAcademico'=>1, 'Especialidad' => 'Ingles', 'Descripcion' => 'Ingles', 'Activo' => 1]);
        // DB::table('Especialidad')->insert(['Num'=>20,'NivelAcademico'=>3, 'Especialidad' => 'Diplomado en Educación Superior', 'Descripcion' => 'Diplomado en Educación Superior', 'Activo' => 1]);

        /*ESPECIALIDADES ADICIONALES */
        DB::table('Especialidad')->insert(['Num' => 1, 'NivelAcademico' =>2,'Especialidad'=>'Ciencias Básicas', 'Descripcion' => 'Ciencias Básicas', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 2, 'NivelAcademico' =>2,'Especialidad'=>'Ingeniería Agronómica', 'Descripcion' => 'Ingeniería Agronómica', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 3, 'NivelAcademico' =>2,'Especialidad'=>'Ingeniería Comercial', 'Descripcion' => 'Ingeniería Comercial', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 4, 'NivelAcademico' =>2,'Especialidad'=>'Ingeniería Financiera', 'Descripcion' => 'Ingeniería Financiera', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 5, 'NivelAcademico' =>2,'Especialidad'=>'Ingeniería Economica', 'Descripcion' => 'Ingeniería Economica', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 6, 'NivelAcademico' =>2,'Especialidad'=>'Ingeniería en Sistemas Electrónicos', 'Descripcion' => 'Ingeniería en Sistemas Electrónicos', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 7, 'NivelAcademico' =>2,'Especialidad'=>'Ingeniería de Sistemas', 'Descripcion' => 'Ingeniería de Sistemas', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 8, 'NivelAcademico' =>2,'Especialidad'=>'Ingeniería Telecomunicaciones', 'Descripcion' => 'Ingeniería Telecomunicaciones', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 9, 'NivelAcademico' =>2,'Especialidad'=>'Ingeniería Mecatrónica', 'Descripcion' => 'Ingeniería Mecatrónica', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 10, 'NivelAcademico' =>2,'Especialidad'=>'Ingeniería Civil', 'Descripcion' => 'Ingeniería Civil', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 11, 'NivelAcademico' =>2,'Especialidad'=>'Ingeniería Geográfica', 'Descripcion' => 'Ingeniería Geográfica', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 12, 'NivelAcademico' =>2,'Especialidad'=>'Ingeniería Industrial', 'Descripcion' => 'Ingeniería Industrial', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 13, 'NivelAcademico' =>2,'Especialidad'=>'Ingeniería Agroindustrial', 'Descripcion' => 'Ingeniería Agroindustrial', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 14, 'NivelAcademico' =>2,'Especialidad'=>'Ingeniería Ambiental', 'Descripcion' => 'Ingeniería Ambiental', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 15, 'NivelAcademico' =>2,'Especialidad'=>'Ingeniería Petrolera', 'Descripcion' => 'Ingeniería Petrolera', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 16, 'NivelAcademico' =>1,'Especialidad'=>'Tec.Sup. en Programación de Sistemas', 'Descripcion' => 'Tec.Sup. en Programación de Sistemas', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 17, 'NivelAcademico' =>1,'Especialidad'=>'Tec.Sup. en Analisis de Sistemas', 'Descripcion' => 'Tec.Sup. en Analisis de Sistemas', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 18, 'NivelAcademico' =>1,'Especialidad'=>'Tec.Sup. en Sistemas Electrónicos', 'Descripcion' => 'Tec.Sup. en Sistemas Electrónicos', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 19, 'NivelAcademico' =>1,'Especialidad'=>'Tec.Sup. en Informática', 'Descripcion' => 'Tec.Sup. en Informática', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 20, 'NivelAcademico' =>1,'Especialidad'=>'Tec.Sup. en Construcción Civil', 'Descripcion' => 'Tec.Sup. en Construcción Civil', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 21, 'NivelAcademico' =>1,'Especialidad'=>'Tec.Sup. en Energías Renovables', 'Descripcion' => 'Tec.Sup. en Energías Renovables', 'Activo'=>0]);
        DB::table('Especialidad')->insert(['Num' => 22, 'NivelAcademico' =>1,'Especialidad'=>'Tec.Sup. en Energías Sistemas Electrónicos', 'Descripcion' => 'Tec.Sup. en Energías Sistemas Electrónicos', 'Activo'=>0]);

    }
}

