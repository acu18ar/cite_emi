<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use App\Http\Requests\TipoMiembroRequest;
use App\Models\TipoMiembro;

class TipoMiembroController extends Controller
{
    public function view() {
        return view('modules.TipoMiembro.view');
    }
    
    public function index() {
        $item = TipoMiembro::select('id', 'Num', 'TipoMiembro', 'Descripcion', 'Abreviacion', 'Requerido', 'Activo')->whereNull('deleted_at');
        
        if(\Auth::user()->Rol != 1) {
            $item = $item->where('id', \Auth::user()->TipoMiembro);
        }

        return Datatables::of($item)
            ->addColumn('action', function ($p) {
                return '<a href="#" @click.prevent="showConsulta('. $p->id . ')" class="btn btn-info btn-xs"><i class="fa fa-bars"></i> '. trans('labels.actions.details') .'</a> &nbsp;';
            })
        ->editColumn('id', '{{$id}}')
        ->make(true);
    }

    public function list(Request $request) {
        $item = new TipoMiembro();
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
            $item = TipoMiembro::findOrFail($request->id);
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

    public function store (TipoMiembroRequest $request) {
        if($request->id) {
            $item = TipoMiembro::findOrFail($request->id);
            $msg = trans('messages.updated');
        } else {
            $item = new TipoMiembro();
            $item->CreatorUserName = \Auth::user()->email;
            $item->CreatorFullUserName = \Auth::user()->Persona;
            $item->CreatorIP = $request->ip();
            $msg = trans('messages.added');
        }

        $item->Num = $request->Num;
        $item->TipoMiembro = $request->TipoMiembro;
        $item->Descripcion = $request->Descripcion;
        $item->Abreviacion = $request->Abreviacion;
        $item->Requerido = $request->Requerido;
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
        $item = TipoMiembro::where('id', $request->id)->first();
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
