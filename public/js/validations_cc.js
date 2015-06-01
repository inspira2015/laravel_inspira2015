function verificar() {

var postal = document.forms["formulario"]["postal"].value;	
var numero = document.forms["formulario"]["numero"].value;
var nombre = document.forms["formulario"]["nombre"].value;
var apellido =document.forms["formulario"]["apellido"].value;
var codigo = document.forms["formulario"]["codigo"].value;
var direccion = document.forms["formulario"]["direccion"].value;
var pais = document.forms["formulario"]["pais"].value;
var estado = document.forms["formulario"]["state"].value;
var ciudad = document.forms["formulario"]["ciudad"].value;
var errores = "";
	if(document.forms["formulario"]["toc"].checked==false) {
  errores += "Debe aceptar terminos y condiciones para continuar.<br />";
}
	if(document.forms["formulario"]["politicas"].checked==false) {
errores += "Debe aceptar Politicas de Privacidad para continuar.<br />";
}

	
	//CP VERIFICAR
	if(!zip_validation(postal))
		{
			errores += "Codigo postal erroneo.<br />";
		}
		//Verificar si los nombres no tienen numeros o signos
		if(!name_validation(nombre))
		{
			errores += "Utilize sólo un nombre que sólo contenga letras.<br />";
		}
			
		//Verificar si los apellidos no tienen numeros o signos
		if(!name_validation(apellido))
		{
			errores += "Utilize sólo un apellido que sólo contenga letras.<br />";
		}
	if(!ciudad_validation(direccion))
		{
			errores += "Verifique la direccion.<br />";
		}
			
		//Verificar si el correo es válido
		if(!number_validation(numero))
		{
			errores += "El # de tarjeta no es válido.<br />";
		}
			
		//Verificar contraseñas son iguales
		if(!ciudad_validation(ciudad))
		{
			errores += "Ingrese una ciudad.<br />";
			//alert("FALSO!");
		}
			
		//Verificar si el celular no tienen numeros o signos
		if(!codigo_validation(codigo))
		{
			errores += "El codigo es invalido<br />";
		}
		
			

		//Verificar si los estados 
		if(!state_validation(estado))
		{
			errores += "Seleccione un Estado.<br />";
		}
			
		if(errores != "")
		{
		document.getElementById("error").innerHTML=errores;	 
		}
		else
		{
			formulario.submit();
		}

}
//Validaciones
	function username_validation(name){
		var valid_name = /^[a-zA-Z]{1,30}$/;
		if(!valid_name.test(name)) 
		 {         
			 return false; 
		 } 
		 else 
		 { 
			 return true;
		 } 	
	}

	function email_validation(email){
		var valid_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
		if(!valid_email.test(email)) 
		 {         
			 return false; 
		 } 
		 else 
		 { 
			 return true;
		 }
	}
		
	function conpassword_validation(conpass, res){
		if(conpass == res)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function number_validation(numero){
		var valid_number = /\D/;
		if(valid_number.test(numero)) 
		 {         
			 return false; 
		 } 
		 else 
		 { 
			 if(!numero){
	return false;	
	}else{
		if(numero.length>=15){
			 return true;
			}
		else{
			return false;
		}
		}
		 }
	}
function codigo_validation(numero){
	
		var valid_number = /\D/;
		if(valid_number.test(numero)) 
		 {         
			 return false; 
		 } 
		 else 
		 { 
			 if(!numero){
	return false;	
	}else{
			 	if(numero.length>=3 && numero.length<5){
			 return true;
			}
		else{
			return false;
		}
		}
		 }
	}

function zip_validation(numero){
	
		var valid_number = /\D/;
		if(valid_number.test(numero)) 
		 {         
			 return false; 
		 } 
		 else 
		 { 
			 if(!numero){
	return false;	
	}else{
			 	if(numero.length>=5 && numero.length<7){
			 return true;
			}
		else{
			return false;
		}
		}
		 }
	}
	
	function state_validation(name){
		if(!name) 
		 {         
			 return false; 
		 } 
		 else 
		 { 
			 return true;
		 } 
	}
function name_validation(name){
		if(!name) 
		 {         
			 return false; 
		 } 
		 else 
		 { 
			 return true;
		 } 
	}
	
	function ciudad_validation(name){
		if(!name) 
		 {         
			 return false; 
		 } 
		 else 
		 { 
			 return true;
		 } 
	}