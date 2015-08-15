@extends('layouts.basic')

@section('content')
    <style type="text/css">
      .container li{
        margin-bottom: 8px;
      }
    </style>
<div style="background-color:#e5e7e9;padding-left:40px; padding-right:40px;">
	<div class="row" style="background-color:#e5e7e9; margin-bottom:0px; padding-top:50px;">
        <h2 style="float:left; text-transform:uppercase; margin-bottom:25px; text-align:left; 40px;display:inline;">
          @lang('affiliations.select')
        </h2>
	</div>
	<div class="row" style="padding: 0 20px;">
		@include('errors.messages')
	</div>
	<div class="row"  style="margin-bottom:50px; background-color:#e5e7e9; margin-bottom:50px; padding-top:50px;">
        <?php echo Form::open(array('url' => 'affiliation/add', 'id' => 'affiliation','name' => 'formulario' )) ?>

<?php

          	foreach($suscription_array as $key => $obj)
          	{
          		$descriptions = $obj->getAffDescriptionArray();
				echo '<div class="col-lg-'.(12/$suscription_count).' col-md-'.(12/$suscription_count).'">
                  		<h1 style="color:#ffffff; background-color:' . call_user_func(array($colorCodes, $obj->getAffiliationName())) . '; text-align:center;  margin:0px 10px; padding:10px; font-size:26px;">
                  			'. $obj->getAffiliationName() .'
                  		</h1>
                 		
                 		<div class="content" style="margin-top:0px; background-color:#eef0f0; margin-bottom:0px; padding-bottom:0px;">
                    		<div class="informacion">
								<p style="text-align:center">'. $obj->getAffiliationSmallDesc() .'</p>
                        	</div>
                          	<div class="divider content" style="padding-top:0px; padding-bottom:0px; margin: 0px 0px; bottom:0px;" ></div>
                        </div>
						<div class="content" style="margin-top:0px; margin-bottom:0px;">
                        	<div class="informacion">

                          	<ul style="list-style-type:disc;">
                        ';
    		    foreach($descriptions as $k => $descArray)
    			{
					echo '<li>'.$descArray['description'].'</li>';
				}		
?>
					</ul>
          				</div>
            			</div>
          				<div class="content" style="margin-top:0px; background-color:#eef0f0; margin-bottom:0px; padding-bottom:0px; padding-top:0px;">
          				<div class="divider content" style="padding-top:0px; padding-bottom:0px; margin: 0px 0px; bottom:0px;" ></div>  
            			<div class="informacion">
            			<h2 style="text-align:center">@lang('affiliations.monthfee'): <br>
                  <?php
                    $convertHelper->setCost($obj->getAffiliationPrice());
                    $convertHelper->setCurrencyOfCost($obj->getCurrency());


                   ?>
						<?php echo $convertHelper->getFomattedAmount(); ?>
						<?php echo $convertHelper->getCurrencyShow(); ?>
            <?php  echo Form::hidden('currency_' . $obj->getAffiliationId(), $convertHelper->getCurrencyShow()); ?>
            <?php  echo Form::hidden('amount_' . $obj->getAffiliationId(), $convertHelper->getFomattedAmount()); ?>


						</h2>
				          </div>
				            <div class="divider content" style="padding-top:0px; padding-bottom:0px; margin: 0px 0px; bottom:0px;" ></div>
				          </div>
				          <div class="content" style="margin-top:0px; margin-bottom:0px;">
				            <div class="informacion" style="min-height:130px;">

            				<h2>@lang('affiliations.promotion')</h2>
            
          					<div style="display:inline; float:left; text-align:left;">

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
                        echo Form::radio('affiliation', $obj->getAffiliationId(), $radio_select,array('style' => 'width: 30px')); 
                      ?>

          					</div>
         				 	<h2  style="display:inline;color:<?php echo call_user_func(array($colorCodes, $obj->getAffiliationName()));?>; float:left; width:60%;">
            					<?php echo Lang::get('affiliations.affconfirm', array('affiliation' => $obj->getAffiliationName())); ?>
            				</h2> 
            
					          </div>
					            
					          </div>

					        </div>
<?php
}
?>
        <?php echo Form::close() ?>

  <div class="col-lg-12 col-md-12" style="padding:20px;">
          <div class="divider"></div></div>
       <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">  
            <a href="/users">
              <img style="width:50%; height:auto;"src="<?php echo url();?>/images/regresartransparente.png"/>
            </a>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4">&nbsp;</div>
          <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;"> 
           <a href="#" onClick="formulario.submit()"><img style="width:50%; height:auto;"src="images/continuar.png"/></a></div>
    </div>
  </div>

@endsection