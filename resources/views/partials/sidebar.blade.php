<div class="sidebar-inner slimscrollleft">
    <!--- Divider --><div class="user-details">
            <div class="text-center">
                <p></p>
                <p></p>
                <p></p>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <img src="/storage/imagenes/{{ Auth::user()->Foto }}" class="rounded-circle" width="100">
                </div>
                <div class="user-info">
                    <div class="dropdown">
                    </div>
                    <p></p>
                    <p></p>
                    <p class="text-muted m-0"> {{ Auth::user()->Persona }}</p>
                    <p class="text-muted m-0 small"> <b>{{ Auth::user()->rol->Rol }}</b></p>
                    {{-- <p class="text-muted m-0"><i class="far fa-dot-circle text-success"></i> Conectado</p> --}}
                </div>
            </div>
    @include('partials.menu')
</div>