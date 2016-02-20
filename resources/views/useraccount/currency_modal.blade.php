<div class="flat-windows">
	<div class="modal fade" id="currency" tabindex="-1" role="dialog" >
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
				<div class="modal-body">
					<div class="modal-wrapper">
						<div class="row text-center">
							<div class="col-xs-12">
							
							<?php
							$convertHelper->setCost( $vacational_fund_amount );
							$convertHelper->setCurrencyOfCost( $vacational_fund_currency );
							$convertHelper->setCurrencyShow($currency_change_to);
							$vacation_fund = $convertHelper->getConvertAmount();
							
							$convertHelper->setCost( $vacational_fund_total );
							$total_fund = $convertHelper->getConvertAmount();
							
							$convertHelper->setCost( $userAffiliation->amount );
							$convertHelper->setCurrencyOfCost( $userAffiliation->currency );
							$convertHelper->setCurrencyShow( $userAffiliation->currency_change_to );
		
							$affiliation_cost_convert = $convertHelper->getConvertAmount();
		
							?>
							
							{{ Lang::get('userdata.affect-vacationfund') }}:<br><br>			
		
		
							{{ Lang::get('userdata.affiliation-payment') }}: <br>{{ Lang::get('userdata.from') }}
								$ {{ number_format($userAffiliation->amount, 2, '.', '') . ' ' . $userAffiliation->currency }} 
								{{ Lang::get('userdata.to') }}
								$ {{ number_format(@$affiliation_cost_convert, 2, '.', '') . ' ' . @$currency_change_to }}<br>
							
							{{ Lang::get('userdata.vacation-fund') }}: <br>{{ Lang::get('userdata.from') }}
							 	$ {{ number_format($vacational_fund_amount, 2, '.', '') . ' ' . $vacational_fund_currency }} 
							 	{{ Lang::get('userdata.to') }}
								$ {{ number_format($vacation_fund, 2, '.', '') }}  {{ $currency_change_to }}<br>
							
							{{ Lang::get('userdata.total-saved') }}: <br>{{ Lang::get('userdata.from') }}
								 $ {{ number_format($vacational_fund_total, 2, '.', '') }} {{ $vacational_fund_currency }}
								 {{ Lang::get('userdata.to') }}
								 $ {{ number_format($total_fund, 2, '.', '') }} {{ $currency_change_to }}
		
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-5 col-md-4 text-left">
							<button type="button" class="btn btn-blue-clear back btn-small" data-dismiss="modal">{{ Lang::get('userdata.cancel') }}</button>
						</div>
						<div class="col-xs-5 col-xs-push-2 col-md-4 col-md-push-4">
							<a class="btn-light-blue btn-small" data-role="change" data-route="api/user/change-currency">{{ Lang::get('userdata.change') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>