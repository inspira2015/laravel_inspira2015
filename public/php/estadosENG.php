<?php
	$country = $_GET['country'];
	
	$states['MX'] = array(
		array("clave"=>"AGS", "nombre"=>"Aguascalientes"), 
		array("clave"=>"BCN", "nombre"=>"Baja California"), 
		array("clave"=>"BCS", "nombre"=>"Baja-California-Sur"),
		array("clave"=>"CAMP", "nombre"=>"Campeche"),
		array("clave"=>"CHIS", "nombre"=>"Chiapas"),
		array("clave"=>"CHIH", "nombre"=>"Chihuahua"),
		array("clave"=>"COAH", "nombre"=>"Coahuila"),
		array("clave"=>"COL", "nombre"=>"Colima"),
		array("clave"=>"DF", "nombre"=>"Distrito Federal"),
		array("clave"=>"DGO", "nombre"=>"Durango"),
		array("clave"=>"MEX", "nombre"=>"Estado de México"),
		array("clave"=>"GTO ", "nombre"=>"Guanajuato"),
		array("clave"=>"GRO", "nombre"=>"Guerrero"),
		array("clave"=>"HGO", "nombre"=>"Hidalgo"),
		array("clave"=>"JAL", "nombre"=>"Jalisco"),
		array("clave"=>"MICH", "nombre"=>"Michoacan"),
		array("clave"=>"MOR", "nombre"=>"Morelos"),
		array("clave"=>"NAY", "nombre"=>"Nayarit"),
		array("clave"=>"NL", "nombre"=>"Nuevo Leon"),
		array("clave"=>"OAX", "nombre"=>"Oaxaca"),
		array("clave"=>"PUE", "nombre"=>"Puebla"),
		array("clave"=>"QRO", "nombre"=>"Queretaro"),
		array("clave"=>"QROO ", "nombre"=>"Quintana Roo"),
		array("clave"=>"SLP", "nombre"=>"San Luis Potosi"),
		array("clave"=>"SIN", "nombre"=>"Sinaloa"),
		array("clave"=>"SON", "nombre"=>"Sonora"),
		array("clave"=>"TAB", "nombre"=>"Tabasco"),
		array("clave"=>"TAMP", "nombre"=>"Tamaulipas"),
		array("clave"=>"TLAX", "nombre"=>"Tlaxcala"),
		array("clave"=>"VER", "nombre"=>"Veracruz"),
		array("clave"=>"YUC", "nombre"=>"Yucatan"),
		array("clave"=>"ZAC", "nombre"=>"Zacatecas")
						 );
	
	$states['US'] = array(
		array("clave"=>"AK", "nombre"=>"Alaska"),
		array("clave"=>"AL", "nombre"=>"Alabama"),
		array("clave"=>"AR", "nombre"=>"Arkansas"),
		array("clave"=>"AZ", "nombre"=>"Arizona"),
		array("clave"=>"CA", "nombre"=>"California"),
		array("clave"=>"CO", "nombre"=>"Colorado"),
		array("clave"=>"CT", "nombre"=>"Connecticut"),
		array("clave"=>"DC", "nombre"=>"District Of Columbia"),
		array("clave"=>"DE", "nombre"=>"Delaware"),
		array("clave"=>"FL", "nombre"=>"Florida"),
		array("clave"=>"GA", "nombre"=>"Georgia"),
		array("clave"=>"HI", "nombre"=>"Hawaii"),
		array("clave"=>"IA", "nombre"=>"Iowa"),
		array("clave"=>"ID", "nombre"=>"Idaho"),
		array("clave"=>"IL", "nombre"=>"Illinois"),
		array("clave"=>"IN", "nombre"=>"Indiana"),
		array("clave"=>"KS", "nombre"=>"Kansas"),
		array("clave"=>"KY", "nombre"=>"Kentucky"),
		array("clave"=>"LA", "nombre"=>"Louisiana"),
		array("clave"=>"MA", "nombre"=>"Massachusetts"),
		array("clave"=>"MD", "nombre"=>"Maryland"),
		array("clave"=>"ME", "nombre"=>"Maine"),
		array("clave"=>"MI", "nombre"=>"Michigan"),
		array("clave"=>"MN", "nombre"=>"Minnesota"),
		array("clave"=>"MO", "nombre"=>"Missouri"),
		array("clave"=>"MS", "nombre"=>"Mississippi"),
		array("clave"=>"MT", "nombre"=>"Montana"),
		array("clave"=>"NC", "nombre"=>"North Carolina"),
		array("clave"=>"ND", "nombre"=>"North Dakota"),
		array("clave"=>"NE", "nombre"=>"Nebraska"),
		array("clave"=>"NH", "nombre"=>"New Hampshire"),
		array("clave"=>"NJ", "nombre"=>"New Jersey"),
		array("clave"=>"NM", "nombre"=>"New Mexico"),
		array("clave"=>"NV", "nombre"=>"Nevada"),
		array("clave"=>"NY", "nombre"=>"New York"),
		array("clave"=>"OH", "nombre"=>"Ohio"),
		array("clave"=>"OK", "nombre"=>"Oklahoma"),
		array("clave"=>"OR", "nombre"=>"Oregon"),
		array("clave"=>"PA", "nombre"=>"Pennsylvania"),
		array("clave"=>"PR", "nombre"=>"Puerto Rico"),
		array("clave"=>"RI", "nombre"=>"Rhode Island"),
		array("clave"=>"SC", "nombre"=>"South Carolina"),
		array("clave"=>"SD", "nombre"=>"South Dakota"),
		array("clave"=>"TN", "nombre"=>"Tennessee"),
		array("clave"=>"TX", "nombre"=>"Texas"),
		array("clave"=>"UT", "nombre"=>"Utah"),
		array("clave"=>"VA", "nombre"=>"Virginia"),
		array("clave"=>"VI", "nombre"=>"Virgin Islands"),
		array("clave"=>"VT", "nombre"=>"Vermont"),
		array("clave"=>"WA", "nombre"=>"Washington"),
		array("clave"=>"WI", "nombre"=>"Wisconsin"),
		array("clave"=>"WV", "nombre"=>"West Virginia"),
		array("clave"=>"WY", "nombre"=>"Wyoming")
						 );

	$states['CA'] = array(
		array("clave"=>"AB", "nombre"=>"Alberta"),
		array("clave"=>"BC", "nombre"=>"British Columbia"),
		array("clave"=>"LB", "nombre"=>"Labrador"),
		array("clave"=>"MB", "nombre"=>"Manitoba"),
		array("clave"=>"NB", "nombre"=>"New Brunswick"),
		array("clave"=>"NF", "nombre"=>"Newfoundland"),
		array("clave"=>"NL", "nombre"=>"Newfoundland & Labrador"),
		array("clave"=>"NS", "nombre"=>"Nova Scotia"),
		array("clave"=>"NT", "nombre"=>"Northwest Territories"),
		array("clave"=>"NU", "nombre"=>"Nunavut Territory"),
		array("clave"=>"ON", "nombre"=>"Ontario"),
		array("clave"=>"PE ", "nombre"=>"Prince Edward Island"),
		array("clave"=>"PQ", "nombre"=>"Quebec"),
		array("clave"=>"SK", "nombre"=>"Saskatchewan "),
		array("clave"=>"YT", "nombre"=>"Yukon Territory")
						 );
 
	$states['AU'] = array(
		array("clave"=>"ACT ", "nombre"=>"Australian Cap. Terr."),
		array("clave"=>"NSW", "nombre"=>"New South Wales"),
		array("clave"=>"NT ", "nombre"=>"Northern Territory"),
		array("clave"=>"QLD ", "nombre"=>"Queensland "),
		array("clave"=>"SA", "nombre"=>"South Australia"),
		array("clave"=>"TAS", "nombre"=>"Tasmania"),
		array("clave"=>"VIC", "nombre"=>"Victoria"),
		array("clave"=>"WA", "nombre"=>"Western Australia")
						 );

	if(isset($states[$country]))
	{
		echo json_encode($states[$country]);
	}
	else
	{
		echo 'no states';
	}
?>