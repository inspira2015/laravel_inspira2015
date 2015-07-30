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
    <div class="row" id="arriba" style="margin-bottom:50px;">
      <div id="error" style="color:red; text-align:left; margin:0 auto; width:300px;"></div>
      <div class="col-lg-12 col-md-12 col-sm-12" >

        <?php echo Form::open(array('url' => 'users/registration', 'id' => 'user_data','name' => 'formulario','data-toggle' => 'validator' )) ?>
         
            <div class="col-lg-1col-md-push-2 col-sm-10-col-sm-push-2 " id="formularios">
                
                <div class="form-group">
                    <label for="name">* <?php echo  Lang::get('registry.name'); ?></label>
                    <div class="input-group">
                        <?php echo Form::text('name',  Input::get('name') ? Input::get('name') : @$name, array('required','class' => 'form-control','id' => 'name', 'placeholder' => Lang::get('registry.name_place'))); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name">* <?php echo  Lang::get('registry.last_name'); ?></label>
                    <div class="input-group">
                        <?php echo Form::text('last_name', Input::get('last_name') ? Input::get('last_name') : @$last_name, array('required','class' => 'form-control','id' => 'last_name')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputEmail">* E-mail</label>
                    <div class="input-group">
                        <?php echo Form::email('email', Input::get('email') ? Input::get('email') : @$email, array('required','class' => 'form-control','id' => 'email')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="contrasena">* <?php echo  Lang::get('registry.password'); ?></label>
                    <div class="input-group">
                        <?php echo Form::password('password',  array('required','class' => 'form-control','id' => 'password')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="contrasena2">* <?php echo  Lang::get('registry.retype_pwd'); ?></label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password_check" id="password_check"  value=""required>
                    </div>
                </div>  

                <div class="form-group">
                    <label for="celular">* <?php echo  Lang::get('registry.celphone'); ?></label>
                    <div class="input-group">
                        <?php echo Form::text('cellphone_number', Input::get('cellphone_number') ? Input::get('cellphone_number') : @$cellphone_number, array('required','class' => 'form-control','id' => 'cellphone_number')); ?>
                    </div>
                </div>

                <!--<div class="form-group medios" style="width:50%; display:inline;">-->
                <div class="form-group col-lg-6 col-md-6">
                  <label for="pais">* <?php echo  Lang::get('registry.country'); ?></label>
                  <div class="input-group">
                      <?php echo Form::select('country', $country_list,Input::get('country') ? Input::get('country') : @$country, array('class' => 'form-control','id' => 'country')); ?>
                  </div>
                </div>
                <!--<div class="form-group medios" style="width:50%; display:inline;">-->
                <div class="form-group col-lg-6 col-md-6">
                    <label for="state">* <?php echo  Lang::get('registry.state'); ?></label>
                    <div id="contenedor-estados" class="input-group">
                      <?php echo Form::text('state', Input::get('state') ? Input::get('state') : @$state, array('required','class' => 'form-control','id' => 'state')); ?>
                    </div>
                </div>
            </div>
        <!--<div class="form-group medios" style="width:50%; display:inline;">-->
            <div class="form-group col-lg-6 col-md-6">
              <label for="estado">* <?php echo  Lang::get('registry.lang'); ?></label>
              <div class="input-group">
                <?php echo Form::select('language', $lan_list,Input::get('language')  ? Input::get('language') : @$language, array('class' => 'form-control','id' => 'language')); ?>
              </div>
            </div>
              <!--<div class="form-group medios" style="width:50%; display:inline;">-->
            
            <div class="form-group col-lg-6 col-md-6">
              <label for="currency">* <?php echo  Lang::get('registry.currency'); ?></label>
              <div class="input-group">
                <?php echo Form::select('currency', $currency_list,Input::get('currency')   ? Input::get('currency') : @$currency, array('class' => 'form-control','id' => 'currency')); ?>
              </div>
                </div>
        <?php echo Form::close() ?>
            </div>
          <div class="col-lg-12 col-md-12" style="padding:20px;">
            <div class="divider"></div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">  
            <a href="/codes/1">
              <img style="width:50%; height:auto;"src="<?php echo url();?>/images/regresartransparente.png"/>
            </a>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4"></div>
          <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:50px;">   
          <a href="#" onClick="verificar()">
              <img style="width:50%; height:auto;"src="<?php echo url();?>/images/continuar.png"/>
          </a></div>
  </div>
          
        
  @stop
  