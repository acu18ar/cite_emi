<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;

class DashboardController extends Controller
{
    public function inscritos (Request $request) {
        
        $item = Persona::from('Persona as p')
                        ->join('UnidadAcademica as ua', 'p.UnidadAcademica', '=', 'ua.id')
                        ->join('PersonaEspecialidad as pe', 'pe.Persona', '=', 'p.id')
                        ->join('Especialidad as e', 'pe.Especialidad', '=', 'e.id')
                        ->join('Estado as es', 'pe.Estado', '=', 'es.id')
                        ->where('p.Rol', 6);
                        
        if( \Auth::user()->Rol != 1 )
            $item->where('ua.id', \Auth::user()->UnidadAcademica);
                        
        if($request->UnidadAcademica > 0) 
            $item->where('ua.id', $request->UnidadAcademica);
            
        switch($request->Dimension) {
            case 'UnidadAcademica':
                $item = $item->groupBy('ua.id')->select('ua.UnidadAcademica', \DB::raw('count(p.*) as "Cantidad"'))->get();
                break;
            case 'Especialidad':
                $item = $item->groupBy('e.Especialidad')->select('e.Especialidad', \DB::raw('count(p.*) as "Cantidad"'))->get();
                break;
            case 'Estado':
                $item = $item->groupBy('es.id')->select('es.Estado', \DB::raw('count(p.*) as "Cantidad"'))->get();
                break;
            case 'Fecha':
                $item = $item->groupBy(\DB::raw('TO_CHAR(pe.created_at, \'YYYY-MM-DD\')'))
                            ->select(\DB::raw('TO_CHAR(pe.created_at, \'YYYY-MM-DD\') as "Fecha"'), \DB::raw('count(p.*) as "Cantidad"'))
                            ->orderBy(\DB::raw('TO_CHAR(pe.created_at, \'YYYY-MM-DD\')'), 'asc')
                            ->get();
                break;
            default :
                $item = $item->groupBy('ua.id')->select('ua.UnidadAcademica', \DB::raw('count(p.*) as "Cantidad"'))->get();
                break;
        }

        $data = array(
            'success' => true,
            'data' => $item,
            'msg' => 'Listado correctamente'
        );

        return response()->json($data);
    }
}
