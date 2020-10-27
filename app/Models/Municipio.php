<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'Municipio';

    public function depDocId() 
    
    {
        return $this->belongsTo(DepDocId::class, 'DepDocId');
    }

   
}
