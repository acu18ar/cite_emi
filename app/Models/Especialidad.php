<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $table = 'Especialidad';
 
    public function nivelAcademico() {
        return $this->belongsTo(NivelAcademico::class, 'NivelAcademico');
    }
}
 