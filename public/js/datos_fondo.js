var edicion3 = false;

$(document).ready(function() {
	edicion3 = false;
	$('#cambiar3').click(function(){
		if(edicion3 === false)
		{
			change3();
			edicion3 = true;
		}	
	});
});


function change3()
{
	var agregarfondo = $('#agregarfondo');
	$('#agregarfondo').html('');
	$('<input type="text" style ="width:180px; float: left; display:inline-block;" class="controles" name="PrecioItem" >').appendTo(agregarfondo);
	$('<input id = "pagar" style ="width:130px; float: left; display:inline-block;" type="image" src="images/pagar.png" border="0" name="submit" alt="Pagar con DineroMail">').appendTo(agregarfondo);
	

	$('<br>').appendTo(agregarfondo);
	
	$('<input id="cancelar3" style ="margin-top: 5px; width:130px; float: right" type="image" src="images/cancelar.png" border="0">').appendTo(agregarfondo);
	$('</div>').appendTo(agregarfondo);
	
	$('#cancelar3').click(function(){
		reset3();
		
	});
}

function reset3()
{
	var agregarfondo = $('#agregarfondo');
	$('#agregarfondo').html('');
	
	$('<a id="cambiar3" style="display:inline-block; width:50%;"><img src="images/abonoadicional.png" style="width:80%;"/><img src="images/visa_master_american_oxxo_7.png" style="margin-bottom:0px; display:inline-block;/"></a>').appendTo(agregarfondo);
	$('</div>').appendTo(agregarfondo);
	
	edicion3 = false;
	
	$('#cambiar3').click(function(){
		if(edicion3 === false)
		{
			change3();
			edicion3 = true;
		}	
	});
}