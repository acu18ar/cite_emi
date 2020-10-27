<?php

namespace App\Exports;

use App\Models\Persona;
use Maatwebsite\Excel\Concerns\FromCollection;


class UsersExports implements FromCollection
{
   
    public function collection()
    {
        //return Persona::all();
        return Persona::select("Cargo","Persona","CI")->get();
    }
}
