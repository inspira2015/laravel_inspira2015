<div class="flat-windows">
	<div class="modal fade" id="modal-login" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-body text-center">
		  	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  	<span><img src="images/member-icon-blue.png"></span>
		  	<div class="modal-wrapper">
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
						<div class="form-group">
				            <div class="input-group">
				              {!! Form::password('password', array('class' => 'form-control','id' => 'password', 'placeholder' => 'CONTRASE&Ntilde;A')) !!}                                                
				            </div>
						</div>
					</div>
					<div class="col-xs-12">
						<a href="#" class="btn-blue">INICIAR SESI&Oacute;N</a>
					</div>
					{!! Form::close() !!}

				</div>   
				<div class="row text-center">
					<a href="{{ url('olvido-contrasena') }}">&iquest; Olvid&oacute; su contrase&ntilde;a?</a>
					<a href="{{ url('registro') }}"> &iquest; No est&aacute; registrado ? </a>
				</div>
		  	</div>
	    </div>
	  </div>
	</div>
</div>