<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use App\Http\Requests\DepDocIdRequest;
use App\Models\DepDocId;

class DepDocIdController extends Controller
{
    public function view() {
        return view('modules.DepDocId.view');
    }
    
    public function index() {
        $item = DepDocId::select('id', 'Num', 'DepDocId', 'DepDocIdDescripcion')->whereNull('deleted_at');
        
        if(\Auth::user()->Rol != 1) {
            $item = $item->where('id', \Auth::user()->DepDocId);
        }

        return Datatables::of($item)
            ->addColumn('action', function ($p) {
                return '<a href="#" @click.prevent="showDepDocId('. $p->id . ')" class="btn btn-info btn-xs"><i class="fa fa-bars"></i> '. trans('labels.actions.details') .'</a> &nbsp;';
            })
        ->editColumn('id', '{{$id}}')
        ->make(true);
    }

    public function list(Request $request) {
        $item = new DepDocId();
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
            $item = DepDocId::findOrFail($request->id);
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

    public function store (DepDocIdRequest $request) {
        if($request->id) {
            $item = DepDocId::findOrFail($request->id);
            $msg = trans('messages.updated');
        } else {
            $item = new DepDocId();
            $item->CreatorUserName = \Auth::user()->email;
            $item->CreatorFullUserName = \Auth::user()->Persona;
            $item->CreatorIP = $request->ip();
            $msg = trans('messages.added');
        }
        
        $item->Num = $request->Num;
        $item->DepDocId = $request->DepDocId;
        $item->DepDocIdDescripcion = $request->DepDocIdDescripcion;
        
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
        $item = DepDocId::where('id', $request->id)->first();
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
