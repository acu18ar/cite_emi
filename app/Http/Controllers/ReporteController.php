<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use App\Http\Requests\PersonaRequest;
use App\Models\Reporte;

class ReporteController extends Controller
{
    public function view(){
        return view('modules.Reporte.view');
    }

    public function excelMiembro(Request $request) {
        //$item = Persona::find($request->id);
        $item=new Reporte();
        /*$gestion=2020;
        $periodioGestion=1;
        $personaId=1;*/

        $gestion=$request->gestion;
        $periodoGestion=$request->periodoGestion;
        $personaId=$request->personaId;

        $sql='
            SELECT  
            p."Persona", 
            d."FechaHora" as "Fecha y Hora",
            e."Especialidad" as "Carrera",
            ua."UnidadAcademica" as "Unidad Academica",
            tm."TipoMiembro" as "Tipo Miembro", 
            CASE 
                WHEN d."Finalizado"=true THEN \'Finalizo\'
                ELSE \'No Finalizo\'
            END AS "Defensa",
            d."Titulo"
            FROM public."PersonaDefensa" pd
            JOIN public."Persona" p ON pd."Persona"=p."id"
            JOIN public."Defensa" d ON pd."Defensa"=d."id"
            JOIN public."TipoMiembro" tm ON pd."TipoMiembro"=tm."id"
            JOIN public."Especialidad" e ON d."Especialidad"=e."id"
            JOIN public."UnidadAcademica" ua ON d."UnidadAcademica"=ua."id"
            WHERE d."Gestion"='.$gestion.'
            AND d."PeriodoGestion"='.$periodoGestion.'
            AND pd."Persona"='.$personaId.'
            AND pd.deleted_at IS NULL
            AND d.deleted_at IS NULL
            ORDER BY ua."UnidadAcademica",tm."TipoMiembro";
        ';
        $nombre="excelMiembro";
        $item = $item->generaExcel($sql,$nombre);

        $result = array (
            'success' => true,
            'data' => $item,
            'msg' => trans('messages.found')
        );

        return response()->json($result);
    }

    public function excelMiembroGlobal(Request $request) {
        //$item = Persona::find($request->id);
        $item=new Reporte();
        /*$gestion=2020;
        $periodioGestion=1;*/

        $gestion=$request->gestion;
        $periodoGestion=$request->periodoGestion;

        $sql='
            select 
            z."Persona", 
            z."UnidadAcademica" as "Unidad Academica",
            sum(z."Tutor") as "Tutor",
            sum(z."Vocal1") as "Vocal 1",
            sum(z."Vocal2") as "Vocal 2",
            sum(z."VocalRelator") as "Vocal Relator",
            sum(z."Presidente") as "Presidente"
            from (
                SELECT  
                    p."Persona", 
                    ua."UnidadAcademica",
                    case when pd."TipoMiembro" = 1 then 1 else 0 end as "Tutor",
                    case when pd."TipoMiembro" = 2 then 1 else 0 end as "Vocal1",
                    case when pd."TipoMiembro" = 3 then 1 else 0 end as "Vocal2",
                    case when pd."TipoMiembro" = 6 then 1 else 0 end as "VocalRelator",
                    case when pd."TipoMiembro" = 7 then 1 else 0 end as "Presidente"
                    FROM public."PersonaDefensa" pd
                    JOIN public."Persona" p ON pd."Persona"=p."id"
                    JOIN public."Defensa" d ON pd."Defensa"=d."id"
                    JOIN public."TipoMiembro" tm ON pd."TipoMiembro"=tm."id"
                    JOIN public."Especialidad" e ON d."Especialidad"=e."id"
                    JOIN public."UnidadAcademica" ua ON d."UnidadAcademica"=ua."id"
                    WHERE d."Gestion"='.$gestion.'
                    AND d."PeriodoGestion"='.$periodoGestion.'
                    AND pd.deleted_at IS NULL
                    AND d.deleted_at IS NULL
                ) z GROUP BY 
                    z."Persona", 
                    z."UnidadAcademica"
                    ORDER BY
                    z."Persona";
        ';
        $nombre="excelMiembro";
        $item = $item->generaExcel($sql,$nombre);

        $result = array (
            'success' => true,
            'data' => $item,
            'msg' => trans('messages.found')
        );

        return response()->json($result);
    }
}