{!! Form::open(array('url' => url('payment/bonus') , 'class' => 'form-data' )) !!}

<div class="row margin-top">	
	<div class="col-xs-12">
		<div class="form-group">
			<label for="name">{{ Lang::get('creditcards.card-number') }}</label>
			<div class="input-group">
				{!! Form::text('cnumber', Input::get('cnumber') ? Input::get('cnumber') : @$cnumber, array('class' => 'form-control','id' => 'card_number')) !!}
			</div>
		</div>
		<div class="form-group">
			<label for="numero">{{ Lang::get('creditcards.ccv') }} <a data-toggle="modal" class="small" data-target="#what-is-ccv" href="#">{{ Lang::get('creditcards.what-is') }}</a></label>
			<div class="input-group">
			  {!! Form::text('ccv', Input::get('ccv') ? Input::get('ccv') : @$ccv, array('class' => 'form-control','id' => 'codigo', 'size' => '4', 'maxlength' => '4' )) !!}                        
			</div>
		</div>
		<div class="form-group">
			<label for="expiration">{{ Lang::get('creditcards.expiration') }}</label>
			<div class="input-group">
				{!! Form::text('expiration_date', Input::get('expiration_date') ? Input::get('expiration_date') : @$expiration_date, array('class' => 'form-control', 'size' => '7', 'maxlength' => '7', 'data-mask-type' => 'expiration', 'placeholder' => Lang::get('creditcards.expiry'))) !!}
			</div>
		</div>			
		<div class="form-group">
            <label for="nombre">{{ Lang::get('creditcards.name-on-card') }}</label>
            <div class="input-group">
              {!! Form::text('name_on_card', Input::get('name_on_card') ? Input::get('name_on_card') : @$name_on_card, array('class' => 'form-control','id' => 'name_on_card')) !!}                                                
            </div>
		</div>
		<div class="form-group">
            <label for="nombre">{{ Lang::get('creditcards.birthdate') }}</label>
            <div class="input-group">
              {!! Form::text('birthdate', Input::get('birthdate') ? Input::get('birthdate') : @$birthdate, array('class' => 'form-control', 'data-mask-type' => 'date', 'placeholder' => Lang::get('creditcards.birthdate-format') )) !!}                                                
            </div>
		</div>
		
		<div class="form-group" style="line-height: 2;">
			<label for="amount">{{ Lang::get('userdata.amount') }}:   $</label>
			<div class="input-group">
				<input type="text" name="amount" class="form-control" style="width:calc(75% - 10px)!important;display:inline-block;margin-right: 10px;">{{ $user->currency }}
			</div>
		</div>
			
		<div class="form-group">
			<div class="col-xs-4 col-xs-push-8 text-center nopadding">
				<div data-role="submit" data-route="useraccount/update-payment" class="btn-blue btn-small">{{ Lang::get('userdata.pay') }}</div>
			</div>
		</div>
	</div>
</div>

<div class="row margin-top">
	<div class="col-xs-8 text-center ">
		<img src="images/markets.png">
	</div>
	<div class="col-xs-4 text-center">
		<a class="btn-blue-clear btn-small underline">M&aacute;s Info</a>
	</div>
</div>
{!! Form::close() !!}


<div class="row">
@include('errors.messages')
</div>
	
@if(@$receipt)
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 text-center">
			<a href="{{ $receipt }}" class="btn-light-blue btn-small" target="_blank">{{ Lang::get('userdata.view-receipt') }}</a>
		</div>
	</div>
@endif

<style>
	.underline {
		text-decoration: underline;
	}
	.less-margin {
		margin-top: -15px;
	}
	.margin-top {
		margin-top: 15px;
	}
</style>

@include('creditcards.modal_ccv')
