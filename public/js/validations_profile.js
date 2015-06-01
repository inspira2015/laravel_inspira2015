function verificar() {

var correo = document.forms["formulario"]["correo"].value;
var pais = document.forms["formulario"]["country"].value;
var nombre = document.forms["formulario"]["nombre"].value;
var apellido =document.forms["formulario"]["apellido"].value;
var email =document.forms["formulario"]["email"].value;
var password =document.forms["formulario"]["password"].value;
var password_check = document.forms["formulario"]["password_check"].value;
var celular = document.forms["formulario"]["celular"].value;

var pais = document.forms["formulario"]["pais"].value;
var estado = document.forms["formulario"]["state"].value;
var language = document.forms["formulario"]["language"].value;
var currency = document.forms["formulario"]["currency"].value;
var errores = "";
	
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
			
		//Verificar si el correo es válido
		if(!email_validation(email))
		{
			errores += "El correo proveído no es válido.<br />";
		}
			
		//Verificar contraseñas son iguales
		if(!conpassword_validation(password, password_check))
		{
			errores += "Las contraseñas deben ser iguales.<br />";
			//alert("FALSO!");
		}
			
		//Verificar si el celular no tienen numeros o signos
		if(!phone_validation(celular))
		{
			errores += "El celular es inválido<br />";
		}
		else 
		{
			phone_inserted = true;	
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

	function phone_validation(phone){
		var valid_phone = /^\(?([0-9]{1,16})\)?$/;
		if(!valid_phone.test(phone)) 
		 {         
			 return false; 
		 } 
		 else 
		 { 
			 return true;
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
	
	function money_validation(amount){
		var valid_money = /^\(?([0-9]{1,16})\)?$/;
		if(!valid_money.test(amount)) 
		 {         
			 return false; 
		 } 
		 else 
		 { 
			 return true;
		 }
	}
	