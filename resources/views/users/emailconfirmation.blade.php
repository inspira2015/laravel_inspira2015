@extends('layouts.master')

@section('content')
<div class="description">
  <i class="fa fa-user" style="border: 3px solid grey; border-radius:50%; width:25px; height:25px;"></i>
  <p><?php echo $full_name; ?></p>
  <br/>
  <p class="account_conf">Por Favor revisa tu correo para confirmar tu cuenta</p>

</div>

{!! HTML::style('css/app/users.css') !!}
{!! HTML::script('js/users.js') !!}
@stop
  