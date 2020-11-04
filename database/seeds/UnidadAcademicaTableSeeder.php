<?php

use Illuminate\Database\Seeder;

class UnidadAcademicaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('UnidadAcademica')->insert(['Num'=> 1, 'UnidadAcademica' => 'EMI Central', 'Sigla' => 'CENTRAL', 'Alias' => 'EMI Suc. Av. Arce']);
        // DB::table('UnidadAcademica')->insert(['Num'=> 2, 'UnidadAcademica' => 'Unidad Académica La Paz', 'Sigla' => 'UALP', 'Alias' => 'La Paz', 'idSaga' => 1]);
        // DB::table('UnidadAcademica')->insert(['Num'=> 3, 'UnidadAcademica' => 'Unidad Académica Santa Cruz', 'Sigla' => 'UASC', 'Alias' => 'Santa Cruz', 'idSaga' => 2]);
        // DB::table('UnidadAcademica')->insert(['Num'=> 4, 'UnidadAcademica' => 'Unidad Académica Cochabamba', 'Sigla' => 'UACB', 'Alias' => 'Cochabamba', 'idSaga' => 3]);
        // DB::table('UnidadAcademica')->insert(['Num'=> 5, 'UnidadAcademica' => 'Unidad Académica Riberalta', 'Sigla' => 'UARIB', 'Alias' => 'Riberalta', 'idSaga' => 4]);
        // DB::table('UnidadAcademica')->insert(['Num'=> 6, 'UnidadAcademica' => 'Unidad Académica del Trópico', 'Sigla' => 'UATRO', 'Alias' => 'Shinahota', 'idSaga' => 5]);
        
    }
}
