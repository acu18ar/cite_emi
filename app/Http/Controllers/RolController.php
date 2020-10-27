<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use App\Http\Requests\RolRequest;
use App\Models\Rol;

class RolController extends Controller
{
    public function view() {
        return view('modules.Rol.view');
    }
    
    public function index() {
        $rol = Rol::select('id', 'Num', 'Rol')->whereNull('deleted_at');
        
        if(\Auth::user()->Rol!=1) {
            $rol = $rol->where('Num','>', 1);
        }

        return Datatables::of($rol)
            ->addColumn('action', function ($p) {
                return '<a href="#" @click.prevent="showRol('. $p->id . ')" class="btn btn-info btn-xs"><i class="fa fa-bars"></i> '. trans('labels.actions.details') .'</a> &nbsp;';
            })
        ->editColumn('id', '{{$id}}')
        ->make(true);
    }

    public function list(Request $request) {
        $item = new Rol();
        $objeto = null;

        if(\Auth::user()->Rol != 1)
            $item = $item->where('id','>', 1);

        $objeto = $item->orderBy('Num', 'asc')->get();
        
        $data = array(
            'success' => true,
            'data' => $objeto,
            'msg' => trans('messages.listed')
        );

        return response()->json($data);
    }

    public function show(Request $request) {
        $item = Rol::findOrFail($request->id);
        $data = array(
            'success' => true,
            'data' => $item,
            'msg' => trans('messages.listed')
        );
        
        return response()->json($data);
    }

    public function store(RolRequest $request) {
        if($request->id) {
            $item = Rol::findOrFail($request->id);
            $msg = trans('messages.updated');
        } else {
            $item = new Rol();
            $item->CreatorUserName = \Auth::user()->email;
            $item->CreatorFullUserName = \Auth::user()->Persona;
            $item->CreatorIP = $request->ip();
            $msg = trans('messages.added');
        }
        
        $item->Num = $request->Num;
        $item->Rol = $request->Rol;        
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
        $item = Rol::where('id', $request->id)->first();
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
