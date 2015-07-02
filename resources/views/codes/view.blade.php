@extends('layouts.basic')

@section('content')
<div class="row"  style="background-color:rgba(229,231,233,0.4); margin-bottom:10px;">
	<div class="col-lg-12 col-md-12">
		<div class="codigo"></div>
		<div class="col-lg-12 col-md-12" style="padding:20px;">
			<?php echo Form::open(array('url' => 'codes/check', 'id' => 'profile', 'name'=>'formulario')) ?>
			<div class="content" style="background-color:transparent; ">
				<h2 style="text-transform:none; font-size:24px; color:#465664; text-align:justify;">
					{{ Lang::get('code.promo') }}
				</h2>
				<br><br>
				<div class="inputs" style="margin:0 auto; width:70%;">
					<?php echo Form::text('code', '', array('style' => 'width:100%; border:12px solid #465664; background-color:#bec4c9; color:#465664;', 'required' => 'required'));?>
				</div>
				<?php echo Form::close()?>
			</div>
			
			<div class="col-lg-12 col-md-12" style="padding:20px;">
				<div class="divider"></div>
			</div>
		</div>
	</div>
</div>
<div class="row"  style="margin-bottom:350px; background-color:rgba(229,231,233,0.4); margin-top:10px; padding:0px;">
	<div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:30px; margin-top:70px;"></div>
	<div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:30px; margin-top:70px;">  
		<a href="#" onClick="formulario.submit()">
			<img style="width:100%; height:auto;"src="<?php echo url();?>/images/continuargrande.png"/>
		</a>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:30px; margin-top:70px;"></div>
	<div class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom:0px;"> 
		
		@if($errors->has())
			<div class="col-lg-3"></div>
			<div class="col-lg-6 col-sm-12" style="margin:0 auto;">
				<p style="color:#cc4b9b">
					{{ Lang::get('code.promo-invalid') }}
				</p> 
				<a href="?route=users/profileexternal2">
					{!! HTML::image('/images/sincodigo.png', 'Inspira Mexico - Sin Codigo', array('style' => 'margin-top:30px;width:50%; height:auto;')) !!}
				</a>
			</div>
			<div class="col-lg-3"></div>
		@endif
	</div>
</div>
@endsection