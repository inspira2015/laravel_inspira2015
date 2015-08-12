@extends('layouts.basic')

@section('content')
	<div class="row bg-gray" data-role="response">
		@include('creditcards.payment_form')
	</div>
	@include('creditcards.modal_ccv')
@stop	
