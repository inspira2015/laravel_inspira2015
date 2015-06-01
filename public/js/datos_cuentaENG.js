var profileData2;
var edicion2 = false;

$(document).ready(function() {
	getData2();
	$('#cambiar2').click(function(){
		if(edicion2 == false)
		{
			change2();
			edicion2 = true;
		}
		else
		{
			updateData2();
		}	
	});
});

function getData2()
{
	$.ajax({
	type        : "GET",
	contentType : "application/json; charset=utf-8",
	dateType    : "json",
	url         : 'php/datos_cuenta.php?action=get',
	data        : {},
	success     : function(response)
	{
		response = JSON.parse(response);
		profileData2 = response;
		$('#correo').html('Email: '+response.email);
		$('#contrasena').html('Password: <input type="password" style="background-color:#f6f7f7 !important; border:none;" disabled value="'+(response.password)+'"/>');
  }});
}

function change2()
{
	var campos2 = $('#campos2');
	$('#cambiar2').html('<img src="images/guardarENG.png"/>');
	$(campos2).html('');
	
	$('<label style="display:none;">Email: </label>').appendTo(campos2);
	$('<input type="text" class="" id="correo" name="correo" style="display:none;" required>').val(profileData2.email).appendTo(campos2);

	
	$('<label class="controleslabel">Password: </label>').appendTo(campos2);
	$('<input class="controles" type="password" class="" id="contrasena" name="contrasena" required>').val(profileData2.password).appendTo(campos2);
	$('<label class="controleslabel">Confirm: </label>').appendTo(campos2);
	$('<input class="controles" type="password" class="" id="confirmar" name="confirmar" required>').appendTo(campos2);
	
}

function updateData2()
{
	var correo = $("#correo").val(); 
	var contrasena = $("#contrasena").val(); 
	var confirmar = $("#confirmar").val(); 
	
	var error = false;
	if(contrasena==confirmar){
	$.ajax({
	type        : "GET",
	contentType : "application/json; charset=utf-8",
	dateType    : "json",
	url         : 'php/datos_cuenta.php?action=update',
	data        : {correo : correo, contrasena : contrasena},
	success     : function(response)
	{
		if(response == 'Ya existe')
		{
			error = true;
			change2();
			$('<br>').appendTo(campos2);
			$('<p class="controleslabel">This email is being used by another account</p>').appendTo(campos2);
			edicion2 = true;
		}
		else
		{
			getData2();
			var correo = $("#correo").val(); 
			var contrasena = $("#contrasena").val(); 
			reset2(correo, contrasena);	
		}
	}});
	}
	else
	{
		
		error = true;
		change2();
		$('<br>').appendTo(campos2);
		$('<br>').appendTo(campos2);
		$('<p class="controleslabel" >Passwords must match</p>').appendTo(campos2);
		edicion2 = true;
	}
}

function reset2(correo, contrasena)
{
	var campos2 = $('#campos2');
	$('#cambiar2').html('<img src="images/cambiarENG.png"/>');
	$(campos2).html('');

	$('<p id = "correo" class=""> </p>').html('Email: '+correo).appendTo(campos2);
	$('<p id = "contrasena" class=""> </p>').html('Password: '+contrasena).appendTo(campos2);
	
	edicion2 = false;
}