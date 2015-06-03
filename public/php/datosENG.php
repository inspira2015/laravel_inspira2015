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
		$query = "SELECT leisure_id, cel_phn, home_phn, wrk_phn, address, country, state, city FROM inspirausers WHERE id =$userid";
		$result = mysqli_query($link, $query);
		
		$row = $result->fetch_assoc();
		
		echo json_encode($row);
	}
	else
	{
		$cel_phn = $_GET['celular']; 
		$home_phn = $_GET['telefono_casa']; 
		$wrk_phn = $_GET['telefono_trabajo']; 
		$address = $_GET['direccion']; 
		$country = $_GET['pais']; 
		$state = $_GET['estado'];
		$city= $_GET['city'];
		$query = "UPDATE inspirausers SET cel_phn = '$cel_phn', 
		home_phn = '$home_phn', 
		wrk_phn = '$wrk_phn', 
		address = '$address', 
		city = '$city', 
		country = '$country', 
		state = '$state' 
		WHERE id = '$userid'";
		$result = mysqli_query($link, $query);
	
	}
?>