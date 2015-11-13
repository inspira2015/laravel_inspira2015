<div class="flat-windows">
	<div class="modal fade" id="modal-login" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-body text-center">
		  	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  	@if(Auth::check())
		  		@include('uber.auth.options')
		  	@else
		  		<span><img src="images/member-icon-blue.png"></span>
		  		<div class="modal-wrapper" data-role="response">
	  			@include('uber.auth.login')
	  			</div>
	  		@endif
	    </div>
	  </div>
	</div>
</div>