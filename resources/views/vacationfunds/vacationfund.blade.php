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
        <form method="post" action="?route=users/addfondo" id="profile" name="formulario">

				    <input type="hidden" name="email" value="<?php //echo $user_data['email']; ?>" />

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
                $ &nbsp;<input type="text" class="form-control" name="amount" id="amount" style="width:70%; display:inline;"/>&nbsp;<?php //echo $user_data["currency"]; ?>&nbsp;
              </div>
        </form>
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
</div>

      <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">  
        <a href="/affiliation" ><img style="width:50%; height:auto;"src="images/regresartransparente.png"/></a>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4">&nbsp;</div>

      <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">   
        <a href="vacationfund/add" onClick="validateForm()">
          <img style="width:50%; height:auto;"src="images/continuar.png"/>
        </a>
      </div>
        
 

</div>
</div>
  </div>    

		 <script type="text/javascript">
    function validateForm()
    {
    var fondo = document.forms["formulario"]["fondo"].value;
	var a=document.forms["formulario"]["amount"].value;
		if(fondo==1){
    if (a==null || a=="" || a=="0")
      {
      alert("Favor de ingresar una cantidad");
      
      }else{
		  formulario.submit();
	  }
    }else{
		formulario.submit();
	}
	}
    </script>

  @stop
