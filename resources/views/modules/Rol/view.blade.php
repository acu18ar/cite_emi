@extends('layouts.app')
@section('content')
<div id="rol-app">
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">{{ trans('labels.modules.Rol') }}</h4>
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
                                    <a href="#" @click.prevent="newRol" class="btn btn-success waves-effect waves-light m-l-10"><i class="fa fa-plus"></i> {{ trans('labels.actions.new')}}</a>
                                </div>
                            </div>
                            <div class="card-body miClase">
                                <table id="rol-table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- formulario de consulta-->
    <div class="modal fade" id="frm-rol" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>{{ trans('labels.modules.Rol') }}</strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="form-group">
                            <label for="Num">Numero</label>
                            <input type="number" class="form-control" name="Num" v-model="rol.Num">
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Num"><li class="parsley-required">@{{ errorBag.Num }}</li></ul>
                        </div>
                        <div class="form-group">
                            <label for="Rol">Rol</label>
                            <input type="text" class="form-control" name="Rol" v-model="rol.Rol">
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Rol"><li class="parsley-required">@{{ errorBag.Rol }}</li></ul>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" @click.prevent="saveRol()" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('labels.actions.save') }}</a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-window-close"></i> {{ trans('labels.actions.cancel')}} </button>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>

     <!-- vista de consulta-->
    <div class="modal fade" id="view-rol" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="custom-width-modalLabel">{{ trans('labels.modules.Rol') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <h4>Numero</h4>
                    <p class="text-muted">@{{ rol.Num }}</p>
                    <h4>Rol</h4>
                    <p class="text-muted">@{{ rol.Rol }}</p>
                </div>
                <div class="modal-footer">
                    <a href="#" @click.prevent="editRol" class="btn btn-warning"><i class="fa fa-edit"></i> {{ trans('labels.actions.edit') }}</a>
                    <a href="#" @click.prevent="deleteRol" class="btn btn-danger"><i class="fa fa-trash"></i> {{ trans('labels.actions.destroy') }}</a>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<script>
    //var auth = {!! Auth::user() !!};
    var urlIndexRol = '{!! route('Rol.index')!!}';
    var urlShowRol = '{!! route('Rol.show')!!}';
    var urlSaveRol= '{!! route('Rol.store')!!}';
    var urlDestroyRol = '{!! route('Rol.destroy')!!}';
</script>
{!! Html::script('/js/Rol/Rol.js') !!}
@endsection
