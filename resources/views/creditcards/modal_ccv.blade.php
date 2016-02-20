<div class="flat-windows">
	<div class="modal fade" id="what-is-ccv" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

	      <div class="modal-body">
			<div class="modal-wrapper">

				<div class="row text-center" id="text">
					<div class="col-xs-12">
						<h4 class="modal-title">{{ Lang::get('creditcards.ccv-modal.title') }}</h4>
						<p class="text-justify">{{ Lang::get('creditcards.ccv-modal.description') }}</p> 
					</div>
					<div class="col-xs-12">
						<div class="row text-center">
							<div class="col-sm-6">
								<div class="row">
									<h5>Visa/Mastercard</h5>
								</div>
								<div class="row">
									<img src="http://inspiramexico.mx/cvv/cvv-visa.gif" style=" margin-top:10px;margin-bottom:10px;width:80%;">
								</div>
								<div class="row">
									<p>{{ Lang::get('creditcards.ccv-modal.vismas') }}</p>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<h5>American Express</h5>
								</div>
								<div class="row">
									<img src="http://inspiramexico.mx/cvv/cvv-amex.gif" style="min-height: 80px;margin-top:10px;margin-bottom:10px;width:80%;">
								</div>
								<div class="row">
									<p>{{ Lang::get('creditcards.ccv-modal.amex') }}</p>
								</div>
							</div>
						</div>
				
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-xs-6 col-xs-push-6 col-md-4 col-md-push-8 text-right">
					<button type="button" class="btn-light-blue btn-small" data-dismiss="modal">
						{{ Lang::get('layout.close') }}
					</button>
				</div>
			</div>
	    </div>
	  </div>
	</div>
</div>
