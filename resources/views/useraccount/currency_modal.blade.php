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
					?>
					
					{{ Lang::get('userdata.affect-vacationfund') }}<br><br>				
					<strong  style="text-transform:uppercase;">{{ Lang::get('subtotal.vacational-fund-fee') }}:</strong> <br>
					{{ Lang::get('userdata.current') }}: $ {{ number_format($vacational_fund_amount, 2, '.', '') . ' ' . $vacational_fund_currency }}  <br>
					{{ Lang::get('userdata.changes-to') }}: $ {{ number_format($vacation_fund, 2, '.', '') }}  {{$convertHelper->getCurrencyShow() }} <br><br>
					
					<strong style="text-transform:uppercase;">{{ Lang::get('subtotal.total-fund') }}:</strong><br>
					{{ Lang::get('userdata.current') }}: $ {{ number_format($vacational_fund_total, 2, '.', '') }} {{ $vacational_fund_currency }} <br>
					{{ Lang::get('userdata.changes-to') }}: $ {{ number_format($total_fund, 2, '.', '') }} {{$convertHelper->getCurrencyShow() }}
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