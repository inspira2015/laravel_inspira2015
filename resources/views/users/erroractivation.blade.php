@extends('layouts.master')

@section('content')

<div class="description error">

  <p class="account_conf">Tu cuenta ya ha sido activada!!</p>


  <p>Si no puedes entrar reinicia tu password o contactanos por email</p>
</div>


{!! HTML::style('css/app/users.css') !!}
{!! HTML::script('js/users.js') !!}

@stop
  