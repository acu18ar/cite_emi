<div class="container mail-body">
	<div class="card border-primary">
		<div class="card-header text-center" style="background-color:#003F8A;">
			<img src="{{url('/')}}/images/emi_logo.png" alt="EMI" class="img-thumbnail">
			<h3 style="color: #FFCC00;">{{ config('app.name') }}</h3>	
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-12">
					<span class="card-text">
						<p>Hola <b><i>{{ $user->Persona}}</i></b>,</p>
						<p>Se ha generado una clave para inicio de sesión:
                            <h4><strong>{{$tokenLogin}}</strong></h4>
                        </p>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>

