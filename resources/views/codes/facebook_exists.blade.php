@extends('layouts.basic', array( 'title' => Lang::get('code.title') ))

@section('content')
<div class="row bg-gray-transparent" style="border-top:150px;">

<div class="col-sm-10 col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3" id="code-error">
	<div class="row">
		Esta cuenta de FB ya se encuentra registrada. 
		Para continuar salga de esta cuenta e inicie sesión a la cuenta deseada. Una vez hecho esto de click al botón “Registrarse con FB” una vez mas.
	</div>
	<div class="row">
		<div class="thumbnail">
			<img src="{{ $avatar }}" class="portrait">
		</div>
	</div>
	<div class="row">
	<fb:login-button autologoutlink="true">Login To My Facebook Account!</fb:login-button>
	</div>
</div>
</div>
<style>
	.thumbnail {
  position: relative;
  width: 75px;
  height: 75px;
  overflow: hidden;
}
.thumbnail img {
  position: absolute;
  left: 50%;
  top: 50%;
  height: 100%;
  width: auto;
  -webkit-transform: translate(-50%,-50%);
      -ms-transform: translate(-50%,-50%);
          transform: translate(-50%,-50%);
}
.thumbnail img.portrait {
  width: 100%;
  height: auto;
}
</style>
@endsection