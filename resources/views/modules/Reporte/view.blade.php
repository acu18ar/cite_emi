@extends('layouts.app')
@section('content')
<div id="reporte-app">
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Puntaje</h4>
            </div>
        </div>
    </div>
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="excelMiembro-tab" data-toggle="tab" href="#excelMiembro" role="tab" aria-controls="excelMiembro" aria-selected="true">Defensa por Persona</a>
            </li>  
            <li class="nav-item">
                <a class="nav-link" id="excelMiembroGlobal-tab" data-toggle="tab" href="#excelMiembroGlobal" role="tab" aria-controls="excelMiembroGlobal" aria-selected="true">Defensa por Gestion</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="excelMiembro" role="tabpanel" aria-labelledby="excelMiembro-tab">
                <div class="row">
                    <div class="offset-md-3 col-md-6 offset-lg-4 col-lg-4">

                        <div class="form-group col-lg-12">
                            <label for="Gestion">Gestion</label>
                            <input type="number" class="form-control" name="pestion" v-model="excelMiembroRequest.gestion">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="PeriodoGestion">Periodo Gestion</label>
                            <select class="form-control" name="periodoGestion" v-model="excelMiembroRequest.periodoGestion">
                                <option value=1>I/@{{excelMiembroRequest.gestion}}</option>
                                <option value=2>II/@{{excelMiembroRequest.gestion}}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="Persona">Peronsa</label>
                            <select class="form-control" name="persona" v-model="excelMiembroRequest.personaId" id="Persona" style="width: 100%"></select>
                        </div>
                        <div class="form-group col-lg-12 text-center" @click.prevent="excelMiembro">
                            <button class="btn btn-success">Cargar Defensas</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show" id="excelMiembroGlobal" role="tabpanel" aria-labelledby="excelMiembroGlobal-tab">
                <div class="row">
                    <div class="offset-md-3 col-md-6 offset-lg-4 col-lg-4">

                        <div class="form-group col-lg-12">
                            <label for="Gestion">Gestion</label>
                            <input type="number" class="form-control" name="gestion" v-model="excelMiembroGlobalRequest.gestion">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="PeriodoGestion">Periodo Gestion</label>
                            <select class="form-control" name="periodoGestion" v-model="excelMiembroGlobalRequest.periodoGestion">
                                <option value=1>I/@{{excelMiembroGlobalRequest.gestion}}</option>
                                <option value=2>II/@{{excelMiembroGlobalRequest.gestion}}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-12 text-center" @click.prevent="excelMiembroGlobal">
                            <button class="btn btn-success">Cargar Defensas</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //var auth = {!! Auth::user() !!};
    var urlExcelMiembro = '{!! route('Reporte.excelMiembro')!!}';
    var urlExcelMiembroGlobal = '{!! route('Reporte.excelMiembroGlobal')!!}';
    var urlSelect2Persona = '{!! route('Persona.select2')!!}';
</script>
{!! Html::script('/js/Reporte/Reporte.js') !!}
@endsection