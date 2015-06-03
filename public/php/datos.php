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
		$query = "SELECT * FROM inspirausers WHERE id =$userid";
		$result = mysqli_query($link, $query);
		
		$row = $result->fetch_assoc();
		if($row['afiliacion']==1){
			$row['afiliacion']=81;
		}
		if($row['afiliacion']==2){
			$row['afiliacion']=82;
		}
		if($row['afiliacion']==3){
			$row['afiliacion']=83;
		}
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