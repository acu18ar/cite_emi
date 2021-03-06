<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use App\Http\Requests\NivelAcademicoRequest;
use App\Models\NivelAcademico;

class NivelAcademicoController extends Controller
{
    public function view() {
        return view('modules.NivelAcademico.view');
    }
    
    public function index() {
        $item = NivelAcademico::select('id',
                                'Num',
                                 'NivelAcademico',
                                  'Descripcion',
                                   'Activo')
                                   ->whereNull('deleted_at');
        
        if(\Auth::user()->Rol != 1) {
            $item = $item->where('id', \Auth::user()->NivelAcademico);
        }

        return Datatables::of($item)
            ->addColumn('action', function ($p) {
                return '<a href="#" @click.prevent="showNivelAcademico('. $p->id . ')" class="btn btn-info btn-xs"><i class="fa fa-bars"></i> '. trans('labels.actions.details') .'</a> &nbsp;';
            })
        ->editColumn('id', '{{$id}}')
        ->make(true);
    }

    public function list(Request $request) {
        $item = new NivelAcademico();
        $objeto = null;
        $objeto = $item->whereNull('deleted_at')->orderBy('Num', 'asc')->get();
        
        $data = array(
            'success' => true,
            'data' => $objeto,
            'msg' => trans('messages.listed')
        );

        return response()->json($data);
    }

    public function show(Request $request) {
        try {
            $item = NivelAcademico::findOrFail($request->id);
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

    public function store (NivelAcademicoRequest $request) {
        if($request->id) {
            $item = NivelAcademico::findOrFail($request->id);
            $msg = trans('messages.updated');
        } else {
            $item = new NivelAcademico();
            $item->CreatorUserName = \Auth::user()->email;
            $item->CreatorFullUserName = \Auth::user()->Persona;
            $item->CreatorIP = $request->ip();
            $msg = trans('messages.added');
        }

        $item->Num = $request->Num;
        $item->NivelAcademico = $request->NivelAcademico;
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
        $item = NivelAcademico::where('id', $request->id)->first();
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
