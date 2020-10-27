@extends('layouts.app')
@section('content')
<div id="especialidad-app">
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">{{ trans('labels.modules.Especialidad') }}</h4>
            </div>
        </div>
        <div class="page-content-wrapper ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12"> 
                        <div class="card">
                            <div class="card-header ">
                                <h3 class="card-title text-dark m-0">Registros</h3>
                                <div class="btn-group float-right">
                                    <a href="#" @click.prevent="newEspecialidad" class="btn btn-success waves-effect waves-light m-l-10"><i class="fa fa-plus"></i> {{ trans('labels.actions.new')}}</a>
                                </div>
                            </div>
                            <div class="card-body ">
                                <table id="especialidad-table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- formulario de consulta-->
    <div class="modal fade" id="frm-especialidad" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>{{ trans('labels.modules.Especialidad') }}</strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="form-group">
                            <label for="NivelAcademico">Nivel Academico</label>
                            <select type="text" class="form-control" name="NivelAcademico" v-model="especialidad.NivelAcademico">
                                <option :value="na.id" v-for="na in nivelAcademicas">@{{ na.NivelAcademico }}</option>
                            </select>                            
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.NivelAcademico"><li class="parsley-required">@{{ errorBag.NivelAcademico }}</li></ul>
                        </div>
                        
                        <div class="form-group">
                            <label for="Especialidad">{{ trans('labels.modules.Especialidad') }}</label>
                            <input type="text" class="form-control" name="Especialidad" v-model="especialidad.Especialidad">
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Especialidad"><li class="parsley-required">@{{ errorBag.Especialidad }}</li></ul>
                        </div>
                        <div class="form-group">
                            <label for="Descripcion">Descripcion</label>
                            <input type="text" class="form-control" name="Descripcion" v-model="especialidad.Descripcion">
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Descripcion"><li class="parsley-required">@{{ errorBag.Descripcion }}</li></ul>
                        </div>
                        <div class="col-lg-3">
                            <label for="Verificado"> Activo</label>
                            <input type="checkbox" class="form-control checkox" name="Verificado" v-model="especialidad.Activo"></input>
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Activo"><li class="parsley-required">@{{ errorBag.Activo }}</li></ul>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" @click.prevent="saveEspecialidad()" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('labels.actions.save') }}</a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-window-close"></i> {{ trans('labels.actions.cancel')}} </button>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>

     <!-- vista de consulta-->
    <div class="modal fade" id="view-especialidad" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="custom-width-modalLabel">{{ trans('labels.modules.Especialidad') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <h4>NivelAcademico</h4>
                    <p class="text-muted">@{{ especialidad.NivelAcademico ?  especialidad.nivel_academico.NivelAcademico : '' }}</p>
                    <h4>{{ trans('labels.modules.Especialidad') }}</h4>
                    <p class="text-muted">@{{ especialidad.Especialidad }}</p>
                    <h4>Descripcion</h4>
                    <p class="text-muted">@{{ especialidad.Descripcion }}</p>
                    <h4>Activo</h4>
                    <p class="text-muted">@{{ especialidad.Activo ? 'SI' : 'NO' }}</p>
                </div>
                <div class="modal-footer">
                    <a href="#" @click.prevent="editEspecialidad" class="btn btn-warning"><i class="fa fa-edit"></i> {{ trans('labels.actions.edit') }}</a>
                    <a href="#" @click.prevent="deleteEspecialidad" class="btn btn-danger"><i class="fa fa-trash"></i> {{ trans('labels.actions.destroy') }}</a>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
</div> 
<script>
    //var auth = {!! Auth::user() !!};
    var urlIndexEspecialidad = '{!! route('Especialidad.index')!!}';
    var urlShowEspecialidad = '{!! route('Especialidad.show')!!}';
    var urlSaveEspecialidad= '{!! route('Especialidad.store')!!}';
    var urlDestroyEspecialidad = '{!! route('Especialidad.destroy')!!}';
    var urlListNivelAcademica = '{!! route('NivelAcademico.list')!!}';
</script>
{!! Html::script('/js/Especialidad/Especialidad.js') !!}
@endsection