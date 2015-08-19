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
	
			<div class="col-sm-5 col-sm-push-7 col-md-4 col-md-push-2">
				<div class="row text-right">
					<a href="<?php echo url(); ?>/auth/logout">Logout</a><br><br>
				</div>
				@if( $accountSetup->checkValidAccount() !==FALSE )
				<div class="row">
					<a href="{{ url('reservations') }}" class="btn-blue btn-small">{{ Lang::get('userdata.go-reservations') }}</a>
				</div>
				@endif
			</div>
		</div>
		
		<div class="row">
			<div class="divider"></div>
		</div>
	
		<div class="row text-left">
			<div class="col-md-6">
				<div class="row bg-light-gray-transparent" id="contact-info">
					<div class="row">
						<h3>{{ Lang::get('userdata.information') }}</h3>
					</div>
					<div class="row" data-role="response">
						@include('useraccount.contact')
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
							<strong>{{ Lang::get('userdata.language') }}</strong>: &nbsp; {{ Str::upper($user->details->language) }}
						</div>
						<div class="col-sm-4 col-sm-push-2 text-center">
							<a data-role="change" data-route="api/user/change-language" class="btn-blue btn-small">
								{{ Lang::get('userdata.change') }}
							</a>
						</div>					
					</div>
					<div class="row form-data" data-role="response">
						<div class="col-xs-6">
<!-- 							Cambiar esta parte con el currency y funcion que debe de ir -->
							<strong>{{ Lang::get('userdata.currency') }}</strong>: MXN							
						</div>
						<div class="col-sm-4 col-sm-push-2 text-center">
							<div data-role="change" data-route="useraccount/edit-contact" class="btn-blue btn-small">{{ Lang::get('userdata.change') }}</div>
						</div>
					</div>
				</div>
				<div class="row bg-light-gray-transparent text-center" id="inspira-points">
					{{ Lang::get('userdata.inspira-points') }} 
					<span class="pink">0  {{ Lang::get('userdata.points') }}</span>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row bg-light-gray-transparent" id="account-affiliation">
					<div class="row">
						<h3>{{ Lang::get('userdata.affiliation-type') }}:<br>
							- Tipo -
						</h3>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1" id="promotion-box">							
							<div class="promotion">
								<a href="#"> 
									Eleva de Categor&iacute;a<br>
									25% de Ahorros adicionales
								</a>
							</div>
							<div class="arrow"></div>
						</div>
					</div>
					<div class="row" data-role="response">
						<div class="col-xs-12">
							{{ Lang::get('userdata.expiration-date') }}:<br>
							00-00-0000
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
						<div class="col-xs-12  form-data">
							<div class="row">
								<strong>{{ Lang::get('subtotal.total-fund') }}:</strong> $ {{ round(0.00) }} MXN
							</div>
							<div class="row">
								<strong>{{ Lang::get('subtotal.vacational-fund-fee') }}:</strong> $ {{ number_format($vacational_fund_amount, 2, '.', '') . ' ' . $vacational_fund_currency }} <br><br>
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
					<div class="row form-data">
						<div class="col-xs-8">
							Tarjetas
						</div>
						<div class="col-xs-4 text-center">
							<a data-role="change" data-route="useraccount/edit-contact" class="btn-blue btn-small">{{ Lang::get('userdata.pay') }}</a>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top:30px;">
					
					<div class="col-xs-10 col-xs-offset-1">
						<h3 class="row">Promociones del mes</h3>
						<div class="row">
							<div class="col-xs-3 col-md-6 promo">
								<img src="images/manzanillo.png"/>
								<span>Manzanillo</span>
							</div>
							<div class="col-xs-3 col-md-6 promo">
								<img src="images/mazatlan.png"/>
								<span>Mazatlan</span>
							</div>
							<div class="col-xs-3 col-md-6 promo">
								<img src="images/lasvegas.png"/>
								<span>Las Vegas</span>
							</div>
							<div class="col-xs-3 col-md-6 promo">
								<img src="images/malaga.png"/>
								<span>Malaga</span>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		@if( $accountSetup->checkValidAccount() !==FALSE )
		<div class="row">
			<div class="divider"></div><br>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<a href="{{ url('reservations') }}" class="btn-blue">{{ Lang::get('userdata.go-reservations') }}</a>
			</div>
		</div>
		@endif
	</div>
</div>
@stop