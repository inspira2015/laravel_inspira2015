<div class="col-xs-12">
	<div class="row">
		<div class="col-xs-12 form-data">
			<strong>Email</strong>: {{ $user->details->email }}
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6 form-data ">
			<strong>{{ Lang::get('userdata.password') }}</strong>: *********
		</div>
		<div class="col-xs-5 col-xs-push-1 text-center">
			<a data-role="change" data-route="useraccount/edit-password" class="btn-blue btn-small">{{ Lang::get('userdata.change') }}</a>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col-xs-8 form-data">
			@if(!$user->details->facebook_id)
 				<a href="useraccount/fbLink" class="fb-linkto">{{ Lang::get('userdata.fb-link') }}</a> 
<!--  				<a data-role="change" data-route="useraccount/fbLink" class="fb-linkto">{{ Lang::get('userdata.fb-link') }}</a>  -->
			@else
 				<a data-role="change" data-route="useraccount/fb-unlink" class="fb-linkto">{{ Lang::get('userdata.fb-unlink') }}</a> 
			@endif
		</div>
		
		<div class="col-xs-3 col-xs-push-1 col-md-4 col-md-push-0 form-data">
			<a data-toggle="modal" data-target="#linktofb" href="#" class="btn-blue-clear btn-small underline">{{ Lang::get('userdata.more-info') }}</a>
		</div>
	</div>
	@if($errors->has())
	<div class="row">
		<div class="col-xs-12">
			<div class="form-group">
			@include('errors.messages')
			</div>
		</div>
	</div>
	@endif
</div>
@include('useraccount.linktofb_modal')
