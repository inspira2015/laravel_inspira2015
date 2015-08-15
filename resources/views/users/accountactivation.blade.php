@extends('layouts.basic')

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

<div class="row">
	<div class="col-xs-10 col-xs-push-1 col-sm-6 col-sm-push-3">
		<div class="description">
			<i class="fa fa-user"></i>
			<p><?php echo $full_name; ?></p>
			<br/>
			<p class="account_conf">{{ Lang::get('emails.confirm-message') }}</p>
		</div>
	</div>
</div>

<style>
	.fa-user {
		border: 3px solid grey; border-radius:50%; width:25px; height:25px;
	}
	.description {
		margin-bottom: 350px;
	}
</style>

@stop
  