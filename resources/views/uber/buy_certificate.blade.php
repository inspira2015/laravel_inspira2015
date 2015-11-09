@extends('layouts.uber.master')

@section('content')
<div class="row bg-gray" data-role="response">
	@include('uber.buy_certificate_form')
</div>
@include('creditcards.modal_ccv')
@endsection