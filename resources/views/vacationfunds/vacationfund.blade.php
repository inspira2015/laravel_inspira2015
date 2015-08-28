@extends('layouts.basic')

@section('content')
<div class="row bg-gray">
	<div class="col-xs-12 nopadding">
	{!! Form::open(array('url' => 'vacationfund/add', 'class' => 'margin')) !!}
		<div class="row">
			<div class="col-xs-4 col-sm-3 col-sm-2">  
				<a href="{{ URL::previous() }}" class="btn-blue-clear btn-medium back">
					{{ Lang::get('layout.back') }}
				</a>
			</div>
			<div class="col-xs-4 col-xs-push-4 col-sm-3 col-sm-push-6 col-md-2 col-md-push-8">   
				<div data-role="submit" class="btn-blue-clear btn-medium">
					{{ Lang::get('layout.continue') }}
				</div>
			</div>
			<div class="divider"></div>
			<div class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2">
			@include('errors.messages')
			</div>
		
		</div>
		
	
		<div class="bg-light-gray text-justify row">
			<div class="vacational">
				<h2> 
	            	{{ Lang::get('vacationfund.title') }}  
	        	</h2>
				{!! Lang::get('vacationfund.information') !!}
			</div>
		</div>
		<div class="row vacational">
			<div class="col-xs-12 margin text-left">
				<div class="form-group">
					<h3 class="row nopadding">
						{{ Lang::get('vacationfund.questionjoin') }}
					</h3>
					<div class="row">
						<div class="col-xs-4 col-sm-2 col-md-2 nopadding"> 
				            {{ Lang::get('vacationfund.yes') }}
							<input type="radio" name="fondo" value="1" checked="checked" />
			            </div>
			            <div class="col-xs-8 col-sm-6 col-md-3 nopadding">
			            	{{ Lang::get('vacationfund.no') }}
							<input type="radio" name="fondo" value="0"/>
						</div>
					</div>
				</div>
				<div class="form-group">
					<h3 class="row nopadding">
						{{ Lang::get('vacationfund.savingamount') }} *
					</h3>
					<div class="row">
						<div class="col-md-6 nopadding">
						$ &nbsp; {!! Form::text('amount', Input::get('amount') ? Input::get('amount') : @$amount, array('style'=>'width:70%; display:inline;', 'required','class' => 'form-control','id' => 'amount')) !!}
						&nbsp; {{ $userCurrency }} &nbsp;
	                
						{!! Form::hidden('currency', $userCurrency ) !!}
						</div>
					</div>
				</div>	     
			</div>
		</div>
		
		<div class="row">
			<div class="divider"></div>
		</div>
		<div class="row text-justify margin">
			* {!! Lang::get('vacationfund.termsconditions') !!}
		</div>
		<div class="row nopadding">
			<div class="divider"></div>
			<div class="col-xs-4 col-sm-2 nopadding">  
				<a href="{{ URL::previous() }}" class="btn-blue-clear btn-medium back">
					{{ Lang::get('layout.back') }}
				</a>
			</div>
			<div class="col-xs-5 col-xs-push-3 col-sm-3 col-sm-push-7 nopadding">   
				<div data-role="submit" class="btn-blue btn-medium">
					{{ Lang::get('layout.continue') }}
				</div>
			</div>
		</div>
		
    {!! Form::close() !!}
	</div>
</div>
@stop