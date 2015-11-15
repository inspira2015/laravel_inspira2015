{!! Form::open(array('url' => 'payment/addcreditcard')) !!}
	<div class="row">
		<div class="col-xs-4 col-sm-3 col-md-2">  
			<a href="{{ url('/') }}" class="btn-blue-clear btn-medium back">
				{{ Lang::get('layout.back') }}
			</a>
		</div>
		<div class="col-xs-4 col-xs-push-4 col-sm-3 col-sm-push-6 col-md-2 col-md-push-8">   
			<div data-role="submit" data-route="{{ url('registrar') }}"  class="btn-blue-clear btn-medium">
				{{ Lang::get('layout.continue') }}
			</div>
		</div>
		<div class="divider"></div>
	</div>
	
	<div class="row">
		<div class="col-xs-12" id="register-box">
			<h2>REGISTRO DE TU CUENTA</h2>
		</div>
	</div>
	<div class="row bg-light-gray text-left">
		<div class="col-xs-12">
			<div class="form-group">
	            <label for="nombre">* Nombre(s):</label>
	            <div class="input-group extra-width">
	              {!! Form::text('name', Input::get('name') ? Input::get('name') : @$name, array('class' => 'form-control','id' => 'name')) !!}                                                
	            </div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="form-group">
	            <label for="nombre">* Apellido:</label>
	            <div class="input-group extra-width">
	              {!! Form::text('last_name', Input::get('last_name') ? Input::get('last_name') : @$last_name, array('class' => 'form-control','id' => 'last_name')) !!}                                                
	            </div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="form-group">
	            <label for="nombre">* E-Mail:</label>
	            <div class="input-group extra-width">
					{!! Form::email('email', Input::get('email') ? Input::get('email') : @$email, array('class' => 'form-control validate-email','id' => 'email', 'data-route' => url('api/users/exists') )) !!}
                            
	            </div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="form-group">
	            <label for="nombre">* Contrase&ntilde;a</label>
	            <div class="input-group extra-width">
	              {!! Form::password('password', array('class' => 'form-control','id' => 'password')) !!}   
	            </div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="form-group">
	            <label for="nombre">* Confirmar Contrase&ntilde;a</label>
	            <div class="input-group extra-width">
	              {!! Form::password('password_confirmation', array('class' => 'form-control','id' => 'password_confirmation')) !!}   
	            </div>
			</div>
		</div>
	</div>
	
	
	<div clas="row" style="margin-top: 30px;">
		<div class="col-xs-6 col-sm-9" style="padding-left:0px;">
			@include('errors.messages')
		</div>
		<div class="col-xs-6  col-sm-3 nopadding">   
			<div data-role="submit" data-route="{{ url('registrar') }}" class="btn-blue btn-medium">
				{{ Lang::get('layout.continue') }}
			</div>
			<div class="col-xs-12 text-right nopadding" id="mandatory">
			* {{ Lang::get('layout.required-fields') }}
			</div>
		</div>
	</div>
{!! Form::close() !!}