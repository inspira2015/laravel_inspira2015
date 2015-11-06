<?php

if($_SERVER['SERVER_ADDR'] == '127.0.0.1'){
	return array(
		'front' => 'dev.inspira', 
		'uber' => 'uber.inspira'
	);
}
else{
	return array(
		'front' => 'inspiramexico.mx', 
		'uber' => 'uber.inspiramexico.mx'
		);
}