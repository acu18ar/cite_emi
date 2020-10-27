<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use App\Http\Requests\PersonaRequest;
use App\Models\Persona;
use App\Models\PersonaEspecialidad;
use App\Models\PersonaEspecialidadRequisito;
use App\Models\PersonaEspecialidadMateria;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExports;
use App\Imports\UsersImport;


class PersonaController extends Controller
{
    public function view(){
        return view('modules.Persona.view');
    }

    public function index() {
        $item = Persona::from('Persona as p')
                            ->leftJoin('UnidadAcademica as ua', 'p.UnidadAcademica', '=', 'ua.id')
                            ->leftJoin('Especialidad as e', 'p.Especialidad', '=', 'e.id')
                            ->leftJoin('Rol as r', 'p.Rol', '=', 'r.id')
                            ->leftJoin('DepDocId as d', 'p.DepDocId', '=', 'd.id')
                            ->whereNull('p.deleted_at')
                            ->select('p.id', 
                            'ua.UnidadAcademica', 
                            'r.Rol', 
                            'p.Grado',
                            'p.ApellidoPaterno', 
                            'p.ApellidoMaterno', 
                            'p.Nombres', 
                            'p.Persona', 
                            'p.Cargo', 
                            'p.CI', 
                            'd.DepDocId', 
                            'e.Especialidad', 
                            'p.TipoPersona', 
                            'p.email', 
                            'p.Activo');        

        if(\Auth::user()->Rol == 2) //operador 
            $item->where('p.UnidadAcademica', \Auth::user()->UnidadAcademica);

        if(\Auth::user()->Rol == 3) //normal
            $item->where('p.id', \Auth::user()->id);

        return Datatables::of($item)
            ->addColumn('action', function ($p) {
                return '<a href="#" @click.prevent="showPersona(' . $p->id . ')" class="btn btn-info btn-xs"><i class="fa fa-bars"></i> ' . trans('labels.actions.details') . '</a> &nbsp;';
            })
            ->editColumn('id', '{{$id}}')
            ->make(true);
    }

    public function list(Request $request) {
        $item = new Persona();
        $objeto = null;

        $objeto = $item->orderBy('id', 'asc')->get();

        $data = array(
            'success' => true,
            'data' => $objeto,
            'msg' => trans('messages.listed')
        );

        return response()->json($data);
    }

    public function show(Request $request) {
        $item = Persona::where('id', $request->id)->with('unidadAcademica', 'rol', 'especialidad', 'depDocId')->first();
        $data = array(
            'success' => true,
            'data' => $item,
            'msg' => trans('messages.listed')
        );

        return response()->json($data);
    }

    public function store(PersonaRequest $request) {
       
        if ($request->id) {
            $item = Persona::findOrFail($request->id);
            $msg = trans('messages.updated');
        } else {
            $item = new Persona();
            $item->CreatorIP = $request->ip();
            $item->CreatorUserName = \Auth::user()->email;
            $item->CreatorFullUserName = \Auth::user()->Usuario;
            $msg = trans('messages.added');
        }

        $item->Grado = $request->Grado;
        $item->Nombres = strtoupper($request->Nombres);
        $item->ApellidoPaterno = strtoupper($request->ApellidoPaterno);
        $item->ApellidoMaterno = strtoupper($request->ApellidoMaterno);
        $item->Persona = strtoupper($request->Nombres)." ".strtoupper($request->ApellidoPaterno)." ".strtoupper($request->ApellidoMaterno);
        $item->Cargo = $request->Cargo;
        $item->Foto = $request->Foto;
        $item->FirmaDigitalizada = $request->FirmaDigitalizada;
        $item->CI = $request->CI;
        $item->DepDocId = $request->DepDocId;
        $item->UnidadAcademica = $request->UnidadAcademica;
        $item->HUnidadAcademica = $request->HUnidadAcademica;
        $item->Especialidad = $request->Especialidad;
        $item->HEspecialidad = $request->HEspecialidad;
        $item->TipoPersona = $request->TipoPersona;
        $item->Rol = $request->Rol;
        
        $item->email = $request->email;
        $item->Activo = $request->Activo ? true : false;
        
        if ($request->password) {
            $item->password = bcrypt($request->password);
        } 
        
        $item->UpdaterIP = $request->ip();
        $item->UpdaterUserName = \Auth::user()->email;
        $item->UpdaterFullUserName = \Auth::user()->Usuario;
        $item->save();

        $result = array(
            'success' => true,
            'data' => $item,
            'msg' => $msg
        );
        return response()->json($result);
    }

    public function destroy(Request $request) {
        $persona = Persona::findOrFail($request->id);
        $persona->deleted_at = Carbon::now();
        $persona->DeleterUserName = Auth::user()->Persona;
        $persona->DeleterFullUserName = Auth::user()->Persona;
        $persona->DeleterIP =  $request->ip();
        $persona->email = $persona->email.'#'.str_random(4);
        $persona->save();
        $msg = trans('messages.deleted');
        $result = array(
            'success' => true,
            'data' => null,
            'msg' => $msg
        );
        return response()->json($result);        
    }

    public function select2(Request $request) {
        $term = trim($request->q);
        
        if (empty($term)) {
            return \Response::json([]);
        }
        
        $items = Persona::where('Persona','ilike','%' . $term . '%')
                            ->limit(50);

        /*if(\Auth::user()->Rol != 1)
            $items = $items->where('UnidadAcademica', \Auth::user()->UnidadAcademica);*/
        
        $items = $items->get();

        $formatted_items = [];

        foreach ($items as $item) {
            $formatted_items[] = ['id' => $item->id, 'text' => $item->Persona];
        }
        return \Response::json($formatted_items);
    }

    public function changePassword(Request $request) {
        $rules = array(
            'new' => 'required|required_with:confirm|same:confirm',
        );
        $this->validate($request, $rules);

        $persona = Persona::find($request->Persona);
        $persona->password = bcrypt($request->confirm);
        $persona->UpdaterIP = $request->ip();
        $persona->UpdaterUserName = \Auth::user()->email;
        $persona->UpdaterFullUserName = \Auth::user()->Usuario;
        $persona->save();

        $data = array(
            'success' => true,
            'data' => null,
            'msg' => 'Contraseña actualizada correctamente'
        );
        
        return response()->json($data);
    } 

    public function profile (){
        return view('modules.Persona.profile');
    }

    public function exportExcel(){
      //$users = Persona::get();
        return Excel::download(new UsersExports, 'Prueba.xlsx');
        //return view('modules.Persona.profile');
    }
     public function importExcel (Request $request){
        $users = Persona::get();
        $file = $request->file('file');
        Excel::import(new UsersImport, $file);

        return back()->with('message', 'Importacion completada');
        //return view('modules.Persona.profile');
    } 
}
