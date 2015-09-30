<div class="modal fade" id="currency" tabindex="-1" role="dialog" >
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
			<div class="modal-body">
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


					{{ Lang::get('userdata.affiliation-payment') }}: {{ Lang::get('userdata.from') }}
						$ {{ number_format($userAffiliation->amount, 2, '.', '') . ' ' . $userAffiliation->currency }} 
						{{ Lang::get('userdata.to') }}
						$ {{ number_format(@$affiliation_cost_convert, 2, '.', '') . ' ' . @$currency_change_to }}<br>
					
					{{ Lang::get('userdata.vacation-fund') }}: {{ Lang::get('userdata.from') }}
					 	$ {{ number_format($vacational_fund_amount, 2, '.', '') . ' ' . $vacational_fund_currency }} 
					 	{{ Lang::get('userdata.to') }}
						$ {{ number_format($vacation_fund, 2, '.', '') }}  {{ $currency_change_to }}<br>
					
					{{ Lang::get('userdata.total-saved') }}: {{ Lang::get('userdata.from') }}
						 $ {{ number_format($vacational_fund_total, 2, '.', '') }} {{ $vacational_fund_currency }}
						 {{ Lang::get('userdata.to') }}
						 $ {{ number_format($total_fund, 2, '.', '') }} {{ $currency_change_to }}

					</div>


				</div>
				<hr>
				<div class="row">
					<div class="col-xs-4 col-md-3 nopadding text-left">
						<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('userdata.cancel') }}</button>
					</div>
					<div class="col-xs-4 col-xs-push-4 col-md-3 col-md-push-6 nopadding">
						<a class="btn btn-blue btn-small" data-role="change" data-route="api/user/change-currency">{{ Lang::get('userdata.change') }}</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>