@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-xs-10 col-xs-push-1 col-sm-6 col-sm-push-3">
		<div class="description">
			<i class="fa fa-user"</i>
			<p><?php echo $full_name; ?></p>
			<br/>
			<p class="account_conf">Por Favor revisa tu correo para confirmar tu cuenta</p>
		</div>
	</div>
</div>

<style>
	.description 
	.fa-user {
		border: 3px solid grey; border-radius:50%; width:25px; height:25px;
	}
</style>
{!! HTML::style('css/app/users.css') !!}
{!! HTML::script('js/users.js') !!}
@stop
  