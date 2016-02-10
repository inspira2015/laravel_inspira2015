@extends('layouts.basic')

@section('content')
    <div class="row bg-gray">
	    <div class="col-xs-12 bg-light-gray">
			<h2>{{ Lang::get('subtotal.subtitle') }}</h2>
			<h3>{{ Lang::get('subtotal.type') }}</h3>
			
			<div class="col-md-8 col-md-offset-2">
				<p class="row">
					{{ Lang::get('subtotal.affiliation-monthly-fee') }}: <strong>$ {{ number_format($affiliation_cost, 2, '.', '') . ' ' . $affiliation_currency }}</strong>
	
				</p>                      
	 			<p>
	 				{{ Lang::get('subtotal.vacational-fund-fee') }}:  <strong>$ {{ number_format($vacational_fund_amount, 2, '.', '') . ' ' . $vacational_fund_currency }}</strong>
	 			</p>
				
				<p>
					{{ Lang::get('subtotal.next-payment-date') }}: <strong>{{ $next_payment_date }}</strong>
				</p>
			</div>		
	    </div>
	    <div class="divider"></div>

		<div class="col-xs-5  col-sm-3 col-sm-push-4 nopadding">
			{!! HTML::image('images/visa_master_american.png', 'credit card allowed', array('style' => 'width:100%;')) !!}
		</div>
		<div class="col-xs-6 col-xs-push-1 col-sm-3 col-sm-push-6  nopadding">   
			<a href="payment/creditcardinfo" class="btn-blue btn-medium">
				{{ Lang::get('layout.continue') }}
			</a>
		</div>
    </div>
    
    <style>
	    .bg-light-gray{
		    background-color: #f4f4f4;
		    padding:20px;
	    }
    </style>
@stop	