@extends('layouts.basic')

@section('content')

<div class="container">	
  <div class="row"  style="margin-bottom:50px; background-color:#e5e7e9; margin-bottom:100px;">
    <div class="col-lg-12 col-md-12">
      <div class="content">
        <div class="informacion">
          <h2 style="padding-bottom:20px;"> 
            {{  @$name }}  
          </h2> 
          <p>
            {!! Lang::get('vacationfund.information') !!}
          </p>
        </div>  
      </div>
      
      <div class="col-lg-12 col-md-12" style="padding:20px;">
        <?php echo Form::open(array('url' => 'vacationfund/add', 'id' => 'vacationfund','name' => 'vacationfund' )) ?>
            <div class="content" style="background-color:transparent; ">
            <h2>
              {{ Lang::get('vacationfund.questionjoin') }}
            </h2>
            <div class="inputs" >
              {{ Lang::get('vacationfund.yes') }}
              
              <input type="radio" name="fondo" value=1 id="fondo2" checked="checked"  onclick="clicked(this)"/>
              {{ Lang::get('vacationfund.no') }}
              <input type="radio" name="fondo" id="fondo1" value=0  onclick="clicked(this)"/>
              </div>
              <h2>
                {{ Lang::get('vacationfund.savingamount') }}
              </h2>
              
              <div class="col-lg-6 col-md-12 amounts" style="text-align:left; padding-top:12px;">
                $ &nbsp;<?php echo Form::text('amount', Input::get('amount') ? Input::get('amount') : @$amount, 
                array('style'=>'width:70%; display:inline;', 'required','class' => 'form-control','id' => 'amount')); ?>
                &nbsp;<?php echo $currency; ?>&nbsp;
              </div>
       
      </div>
      
      <div class="col-lg-12 col-md-12" style="padding:20px;">
        <div class="divider"></div>
      </div>

      <div class="col-lg-12 col-md-12" style="padding:20px;">
        <p style="text-align:left;">
	       {!! Lang::get('vacationfund.termsconditions') !!}
	     </p>
      </div>

      <div class="col-lg-12 col-md-12" style="padding:20px;">
        <div class="divider"></div>
      </div>
       <?php echo Form::close() ?>
</div>

      <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">  
        <a href="/affiliation" ><img style="width:50%; height:auto;"src="images/regresartransparente.png"/></a>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4">&nbsp;</div>

      <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">   
        <a href="#" onClick="validateForm()">
          <img style="width:50%; height:auto;"src="images/continuar.png"/>
        </a>
      </div>
        
 

</div>
</div>
  </div>    

		 <script type="text/javascript">
    function validateForm()
    {
  vacationfund.submit();
	}
    </script>

  @stop
