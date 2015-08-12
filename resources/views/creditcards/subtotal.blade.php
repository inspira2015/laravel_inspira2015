@extends('layouts.basic')

@section('content')
    <div class="row"  style="margin-bottom:50px; background-color:#e5e7e9; margin-bottom:500px;">
	    <div class="col-lg-12 col-md-12">
            <div class="content" style="padding-bottom:20px;">
            	<div class="informacion">
            		<h2 style="padding-bottom:20px; text-align:center;">RESUMEN DE SU CUENTA</h2>
					<p style="text-align:center;">
						<span style="font-weight:bold;">PRIMER MES GRATUITO</span>
					</p>
					<div style="width:45%; margin:0 auto; padding-top:20px;">
						<p>
							Pago mensual Afiliacion: <strong>$ <?php echo number_format($affiliation_cost, 2, '.', '') . ' ' .
							$affiliation_currency; ?></strong>
	
						</p>                      
			 			<p>
			 				Pago Mensual Fondo vacacional:  <strong>$ <?php echo number_format($vacational_fund_amount, 2, '.', '') . ' ' .
							$vacational_fund_currency; ?></strong>
			 			</p>
						
						<p>
							Proxima fecha de pago: <strong><?php echo $next_payment_date; ?></strong>
						</p>
					</div>	
				</div>
            
          	</div>
			<div class="divider" style="margin-bottom:10px;"></div>
		</div>

		<div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">  
        	
         </div>
		
        <div class="col-lg-4 col-md-4 col-sm-4">
			<a href="#" id = "" > 
				<img style="text-align: center; margin: 0 auto; width: 70%; height: auto;" src="<?php echo url();?>/images/visa_master_american.png"/> 
			</a>
		</div>
        <a href="/payment/creditcardinfo"> <img src="<?php echo url();?>/images/continuar.png"/></a>
        <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">
		
			
		</div>

    </div>
@stop	