<?php

namespace App\Imports;

use App\Models\Persona;
use Maatwebsite\Excel\Concerns\ToModel;

ini_set('max_execution_time', 580); 

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Persona([
            
            'Grado' => $row[0],
            'Cargo' => $row[1],
            'Nombres' => $row[2],
            'ApellidoPaterno' => $row[3],
            'ApellidoMaterno' => $row[4],
            'CI' => $row[5],
            'Foto' => $row[6],
            'email' => $row[7],
            'password' => bcrypt($row[8]),
            'Rol' => '4',
            /* 'Grado' => 'ING.', */
            'Persona' => $row[3].' '.$row[4].' '.$row[2],
            'UnidadAcademica' => '4',
            'HUnidadAcademica' => 'Unidad Académica Cochabamba',
            'TipoPersona' => 'I',
            'Activo' => 'true',
            'CreatorIP' => '192.168.6.168',
            'CreatorUserName' => 'erocham@adm.emi.edu.bo',
            'CreatorFullUserName' => 'erocham@adm.emi.edu.bo',
            'UpdaterIP' => '192.168.6.168',
           

        ]);
    }
}
