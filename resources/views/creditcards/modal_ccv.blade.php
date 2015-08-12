<div class="modal fade" id="what-is-ccv" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ Lang::get('creditcards.ccv-modal.title') }}</h4>
      </div>
      <div class="modal-body">
		<div class="row text-justify">
			<p>{{ Lang::get('creditcards.ccv-modal.description') }}</p> 
		</div>   
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<h5>Visa/Mastercard</h5>
				</div>
				<div class="row">
					<img src="http://inspiramexico.mx/cvv/cvv-visa.gif" style="margin-left:50px; margin-top:10px;margin-bottom:10px;">
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
					<img src="http://inspiramexico.mx/cvv/cvv-amex.gif" style="margin-left:50px;width: 215px; height: 103px;margin-top:10px;margin-bottom:10px;">
				</div>
				<div class="row">
					<p>{{ Lang::get('creditcards.ccv-modal.amex') }}</p>
				</div>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
