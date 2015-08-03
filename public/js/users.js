$(function() {
	// Setup form validation on the #register-form element
	$("#user_data").validate({
		// Specify the validation rules
		
		submitHandler: function(form) {
			form.submit();
		}
	});
});


function verificar() {
	$("#user_data").submit();
}