<?php

if(@$_SERVER['SERVER_ADDR'] == '127.0.0.1'){
	return array(
		'front' => 'dev.inspira', 
		'uber' => 'uber.inspira',
		'api' => 'api.inspira',
		'promotions' => 'promociones.inspira'
	);
}
else{
	return array(
		'front' => 'inspiramexico.mx', 
		'uber' => 'uber.inspiramexico.mx',
		'api' => 'api.inspiramexico.mx',
		'promotions' => 'promociones.inspiramexico.mx'
	);
}