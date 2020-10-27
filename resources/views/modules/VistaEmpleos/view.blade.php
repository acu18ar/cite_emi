@extends('layouts.app')
@section('content')
<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title"></h4>
        </div>
    </div>
    <div class="page-content-wrapper ">
        <div class="container-fluid">
         
                        @foreach($vistaEmpleos as $vistaEmpleo)
                        @endforeach 
                        <div class="container-fluid">
                            <div class="row">
                                @foreach($vistaEmpleos as $vistaEmpleo)
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body user-card">
                                            <div class="media-main"> 
                                                <a class="float-left" href="#">
                                                    <img src="/storage/imagenes/{{ $vistaEmpleo->Foto }}" class="rounded-circle" width="100" height="100">
                                                   
                                                </a>
                                                <div class="info pl-3">
                                                    <h4 class="mt-3">{{ $vistaEmpleo->Persona }}</h4>
                                                   
                                                    <br class="text-muted">{{ $vistaEmpleo->Titulado }}</br>
                                                    <p class="text-muted">{{ $vistaEmpleo->DepDocId }}  {{ $vistaEmpleo->Municipio }}</p>
                                                    
                                                   
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                           
                                            {{ $vistaEmpleo->TipoOportunidad }}</br>
                                            {{ $vistaEmpleo->Sector }}</br>
                                            {{ $vistaEmpleo->ExperienciaLaboral }}</br>
                                            
                                            <p class="text-muted info-text">
                                                {{ $vistaEmpleo->Descripcion }}</br>
                                                {{ $vistaEmpleo->PalabrasClaves }}</br>
                                            </p>
                                            <hr>
                                            <ul class="social-links list-inline m-b-0">
                                                <li class="list-inline-item">
                                                    <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Facebook"><i class="fab fa-facebook-f"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Twitter"><i class="fab fa-twitter"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="1234567890"><i class="fas fa-phone"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="@skypename"><i class="fab fa-skype"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="email@email.com"><i class="far fa-envelope"></i></a>
                                                </li>
                                            </ul>
                                        </div> <!-- card-body -->
                                    </div>
                                </div>
                                @endforeach 
                           
                            </div> <!-- end row -->

                       

        </div>
    </div>
</div>
<script>
    var auth = {!! Auth::user() !!};
</script>
@endsection
