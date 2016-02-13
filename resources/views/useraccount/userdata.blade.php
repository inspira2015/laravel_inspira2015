@extends('layouts.basic')

@section('content')
<div class="row bg-gray-transparent" id="user">
	<div class="col-xs-12">
		<div class="row">
			<div class="col-sm-5 col-md-6 nopadding">
				<h2 class="text-left">
					<i class="fa fa-user"></i>
					<span>
						{{ Str::upper($user->details->name) }} {{ Str::upper($user->details->last_name) }}
					</span>
				</h2>
			</div>
	
			<div class="col-xs-12 col-sm-7 col-md-6">
				@if( $user->details->leisure_id !== null )
					<a href="{{ url('useraccount/reservations') }}" class="btn-blue btn-big">
						{{ Lang::get('userdata.go-reservations') }}
					</a>
				@endif
			</div>
		</div>
		
		<div class="row">
			<div class="divider"></div>
		</div>
	
		<div class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2">
			<div class="row">
				@include('errors.messages', array('success' => true ))
			</div>
		</div>
	
		<div class="row text-left">
			<div class="col-md-6">
				<div class="row bg-light-gray-transparent" id="contact-info">
					<div class="row" data-role="response">
						<div class="col-xs-12 nopadding">
							@include('useraccount.contact')
						</div>
					</div>
				</div>
				<div class="row bg-light-gray-transparent" id="account-details">
					<div class="row">
						<h3>{{ Lang::get('userdata.account-details') }}</h3>
					</div>
					<div class="row" data-role="response">
						@include('useraccount.password')
					</div>
				</div>
				<div class="row bg-light-gray-transparent" id="account-convert">
					
					<div class="row form-data" data-role="response">
						<br><br>
						<div class="col-xs-6">
							<strong>{{ Lang::get('userdata.language') }}</strong>: &nbsp;{{ Str::upper($user->details->language) }}
						</div>
						<div class="col-xs-6 col-sm-5 col-sm-push-1 text-center">
							<a data-role="change" data-route="api/user/change-language" class="btn-blue btn-small">
								{{ Lang::get('userdata.change') }}
							</a>
						</div>					
					</div>
					<div class="row form-data" data-role="response">
						<div class="col-xs-6">
							<strong>{{ Lang::get('userdata.currency') }}</strong>: &nbsp;{{ $user->details->currency }}						
						</div>
						<div class="col-xs-6 col-sm-5 col-sm-push-1 text-center">
							<a href="#"  data-toggle="modal" data-target="#currency" class="btn-blue btn-small">{{ Lang::get('userdata.change') }}</a>
						</div>
					</div>
					<div class="row form-data" data-role="response">
						<div class="col-xs-6">
							<strong>{{ Lang::get('userdata.credit-card') }}</strong>				
						</div>
						<div class="col-xs-6 col-sm-5 col-sm-push-1 text-center">
							<a href="{{ url('creditcardinfo/update') }}"  class="btn-blue btn-small">{{ Lang::get('userdata.change') }}</a>
						</div>
					</div>
				</div>
				<div class="row bg-light-gray-transparent text-center" id="inspira-points">
					<h3>{{ Lang::get('userdata.inspira-points') }} <span class="pink">{{ $inspiraPointsBalance }}  {{ Lang::get('userdata.points') }}</span></h3>
					
				</div>
				
<!--
				<div class="row bg-light-gray-transparent" id="history-payments">
					<div class="col-xs-7 nopadding">
						<h3>{{ Lang::get('userdata.payment-history') }} </h3>
					</div>
					<div class="col-xs-4 text-center">
						<a class="btn-blue btn-small" data-toggle="modal" data-target="#payment-history" href="#">
							{{ Lang::get('userdata.view') }}
						</a>
					</div>
				</div>
-->
			</div>
			<div class="col-md-6">
				
				<div class="row bg-light-gray-transparent" id="account-affiliation">
					<div class="row">
						<h3>{{ Lang::get('userdata.affiliation-type') }}:<br>
							@if(Lang::locale() == 'es')
								{{ $affiliation->name_es }}
							@else
								{{ $affiliation->name_eng }}
							@endif 
						</h3>
					</div>
					
					@if($affiliation->id != $code->max_level )
					<div class="row">
						<div class="col-sm-10 col-sm-offset-1 col-md-12  col-md-offset-0 upgrade" id="promotion-box">					
							<div class="promotion">
								<a href="#" data-toggle="modal" data-target="#change-affiliation"> 
									<span>{{ Lang::get('userdata.upgrade') }}</span><br>
									{{ Lang::get('userdata.additional-savings') }}
								</a>
							</div>
							<div class="arrow"></div>
						</div>
					</div>
					@endif
					
					<div class="row" data-role="response">
						<div class="col-xs-12">
							{{ Lang::get('userdata.expiration-date') }}:<br>
							{{ $next_payment_date }}
						</div>
					</div>
				</div>
				<div class="row bg-light-gray-transparent" id="account-funds">
					<div class="row">
						<h3>
							{{ Lang::get('userdata.vacation-fund') }}
						</h3>
					</div>
					<div class="row" data-role="response">
						@if( $vacational_fund->amount == '0' )
						<div class="col-sm-10 col-sm-offset-1 col-md-12 col-md-offset-0 subscribe" id="promotion-box">		
							<div class="promotion">
								<a href="{{ url('vacationfund/update', ['vacationfund' => $vacational_fund->id ]) }}">
									<span>{{ Lang::get('userdata.subscribe') }}</span><br>
									{{ Lang::get('userdata.additional-savings-fifty') }}
								</a>
							</div>
							<div class="arrow"></div>
						</div>
						@endif
						<div class="col-xs-12  form-data">
							<div class="row">
								<strong>{{ Lang::get('subtotal.total-fund') }}:</strong> $ {{ number_format($vacational_fund_total, 2, '.', '') }} {{ $vacational_fund_currency }}
							</div>
							<div class="row">
								<strong>{{ Lang::get('subtotal.vacational-fund-fee') }}:</strong> $ {{ number_format($vacational_fund_amount, 2, '.', '') }} {{ $vacational_fund_currency }} <br><br>
							</div>
							<div class="row">
								<strong>{{ Lang::get('subtotal.next-payment-date') }}: </strong>{{ $next_payment_vacation_date }}
							</div>
						</div>
					</div>
				</div>
				<div class="row bg-light-gray-transparent" id="account-bonus">
					<div class="row">
						<h3>
							{{ Lang::get('userdata.additional-bonus') }}
						</h3>
					</div>
					<div class="row form-data" data-role="response">
						@include('useraccount.payment')
					</div>
				</div>
				<div class="row" style="margin-top:30px;">
					
					<div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-1 ">
						<h3 class="row">{{ Lang::get('userdata.monthly-promotions')}}</h3>
						<div class="row">
							<div class="col-xs-6 col-sm-3 col-md-6 promo">
								<a href="{{ url('destination/mazanillo') }}">{!! HTML::image('images/manzanillo.png', 'Manzanillo - Inspira Mexico') !!}</a>
								<span>Manzanillo, MX</span>
							</div>
							<div class="col-xs-6 col-sm-3 col-md-6 promo">
								<a href="{{ url('destination/mazatlan') }}">{!! HTML::image('images/mazatlan.png', 'Mazatlan - Inspira Mexico') !!}</a>
								<span>Mazatl&aacute;n, MX</span>
							</div>
							<div class="col-xs-6 col-sm-3 col-md-6 promo">
								<a href="{{ url('destination/las-vegas') }}">{!! HTML::image('images/lasvegas.png', 'Las Vegas - Inspira Mexico') !!}</a>
								<span>Las Vegas, E.U.</span>
							</div>
							<div class="col-xs-6 col-sm-3 col-md-6 promo">
								<a href="{{ url('destination/malaga') }}">{!! HTML::image('images/malaga.png', 'Malaga - Inspira Mexico') !!}</a>
								<span>Malaga, Esp.</span>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		@if( $user->details->leisure_id !== null )
		<div class="row">
			<div class="divider"></div><br>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<a href="{{ url('useraccount/reservations') }}" class="btn-blue">{{ Lang::get('userdata.go-reservations') }}</a>
			</div>
		</div>
		@endif
	</div>
</div>
@include('useraccount.currency_modal')
@include('useraccount.payment_history_modal')
@include('useraccount.affiliation_modal')

@stop