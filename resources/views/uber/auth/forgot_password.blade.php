<div class="modal-wrapper" data-role="response">
	<div class="row text-center">
	@if($errors->has())
		@foreach($errors->all() as $error)
			{{ $error }}					
		@endforeach
	@else
	</div>
	<div class="row text-center">
		{!! Form::open() !!}
		<div class="col-xs-12">
			<div class="form-group">
	            <div class="input-group">
	              {!! Form::text('email', Input::get('email') ? Input::get('email') : @$email, array('class' => 'form-control','id' => 'email' , 'placeholder' => 'E-MAIL')) !!}                                                
	            </div>
			</div>
		</div>
		<div class="col-xs-12">
			<div href="#" data-role="submit" data-route="{{ url('restablecer-contrasena') }}" class="btn-blue">Reestablecer Contrase&ntilde;a</div>
		</div>
		{!! Form::close() !!}
	</div>  
	@endif
</div>