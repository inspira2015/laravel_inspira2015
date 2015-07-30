$(function() {
	// Setup form validation on the #register-form element
	$("#user_data").validate({
		// Specify the validation rules
		rules: {
			name: "required",
			last_name: "required",
			email: {
				required: true,
				email: true
			},
			password: {
				minlength: 5
			},
			password_check: {
				minlength: 5,
				equalTo: "#password"
			},
			cellphone_number:{
				required: true,
				minlength: 10,
			}
		},
		submitHandler: function(form) {
			form.submit();
		}
	});
});


function verificar() {
	$("#user_data").submit();
}