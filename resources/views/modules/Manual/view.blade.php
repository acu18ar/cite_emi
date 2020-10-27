@extends('layouts.app')
@section('content')
<div id="manual-app">
    <div class="container">
        <ul class="nav nav-tabs" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-manual-tab" data-toggle="pill" href="#pills-manual" role="tab" aria-controls="pills-manual" aria-selected="false">Manual</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="pills-rac-tab" data-toggle="pill" href="#pills-rac" role="tab" aria-controls="pills-rac" aria-selected="true">Rac 02</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-manual" role="tabpanel" aria-labelledby="pills-manual-tab">
                <embed src="../docs/MANUAL%20SISTEMA%20DE%20DEFENSA%20DE%20TRABAJO%20DE%20GRADO.pdf" type="application/pdf" width="100%" height="600px" />
            </div>
            <div class="tab-pane fade" id="pills-rac" role="tabpanel" aria-labelledby="pills-rac-tab">
                <embed src="../docs/RAC%20-%2002%20CORREGIDO%20%20final%201.pdf" type="application/pdf" width="100%" height="600px" />
            </div>
        </div>
    </div>
</div>
<script>
    var auth = {!! Auth::user() !!};

</script>
@endsection