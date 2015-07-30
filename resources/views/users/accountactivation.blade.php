@extends('layouts.master')

@section('content')
<div class="description">
	<i class="fa fa-user" style="border: 3px solid grey; border-radius:50%; width:25px; height:25px;"></i>
	<p><?php echo $full_name; ?></p>
	<br/>
	<p>Su correo ha sido confirmado</p>
	
	<p class="account_conf">BIENVENIDO Y<br/>
		FELICES VIAJES!
	</p>
</div>

<div class="continuar">
	continuar
</div>

{!! HTML::style('css/app/users.css') !!}
{!! HTML::script('js/users.js') !!}

@stop
  