@extends('layouts.app')
@section('content')
<div id="unidadacademica-app">
    <div class="content">
        <div class="">
            <div class="page-header-title">
                {{-- <h4 class="page-title">{{ trans('labels.modules.UnidadAcademica') }}</h4> --}}
                <h4 class="page-title">CURSOS C.I.T.E.</h4>
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
                                    <a href="#" @click.prevent="newUnidadAcademica" class="btn btn-success waves-effect waves-light m-l-10"><i class="fa fa-plus"></i> {{ trans('labels.actions.new')}}</a>
                                </div>
                            </div>
                            <div class="card-body miClase">
                                <table id="unidadacademica-table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- formulario de consulta-->
    <div class="modal fade" id="frm-unidadacademica" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>{{ trans('labels.modules.UnidadAcademica') }}</strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="form-group">
                            <label for="Num">Numero</label>
                            <input type="number" class="form-control" name="Num" v-model="unidadacademica.Num">
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Num"><li class="parsley-required">@{{ errorBag.Num }}</li></ul>
                        </div>
                        <div class="form-group">
                            {{-- <th scope="col">Agencia</th> --}}
                            <label for="UnidadAcademica">hfsdfa</label>
                            {{-- <label for="UnidadAcademica">Curso Militar</label> --}}
                            <input type="text" class="form-control" name="hdsfkjl" v-model="gfvdc">
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.UnidadAcademica"><li class="parsley-required">cueS</li></ul>
                        </div>
                        <div class="form-group">
                             <label for="Sigla">Sigla</label>
                            <input type="text" class="form-control" name="Sigla" v-model="unidadacademica.Sigla">
                            <ul class="parsley-errors-list filled" id="parsley-id-19" v-if="errorBag.Sigla"><li class="parsley-required">@{{ errorBag.Sigla }}</li></ul>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" @click.prevent="saveUnidadAcademica()" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('labels.actions.save') }}</a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-window-close"></i> {{ trans('labels.actions.cancel')}} </button>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>

     <!-- vista de consulta-->
    <div class="modal fade" id="view-unidadacademica" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="custom-width-modalLabel">{{ trans('labels.modules.UnidadAcademica') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <h4>Numero</h4>
                    <p class="text-muted">@{{ unidadacademica.Num }}</p>
                    <h4>hkgj</h4>
                    {{-- <p class="text-muted">@{{ unidadacademica.UnidadAcademica }}</p> --}}
                    <p class="text-muted">@ Curso Militar</p>
                    <h4>Sigla</h4>
                    <p class="text-muted">@{{ unidadacademica.Sigla }}</p>
                </div>
                <div class="modal-footer">
                    <a href="#" @click.prevent="editUnidadAcademica" class="btn btn-warning"><i class="fa fa-edit"></i> {{ trans('labels.actions.edit') }}</a>
                    <a href="#" @click.prevent="deleteUnidadAcademica" class="btn btn-danger"><i class="fa fa-trash"></i> {{ trans('labels.actions.destroy') }}</a>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<script>
    //var auth = {!! Auth::user() !!};
    var urlIndexUnidadAcademica = '{!! route('UnidadAcademica.index')!!}';
    var urlShowUnidadAcademica = '{!! route('UnidadAcademica.show')!!}';
    var urlSaveUnidadAcademica= '{!! route('UnidadAcademica.store')!!}';
    var urlDestroyUnidadAcademica = '{!! route('UnidadAcademica.destroy')!!}';
</script>
{!! Html::script('/js/UnidadAcademica/UnidadAcademica.js') !!}
@endsection
