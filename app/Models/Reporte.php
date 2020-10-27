<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Log;

class Reporte extends Model
{

    public function generaExcel($sql,$nombre)
    {
        $fileName = md5($nombre . Carbon::now());
        $basePathGenerated =public_path('tmp/');

        //Elimina previamente en caso de que el archivo exista
        if (\Storage::exists($basePathGenerated . $fileName . '.xlsx'))
            \Storage::delete($basePathGenerated);

        //reemplaza los parametros
        //return $parametrosReporte;
    //    return $sql;
       //crea cabeceras del archivo
       $result = \DB::select(\DB::raw($sql));
       $cabeceras = [];
       $i = 0;
       foreach ($result as $key => $value) {
           foreach ($value as $k => $v) {
               $cabeceras[$i] = $k;
               $i++;
           }
           break;
       }
        //genera el archivo excel
        ob_clean();
        \Excel::store(new \App\Exports\TipoReporteExport($sql, $cabeceras), $fileName.'.xlsx', 'generated');
       
        $urlFile = config('parameters.generated_files');
        
        return array(
            'url' => $urlFile . $fileName . '.xlsx',
            'uri' => $basePathGenerated . $fileName . '.xlsx',
            'fileName' => $fileName . '.xlsx'
        );
    }
}
