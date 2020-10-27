@extends('layouts.app')
@section('content')
<div id="dashboard-app">
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">{{ config('app.name') }}</h4>
            </div>
        </div>
        <div class="page-content-wrapper ">
            <div class="container-fluid">
             
                            <div class="page-content-wrapper ">
        
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p> &nbsp;</p>
                                            <p>&nbsp; </p>
                                            <p>&nbsp;</p>
                                            <p>&nbsp;</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">
                                                        <span class="d-block d-sm-none"><i class="fa fa-home"></i></span>
                                                        <span class="d-none d-sm-block">Condiciones del servicio</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">
                                                        <span class="d-block d-sm-none"><i class="fa fa-user"></i></span>
                                                        <span class="d-none d-sm-block">Privacidad</span>
                                                    </a>
                                                </li>
                                              
                                            </ul>
                                            <div class="tab-content bg-light">
                                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                    <p>Te damos la bienvenida al Sistema Work Network EMI .</p>
                                                    <p>EMI desarrolla tecnologías y servicios que permiten que las personas se conecten, creen comunidades y hagan crecer su negocio. Estas Condiciones rigen el uso del sistema, Trabajo y los demás productos, funciones, apps, servicios, tecnologías y software que ofrecemos (los Productos de EMI o Productos), excepto cuando indiquemos expresamente que se aplican otras condiciones (y no estas). EMi, Inc. te proporciona estos Productos.</p>
                                                </div>
                                                <div class="tab-pane fade " id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                    <p>El sistema te ofrece</p>
                                                    <p>Nuestra Política de datos explica cómo recopilamos y usamos tus datos personales para determinar algunos de los anuncios que ves y proporcionar todos los demás servicios que se describen a continuación. También puedes ir a la configuración cuando quieras para revisar las opciones de privacidad que tienes respecto de cómo usamos tus datos.</p>
                                                </div>
                                               
                                            </div>
                                        </div>

                                     
                                        <div class="col-lg-6">
                                            <div class="tabs-vertical-env">
                                                
                                                <div class="tab-content bg-light">
                                                    <div class="tab-pane fade show active" id="v-home-2" role="tabpanel" aria-labelledby="v-home-tab-2">
                                                        <p>Las cookies son pequeños fragmentos de texto que se utilizan para almacenar información en navegadores web. Se utilizan para almacenar y recibir identificadores y otros datos en computadoras, teléfonos y otros dispositivos. Otras tecnologías, incluidos los datos que almacenamos en tu navegador web o dispositivo, los identificadores asociados a tu dispositivo y otros programas, se utilizan con fines similares. A los efectos de esta política, todas estas tecnologías reciben el nombre de "cookies".</p>
                                                    </div>
                                                    <div class="tab-pane fade" id="v-profile-2" role="tabpanel" aria-labelledby="v-profile-tab-2">
                                                        <p>Utilizamos cookies si tienes una cuenta de EMI Work Network, utilizas los Productos de EMI Work Network, incluidos nuestro sitio web y nuestras aplicaciones, o visitas otros sitios web y otras aplicaciones que usan los Productos de EMI Work Network, incluidos el botón "Me gusta" u otras tecnologías de EMI Work Network. Las cookies permiten a EMI Work Network ofrecerte los Productos de EMI Work Network y entender la información que recibimos sobre ti, incluida la información sobre cómo usas los demás sitios web y aplicaciones o si te registraste o iniciaste sesión en ellos.</p>
                                                        <p>En esta política, se explica cómo usamos las cookies y las opciones tienes. Excepto que se especifique lo contrario en esta política, la Política de datos se aplicará al procesamiento de los datos que recopilamos mediante cookies.</p>
                                                    </div>
                                                    
                                                </div>
                                                <ul class="nav nav-tabs flex-column nav tabs-vertical" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="v-home-tab-2" data-toggle="tab" href="#v-home-2" role="tab" aria-controls="v-home-2" aria-selected="true">Cookies</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="v-profile-tab-2" data-toggle="tab" href="#v-profile-2" role="tab" aria-controls="v-profile-2" aria-selected="false">Otras tecnologías</a>
                                                    </li>
                                                  
                                            </div>
                                        </div>
                                    </div>
                               
        
                                </div><!-- container-fluid -->
        
                            </div> <!-- Page content Wrapper -->
        
                        </div> <!-- content -->
        
                
            </div>
        </div>
    </div>
</div>
<script>
    var auth = {!! Auth::user() !!};
</script>
@endsection
