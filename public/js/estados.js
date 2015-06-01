$(document).ready(function() {
	$('#pais').change(function(){
		getStates($('#pais').val());
	});
});

function getStates(country)
{
 $.ajax({
  type        : "GET",
  contentType : "application/json; charset=utf-8",
  dateType    : "json",
  url         : 'php/estados.php',
  data        : { country : country},
  success     : function(response)
  {
	$('#state').remove();
	
	if(response == 'no states')
	{
		$('#contenedor-estados').append('<input type="text" name="state" id="state" required="" class="form-control"/>');
	}
	else
	{
		var select = $('<select name = "state" id = "state" required="" class="form-control"> </select>');
		response = JSON.parse(response);
		$(response).each(function(key, state)
		{
			$(select).append('<option value="'+state['clave']+'">'+state['nombre']+'</option>');
		}); 
			
		$('#contenedor-estados').append(select);
	}
  }});
}