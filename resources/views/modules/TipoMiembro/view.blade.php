@extends('layouts.app')
@section('content')
<div id="tipomiembro-app">
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">{{ trans('labels.modules.TipoMiembro') }}</h4>
            </div>
        </div>
        <div class="page-content-wrapper ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header miClase">
                                <h3 class="card-title text-dark m-0">Registros</h3>
                                <div class="btn-group float-right">
                                    <a href="#" @click.prevent="newTipoMiembro" class="btn btn-success waves-effect waves-light m-l-10"><i class="fa fa-plus"></i> {{ trans('labels.actions.new')}}</a>
                                </div>
                            </div>
                            <div class="card-body miClase">
                                <table id="tipomiembro-table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- formulario de consulta-->
    <div class="modal fade" id="frm-tipomiembro" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>{{ trans('labels.modules.TipoMiembro') }}</strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="form-group">
                            <label for="Num">No.</label>
                            <input type="number" class="form-control" name="Num" v-model="tipomiembro.Num">
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Num"><li class="parsley-required">@{{ errorBag.Num }}</li></ul>
                        </div>
                        <div class="form-group">
                            <label for="TipoMiembro">{{ trans('labels.modules.TipoMiembro') }}</label>
                            <input type="text" class="form-control" name="TipoMiembro" v-model="tipomiembro.TipoMiembro">
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.TipoMiembro"><li class="parsley-required">@{{ errorBag.UnidadAcaedmica }}</li></ul>
                        </div>
                        <div class="form-group">
                            <label for="Descripcion">Descripción</label>
                            <textarea name="Descripcion" class="form-control" cols="30" rows="1" v-model="tipomiembro.Descripcion"></textarea>
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Descripcion"><li class="parsley-required">@{{ errorBag.Descripcion }}</li></ul>
                        </div>

                        <div class="form-group">
                            <label for="Abreviacion">Abreviación</label>
                            <input type="text" class="form-control" name="Abreviacion" v-model="tipomiembro.Abreviacion">
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Abreviacion"><li class="parsley-required">@{{ errorBag.Abreviacion }}</li></ul>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-xs-12">
                                <label for="EstadoRequerido">Requerido</label>
                                <input type="checkbox" name="Requerido" class="form-control checkox" v-model="tipomiembro.Requerido">
                                <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Requerido"><li class="parsley-required">@{{ errorBag.Requerido }}</li></ul>
                            </div>

                            <div class="form-group col-md-6 col-xs-12">
                                <label for="Activo">Activo</label>
                                <input type="checkbox" name="Activo" class="form-control checkox" v-model="tipomiembro.Activo">
                                <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Activo"><li class="parsley-required">@{{ errorBag.Activo }}</li></ul>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" @click.prevent="saveTipoMiembro()" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('labels.actions.save') }}</a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-window-close"></i> {{ trans('labels.actions.cancel')}} </button>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>

     <!-- vista de consulta-->
    <div class="modal fade" id="view-tipomiembro" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="custom-width-modalLabel">{{ trans('labels.modules.TipoMiembro') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <h4>Numero</h4>
                    <p class="text-muted">@{{ tipomiembro.Num }}</p>
                    <h4>Tipo de Miembro</h4>
                    <p class="text-muted">@{{ tipomiembro.TipoMiembro }}</p>
                    <h4>Descripción</h4>
                    <p class="text-muted">@{{ tipomiembro.Descripcion }}</p>
                    <h4>Abreviación</h4>
                    <p class="text-muted">@{{ tipomiembro.Abreviacion }}</p>
                    <h4>Requerido</h4>
                    <p class="text-muted">@{{ tipomiembro.Requerido ? 'SI' : 'NO' }}</p>
                    <h4>Activo</h4>
                    <p class="text-muted">@{{ tipomiembro.Activo ? 'SI' : 'NO' }}</p>
                </div>
                <div class="modal-footer">
                    <a href="#" @click.prevent="editTipoMiembro" class="btn btn-warning"><i class="fa fa-edit"></i> {{ trans('labels.actions.edit') }}</a>
                    <a href="#" @click.prevent="deleteTipoMiembro" class="btn btn-danger"><i class="fa fa-trash"></i> {{ trans('labels.actions.destroy') }}</a>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<script>
    //var auth = {!! Auth::user() !!};
    var urlIndexTipoMiembro = '{!! route('TipoMiembro.index')!!}';
    var urlShowTipoMiembro = '{!! route('TipoMiembro.show')!!}';
    var urlSaveTipoMiembro= '{!! route('TipoMiembro.store')!!}';
    var urlDestroyTipoMiembro = '{!! route('TipoMiembro.destroy')!!}';
</script>
{!! Html::script('/js/TipoMiembro/TipoMiembro.js') !!}
@endsection
