<?php
	$host = "localhost";
	$user = "root";
	$password = "";
	$database = "u983060307_p";

	$link = mysqli_connect($host, $user, $password, $database);
	
	$codigo = $_GET['password'];
	$comprobar = false;
	
	$query = "SELECT COUNT(nombre) FROM codigo WHERE $codigo = nombre";
	$result = mysqli_query($link, $query);
	
	if ($result > 0) {
			$comprobar = true;
		}
	
	for ($i = 0; $i < $result ; $i++) {
		if ($codigo == $row[i]) {
			$comprobar = true;
		}
    echo $i;
}
	
	if(isset($comprobar == true)
	{
		echo 'Si';
	}
	else
	{
		echo 'No';
	}
?>