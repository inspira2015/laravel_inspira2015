@if(Auth::check())
<div class="flat-windows">
	<div class="modal fade" id="modal-options" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-body text-center">
		  	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  		@include('landings.__common.auth.options')
	    </div>
	  </div>
	</div>
</div>
@else
<div class="flat-windows">
	<div class="modal fade" id="modal-login" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-body text-center">
		  	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  		<span><img src="images/member-icon-blue.png"></span>
		  		<div class="modal-wrapper" data-role="response">
	  			@include('landings.__common.auth.login')
	  			</div>
	    </div>
	  </div>
	</div>
</div>
@endif