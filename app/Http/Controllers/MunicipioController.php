<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use App\Http\Requests\MunicipioRequest; 
use App\Models\Municipio;

class MunicipioController extends Controller
{
    public function view() {
        return view('modules.Municipio.view');
    }
    
    public function index() {
        //$item = Municipio::select( 'Num','DepDocId', 'Municipio', 'Descripcion', 'Activo');

        $item = Municipio::from('Municipio as e')
                ->leftJoin('DepDocId as na', 'e.DepDocId', '=', 'na.id')
                ->select('e.id','e.Num','na.DepDocId', 'e.Municipio', 'e.Descripcion', 'e.Activo')
                ->whereNull('e.deleted_at');
        if(\Auth::user()->Rol != 1) {
            $item = $item->where('id', \Auth::user()->Municipio);
        }

        return Datatables::of($item)
            ->addColumn('action', function ($p) {
                return '<a href="#" @click.prevent="showMunicipio('. $p->id . ')" class="btn btn-info btn-xs"><i class="fa fa-bars"></i> '. trans('labels.actions.details') .'</a> &nbsp;';
            })
        ->editColumn('id', '{{$id}}')
        ->make(true);
    }
 
    public function list(Request $request) {
        $item = Municipio::from('Municipio as e')->join('DepDocId as na','e.DepDocId','=','na.id');
        $objeto = null;
        $objeto = $item->select('e.id', DB::raw('CONCAT(na."DepDocId", \' \', e."Municipio") as "Municipio"'))
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
            $item = Municipio::findOrFail($request->id);
            $item->depDocId->DepDocId;
            //$item = Municipio::where('id', $request->id)->with('depDocId')->first();

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

    public function store (MunicipioRequest $request) {
        if($request->id) {
            $item = Municipio::findOrFail($request->id);
            $msg = trans('messages.updated');
        } else {
            $item = new Municipio();
            $item->CreatorUserName = \Auth::user()->email;
            $item->CreatorFullUserName = \Auth::user()->Persona;
            $item->CreatorIP = $request->ip();
            $msg = trans('messages.added');
        }
        $item->Num = $request->Num;
        $item->DepDocId = $request->DepDocId;
        $item->Municipio = $request->Municipio;
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
        $item = Municipio::where('id', $request->id)->first();
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
    
    //********tablas dinamicas para la seleccion segun el valor*******//
    public function byProjet($id) {
       
        return Municipio::where('DepDocId', $id)->get();
    }
    //********tablas dinamicas para la seleccion segun el valor*******//
}
