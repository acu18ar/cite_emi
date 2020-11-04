@extends('layouts.app')
@section('content') 
<div id="persona-app">
    <loading v-if="isLoading"></loading>
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">{{ trans('labels.modules.Persona') }}</h4>
            </div>
        </div>
        <div class="page-content-wrapper ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-dark m-0">Detalle de Registros</h3>
                                <div align="right">
                                    <a href="#" @click.prevent="newPersona" class="btn btn-success waves-effect waves-light m-l-10"><i class="fa fa-plus"></i> {{ trans('labels.actions.new')}}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="persona-table" class="table table-striped table-bordered dt-responsive no-wrap" cellspacing="0" width="100%"></table>
                            </div>
                            <div class="card-body">
                            <div class="col-md-4">
                             <form action="{{ route('Persona.import.excel')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                @if(Session::has('message'))
                            <p> {{ Session::get ('message')}}</p>
                                @endif
                                <input type="file" name="file" required class="filestyle" data-buttonname="btn-primary" data-buttontext="Seleccionar...">
                                <button class="btn btn-info waves-effect waves-light m-l-10" >Importar datos</button>

                            </form> 
                            </div>
                        </div>
                            <div class="card-body">
                                        
                                    Clic <a href="{{ route('Persona.excel')}}" >aqui</a>
    
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- formulario de persona-->
    <div class="modal fade animated zoomIn" id="frm-persona" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>{{ trans('labels.modules.Persona') }}</strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label for="Nombre">Nombre(s)</label>
                                    <input type="text" class="form-control" name="Nombre" v-model="persona.Nombres">                                                   
                                    <ul class="parsley-errors-list filled"  id="parsley-id-19" v-if="errorBag.Nombres"><li class="parsley-required">@{{ errorBag.Nombres }}</li></ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label for="ApellidoPaterno">Apellido Paterno</label>
                                    <input type="text" class="form-control" name="ApellidoPaterno" v-model="persona.ApellidoPaterno">                                                   
                                    <ul class="parsley-errors-list filled"  id="parsley-id-19" v-if="errorBag.ApellidoPaterno"><li class="parsley-required">@{{ errorBag.ApellidoPaterno }}</li></ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-12">
                            <div class="form-group">
                                    <label for="ApellidoMaterno">Apellido Materno</label>
                                    <input type="text" class="form-control" name="ApellidoMaterno" v-model="persona.ApellidoMaterno">                                                   
                                    <ul class="parsley-errors-list filled"  id="parsley-id-19" v-if="errorBag.ApellidoMaterno"><li class="parsley-required">@{{ errorBag.ApellidoMaterno }}</li></ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label for="Grado">Grado y Especialidad</label>
                                    <input type="text" class="form-control" name="Grado" v-model="persona.Grado" placeholder="CNL. DAEN.">
                                    <ul class="parsley-errors-list filled"  id="parsley-id-19" v-if="errorBag.Grado"><li class="parsley-required">@{{ errorBag.Grado }}</li></ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label for="Cargo">Cargo</label>
                                    <input type="text" class="form-control" name="Cargo" v-model="persona.Cargo" placeholder="Ej. Docente de...">                                                   
                                    <ul class="parsley-errors-list filled"  id="parsley-id-19" v-if="errorBag.Cargo"><li class="parsley-required">@{{ errorBag.Cargo }}</li></ul>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="Especialidad">Carrera</label>
                                    <select type="text" class="form-control" name="Especialidad" v-model="persona.Especialidad">
                                        <option :value="es.id" v-for="es in especialidades">@{{ es.Especialidad }}</option>
                                    </select>
                                    <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Especialidad"><li class="parsley-required">@{{ errorBag.Especialidad }}</li></ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label for="UnidadAcademica">Curso</label>
                                    <select type="text" class="form-control" name="UnidadAcademica" v-model="persona.UnidadAcademica">
                                        <option :value="ua.id" v-for="ua in unidadAcademicas">@{{ ua.UnidadAcademica }}</option>
                                    </select>
                                    <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.UnidadAcademica"><li class="parsley-required">@{{ errorBag.UnidadAcademica }}</li></ul>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                <label for="TipoPersona">Procedencia de Registro</label>    
                                    <select type="text" class="form-control" name="TipoPersona" v-model="persona.TipoPersona">
                                        <option value="I">INTERNO</option>
                                        <option value="E">EXTERNO</option>
                                        <option value="O">OTRO</option>
                                    </select>                                               
                                    <ul class="parsley-errors-list filled"  id="parsley-id-19" v-if="errorBag.TipoPersona"><li class="parsley-required">@{{ errorBag.TipoPersona }}</li></ul>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="Rol"> Rol</label>
                                    <select type="text" class="form-control" name="Rol" v-model="persona.Rol">
                                        <option :value="r.id" v-for="r in roles">@{{ r.Rol }}</option>
                                    </select>
                                    <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Rol"><li class="parsley-required">@{{ errorBag.Rol }}</li></ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="CI"> Carnet de Identidad</label>
                                    <input type="text" class="form-control" name="CI" v-model="persona.CI">
                                    <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.CI"><li class="parsley-required">@{{ errorBag.CI }}</li></ul>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label for="Extension"> Extension</label>
                                    <select type="text" class="form-control" name="Extension" v-model="persona.DepDocId">
                                        <option :value="ex.id" v-for="ex in depDocIds">@{{ ex.DepDocId }}</option>
                                    </select>
                                    <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Rol"><li class="parsley-required">@{{ errorBag.Rol }}</li></ul>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4 col-lg-4">
                                <label for="Verificado"> Activo</label>
                                <input type="checkbox" class="form-control checkox" name="Verificado" v-model="persona.Activo"></input>
                                <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Activo"><li class="parsley-required">@{{ errorBag.Activo }}</li></ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="email"> Email</label>
                                    <input type="text" class="form-control" name="email" v-model="persona.email">
                                    <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.email"><li class="parsley-required">@{{ errorBag.email }}</li></ul>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input type="password" class="form-control" name="password" v-model="persona.password">
                                    <ul class="parsley-errors-list filled" id="parsley-|id-19" v-if="errorBag.password"><li class="parsley-required">@{{ errorBag.password }}</li></ul> 
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-md-6 col-lg-6">
                                    <p>Foto:</p>
                                    <input type="file" class="filestyle" id="Foto" name="Fotografia" data-buttonname="btn-primary" data-buttontext="Seleccionar..." @change="loadFile('Foto', 'perfil')">
                                    <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Fotografia"><li class="parsley-required">@{{ errorBag.Fotografia }}</li></ul>
                                </div>
                                <div class="col-xs-12 col-md-6 col-lg-6">
                                    <p>Firma Digitalizada:</p>
                                    <input type="file" class="filestyle" id="Firma" name="FirmaDigitalizada" data-buttonname="btn-primary" data-buttontext="Seleccionar..." @change="loadFile('Firma', 'firma')">
                                    <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.FirmaDigitalizada"><li class="parsley-required">@{{ errorBag.FirmaDigitalizada }}</li></ul>
                                </div>
                                <span v-show="isLoadingFile" class="text-success"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Cargando Archivo<span class="sr-only">Cargando...</span></span>
                                <span v-show="!isLoadingFile && persona.Fotografia" class="text-info"><i class="fa fa-thumbs-o-up"></i> Archivo Cargado!</span>                        
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" @click.prevent="savePersona()" class="btn btn-success">{{ trans('labels.actions.save') }}</a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-window-close"></i> {{ trans('labels.actions.cancel')}} </button>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- formulario de vista persona-->
    <div class="modal fade" id="view-persona" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="custom-width-modalLabel">{{ trans('labels.modules.Persona') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <h4>@{{ persona.Persona }} </h4>
                    </div>
                    <div class="row">
                        <div class="row col-md-6">
                            <div class="col-md-12">
                                <div><img :src="persona.URLFoto" style="width:150px;"></div>
                            </div>
                            <div class="col-md-12">
                                <div><label><b>Firma Digitalizada: </b></label></div>
                                <div><img :src="persona.URLFirma" style="width:150px;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div><label><b>Cargo: </b><br>@{{ persona.Cargo }}</label></div>
                            <div><label><b>Carnet de Identidad: </b><br>@{{ persona.CI ? persona.CI+' ' : '' }}@{{ persona.dep_doc_id ? persona.dep_doc_id.DepDocId : '' }}</label></div>
                            <div><label><b>E-mail: </b><br>@{{ persona.email }}</label></div>
                            <div><label><b>Unidad Académica: </b><br>@{{ persona.unidad_academica ? persona.unidad_academica.UnidadAcademica : '' }}</label></div>
                            <div><label><b>Especialidad: </b><br>@{{ persona.especialidad ? persona.especialidad.Especialidad : '' }}</label></div>
                            <div v-if="persona.TipoPersona === 'I'"><label><b>Procedencia: <br></b>INTERNO</label></div>
                            <div v-if="persona.TipoPersona === 'E'"><label><b>Procedencia: <br></b>EXTERNO</label></div>
                            <div v-if="persona.TipoPersona === 'O'"><label><b>Procedencia: <br></b>OTRO</label></div>
                        </div>                 
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" @click.prevent="cambiopassword" class="btn btn-success waves-effect waves-light"><i class="fab fa-expeditedssl"></i> {{ trans('labels.actions.cambiopassword') }}</a>
                    <a href="#" @click.prevent="editPersona" class="btn btn-warning"><i class="fa fa-edit"></i> {{ trans('labels.actions.edit') }}</a>
                    <a href="#" @click.prevent="deletePersona" class="btn btn-danger"><i class="fa fa-trash"></i> {{ trans('labels.actions.destroy') }}</a>
                </div>
            </div>
        </div>
    </div>
    <!-- formulario de vista cambiar password persona-->
    <div class="modal fade" id="view-password" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="custom-width-modalLabel">Cambio de Contraseña</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                {{-- <div class="col-lg-8">
                                    <label for="old">Contraseña Anterior:</label>
                                    <input type="password" class="form-control" name="old" v-model="password.old">
                                    <ul class="parsley-errors-list filled" id="parsley-|id-19" v-if="errorBag.old"><li class="parsley-required">@{{ errorBag.old }}</li></ul> 
                                </div> --}}
                                <div class="col-lg-8">
                                    <label for="new">Nueva Contraseña:</label>
                                    <input type="password" class="form-control" name="new" v-model="password.new">
                                    <ul class="parsley-errors-list filled" id="parsley-|id-19" v-if="errorBag.new"><li class="parsley-required">@{{ errorBag.new }}</li></ul> 
                                </div>
                                <div class="col-lg-8">
                                    <label for="confirm">Confirmar Contraseña:</label>
                                    <input type="password" class="form-control" name="confirm" v-model="password.confirm">
                                    <ul class="parsley-errors-list filled" id="parsley-|id-19" v-if="errorBag.confirm"><li class="parsley-required">@{{ errorBag.confirm }}</li></ul> 
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <a href="#" @click.prevent="changePassword" class="btn btn-success waves-effect waves-light">{{ trans('labels.actions.save') }}</a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-window-close"></i> {{ trans('labels.actions.cancel')}} </button>
                </div>
            </div>
        </div>
    </div>                   
</div>

<script>
    var auth = {!! Auth::user() !!};
    var urlIndexPersona     = '{!! route('Persona.index') !!}';
    var urlListPersona     = '{!! route('Persona.list') !!}';
    var urlShowPersona      = '{!! route('Persona.show') !!}';
    var urlSavePersona      = '{!! route('Persona.store') !!}';
    var urlDestroyPersona   = '{!! route('Persona.destroy') !!}';
    var urlChangePasswordPersona   = '{!! route('Persona.changePassword') !!}';
    var urlUploadFile           = '{!! route('utils.uploadFile') !!}';  
    var urlListUnidadAcademica = '{!! route('UnidadAcademica.list')!!}';
    var urlListEspecialidad = '{!! route('Especialidad.list')!!}';
    var urlListDepDocId = '{!! route('DepDocId.list')!!}';
    var urlListRol = '{!! route('Rol.list')!!}';
</script>
{!! Html::script('/js/Persona/Persona.js') !!}
@endsection
