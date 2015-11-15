@extends('layouts.uber.master')

@section('content')
<div class="row bg-gray" data-role="response">
	@include('uber.certificates.buy_certificate_form')
</div>
@include('creditcards.modal_ccv')
@endsection