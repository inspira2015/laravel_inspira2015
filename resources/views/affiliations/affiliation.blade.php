@extends('layouts.basic')

@section('content')
<div class="row bg-gray">
	<div class="col-xs-12 nopadding">
	{!! Form::open(array('url' => 'affiliation/add')) !!}
	<div class="row">
		<div class="col-xs-12">
			<div class="col-xs-4 col-sm-3 col-md-2">  
				<a href="{{ url('users') }}" class="btn-blue-clear btn-medium back">
					{{ Lang::get('layout.back') }}
				</a>
			</div>
			<div class="col-xs-5 col-xs-push-3 col-sm-3 col-sm-push-6 col-md-2 col-md-push-8 nopadding">   
				<div data-role="submit" class="btn-blue-clear btn-medium">
					{{ Lang::get('layout.continue') }}
				</div>
			</div>
				
			<div class="divider"></div>	
			<div class="col-xs-12 text-left" style="text-transform: uppercase; font-size: 16px;">
				<p>{{ Lang::get('affiliations.select') }} </p><br>
			</div>
			<div class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2">
				@include('errors.messages')
			</div>
		</div>
	</div>

	<div class="row">
		@foreach($suscription_array as $key => $obj)
		<?php  $descriptions = $obj->getAffDescriptionArray(); ?>
		<div class="col-md-{{ (12/$suscription_count) }} {{ strtolower($obj->getAffiliationName()) }}">
			<div class="row margin">
				<h2 class="affiliation-header">
	  			{{ $obj->getAffiliationName() }}
	  			</h2>
			</div>
			<div class="bg-light-gray margin row nopadding">
				<div class="col-xs-12">
					<p>{{ $obj->getAffiliationSmallDesc() }} </p>
				</div>
				<div class="col-xs-12 nopadding">
					<div class="divider"></div>
				</div>
				<div class="col-xs-12 text-left">
					<ul style="list-style-type:disc;">
					@foreach($descriptions as $k => $descArray)
						<li> {{ $descArray['description'] }} </li>
					@endforeach
					</ul>
				</div>
				<div class="col-xs-12 nopadding">
					<div class="divider"></div>
				</div>
				<div class="col-xs-12">
					<h2>@lang('affiliations.monthfee'): <br>
					<?php
					$convertHelper->setCost($obj->getAffiliationPrice());
					$convertHelper->setCurrencyOfCost($obj->getCurrency());
					?>
	
					@if($convertHelper->getCurrencyShow() == "USD")
						${{ $obj->getAffiliationPrice() }} MXN
						({{ $convertHelper->getFomattedAmount()}}
						{{$convertHelper->getCurrencyShow() }}* )
					
					@else
						{{ $convertHelper->getFomattedAmount()}}
						{{$convertHelper->getCurrencyShow() }}
					@endif
	
	
					{!! Form::hidden('currency_' . $obj->getAffiliationId(), $obj->getCurrency() ) !!}
	        		{!! Form::hidden('amount_' . $obj->getAffiliationId(), $obj->getAffiliationPrice()  ) !!}
					</h2>
				</div>
				<div class="col-xs-12 nopadding">
					<div class="divider"></div>
				</div>
				<div class="col-xs-12 nopadding">
					{{ Lang::get('affiliations.promotion') }}
					<?php  
	                    $affiliation = ( int )$affiliation;
	                    $radio_select = FALSE;
	                    if ( $affiliation != 0 )
	                    {
	                      $temp =  $obj->getAffiliationId();
	                      if ( $temp == $affiliation )
	                      {
	                        $radio_select = TRUE;
	                      }
	                    }
	                ?>
	                <div class="form-group text-left">
	                	{!! Form::radio('affiliation', $obj->getAffiliationId(), $radio_select ) !!}
	                	<div style="display:table-cell;padding-left:10px;">{{ Lang::get('affiliations.affconfirm', array('affiliation' => $obj->getAffiliationName())) }}</div>
	                </div>
	
				</div>
			</div>
		</div>
		@endforeach
	</div>
		<div class="row">
			<div class="col-xs-12">
				@if($convertHelper->getCurrencyShow() == "USD")
				<div class="divider"></div>
				<div class="row">
					*{{ Lang::get('affiliations.today-rate') }} ${{ round($exchangeMXN,2) }} MXN
				</div>
				@endif
				<div class="divider"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4 col-sm-3 col-md-2">  
				<a href="{{ url('users') }}" class="btn-blue-clear btn-medium back">
					{{ Lang::get('layout.back') }}
				</a>
			</div>
			<div class="col-xs-6 col-xs-push-2 col-sm-3 col-sm-push-7">   
				<div data-role="submit" class="btn-blue btn-medium">
					{{ Lang::get('layout.continue') }}
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@endsection