<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Auth::routes();
Route::post('login/tokenLoginVerify', ['uses' => 'Auth\LoginController@tokenLoginVerify', 'as' => 'login.tokenLoginVerify'])->middleware('guest');
Route::get('login/microsoft', 'Auth\SocialLoginController@redirectToMicrosoft')->name('login.microsoft')->middleware('guest');
Route::get('login/microsoft/callback', 'Auth\SocialLoginController@handleMicrosoftCallback')->middleware('guest');
Route::get('autologin/{email}/{token}','Auth\LoginController@autologin')->name('autologin');
Route::get('login2','Auth\LoginController@showLoginForm2')->name('login2');



Route::get('/', function () {
    if(Auth::check())
        return view('modules.Inicio.view');

    else 
    return view('modules.pagina_inicio.view2'); 
})->name('home');

Route::get('test', function(){
    // dd(app()->getLocale());
    $item = new \App\Models\Persona();
    dd($item->syncSagaAlumnos());
});

Route::post('uploadFile', function (Request $request) {
    try {
        if ($request->hasFile('File')) {
            $fileName = md5(uniqid() . \Carbon\Carbon::now()) . '.' . strtolower($request->file('File')->getClientOriginalExtension());
            //dd($request->op);
            if ($request->op == 'perfil') {
                $path = $request->file('File')->storeAs('imagenes/', $fileName, 'public');
               //$path = $request->file('File')->storeAs('imagenes/', $fileName, 's3');
               //$path = $request->file('avatar')->storeAs('avatars',$request->user()->id,'s3');
            } else {
                $path = $request->file('File')->storeAs('imagenes/', $fileName, 'public');
            }
            
            $data = array(
                'success' => true,
                'data' => $fileName,
                'msg' => trans('messages.file_uplodaded')
            );
        } else {
            $data = array(
                'success' => false,
                'data' => null,
                'msg' => 'Error al guardar archivo.'
            );
        }
    } catch (\Exception $e) {
        $data = array(
            'success' => false,
            'data' => null,
            'msg' => $e->getMessage()
        );
    }
    return response()->json($data);
})->name('utils.uploadFile');

/****************************************** ROL *********************************/
Route::group(['prefix' => 'Rol', 'middleware' => 'auth'], function () {
    Route::get('/view', ['uses' => 'RolController@view', 'as' => 'Rol.view']);
    Route::get('/list', ['uses' => 'RolController@list', 'as' => 'Rol.list']);
    Route::get('/index', ['uses' => 'RolController@index', 'as' => 'Rol.index']);
    Route::post('/destroy', ['uses' => 'RolController@destroy', 'as' => 'Rol.destroy']);
    Route::post('/store', ['uses' => 'RolController@store', 'as' => 'Rol.store']);
    Route::post('/show', ['uses' => 'RolController@show', 'as' => 'Rol.show']);
}); 

/****************************************** DEPDOCID *********************************/
Route::group(['prefix' => 'DepDocId', 'middleware' => 'auth'], function () {
    Route::get('/view', ['uses' => 'DepDocIdController@view', 'as' => 'DepDocId.view']);
    Route::get('/list', ['uses' => 'DepDocIdController@list', 'as' => 'DepDocId.list']);
    Route::get('/index', ['uses' => 'DepDocIdController@index', 'as' => 'DepDocId.index']);
    Route::post('/destroy', ['uses' => 'DepDocIdController@destroy', 'as' => 'DepDocId.destroy']);
    Route::post('/store', ['uses' => 'DepDocIdController@store', 'as' => 'DepDocId.store']);
    Route::get('/show', ['uses' => 'DepDocIdController@show', 'as' => 'DepDocId.show']);
}); 

/************************************ UNIDAD ACADEMICA *****************/
Route::group(['prefix' => 'UnidadAcademica', 'middleware' => 'auth'], function () {
    Route::get('/view', ['uses' => 'UnidadAcademicaController@view', 'as' => 'UnidadAcademica.view']);
    Route::get('/list', ['uses' => 'UnidadAcademicaController@list', 'as' => 'UnidadAcademica.list']);
    Route::get('/index', ['uses' => 'UnidadAcademicaController@index', 'as' => 'UnidadAcademica.index']);
    Route::post('/destroy', ['uses' => 'UnidadAcademicaController@destroy', 'as' => 'UnidadAcademica.destroy']);
    Route::post('/store', ['uses' => 'UnidadAcademicaController@store', 'as' => 'UnidadAcademica.store']);
    Route::post('/show', ['uses' => 'UnidadAcademicaController@show', 'as' => 'UnidadAcademica.show']);
});

/************************************ PERSONA *****************/
Route::group(['prefix' => 'Persona', 'middleware' => 'auth'], function () {
    Route::get('/view', ['uses' => 'PersonaController@view', 'as' => 'Persona.view']);
    Route::get('/list', ['uses' => 'PersonaController@list', 'as' => 'Persona.list']);
    Route::get('/index', ['uses' => 'PersonaController@index', 'as' => 'Persona.index']);
    Route::post('/destroy', ['uses' => 'PersonaController@destroy', 'as' => 'Persona.destroy']);
    Route::post('/store', ['uses' => 'PersonaController@store', 'as' => 'Persona.store']);
    Route::get('/show', ['uses' => 'PersonaController@show', 'as' => 'Persona.show']);
    Route::get('/select2', ['uses' => 'PersonaController@select2', 'as' => 'Persona.select2']);
    Route::post('/changePassword', ['uses' => 'PersonaController@changePassword', 'as' => 'Persona.changePassword']);
    Route::get('/profile', ['uses' => 'PersonaController@profile', 'as' => 'Persona.profile']);
    Route::get('/excelMiembro', ['uses' => 'PersonaController@excelMiembro', 'as' => 'Persona.excelMiembro']);

    
    Route::get('user-list-excel',  'PersonaController@exportExcel')->name('Persona.excel');
    Route::post('import-list-excel',  'PersonaController@importExcel')->name('Persona.import.excel');
   // Route::post('/view',  'PersonaController@importExcel')->name('Persona.import.excel');
    
});


/************************************ NIVEL ACADEMICO *****************/
Route::group(['prefix' => 'NivelAcademico', 'middleware' => 'auth'], function () {
    Route::get('/view', ['uses' => 'NivelAcademicoController@view', 'as' => 'NivelAcademico.view']);
    Route::get('/list', ['uses' => 'NivelAcademicoController@list', 'as' => 'NivelAcademico.list']);
    Route::get('/index', ['uses' => 'NivelAcademicoController@index', 'as' => 'NivelAcademico.index']);
    Route::post('/destroy', ['uses' => 'NivelAcademicoController@destroy', 'as' => 'NivelAcademico.destroy']);
    Route::post('/store', ['uses' => 'NivelAcademicoController@store', 'as' => 'NivelAcademico.store']);
    Route::post('/show', ['uses' => 'NivelAcademicoController@show', 'as' => 'NivelAcademico.show']);
});

/************************************ UNIDAD ACADEMICA *****************/
Route::group(['prefix' => 'TipoMiembro', 'middleware' => 'auth'], function () {
    Route::get('/view', ['uses' => 'TipoMiembroController@view', 'as' => 'TipoMiembro.view']);
    Route::get('/list', ['uses' => 'TipoMiembroController@list', 'as' => 'TipoMiembro.list']);
    Route::get('/index', ['uses' => 'TipoMiembroController@index', 'as' => 'TipoMiembro.index']);
    Route::post('/destroy', ['uses' => 'TipoMiembroController@destroy', 'as' => 'TipoMiembro.destroy']);
    Route::post('/store', ['uses' => 'TipoMiembroController@store', 'as' => 'TipoMiembro.store']);
    Route::post('/show', ['uses' => 'TipoMiembroController@show', 'as' => 'TipoMiembro.show']);
});

/************************************ ESPECIALIDAD *****************/
Route::group(['prefix' => 'Especialidad', 'middleware' => 'auth'], function () {
    Route::get('/view', ['uses' => 'EspecialidadController@view', 'as' => 'Especialidad.view']);
    Route::get('/list', ['uses' => 'EspecialidadController@list', 'as' => 'Especialidad.list']);
    Route::get('/index', ['uses' => 'EspecialidadController@index', 'as' => 'Especialidad.index']);
    Route::post('/destroy', ['uses' => 'EspecialidadController@destroy', 'as' => 'Especialidad.destroy']);
    Route::post('/store', ['uses' => 'EspecialidadController@store', 'as' => 'Especialidad.store']);
    Route::post('/show', ['uses' => 'EspecialidadController@show', 'as' => 'Especialidad.show']);
});

/************************************ DEPARTAMENTO DOCUMENTO ID *****************/
Route::group(['prefix' => 'DepDocId', 'middleware' => 'auth'], function () {
    Route::get('/view', ['uses' => 'DepDocIdController@view', 'as' => 'DepDocId.view']);
    Route::get('/list', ['uses' => 'DepDocIdController@list', 'as' => 'DepDocId.list']);
    Route::get('/index', ['uses' => 'DepDocIdController@index', 'as' => 'DepDocId.index']);
    Route::post('/destroy', ['uses' => 'DepDocIdController@destroy', 'as' => 'DepDocId.destroy']);
    Route::post('/store', ['uses' => 'DepDocIdController@store', 'as' => 'DepDocId.store']);
    Route::post('/show', ['uses' => 'DepDocIdController@show', 'as' => 'DepDocId.show']);
});
 /************************************ TIPO MIEMBRO *****************/
 Route::group(['prefix' => 'TipoMiembro', 'middleware' => 'auth'], function () {
    Route::get('/view', ['uses' => 'TipoMiembroController@view', 'as' => 'TipoMiembro.view']);
    Route::get('/list', ['uses' => 'TipoMiembroController@list', 'as' => 'TipoMiembro.list']);
    Route::get('/index', ['uses' => 'TipoMiembroController@index', 'as' => 'TipoMiembro.index']);
    Route::post('/destroy', ['uses' => 'TipoMiembroController@destroy', 'as' => 'TipoMiembro.destroy']);
    Route::post('/store', ['uses' => 'TipoMiembroController@store', 'as' => 'TipoMiembro.store']);
    Route::post('/show', ['uses' => 'TipoMiembroController@show', 'as' => 'TipoMiembro.show']);
}); 


/************************************ MANUAL *****************/
Route::group(['prefix' => 'Manual', 'middleware' => 'auth'], function () {
   Route::get('/view', ['uses' => 'ManualController@view', 'as' => 'Manual.view']);
}); 

/************************************ REPORTE *****************/
Route::group(['prefix' => 'Reporte', 'middleware' => 'auth'], function () {
    Route::get('/view', ['uses' => 'ReporteController@view', 'as' => 'Reporte.view']);
    Route::post('/excelMiembro', ['uses' => 'ReporteController@excelMiembro', 'as' => 'Reporte.excelMiembro']);
    Route::post('/excelMiembroGlobal', ['uses' => 'ReporteController@excelMiembroGlobal', 'as' => 'Reporte.excelMiembroGlobal']);
    
}); 



/************************************ ESTADO CIVIL *****************/
Route::group(['prefix' => 'EstadoCivil', 'middleware' => 'auth'], function () {
    Route::get('/view', ['uses' => 'EstadoCivilController@view', 'as' => 'EstadoCivil.view']);
    Route::get('/list', ['uses' => 'EstadoCivilController@list', 'as' => 'EstadoCivil.list']);
    Route::get('/index', ['uses' => 'EstadoCivilController@index', 'as' => 'EstadoCivil.index']);
    Route::post('/destroy', ['uses' => 'EstadoCivilController@destroy', 'as' => 'EstadoCivil.destroy']);
    Route::post('/store', ['uses' => 'EstadoCivilController@store', 'as' => 'EstadoCivil.store']);
    Route::post('/show', ['uses' => 'EstadoCivilController@show', 'as' => 'EstadoCivil.show']);
}); 


/************************************ MUNICIPIO *****************/
Route::group(['prefix' => 'Municipio', 'middleware' => 'auth'], function () {
    Route::get('/view', ['uses' => 'MunicipioController@view', 'as' => 'Municipio.view']);
    Route::get('/list', ['uses' => 'MunicipioController@list', 'as' => 'Municipio.list']);
    Route::get('/index', ['uses' => 'MunicipioController@index', 'as' => 'Municipio.index']);
    Route::post('/destroy', ['uses' => 'MunicipioController@destroy', 'as' => 'Municipio.destroy']);
    Route::post('/store', ['uses' => 'MunicipioController@store', 'as' => 'Municipio.store']);
    Route::post('/show', ['uses' => 'MunicipioController@show', 'as' => 'Municipio.show']);
});



/************************************ VISTA EMPLEOS PERSONA *****************/
Route::group(['prefix' => 'VistaEmpleos', 'middleware' => 'auth'], function () {
    Route::get('/view', ['uses' => 'VistaEmpleosController@view', 'as' => 'VistaEmpleos.view']);
    Route::get('/list', ['uses' => 'VistaEmpleosController@list', 'as' => 'VistaEmpleos.list']);
    Route::get('/index', ['uses' => 'VistaEmpleosController@index', 'as' => 'VistaEmpleos.index']);
    Route::post('/destroy', ['uses' => 'VistaEmpleosController@destroy', 'as' => 'VistaEmpleos.destroy']);
    Route::post('/store', ['uses' => 'VistaEmpleosController@store', 'as' => 'VistaEmpleos.store']);
    Route::get('/show', ['uses' => 'VistaEmpleosController@show', 'as' => 'VistaEmpleos.show']);
});


