<div class="row text-center">
	<div class="col-xs-12">
	@if($errors->has())
		@foreach($errors->all() as $error)
			{{ $error }}
		@endforeach
		@if( Session::has('message') )
		<a data-role="change" data-route="{{ url('olvido-contrasena') }}">&iquest; Olvid&oacute; su contrase&ntilde;a?</a>
		@endif
	@else
	</div>
	{!! Form::open() !!}
	<div class="col-xs-12">
		<div class="form-group">
            <div class="input-group">
              {!! Form::text('email', Input::get('email') ? Input::get('email') : @$email, array('class' => 'form-control','id' => 'email' , 'placeholder' => 'E-MAIL')) !!}                                                
            </div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="form-group">
            <div class="input-group">
            {!! Form::password('password', array('class' => 'form-control','id' => 'password', 'placeholder' => 'CONTRASE&Ntilde;A')) !!}                                                
            </div>
		</div>
	</div>
	<div class="col-xs-12">
		<div href="#" data-role="submit" data-route="{{ url('login') }}" class="btn-blue">INICIAR SESI&Oacute;N</div>
	</div>
	{!! Form::close() !!}
</div>   
<div class="row text-center">
	<a data-role="change" data-route="{{ url('olvido-contrasena') }}">&iquest; Olvid&oacute; su contrase&ntilde;a?</a>
	
	<a href="{{ url('registro') }}"> &iquest; No est&aacute; registrado ? </a>
	@endif
</div>