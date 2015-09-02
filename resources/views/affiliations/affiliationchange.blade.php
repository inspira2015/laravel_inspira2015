@extends('layouts.basic')

@section('content')
<div class="row bg-gray">
	{!! Form::open(array('url' => 'affiliation/modify')) !!}
	<div class="col-xs-12">
		<div class="row nopadding">
			<div class="col-xs-4 col-sm-3 col-sm-2">  
				<a href="{{ url('useraccount') }}" class="btn-blue-clear btn-medium back">
					{{ Lang::get('layout.back') }}
				</a>
			</div>
			<div class="col-xs-4 col-xs-push-4 col-sm-3 col-sm-push-6 col-md-2 col-md-push-8">   
				<div data-role="submit" class="btn-blue-clear btn-medium">
					{{ Lang::get('layout.continue') }}
				</div>
			</div>
			<div class="divider"></div>		
		</div>
	</div>
	<div class="col-xs-12 text-left" style="text-transform: uppercase; font-size: 16px;">
		<p>{{ Lang::get('affiliations.select') }} </p><br>
	</div>
	<div class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2">
		@include('errors.messages')
	</div>
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
				
				{{ $convertHelper->getFomattedAmount()}}
				{{$convertHelper->getCurrencyShow() }}
					
				
				@if($convertHelper->getCurrencyShow() == "USD")
					(${{ $obj->getAffiliationPrice() }} MXN*)
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
                	{!! Form::radio('affiliation', $obj->getAffiliationId(), $radio_select, array('style' => 'display:table-cell')) !!}
                	<div style="display:table-cell;padding-left:10px;">{{ Lang::get('affiliations.affconfirm', array('affiliation' => $obj->getAffiliationName())) }}</div>
                </div>

			</div>
		</div>
	</div>
	@endforeach
	<div class="col-xs-12">
		@if($convertHelper->getCurrencyShow() == "MXN")
		<div class="divider"></div>
		<div class="row">
			*{{ Lang::get('affiliations.today-rate') }} ${{ round($exchangeMXN,2) }} MXN
		</div>
		@endif
		<div class="divider"></div>
	</div>
	<div class="col-xs-4 col-sm-2">  
		<a href="{{ url('useraccount') }}" class="btn-blue-clear btn-medium back">
			{{ Lang::get('layout.back') }}
		</a>
	</div>
	<div class="col-xs-5 col-xs-push-3 col-sm-3 col-sm-push-7">   
		<div data-role="submit" class="btn-blue btn-medium">
			{{ Lang::get('layout.continue') }}
		</div>
	</div>
{!! Form::close() !!}
</div>
@endsection