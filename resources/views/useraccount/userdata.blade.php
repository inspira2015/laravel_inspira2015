@extends('layouts.basic')

@section('content')
<div class="row bg-gray-transparent" id="user">
	<div class="col-xs-12">
		<div class="row">
			<div class="col-md-6 nopadding">
				<h2 class="text-left">
					<div class="display:table-cell;">
						<i class="fa fa-user"></i>
					</div>
					<span style="display:table-cell;">{{ Str::upper($user->details->name) }} {{ Str::upper($user->details->last_name) }}</span>
				</h2>
			</div>
	
			<div class="col-xs-5 col-xs-push-7 col-md-4 col-md-push-2">
				<div class="row text-right">
					<a href="{{ url('auth/logout') }} " style="color:#818c95;">Logout <i class="glyphicon glyphicon-log-out"></i></a>
					<br><br>
				</div>
				@if( $accountSetup->checkValidAccount() !==FALSE && $user->details->leisure_id !== null )
				<div class="row">
					<a href="http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid={{ $user->details->leisure_id }}" class="btn-blue btn-small">{{ Lang::get('userdata.go-reservations') }}</a>
				</div>
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
						<div class="col-xs-4 col-xs-push-2 text-center">
							<a data-role="change" data-route="api/user/change-language" class="btn-blue btn-small">
								{{ Lang::get('userdata.change') }}
							</a>
						</div>					
					</div>
					<div class="row form-data" data-role="response">
						<div class="col-xs-6">
							<strong>{{ Lang::get('userdata.currency') }}</strong>: &nbsp;{{ $user->details->currency }}						
						</div>
						<div class="col-xs-4 col-xs-push-2 text-center">
							<a href="#"  data-toggle="modal" data-target="#currency" class="btn-blue btn-small">{{ Lang::get('userdata.change') }}</a>
						</div>
					</div>
				</div>
				<div class="row bg-light-gray-transparent text-center" id="inspira-points">
					{{ Lang::get('userdata.inspira-points') }} 
					<span class="pink">{{ $inspiraPointsBalance }}  {{ Lang::get('userdata.points') }}</span>
				</div>
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
					@if($affiliation->id < '3' )
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1 col-md-12  col-md-offset-0 upgrade" id="promotion-box">							
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
						<div class="col-xs-10 col-xs-offset-1 col-md-12 col-md-offset-0 subscribe" id="promotion-box">		
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
								<strong>{{ Lang::get('subtotal.next-payment-date') }}: </strong>{{ $next_payment_date }}
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
					
					<div class="col-xs-10 col-xs-offset-1">
						<h3 class="row">{{ Lang::get('userdata.monthly-promotions')}}</h3>
						<div class="row">
							<div class="col-xs-3 col-md-6 promo">
								{!! HTML::image('images/manzanillo.png', 'Manzanillo - InspiraMexico') !!}
								<span>Manzanillo</span>
							</div>
							<div class="col-xs-3 col-md-6 promo">
								{!! HTML::image('images/mazatlan.png', 'Mazatlan - InspiraMexico') !!}
								<span>Mazatlan</span>
							</div>
							<div class="col-xs-3 col-md-6 promo">
								{!! HTML::image('images/lasvegas.png', 'Las Vegas - InspiraMexico') !!}
								<span>Las Vegas</span>
							</div>
							<div class="col-xs-3 col-md-6 promo">
								{!! HTML::image('images/malaga.png', 'Malaga - InspiraMexico') !!}
								<span>Malaga</span>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		@if( $accountSetup->checkValidAccount() !==FALSE && $user->details->leisure_id !== null )
		<div class="row">
			<div class="divider"></div><br>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<a href="http://inspiramexico.leisureloyalty.com/autologin?data=2014RawlaT&mid={{ $user->details->leisure_id }}" class="btn-blue">{{ Lang::get('userdata.go-reservations') }}</a>
			</div>
		</div>
		@endif
	</div>
</div>
@include('useraccount.currency_modal')
@include('useraccount.affiliation_modal')

@stop