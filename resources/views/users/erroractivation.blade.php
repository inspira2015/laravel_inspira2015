@extends('layouts.basic')

@section('content')

<div class="row">
	<div class="col-xs-10 col-xs-push-1 col-sm-8 col-sm-push-2 col-md-6 col-md-push-3">
		<div class="description">
		
		  <p class="account_conf">Tu cuenta ya ha sido activada!!</p>
		
		
		  <p>Si no puedes entrar reinicia tu password o contactanos por email</p>
		</div>
	</div>
</div>
<style>
	.description{
		margin-bottom: 350px;
	}
</style>
{!! HTML::style('css/app/users.css') !!}
{!! HTML::script('js/users.js') !!}

@stop
  