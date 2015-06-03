<?php
if(isset($nuevo)){
echo 'huevos';
echo '<script>
var bodydata= new Array();
	bodydata[0]=new Array();
bodydata[0]={ 
"firstName": "'.$user_data["first_name"].'", 
 "lastName": "'.$user_data["last_name"].'", 
 "email": "'.$user_data["email"].'",
 "address1": "'.$user_data["address"].'",
/* "provinceName": "'.$user_data["state"].'",
"countryCode": "'.$user_data["country"].'",*/
"languageCode": "'.$user_data["language"].'",
"mtierId": 111
/*"^ mtierId": "'.$user_data["afiliacion"].'"*/
};
	
	$.ajax({
		
  type: "POST",
contentType: "application/json",		
 data: JSON.stringify(bodydata),
  url: "https://api.leisureloyalty.com/v3/members?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH",
   success: function() {
    //no data...just a success (200) status code
	   document.getElementById("felicidades").innerHTML ="¡FELICIDADES POR TU NUEVA AFILIACión y bienvenido a inspira méxico";
    document.getElementById("texto").innerHTML = "En tu correo recibiras datos de acceso. Ahora puedes accesar a nuestro sistema de reservaciones, explorar tu mundo de posibilidades y planear tu proxima vacacion de ensueño";
  }
});
</script>';


$json = file_get_contents('https://api.leisureloyalty.com/v3/members?apiKey=usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH&');
$obj = json_decode($json, true);
$data= $obj['data'];
foreach($data as $value){
	if($value['userId']==$user_data['email']){
		$leisure_id=$value['memberId'];
	}
	
}

$host = "localhost";
	$user = "Inspira2015";
	$password = "InspiraMexico2015!";
	$database = "Inspira2015";
	$id = $user_data['id'];

	$link = mysqli_connect($host, $user, $password, $database);

$query = "UPDATE inspirausers SET leisure_id='$leisure_id' WHERE id=$id";

$result = mysqli_query($link, $query);
}
else{

echo '<script>window.location="route=users/error";</script>';
}
?>