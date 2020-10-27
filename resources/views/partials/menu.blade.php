
<div id="sidebar-menu">
    <ul>
        <li class="active">
            <a href="{{ route('home') }}" class="waves-effect {{ Request::is('/') ? 'active' : '' }}"><i class="fas fa-home"></i><span> {{ trans('labels.modules.Inicio') }} </a>        
        </li>
        @if(Auth::user()->Rol == 1)
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect {{ Request::is('UnidadAcademica*') || Request::is('NivelAcademico*') || Request::is('Especialidad*') || Request::is('DepDocId*') || Request::is('Rol*') ? 'subdrop' : '' }}"><i class="mdi mdi-account-settings-variant"></i>
                <span>Adminsitración </span><span class="float-right"><i class="mdi mdi-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="{{ route('Persona.view') }}" class="waves-effect {{ Request::is('Persona/view*') ? 'active' : '' }}"><i class="fas fa-users"></i><span> {{ trans('labels.modules.Persona') }}</a>        </li>
                    <li><a href="{{ route('Rol.view') }}" class="{{ Request::is('Rol*') ? 'active' : '' }}"><i class="fas fa-key"></i> {{ trans('labels.modules.Rol') }}</a></li>
                </ul>
        </li>
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect {{ Request::is('UnidadAcademica*') || Request::is('NivelAcademico*') || Request::is('Especialidad*') || Request::is('DepDocId*') || Request::is('Rol*') ? 'subdrop' : '' }}"><i class="mdi mdi-city"></i>
                <span>Organización </span> <span class="float-right"><i class="mdi mdi-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                <li><a href="{{ route('UnidadAcademica.view') }}" class="{{ Request::is('UnidadAcademica*') ? 'active' : '' }}"><i class="fas fa-university"></i> {{ trans('labels.modules.UnidadAcademica') }}</a></li>
                <li><a href="{{ route('NivelAcademico.view') }}" class="{{ Request::is('NivelAcademico*') ? 'active' : '' }}"><i class="fas fa-graduation-cap"></i> {{ trans('labels.modules.NivelAcademico') }}</a></li>
                <li><a href="{{ route('Especialidad.view') }}" class="{{ Request::is('Especialidad*') ? 'active' : '' }}"><i class="fas fa-suitcase"></i> {{ trans('labels.modules.Especialidad') }}</a></li>
                <li><a href="{{ route('DepDocId.view') }}" class="{{ Request::is('DepDocId*') ? 'active' : '' }}"><i class="far fa-id-card"></i> {{ trans('labels.modules.DepDocId') }}</a></li>
            </ul>
        </li>
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect {{ Request::is('TipoMiembro*') || Request::is('CriterioPuntaje*') || Request::is('Equivalencia*') ? 'subdrop' : '' }}"><i class="fas fa-cog"></i>
                <span>Paramétricas </span> <span class="float-right"><i class="mdi mdi-plus"></i></span></a>
            <ul class="list-unstyled" style="">
                  <li><a href="{{ route('EstadoCivil.view') }}" class="{{ Request::is('EstadoCivil*') ? 'active' : '' }}"><i class="fas fa-user-friends"></i> {{ trans('labels.modules.EstadoCivil') }}</a></li>
                <li><a href="{{ route('Municipio.view') }}" class="{{ Request::is('Municipio*') ? 'active' : '' }}"><i class="fas fa-flag"></i> {{ trans_choice('labels.modules.Municipio', 2) }}</a></li>
            </ul>
        </li>  
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect {{ Request::is('TipoMiembro*') || Request::is('CriterioPuntaje*') || Request::is('Equivalencia*') ? 'subdrop' : '' }}"><i class="fas fa-cogs"></i>
                <span>Configuración </span> <span class="float-right"><i class="mdi mdi-plus"></i></span></a>
            <ul class="list-unstyled" style="">
           
           
            </ul>
        </li>  
        @endif
        @if(Auth::user()->Rol < 4)
       
       
 {{--      <li class="active">
            <a href="{{ route('Reporte.view') }}" class="waves-effect {{ Request::is('Reporte/view*') ? 'active' : '' }}"><i class="fas fa-file-excel"></i><span> {{ trans('labels.modules.Reporte') }}</a>        
        </li>   --}}
        @endif
      
       {{--  <li class="active">
            <a href="{{ url('Defensa/view') }}" class="waves-effect {{ Request::is('Defensa*') ? 'active' : '' }}"><i class="fa fa-address-book"></i><span>{{ trans_choice('labels.modules.Defensa', 2) }}</a>
        </li>   --}} 
        <li class="active">
            <a href="{{ url('Manual/view') }}" class="waves-effect {{ Request::is('Manual*') ? 'active' : '' }}"><i class="fa fa-book"></i><span>{{ trans_choice('labels.modules.Manual', 2) }}</a>
        </li> 
    {{--    
        <li>{!! Form::open(['url'=> route('logout'), 'method' => 'post']) !!}
                <button type="submit" class="dropdown-item"> Cerrar Sesión</button>
            {!! Form::close() !!}
        </li> --}}
    </ul>
</div> 