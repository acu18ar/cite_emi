@extends('layouts.app')
@section('content')
<div id="estadocivil-app">
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">{{ trans('labels.modules.EstadoCivil') }}</h4>
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
                                    <a href="#" @click.prevent="newEstadoCivil" class="btn btn-success waves-effect waves-light m-l-10"><i class="fa fa-plus"></i> {{ trans('labels.actions.new')}}</a>
                                </div>
                            </div>
                            <div class="card-body miClase">
                                <table id="estadocivil-table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- formulario de consulta-->
    <div class="modal fade" id="frm-estadocivil" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>{{ trans('labels.modules.EstadoCivil') }}</strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="form-group">
                            <label for="Num">Número</label>
                            <input type="number" class="form-control" name="Num" v-model="estadocivil.Num">
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Num"><li class="parsley-required">@{{ errorBag.Num }}</li></ul>
                        </div>
                        <div class="form-group">
                            <label for="EstadoCivil">Estado Civil</label>
                            <input type="text" class="form-control" name="EstadoCivil" v-model="estadocivil.EstadoCivil">
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.EstadoCivil"><li class="parsley-required">@{{ errorBag.EstadoCivil }}</li></ul>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" @click.prevent="saveEstadoCivil()" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('labels.actions.save') }}</a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-window-close"></i> {{ trans('labels.actions.cancel')}} </button>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>

     <!-- vista de consulta-->
    <div class="modal fade" id="view-estadocivil" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="custom-width-modalLabel">{{ trans('labels.modules.EstadoCivil') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <h4>Numero</h4>
                    <p class="text-muted">@{{ estadocivil.Num }}</p>
                    <h4>EstadoCivil</h4>
                    <p class="text-muted">@{{ estadocivil.EstadoCivil }}</p>
                </div>
                <div class="modal-footer">
                    <a href="#" @click.prevent="editEstadoCivil" class="btn btn-warning"><i class="fa fa-edit"></i> {{ trans('labels.actions.edit') }}</a>
                    <a href="#" @click.prevent="deleteEstadoCivil" class="btn btn-danger"><i class="fa fa-trash"></i> {{ trans('labels.actions.destroy') }}</a>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<script>
    //var auth = {!! Auth::user() !!};
    var urlIndexEstadoCivil = '{!! route('EstadoCivil.index')!!}';
    var urlShowEstadoCivil = '{!! route('EstadoCivil.show')!!}';
    var urlSaveEstadoCivil= '{!! route('EstadoCivil.store')!!}';
    var urlDestroyEstadoCivil = '{!! route('EstadoCivil.destroy')!!}';
</script>
{!! Html::script('/js/EstadoCivil/EstadoCivil.js') !!}
@endsection
