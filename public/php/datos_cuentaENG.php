<?php
	session_start();
	$userid = $_SESSION['user'];
	$host = "localhost";
	$user = "Inspira2015";
	$password = "InspiraMexico2015!";
	$database = "Inspira2015";

	$link = mysqli_connect($host, $user, $password, $database);
	
	$action = $_GET['action'];
	
	if($action == 'get')
	{
		$query = "SELECT email, password FROM inspirausers WHERE id = $userid";
		$result = mysqli_query($link, $query);
		
		$row = $result->fetch_assoc();
		
		echo json_encode($row);
	}
	else
	{
		$email = $_GET['correo']; 
		$password = $_GET['contrasena']; 
		
		$comprobar = false;
		
		$query = "SELECT * FROM inspirausers WHERE email = '$email' and id <> $userid";
		$result = mysqli_query($link, $query);
		$numero = mysqli_num_rows($result);
	
		if ($numero > 0) {
			$comprobar = true;
		}
		
		if($comprobar == true)
		{
			echo 'Ya existe';
		}
		else
		{
			$query = "UPDATE inspirausers SET email = '$email', password = '$password' WHERE id = $userid";
			$result = mysqli_query($link, $query);
			echo 'No existe';
		}
	}
?>