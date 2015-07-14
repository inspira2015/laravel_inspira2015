@extends('layouts.master')

@section('content')
  <script>
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
  </script>

<div class="description">
  <i class="fa fa-user" style="border: 3px solid grey; border-radius:50%; width:25px; height:25px;"></i>
  <p><?php echo $full_name; ?></p>
  <br/>
  <p>Su correo ha sido confirmado</p>

  <p class="account_conf">BIENVENIDO Y<br/>
  FELICES VIAJES!
  </p>
</div>

<div class="continuar">
 continuar
</div>



  @stop
  