@extends('layouts.app')
@section('content')
<div id="depdocid-app">
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">{{ trans('labels.modules.DepDocId') }}</h4>
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
                                    <a href="#" @click.prevent="newDepDocId" class="btn btn-success waves-effect waves-light m-l-10"><i class="fa fa-plus"></i> {{ trans('labels.actions.new')}}</a>
                                </div>
                            </div>
                            <div class="card-body miClase">
                                <table id="depdocid-table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- formulario de consulta-->
    <div class="modal fade" id="frm-depdocid" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>{{ trans('labels.modules.DepDocId') }}</strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="form-group">
                            <label for="Num">Numero</label>
                            <input type="number" class="form-control" name="Num" v-model="depdocid.Num">
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Num"><li class="parsley-required">@{{ errorBag.Num }}</li></ul>
                        </div>
                        <div class="form-group">
                            <label for="DepDocId">Sigla</label>
                            <input type="text" class="form-control" name="DepDocId" v-model="depdocid.DepDocId">
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.DepDocId"><li class="parsley-required">@{{ errorBag.DepDocId }}</li></ul>
                        </div>
                        <div class="form-group">
                            <label for="DepDocId">Descripcion</label>
                            <input type="text" class="form-control" name="DepDocIdDescripcion" v-model="depdocid.DepDocIdDescripcion">
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.DepDocIdDescripcion"><li class="parsley-required">@{{ errorBag.DepDocId }}</li></ul>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" @click.prevent="saveDepDocId()" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('labels.actions.save') }}</a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-window-close"></i> {{ trans('labels.actions.cancel')}} </button>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>

     <!-- vista de consulta-->
    <div class="modal fade" id="view-depdocid" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="custom-width-modalLabel">{{ trans('labels.modules.DepDocId') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <h4>Numero</h4>
                    <p class="text-muted">@{{ depdocid.Num }}</p>
                    <h4>Sigla</h4>
                    <p class="text-muted">@{{ depdocid.DepDocId }}</p>
                    <h4>Descripción</h4>
                    <p class="text-muted">@{{ depdocid.DepDocIdDescripcion }}</p>
                </div>
                <div class="modal-footer">
                    <a href="#" @click.prevent="editDepDocId" class="btn btn-warning"><i class="fa fa-edit"></i> {{ trans('labels.actions.edit') }}</a>
                    <a href="#" @click.prevent="deleteDepDocId" class="btn btn-danger"><i class="fa fa-trash"></i> {{ trans('labels.actions.destroy') }}</a>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<script>
    //var auth = {!! Auth::user() !!};
    var urlIndexDepDocId = '{!! route('DepDocId.index')!!}';
    var urlShowDepDocId = '{!! route('DepDocId.show')!!}';
    var urlSaveDepDocId= '{!! route('DepDocId.store')!!}';
    var urlDestroyDepDocId = '{!! route('DepDocId.destroy')!!}';
</script>
{!! Html::script('/js/DepDocId/DepDocId.js') !!}
@endsection
