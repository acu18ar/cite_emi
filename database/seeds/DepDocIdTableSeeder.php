<?php

use Illuminate\Database\Seeder;

class DepDocIdTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('DepDocId')->insert(['Num' =>1, 'DepDocId' => 'LP','DepDocIdDescripcion' => 'La Paz', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
        DB::table('DepDocId')->insert(['Num' =>2, 'DepDocId' => 'CH','DepDocIdDescripcion' => 'Chuquisaca', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
        DB::table('DepDocId')->insert(['Num' =>3, 'DepDocId' => 'SC','DepDocIdDescripcion' => 'Santa Cruz', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
        DB::table('DepDocId')->insert(['Num' =>4, 'DepDocId' => 'OR','DepDocIdDescripcion' => 'Oruro', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
        DB::table('DepDocId')->insert(['Num' =>5, 'DepDocId' => 'BE','DepDocIdDescripcion' => 'Beni', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
        DB::table('DepDocId')->insert(['Num' =>6, 'DepDocId' => 'PT','DepDocIdDescripcion' => 'Potosí', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
        DB::table('DepDocId')->insert(['Num' =>7, 'DepDocId' => 'CB','DepDocIdDescripcion' => 'Cochabamba', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
        DB::table('DepDocId')->insert(['Num' =>8, 'DepDocId' => 'TJ','DepDocIdDescripcion' => 'Tarija', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
        DB::table('DepDocId')->insert(['Num' =>9, 'DepDocId' => 'PN','DepDocIdDescripcion' => 'Pando', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
        DB::table('DepDocId')->insert(['Num' =>10, 'DepDocId' => 'RB','DepDocIdDescripcion' => 'Riberalta', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
        DB::table('DepDocId')->insert(['Num' =>11, 'DepDocId' => 'EXT','DepDocIdDescripcion' => 'Extranjero', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
        DB::table('DepDocId')->insert(['Num' =>12, 'DepDocId' => 'OT','DepDocIdDescripcion' => 'Otro', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
    }

}
