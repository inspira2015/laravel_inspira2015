@if($errors->has())
	@if(!isset($success))
		<div class="alert alert-danger" role="alert">
			@foreach($errors->all() as $error)
				{{ $error }}					
			@endforeach
		</div>
	@else
		<div class="alert alert-success" role="alert">
		@foreach($errors->all() as $error)
			{{ $error }}					
		@endforeach
		</div>	
	@endif
@endif