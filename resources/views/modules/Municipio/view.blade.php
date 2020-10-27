@extends('layouts.app')
@section('content')
<div id="municipio-app"> 
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">{{ trans_choice('labels.modules.Municipio', 2) }}</h4>
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
                                    <a href="#" @click.prevent="newMunicipio" class="btn btn-success waves-effect waves-light m-l-10"><i class="fa fa-plus"></i> {{ trans('labels.actions.new')}}</a>
                                </div>
                            </div>
                            <div class="card-body ">
                                <table id="municipio-table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%"></table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- formulario de consulta-->
    <div class="modal fade" id="frm-municipio" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>{{ trans('labels.modules.Municipio') }}</strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body"> 
                    <form role="form">
                        <div class="form-group">
                            <label for="Num">No.</label>
                            <input type="number" class="form-control" name="Num" v-model="municipio.Num">
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Num"><li class="parsley-required">@{{ errorBag.Num }}</li></ul>
                        </div>
                        <div class="form-group">
                            <label for="DepDocId">Departamento</label>
                            <select type="text" class="form-control" name="DepDocId" v-model="municipio.DepDocId">
                                <option :value="na.id" v-for="na in depDocId">@{{ na.DepDocIdDescripcion }}</option>
                            </select>                            
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.DepDocId"><li class="parsley-required">@{{ errorBag.DepDocId }}</li></ul>
                        </div>
                        
                        <div class="form-group">
                            <label for="Municipio">{{ trans_choice('labels.modules.Municipio', 1 ) }}</label>
                            <input type="text" class="form-control" name="Municipio" v-model="municipio.Municipio">
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Municipio"><li class="parsley-required">@{{ errorBag.Municipio }}</li></ul>
                        </div>
                        <div class="form-group">
                            <label for="Descripcion">Descripción</label>
                            <input type="text" class="form-control" name="Descripcion" v-model="municipio.Descripcion">
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Descripcion"><li class="parsley-required">@{{ errorBag.Descripcion }}</li></ul>
                        </div>
                        <div class="col-lg-3">
                            <label for="Verificado"> Activo</label>
                            <input type="checkbox" class="form-control checkox" name="Verificado" v-model="municipio.Activo"></input>
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Activo"><li class="parsley-required">@{{ errorBag.Activo }}</li></ul>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" @click.prevent="saveMunicipio()" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('labels.actions.save') }}</a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-window-close"></i> {{ trans('labels.actions.cancel')}} </button>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>

     <!-- vista de consulta-->
    <div class="modal fade" id="view-municipio" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="custom-width-modalLabel">{{ trans('labels.modules.Municipio') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                     <h4>Número</h4>
                    <p class="text-muted">@{{ municipio.Num }}</p> 
                    <h4>Departamento</h4>
                  {{--   <p class="text-muted">@{{ municipio.DepDocId ?  municipio.dep_DocId.DepDocId : '' }}</p>  --}}
                                       
                   <p class="text-muted"> @{{ municipio.dep_doc_id ? municipio.dep_doc_id.DepDocIdDescripcion : '' }}</p>
                    <h4>{{ trans_choice('labels.modules.Municipio', 1 ) }}</h4>
                    <p class="text-muted">@{{ municipio.Municipio }}</p>
                    <h4>Descripción</h4>
                    <p class="text-muted">@{{ municipio.Descripcion }}</p>
                    <h4>Activo</h4>
                    <p class="text-muted">@{{ municipio.Activo ? 'SI' : 'NO' }}</p>
                </div>
                <div class="modal-footer"> 
                    <a href="#" @click.prevent="editMunicipio" class="btn btn-warning"><i class="fa fa-edit"></i> {{ trans('labels.actions.edit') }}</a>
                    <a href="#" @click.prevent="deleteMunicipio" class="btn btn-danger"><i class="fa fa-trash"></i> {{ trans('labels.actions.destroy') }}</a>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<script>
    //var auth = {!! Auth::user() !!};
    var urlIndexMunicipio = '{!! route('Municipio.index')!!}';
    var urlShowMunicipio = '{!! route('Municipio.show')!!}';
    var urlSaveMunicipio= '{!! route('Municipio.store')!!}';
    var urlDestroyMunicipio = '{!! route('Municipio.destroy')!!}';
   {{--   var urlListDepDocId = '{!! route('DepDocId.list')!!}';  --}}
    var urlListDepDocId = '{!! route('DepDocId.list')!!}';
</script>
{!! Html::script('/js/Municipio/Municipio.js') !!}
@endsection