<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\TipoReporte;

class TipoReporteExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $query = null;
    protected $header = array();
    
    public function __construct($query, $header){
        //$this->super();
        $this->query = $query;
        $this->header = $header;
    }

    public function array(): array {
        
        $result = \DB::select($this->query);

        return $result;
    }


    public function headings(): array
    {
        return $this->header;
    }

}
