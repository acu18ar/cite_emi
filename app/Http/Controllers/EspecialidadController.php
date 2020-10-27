<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use App\Http\Requests\EspecialidadRequest;
use App\Models\Especialidad;

class EspecialidadController extends Controller
{
    public function view() {
        return view('modules.Especialidad.view');
    } 
    
    public function index() {
        //$item = Especialidad::select( 'Num','NivelAcademico', 'Especialidad', 'Descripcion', 'Activo');

        $item = Especialidad::from('Especialidad as e')
                ->leftJoin('NivelAcademico as na', 'e.NivelAcademico', '=', 'na.id')
                ->select('e.id','e.Num','na.NivelAcademico', 'e.Especialidad', 'e.Descripcion', 'e.Activo')
                ->whereNull('e.deleted_at');
        if(\Auth::user()->Rol != 1) {
            $item = $item->where('id', \Auth::user()->Especialidad);
        }

        return Datatables::of($item)
            ->addColumn('action', function ($p) {
                return '<a href="#" @click.prevent="showEspecialidad('. $p->id . ')" class="btn btn-info btn-xs"><i class="fa fa-bars"></i> '. trans('labels.actions.details') .'</a> &nbsp;';
            })
        ->editColumn('id', '{{$id}}')
        ->make(true);
    }

    public function list(Request $request) {
        $item = Especialidad::from('Especialidad as e')->join('NivelAcademico as na','e.NivelAcademico','=','na.id');
        $objeto = null;
        $objeto = $item->select('e.id', DB::raw('CONCAT(na."NivelAcademico", \' \', e."Especialidad") as "Especialidad"'))
                        ->whereNull('e.deleted_at')->orderBy('e.Num', 'asc')->get();
        
        $data = array(
            'success' => true,
            'data' => $objeto,
            'msg' => trans('messages.listed')
        );

        return response()->json($data);
    }

    public function show(Request $request) {
        try {
            $item = Especialidad::findOrFail($request->id);
            $item->nivelAcademico->NivelAcademico;
            //$item = Especialidad::where('id', $request->id)->with('nivelAcademico')->first();

            $data = array(
                'success' => true,
                'data' => $item,
                'msg' => trans('messages.listed')
            );
        } catch(\Exception $e) {
            $data = array(
                'success' => false,
                'data' => null,
                'msg' => trans('mesagges.error')
            );
        } finally {
            return response()->json($data);
        }
    }

    public function store (EspecialidadRequest $request) {
        if($request->id) {
            $item = Especialidad::findOrFail($request->id);
            $msg = trans('messages.updated');
        } else {
            $item = new Especialidad();
            $item->CreatorUserName = \Auth::user()->email;
            $item->CreatorFullUserName = \Auth::user()->Persona;
            $item->CreatorIP = $request->ip();
            $msg = trans('messages.added');
        }
        
        $item->NivelAcademico = $request->NivelAcademico;
        $item->Especialidad = $request->Especialidad;
        $item->Descripcion = $request->Descripcion;
        $item->Activo = $request->Activo ? true : false;
        
        $item->UpdaterUserName = \Auth::user()->email;
        $item->UpdaterFullUserName = \Auth::user()->Persona;
        $item->UpdaterIP = $request->ip();
        $item->save();

        $result = array (
            'success' => true,
            'data' => $item,
            'msg' => $msg
        );
        return response()->json($result);
    }

    public function destroy(Request $request) {
        $item = Especialidad::where('id', $request->id)->first();
        $item->deleted_at = Carbon::now();
        $item->DeleterUserName = \Auth::user()->Persona;
        $item->DeleterFullUserName = \Auth::user()->Persona;
        $item->DeleterIP =  $request->ip();
        $item->save();
        $result = array (
            'success' => true,
            'data' => null,
            'msg' => trans('messages.deleted')
        );
        
        return response()->json($result);
    }
}
